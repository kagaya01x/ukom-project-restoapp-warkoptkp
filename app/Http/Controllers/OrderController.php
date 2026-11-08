<?php

namespace App\Http\Controllers;

use App\Models\MenuCategoryModel;
use App\Models\MenuItemModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        // Aggregate stats from transactions only (no join to order_items to avoid duplication)
        $query = TransactionModel::query();

        $totalRevenue = (clone $query)->sum('grand_total') ?? 0;
        $totalTransactions = (clone $query)->count();

        // Orders count from orders table
        $totalOrders = OrderModel::where('order_status', 'completed')->count();

        // Paginated transaction table with eager loads
        $transactions = TransactionModel::with(['user', 'order'])
            ->latest('datetime')
            ->paginate(15)
            ->withQueryString();

        return view('orders.index', compact(
            'totalRevenue',
            'totalTransactions',
            'totalOrders',
            'transactions',
        ));
    }

    public function create()
    {
        $menuItems  = MenuItemModel::with('category')->get();
        $categories = $menuItems->pluck('category')->unique('category_id')->filter()->values();

        return view('orders.create', compact('menuItems', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'                  => 'required|array|min:1',
            'items.*.menu_item_id'   => 'required|integer|exists:menu_items,menu_item_id',
            'items.*.quantity'       => 'required|integer|min:1|max:100',
            'payment_method'         => 'required|in:Cash,QRIS',
        ]);

        try {
            $transactionId = DB::transaction(function () use ($request) {
                $userId = Auth::id();

                // Fetch all menu items from DB
                $menuItemIds  = collect($request->items)->pluck('menu_item_id')->unique()->toArray();
                $menuItemsMap = MenuItemModel::whereIn('menu_item_id', $menuItemIds)
                    ->get()
                    ->keyBy('menu_item_id');

                // Calculate grand total server-side
                $grandTotal = 0;
                foreach ($request->items as $item) {
                    $menuItem    = $menuItemsMap[$item['menu_item_id']];
                    $grandTotal += $menuItem->item_menu_price * $item['quantity'];
                }

                // Create order
                $order = OrderModel::create([
                    'user_id'      => $userId,
                    'datetime'     => now(),
                    'order_status' => 'completed',
                    'desc'         => null,
                ]);

                // Create order items (gunakan nama kolom sesuai migration order_item)
                foreach ($request->items as $item) {
                    $menuItem = $menuItemsMap[$item['menu_item_id']];
                    OrderItemModel::create([
                        'order_id'       => $order->order_id,
                        'menu_item_id'   => $menuItem->menu_item_id,
                        'item_name'      => $menuItem->item_menu_name,   // snapshot nama
                        'item_price'     => $menuItem->item_menu_price,  // snapshot harga
                        'item_quantity'  => $item['quantity'],
                        'sub_total'      => $menuItem->item_menu_price * $item['quantity'],
                    ]);
                }

                // Generate unique invoice
                $date        = now()->format('Ymd');
                $lastInvoice = TransactionModel::where('invoice', 'like', "INV-{$date}-%")
                    ->lockForUpdate()
                    ->orderBy('invoice', 'desc')
                    ->first();
                $seq     = $lastInvoice ? ((int) substr($lastInvoice->invoice, -4)) + 1 : 1;
                $invoice = 'INV-' . $date . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);

                // Create transaction
                $transaction = TransactionModel::create([
                    'order_id'       => $order->order_id,
                    'user_id'        => $userId,
                    'invoice'        => $invoice,
                    'datetime'       => now(),
                    'grand_total'    => $grandTotal,
                    'payment_method' => $request->payment_method,
                ]);

                // Store transaction_id for redirect after closure
                return $transaction->transaction_id;
            });

            return redirect()
                ->route('orders.show', $transactionId)
                ->with('success', 'Pesanan berhasil diproses.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    public function show($id)
    {
        $transaction = TransactionModel::with(['order.orderItems', 'user'])->findOrFail($id);
        return view('orders.show', compact('transaction'));
    }
}
