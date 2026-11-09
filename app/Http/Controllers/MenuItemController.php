<?php

namespace App\Http\Controllers;

use App\Models\MenuCategoryModel;
use App\Models\MenuItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItemModel::with('category')->paginate(10);
        return view('menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = MenuCategoryModel::all();
        return view('menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input menu baru
        $request->validate([
            'category_id' => 'required|integer|exists:menu_category,category_id',
            'item_menu_name' => 'required|string|max:200',
            'item_menu_price' => 'required|integer|min:0',
            'item_menu_desc' => 'nullable|string',
            'item_menu_img_link' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mengambil path yang di upload ke storage
        $menu_img_path = $request->file('item_menu_img_link')->store('uploads', 'public');

        // Buat data dan simpan
        MenuItemModel::create([
            'category_id' => $request->category_id,
            'item_menu_name' => $request->item_menu_name,
            'item_menu_price' => $request->item_menu_price,
            'item_menu_desc' => $request->item_menu_desc,
            'item_menu_img_link' => $menu_img_path,
        ]);

        return redirect()->route('menu-items.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menuItem   = MenuItemModel::findOrFail($id);
        $categories = MenuCategoryModel::all();
        return view('menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:menu_category,category_id',
            'item_menu_name' => 'required|string|max:200',
            'item_menu_price' => 'required|integer|min:0',
            'item_menu_desc' => 'nullable|string',
            'item_menu_img_link'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $menuItem = MenuItemModel::findOrFail($id);

        $menu_img_path = $menuItem->item_menu_img_link;

        // Cek di $request kalo user upload gambar
        if($request->hasFile('item_menu_img_link')){
            // jaga jaga kalo misal ada file gambar yang sama
            if($menuItem->item_menu_img_link && Storage::disk('public')->exists($menuItem->item_menu_img_link)){
                Storage::disk('public')->delete($menuItem->item_menu_img_link);
            }

            // Simpan file baru jika user upload gambar
            $menu_img_path = $request->file('item_menu_img_link')->store('uploads', 'public');

        }

        
        $menuItem->update([
            'category_id' => $request->category_id,
            'item_menu_name' => $request->item_menu_name,
            'item_menu_price' => $request->item_menu_price,
            'item_menu_desc' => $request->item_menu_desc,
            'item_menu_img_link'=> $menu_img_path,
        ]);

        return redirect()->route('menu-items.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menuItem = MenuItemModel::findOrFail($id);

        if ($menuItem->orderItems()->count() > 0) {
            return back()->with('error', 'Menu tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $menuItem->delete();

        return redirect()->route('menu-items.index')->with('success', 'Menu berhasil dihapus.');
    }
}
