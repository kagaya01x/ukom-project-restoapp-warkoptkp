<?php

namespace App\Http\Controllers;

use App\Models\MenuCategoryModel;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    public function index()
    {
        $categories = MenuCategoryModel::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:menu_category,category_name',
        ]);

        MenuCategoryModel::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = MenuCategoryModel::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => "required|string|max:100|unique:menu_category,category_name,{$id},category_id",
        ]);

        $category = MenuCategoryModel::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = MenuCategoryModel::findOrFail($id);

        if ($category->menuItems()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki menu terkait.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
