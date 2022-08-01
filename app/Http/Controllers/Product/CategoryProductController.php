<?php

namespace App\Http\Controllers\Product;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CategoryProductRequest;
use App\Models\Product\ProductCategory;

class CategoryProductController extends Controller
{
    public function index()
    {
        $title      = "Kategori Produk";
        $categories = ProductCategory::get();

        return view('product_category.index_product_category', compact('title', 'categories'));
    }

    public function store(CategoryProductRequest $request)
    {
        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
        return back()->with('success', 'Berhasil mengambah kategori');
    }

    public function edit($id)
    {
        $title      = "Kategori Produk";
        $categories = ProductCategory::get();
        $category   = ProductCategory::find($id);

        return view('product_category.index_product_category', compact('title', 'categories', 'category'));
    }

    public function update($id, CategoryProductRequest $request)
    {
        ProductCategory::where('id_category', $request->id_category)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
        return back()->with('success', 'Berhasil mengubah nama kategori');
    }
}
