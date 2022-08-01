<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product\Product;
use App\Models\Product\ReviewProduct;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $title      = "Rating W2P";
        $products   = Product::all();
        $users      = Customer::query()->whereNotNull('name')->get();

        return view('developer.rating.index_rating', compact('title', 'products', 'users'));
    }

    public function store(Request $request)
    {
        $save = ReviewProduct::query()->create([
            'id_product'    => $request->id_product,
            'id_user'       => $request->id_user,
            'rating'        => $request->rating,
            'review'        => $request->review,
        ]);

        return $save
            ? redirect()->back()->with('success', 'Rating Berhasil dibuat')
            : redirect()->back()->with('error', 'Rating gagal dibuat');
    }
}
