<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CommonSettingController extends Controller
{
    public function index()
    {
        return view('setting.common_setting', [
            'title'      => "Kebijakan dan privasi",
            'privacy'    => Setting::where('setting_name', 'privacy')->value('setting'),
            'term'       => Setting::where('setting_name', 'term_id')->value('setting'),
            'promo'      => Setting::where('setting_name', 'promo-login')->value('setting'),
            'about'      => Setting::where('setting_name', 'tentang-kami')->value('setting'),
            'pusat'      => Setting::where('setting_name', 'kantor-pusat')->value('setting'),
        ]);
    }

    public function updatePrivacy(Request $request)
    {
        Setting::where('setting_name', 'privacy')->update(['setting' => $request->privacy]);
        return back()->with('success', 'Berhasil update Kebijakan dan privasi');
    }

    public function updateTerm(Request $request)
    {
        Setting::where('setting_name', 'term_id')->update(['setting' => $request->term]);
        return back()->with('success', 'Berhasil update syarat dan ketentuan');
    }

    public function updateAboutIDP(Request $request)
    {
        Setting::where('setting_name', 'tentang-kami')->update(['setting' => $request->about]);
        Setting::where('setting_name', 'kantor-pusat')->update(['setting' => $request->pusat]);
        return back()->with('success', 'Berhasil update tentang Indoprinting');
    }

    public function updatePromo(Request $request)
    {
        $image      = $request->promo;
        if (!$image->isValid()) return back()->with('error', 'Gambar tidak valid');
        if (file_exists(public_path("images/promotion/{$request->old_promo}")) && $request->old_promo) {
            unlink(public_path("images/promotion/{$request->old_promo}"));
        }
        $filename   = $image->getClientOriginalName();
        $image->move(public_path("images/promotion"), $filename);
        Setting::where('setting_name', 'promo-login')->update(['setting' => $filename]);
        return back()->with('success', 'Berhasil update gambar promosi di halaman login');
    }
}
