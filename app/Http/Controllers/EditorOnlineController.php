<?php

namespace App\Http\Controllers;

use App\Http\Requests\Editor\FontRequest;
use Illuminate\Support\Str;
use App\Models\EditorOnline;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;

class EditorOnlineController extends Controller
{
    public function index()
    {
        $title = "Design Online Indoprinting";
        $fonts  = DB::table('editor_fonts')->get()->toJson();
        return view('editor.index_editor', compact('title', 'fonts'));
    }

    public function store(Request $request)
    {
        $store = EditorOnline::query()
            ->create([
                'product_id'    => $request->product_id,
                'thumbnail'     => $request->thumbnail,
                'design'        => $request->design,
                'title'         => $request->title,
            ]);
        echo $store ? "Sudah disimpan" : "Gagal disimpan";
    }

    public function getDesign(Request $request)
    {
        $product_id = $request->product_id;
        $get        = EditorOnline::query()->where('product_id', $product_id)->get();
        $design     = [];
        if ($get) :
            foreach ($get as $get) :
                array_push($design, [
                    'product'   => json_decode($get->design, true),
                    'thumbnail' => $get->thumbnail,
                    'title'     => $get->title,
                    'id'        => $get->id
                ]);
            endforeach;
            echo json_encode($design);
        else :
            echo false;
        endif;
    }

    public function destroy(Request $request)
    {
        $id         = $request->id_design;
        $destroy    = EditorOnline::query()->where('id', $id)->delete();
        echo $destroy ? true : false;
    }

    public function createDesign(Request $request)
    {
        $title      = "Create design w2p";
        $product    = Product::query()->where('id_product', $request->product_id)->first();
        $layouts    = $product->layout ? json_decode($product->layout) :  json_decode($product->stages)->design_layout->layout[0];
        $sizes      = json_decode($product->size)->size;

        return view('editor.create_w2p', compact('title', 'sizes', 'product', 'layouts'));
    }

    public function saveProductDesign(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->ukuran as $id => $ukuran) :
                $image_design = [];
                foreach ($request->file("img_design{$id}") as $image) :
                    if ($image->isValid()) :
                        $filename   = $image->hashName();
                        $image->move(public_path('editor-online/products/images'), $filename);
                        array_push($image_design, $filename);
                    endif;
                endforeach;
                $design_id = DB::table('idp_product_design')->insertGetId([
                    'product_id'    => $request->product_id,
                    'ukuran'        => $request->product_id . '-' . Str::slug($ukuran, '-'),
                    'layout_name'   => json_encode($request->input("layout_name{$id}")),
                    'img_design'    => json_encode($image_design)
                ]);
                $this->Json($ukuran, $request->input("layout_name{$id}"), $image_design, $request->product_id, $request->thumbnail, $design_id);
                $this->Json_front_end($ukuran, $request->input("layout_name{$id}"), $image_design, $request->product_id, $request->thumbnail, $design_id);
            endforeach;
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Layout desain berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function Json($size, $layouts, $image_design, $product_id, $thumbnail, $design_id)
    {
        $stages         = [];
        foreach ($layouts as $idl => $layout) :
            $stage = [
                "title"         => $layout,
                "thumbnail"     => "assets/images/products-img/" . $thumbnail,
                "elements"      => [
                    [
                        "title"         => "Base",
                        "source"        => DIRECTORY_SEPARATOR . "editor-online" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .  $image_design[$idl],
                        "type"          => "image",
                        "parameters"    => [
                            "left" => 400,
                            "top" => 300,
                            "originX" => "center",
                            "originY" => "center",
                            "z" => -1,
                            "fill" => false,
                            "colorLinkGroup" => "base",
                            "draggable" => 0,
                            "rotatable" => 0,
                            "resizable" => 0,
                            "removable" => 0,
                            "zChangeable" => 0,
                            "scaleX" => 1,
                            "scaleY" => 1,
                            "lockUniScaling" => false,
                            "uniScalingUnlockable" => 0,
                            "angle" => 0,
                            "boundingBoxMode" => "inside",
                            "opacity" => 1,
                            "minScaleLimit" => 0.01,
                        ]
                    ]
                ]
            ];
            array_push($stages, $stage);
        endforeach;
        $layout_design = [$stages];
        $slugDesign     = $product_id . '-' . Str::slug($size);
        $designName     = "editor-online" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "json" . DIRECTORY_SEPARATOR .  $slugDesign . ".json";
        $fp = fopen($designName, 'w');
        fwrite($fp, json_encode($layout_design));

        return true;
    }

    public function Json_front_end($size, $layouts, $image_design, $product_id, $thumbnail, $design_id)
    {
        $stages         = [];
        foreach ($layouts as $idl => $layout) :
            $stage = [
                "title"         => $layout,
                "thumbnail"     => DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "products-img" . DIRECTORY_SEPARATOR . $thumbnail,
                "elements"      => [
                    [
                        "title"         => "Base",
                        "source"        => DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "editor-online" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR .  $image_design[$idl],
                        "type"          => "image",
                        "parameters"    => [
                            "left" => 400,
                            "top" => 300,
                            "originX" => "center",
                            "originY" => "center",
                            "z" => -1,
                            "fill" => false,
                            "colorLinkGroup" => "base",
                            "draggable" => 0,
                            "rotatable" => 0,
                            "resizable" => 0,
                            "removable" => 0,
                            "zChangeable" => 0,
                            "scaleX" => 1,
                            "scaleY" => 1,
                            "lockUniScaling" => false,
                            "uniScalingUnlockable" => 0,
                            "angle" => 0,
                            "boundingBoxMode" => "inside",
                            "opacity" => 1,
                            "minScaleLimit" => 0.01,
                        ]
                    ]
                ]
            ];
            array_push($stages, $stage);
        endforeach;
        $layout_design = [$stages];
        DB::table('idp_product_design')->where('id', $design_id)->update([
            'layouts' => json_encode($layout_design)
        ]);
        $slugDesign     = $product_id . '-' . Str::slug($size);
        $designName     = "editor-online" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "json_fe" . DIRECTORY_SEPARATOR .  $slugDesign . ".json";
        $fp = fopen($designName, 'w');
        fwrite($fp, json_encode($layout_design));

        return true;
    }

    public function fonts()
    {
        $title = "Font w2p";
        $fonts  = DB::table('editor_fonts')->get();
        return view('editor.fonts', compact('title', 'fonts'));
    }

    public function storeFont(Request $request)
    {
        $file       = $request->font;
        $filename   = $file->getClientOriginalName();
        $file->move(public_path('editor-online/fonts'), $filename);

        DB::table('editor_fonts')->insert([
            'name'  => $request->name,
            'url'   => url("editor-online/fonts/$filename")
        ]);

        return back()->with('success', 'Tambah font sukses');
    }
}
