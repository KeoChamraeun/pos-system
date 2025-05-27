<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Category;
use Modules\Product\DataTables\ProductCategoriesDataTable;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function index(ProductCategoriesDataTable $dataTable)
    {
        return $dataTable->render('product::categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_code' => 'required|unique:categories',
            'category_name' => 'required',
            'product_image' => 'nullable|image|max:2048',
        ]);

        $category = Category::create([
            'category_code' => $request->category_code,
            'category_name' => $request->category_name,
            'user_id' => Auth::id(),  // save logged-in user id here
        ]);

        if ($request->hasFile('product_image')) {
            $category->update([
                'product_image' => $request->file('product_image')->store('categories', 'public')
            ]);
        }

        return redirect()->route('product-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        // Optional: prevent editing if not owner
        if ($category->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('product::categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_code' => 'required|unique:categories,category_code,'.$id,
            'category_name' => 'required',
            'product_image' => 'nullable|image|max:2048',
        ]);

        $category = Category::findOrFail($id);

        // Optional: check ownership before update
        if ($category->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $category->update([
            'category_code' => $request->category_code,
            'category_name' => $request->category_name,
        ]);

        if ($request->hasFile('product_image')) {
            $category->update([
                'product_image' => $request->file('product_image')->store('categories', 'public')
            ]);
        }

        return redirect()->route('product-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Optional: check ownership before delete
        if ($category->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $category->delete();

        return redirect()->route('product-categories.index')->with('success', 'Category deleted successfully.');
    }
}
