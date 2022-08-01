<?php

namespace App\Http\Controllers\Product;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product\BestSeller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BestSellerController extends Controller
{
    protected $model_best_seller;
    public function __construct()
    {
        $this->model_best_seller = new BestSeller();
    }

    public function index(Request $request)
    {
        $month      = $request->month ?? Carbon::now()->format('Y-m');
        $outlet     = $request->outlet;
        $title      = "Produk terlaris " . Carbon::create($month)->isoFormat('MMMM Y');
        $condition  = fn ($query) => $query->where('outlet', 'like', $outlet . '%');
        $products   = $this->model_best_seller->getBestSeller($month, $outlet);
        $total      = BestSeller::when($outlet, $condition)->where('created_at', 'like', $month . '%')->sum('price');
        $data_chart = $this->model_best_seller->getDataChart($month, $outlet);
        $outlets    = DB::table('adm_outlet')->get();

        return view('best_seller.index_best_seller', compact('title', 'products', 'total', 'data_chart', 'outlets'));
    }
}
