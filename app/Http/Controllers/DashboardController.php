<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // mengambil data user
        $employee = Auth::user()->employee;
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        // Determine date range
        $today     = now()->toDateString();
        $startDate = $request->filled('start_date') ? $request->start_date : $today;
        $endDate   = $request->filled('end_date')   ? $request->end_date   : $today;

        // Aggregate stats from transactions only (no join to order_items to avoid duplication)
        $query = TransactionModel::query()
            ->whereBetween('datetime', [
                $startDate . ' 00:00:00',
                $endDate   . ' 23:59:59',
            ]);

        $totalRevenue      = (clone $query)->sum('grand_total') ?? 0;
        $totalTransactions = (clone $query)->count();

        // Orders count from orders table
        $totalOrders = OrderModel::whereBetween('datetime', [
            $startDate . ' 00:00:00',
            $endDate   . ' 23:59:59',
        ])->where('order_status', 'completed')->count();

        // Paginated transaction table with eager loads
        $transactions = TransactionModel::with(['user', 'order'])
            ->whereBetween('datetime', [
                $startDate . ' 00:00:00',
                $endDate   . ' 23:59:59',
            ])
            ->latest('datetime')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.index', compact(
            'employee',
            'totalRevenue',
            'totalTransactions',
            'totalOrders',
            'transactions',
            'startDate',
            'endDate'
        ));
    }
}
