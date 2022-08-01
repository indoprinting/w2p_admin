<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        $title      = "Pengaturan Banner";
        $banners    = DB::table('adm_carousel')->get();
        return view('setting.banner', compact('title', 'banners'));
    }

    public function store(Request $request)
    {
        $img        = $request->banner;
        $fileName   = $img->getClientOriginalName();
        $img->move(public_path('images/banner'), $fileName);
        DB::table('adm_carousel')->insert([
            'img'       => $fileName,
            'main'      => 0,
            'active'    => 1,
            'link'      => $request->link,
        ]);
        return back();
    }

    public function destroy($id)
    {
        $data       = DB::table('adm_carousel')->where('id', $id)->first();
        if (file_exists("images/banner/{$data->img}")) {
            unlink("images/banner/{$data->img}");
        }
        DB::table('adm_carousel')->where('id', $id)->delete();
        return back()->with('warning', 'Banner dihapus');
    }

    public function activeBanner(Request $request)
    {
        $id     = $request->id;
        $active = $request->active == 1 ? 0 : 1;
        DB::table('adm_carousel')->where('id', $id)->update(['active' => $active]);
        return back();
    }

    public function mainBanner(Request $request)
    {
        $id     = $request->id;
        $main   = $request->main == 1 ? 0 : 1;
        DB::table('adm_carousel')->where('id', $id)->update(['main' => $main]);
        return back();
    }

    function shortingBanner(Request $request)
    {
        $banners = DB::table('adm_carousel')->get();
        foreach ($banners as $banner) :
            $urutan = $request->input("urutan{$banner->id}");
            DB::table('adm_carousel')->where('id', $banner->id)->update(['urutan' => $urutan]);
        endforeach;
        return back();
    }
}
