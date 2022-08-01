<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product\ReviewProduct;

class ReviewProductController extends Controller
{
    public function index()
    {
        $title      = "Review Produk";
        $reviews    = ReviewProduct::with('order', 'product', 'customer')->get();
        $average    = round(ReviewProduct::avg('rating'), 1);

        return view('product_review.index_review', compact('title', 'reviews', 'average'));
    }

    public function updateRespon(Request $request)
    {
        ReviewProduct::where('id', $request->id)->update(['respon' => $request->respon]);
        return back();
    }
}
