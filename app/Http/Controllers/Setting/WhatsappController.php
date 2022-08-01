<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use function Symfony\Component\String\b;

class WhatsappController extends Controller
{
    public function index()
    {
        $title  = "List Blacklist WA Rapiwha";
        $phones = DB::table('adm_wa_rapiwha')->latest('id')->get();

        return view('setting.rapiwha', compact('title', 'phones'));
    }

    public function store(Request $request)
    {
        DB::table('adm_wa_rapiwha')->insert([
            'phone' => $request->phone,
            'name'  => $request->name,
        ]);
        return back()->with('success', 'Berhasil menambahkan data');
    }

    public function edit(Request $request)
    {
        DB::table('adm_wa_rapiwha')->where('id', $request->id)->update([
            'phone' => $request->phone,
            'name'  => $request->name,
        ]);
        return back()->with('success', 'Berhasil update data');
    }

    public function destroy(Request $request)
    {
        DB::table('adm_wa_rapiwha')->where('id', $request->id)->delete();
        return back()->with('warning', 'Berhasil hapus data');
    }
}
