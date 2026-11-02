<?php

namespace App\Http\Controllers;

use App\Models\MenuCategoryModel;
use App\Models\MenuItemModel;
use Illuminate\Http\Request;

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
        $request->validate([
            'category_id'       => 'required|integer|exists:menu_category,category_id',
            'item_menu_name'    => 'required|string|max:200',
            'item_menu_price'   => 'required|integer|min:0',
            'item_menu_desc'    => 'nullable|string',
            'item_menu_img_link'=> 'nullable|url|max:500',
        ]);

        MenuItemModel::create([
            'category_id'       => $request->category_id,
            'item_menu_name'    => $request->item_menu_name,
            'item_menu_price'   => $request->item_menu_price,
            'item_menu_desc'    => $request->item_menu_desc,
            'item_menu_img_link'=> $request->item_menu_img_link,
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
            'category_id'       => 'required|integer|exists:menu_category,category_id',
            'item_menu_name'    => 'required|string|max:200',
            'item_menu_price'   => 'required|integer|min:0',
            'item_menu_desc'    => 'nullable|string',
            'item_menu_img_link'=> 'nullable|url|max:500',
        ]);

        $menuItem = MenuItemModel::findOrFail($id);
        $menuItem->update([
            'category_id'       => $request->category_id,
            'item_menu_name'    => $request->item_menu_name,
            'item_menu_price'   => $request->item_menu_price,
            'item_menu_desc'    => $request->item_menu_desc,
            'item_menu_img_link'=> $request->item_menu_img_link,
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
