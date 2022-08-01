<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OutletController extends Controller
{
    public function index()
    {
        $title      = "Pengaturan Outlet";
        $outlets    = DB::table('adm_outlet')->get();

        return view('setting.outlet', compact('title', 'outlets'));
    }

    public function update(Request $request)
    {
        DB::table('adm_outlet')->where('id', $request->id)->update([
            'name'  =>  $request->name,
            'phone' =>  $request->phone,
            'email' =>  $request->email,
            'address'   =>  $request->address,
            'working_hours' =>  $request->hour,
            'google_maps'   =>  $request->google_maps,
        ]);

        return back()->with('success', "Berhasil update outlet <strong>{$request->name}</strong>");
    }

    public function setActive(Request $request)
    {
        DB::table('adm_outlet')->where('id', $request->id)->update([
            'active'    => $request->active
        ]);

        return redirect()->back();
    }
}
