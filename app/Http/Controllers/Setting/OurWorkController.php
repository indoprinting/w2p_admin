<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OurWorkController extends Controller
{
    public function index()
    {
        $title  = "Our Work";
        $images = DB::table('adm_our_work')->latest('id')->get();

        return view('setting.ourwork', compact('title', 'images'));
    }

    public function store(Request $request)
    {
        $name       = $request->name;
        $img        = $request->img;
        $fileName   = $img->hashName();
        $img->move(public_path("images/our-work"), $fileName);
        DB::table('adm_our_work')->insert([
            'img'           => $fileName,
            'name'          => $name,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return back()->with('success', 'Berhasil menambah gambar');
    }

    public function destroy(Request $request)
    {
        $img    = DB::table('adm_our_work')->where('id', $request->id)->value('img');
        if (file_exists(public_path("images/our-work/{$img}")) && $img) {
            unlink(public_path("images/our-work/{$img}"));
        }
        DB::table('adm_our_work')->where('id', $request->id)->delete();

        return back()->with('warning', 'Berhasil menghapus gambar');
    }
}
