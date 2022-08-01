<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DesignController extends Controller
{
    public function index()
    {
        $title      = "Design W2P";
        $designs    = DB::table('adm_design_w2p')->latest()->get();

        return view('setting.design', compact('title', 'designs'));
    }

    public function store(Request $request)
    {
        $image_corel = $request->design;
        $design  = str_replace(' ', '-', Str::random(21) . '-' . $image_corel->getClientOriginalName());
        $image_corel->move(public_path('images/design'), $design);

        $image_preview = $request->preview;
        $preview  = str_replace(' ', '-', Str::random(21) . '-' . $image_preview->getClientOriginalName());
        $image_preview->move(public_path('images/design'), $preview);

        $store = DB::table('adm_design_w2p')->insert([
            'invoice'       => $request->invoice,
            'name'          => $request->name,
            'file_corel'    => $design,
            'preview'       => $preview,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        return $store
            ? back()->with('success', 'Berhasil simpan desain')
            : back()->with('error', 'Gagal simpan desain');
    }

    public function update(Request $request)
    {
        $data = DB::table('adm_design_w2p')->where('id', $request->id)->first();
        if ($request->design) :
            $image_corel = $request->design;
            $design  = str_replace(' ', '-', Str::random(21) . '-' . $image_corel->getClientOriginalName());
            $image_corel->move(public_path('images/design'), $design);
        else :
            $design = $data->file_corel;
        endif;

        if ($request->preview) :
            $image_preview = $request->preview;
            $preview  = str_replace(' ', '-', Str::random(21) . '-' . $image_preview->getClientOriginalName());
            $image_preview->move(public_path('images/design'), $preview);
        else :
            $preview = $data->preview;
        endif;

        $update = DB::table('adm_design_w2p')->where('id', $request->id)->update([
            'invoice'       => $request->invoice,
            'name'          => $request->name,
            'file_corel'    => $design,
            'preview'       => $preview,
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        return $update
            ? back()->with('success', 'Berhasil update desain')
            : back()->with('error', 'Gagal update desain');
    }

    public function destroy(Request $request)
    {
        $data = DB::table('adm_design_w2p')->where('id', $request->id)->first();
        if (file_exists(public_path("images/design/{$data->file_corel}"))) {
            unlink(public_path("images/design/{$data->file_corel}"));
        }
        if (file_exists(public_path("images/design/{$data->preview}"))) {
            unlink(public_path("images/design/{$data->preview}"));
        }

        $destroy = DB::table('adm_design_w2p')->delete($request->id);

        return $destroy
            ? back()->with('warning', 'Berhasil delete desain')
            : back()->with('error', 'Gagal delete desain');
    }
}
