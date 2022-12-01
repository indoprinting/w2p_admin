<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PriceListController extends Controller
{
    public function index()
    {
        $title  = "Setting Price List";
        $images = DB::table('idp_price_list')->get();

        return view('setting.price_list', compact('title', 'images'));
    }

    public function store(Request $request)
    {
        $img        = $request->file;
        $fileName   = $img->getClientOriginalName();
        $img->move(public_path("assets/images/price-list"), $fileName);
        DB::table('idp_price_list')->insert([
            'filename'  => $fileName
        ]);

        return back();
    }

    public function destroy(Request $request)
    {
        DB::table('idp_price_list')->where('id', $request->id)->delete();
        return back();
    }
}
