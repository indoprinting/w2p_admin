<?php

namespace App\Http\Controllers\Product;

use Carbon\Carbon;
use App\Models\PrintERP;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductCategory;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    protected $product_model;
    protected $category_product_model;
    protected $erp_model;
    public function __construct()
    {
        $this->product_model = new Product();
        $this->erp_model    = new PrintERP();
        $this->category_product_model = new ProductCategory();
    }

    public function index(Request $request)
    {
        $title      = "Semua Produk";
        $categories = $this->category_product_model->getCategory();
        $products   = $this->product_model->getProduct($request);

        return view('product.index_product', compact('title', 'products', 'categories'));
    }

    public function activeProduct(Request $request)
    {
        Product::where('id_product', $request->id_product)->update(['active' => $request->active]);
        return redirect()->route('product.index');
    }

    public function create(Request $request)
    {
        $category       = $request->category;
        $title          = "Tambah produk";
        $product_erp    = $this->erp_model->getProduct();
        $categories     = $this->category_product_model->getCategory();

        if ($category == "book") :
            return view('product.create_product_book', compact('title', 'product_erp', 'categories'));
        elseif ($category == "sticker") :
            return view('product.create_product_sticker', compact('title', 'product_erp', 'categories'));
        elseif ($category == "acrylic") :
            return view('product.create_product_acrylic', compact('title', 'product_erp', 'categories'));
        else :
            return view('product.create_product', compact('title', 'product_erp', 'categories'));
        endif;
    }

    public function edit(Product $product)
    {
        $title          = "Edit produk $product->name";
        $product_erp    = $this->erp_model->getProduct();
        $categories     = $this->category_product_model->getCategory();

        return view('product.edit_product', compact('title', 'product', 'product_erp', 'categories'));
    }

    public function store(CreateProductRequest $request)
    {
        $image      = $request->img_product;
        $thumbnail  = $image->hashName();
        $image->move(public_path('assets/images/products-img'), $thumbnail);
        $bahan      = $this->saveMaterial($request->material_name);
        $store      = $this->product_model->store($request, $thumbnail, $this->thumbnail2($request), $bahan, $this->saveSize($request), $this->customAtb($request), $this->saveDesign($request));
        return $store
            ? redirect()->route('product.index')->with('success', 'Berhasil menambahkan produk')
            : redirect()->route('product.index')->with('error', 'Gagal menambahkan produk');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $image      = $request->img_product;
        if ($image) :
            $thumbnail  = $image->hashName();
            $image->move(public_path('assets/images/products-img'), $thumbnail);
        else :
            $thumbnail = $product->thumbnail;
        endif;
        if ($request->img_product2) :
            $thumbnail2  = $this->thumbnail2($request);
        else :
            $thumbnail2 = $product->thumbnail2;
        endif;
        $request->desc_id = $request->desc_id ?? $product->desc_id;
        $bahan      = $this->saveMaterial($request->material_name);
        $store      = $this->product_model->store($request, $thumbnail, $thumbnail2, $bahan, $this->saveSize($request), $this->customAtb($request), $this->saveDesign($request));
        return $store
            ? redirect()->route('product.index')->with('success', 'Berhasil update produk')
            : redirect()->route('product.index')->with('error', 'Gagal update produk');
    }

    public function thumbnail2($request)
    {
        $images = array();
        foreach ($request->img_product2 as $image) :
            if ($image->isValid()) :
                $filename   = $image->hashName();
                $image->move(public_path('assets/images/products-img'), $filename);
                array_push($images, $filename);
            endif;
        endforeach;

        return json_encode($images);
    }

    public function saveSize($request)
    {
        $size           = $request->size_name;
        $size_price     = $request->size_price;
        $size_value     = array();
        $price          = array();
        foreach ($size as $id => $ukuran) :
            if ($size_price[$id] && $ukuran) :
                array_push($size_value, $ukuran);
                array_push($price, $size_price[$id]);
            endif;
        endforeach;

        $size = ['size' => $size_value, 'price' => $price];
        return json_encode($size);
    }

    public function saveMaterial($material)
    {
        $mtrl_code      = array();
        $mtrl_name      = array();
        $mtrl_price     = array();
        $mtrl_qty       = array();
        $mtrl_range     = array();
        $mtrl_category  = array();
        $mtrl_min_price = array();
        foreach ($material as $bahan) :
            $mtrl       = explode(',,', $bahan);
            if ($mtrl[0] || $mtrl[0]) :
                array_push($mtrl_code, $mtrl[0]);
                array_push($mtrl_name, $mtrl[1]);
                array_push($mtrl_price, $mtrl[2]);
                array_push($mtrl_qty, $mtrl[3]);
                array_push($mtrl_range, $mtrl[4]);
                array_push($mtrl_category, $mtrl[5]);
                array_push($mtrl_min_price, min(json_decode($mtrl[4], true)));
            endif;
        endforeach;
        return  [
            'material_code'     => $mtrl_code,
            'material_name'     => $mtrl_name,
            'material_price'    => $mtrl_price,
            'material_qty'      => $mtrl_qty,
            'material_range'    => $mtrl_range,
            'material_category' => $mtrl_category,
            'material_min_price' => min($mtrl_min_price),
        ];
    }

    public function customAtb($request)
    {
        $temp_v_code    = array();
        $temp_v_name    = array();
        $temp_v_price   = array();
        $temp_v_qty     = array();
        $temp_v_range   = array();
        $value_code     = array();
        $value_name     = array();
        $value_price    = array();
        $value_qty      = array();
        $value_range    = array();
        $atb_name       = array();
        for ($i = 0; $i < 300; $i++) {
            $post_atb_name  = $request->input("atb_name{$i}");
            if ($post_atb_name != '') :
                array_push($atb_name, $post_atb_name);
                $post_v_name    = $request->input("value_name{$i}");
                if ($post_v_name || !empty($post_v_name) || $post_v_name != []) :
                    foreach ($post_v_name as $v_name) :
                        $value_atb  = explode(',,', $v_name);
                        array_push($temp_v_code, $value_atb[0]);
                        array_push($temp_v_name, $value_atb[1]);
                        array_push($temp_v_price, $value_atb[2]);
                        array_push($temp_v_qty, $value_atb[3]);
                        array_push($temp_v_range, $value_atb[4]);
                    endforeach;
                endif;
                array_push($value_code, $temp_v_code);
                array_push($value_name, $temp_v_name);
                array_push($value_price, $temp_v_price);
                array_push($value_qty, $temp_v_qty);
                array_push($value_range, $temp_v_range);
                $temp_v_code    = array();
                $temp_v_name    = array();
                $temp_v_price   = array();
                $temp_v_qty     = array();
                $temp_v_range   = array();
            endif;
        }

        $atribut =  [
            'name'      => $atb_name,
            'value'     => [
                'value_code'    => $value_code,
                'value_name'    => $value_name,
                'value_price'   => $value_price,
                'value_qty'     => $value_qty,
                'value_range'   => $value_range,
            ],
        ];
        return json_encode($atribut);
    }

    public function saveDesign($request)
    {
        $nama_ukuran    = $request->ukuran;
        $nama_ukuran2   = array();
        $layout         = array();
        $layout2        = array();
        $design2        = array();
        $design         = array();
        foreach ($nama_ukuran as $ukuran) :
            array_push($nama_ukuran2, $ukuran);
        endforeach;
        for ($id = 0; $id < 30; $id++) {
            $layout_name     = $request->input('layout_name' . $id);
            if ($layout_name) :
                foreach ($layout_name as $id_l => $ly) :
                    $ly ? array_push($layout,  $ly) : array_push($layout, 'Design ' . ($id_l + 1));
                endforeach;
                array_push($layout2, $layout);
                $layout     = array();
            endif;

            if ($request->input("img_design$id")) :
                foreach ($request->input("img_design$id")  as $img) :
                    if ($img->isValid()) :
                        $image = $img->getClientOriginalName();
                        $img->move(public_path('assets/images/design'), $image);
                        array_push($design, $image);
                    endif;
                endforeach;
            endif;
            array_push($design2, $design);
            $design     = array();
        }

        return json_encode(array(
            'ukuran'        => $nama_ukuran2,
            'design_layout' => array(
                'layout'        => $layout2,
                'design'        => $design2,
            ),
        ));
    }

    public function show(Product $product) //destroy
    {
        $name   = $product->name;
        if (file_exists(public_path("assets/images/products-img/{$product->thumbnail}"))) {
            unlink(public_path("assets/images/products-img/{$product->thumbnail}"));
        }
        foreach (json_decode($product->thumbnail2) as $thumbnail) {
            if (file_exists(public_path("assets/images/products-img/{$thumbnail}"))) {
                unlink(public_path("assets/images/products-img/{$thumbnail}"));
            }
        }
        $product->delete();
        return back()->with('warning', "Produk <strong>{$name}</strong> sudah dihapus");
    }

    public function duplicate($id)
    {
        $product = Product::find($id);
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' Copy';
        $newProduct->created_at = Carbon::now();
        $newProduct->save();
        return back()->with('success', 'Berhasil duplicate produk');
    }

    public function syncProductERP()
    {
        $sync = $this->erp_model->syncProduct();
        return back()->with('success', 'Sinkronisasi produk selesai');
    }

    public function downloadImage(Request $request)
    {
        $ext    = pathinfo($request->image)['extension'];
        $name   = str_replace(['/', '\\'], '', $request->name) . '.' . $ext;
        return response()->download(public_path("assets/images/products-img/{$request->image}"), $name);
    }

    public function exportProduct()
    {
        $data   = Product::with('kategori')->oldest()->get();
        $spreadsheet    = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Admin')->setLastModifiedBy('Admin');

        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);
        $worksheet->getColumnDimension('J')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'Tanggal Upload')
            ->setCellValue('C1', 'Nama Produk')
            ->setCellValue('D1', 'Berat')
            ->setCellValue('E1', 'Panjang')
            ->setCellValue('F1', 'Lebar')
            ->setCellValue('G1', 'Tinggi')
            ->setCellValue('H1', 'Custom Ukuran')
            ->setCellValue('I1', 'Kategori')
            ->setCellValue('J1', 'Deskripsi');

        $column = 2;
        foreach ($data as $id => $product) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A{$column}", $id + 1)
                ->setCellValue("B{$column}", dateTime($product->created_at))
                ->setCellValue("C{$column}", $product->name)
                ->setCellValue("D{$column}", $product->weight)
                ->setCellValue("E{$column}", $product->panjang)
                ->setCellValue("F{$column}", $product->lebar)
                ->setCellValue("G{$column}", $product->tinggi)
                ->setCellValue("H{$column}", $product->customize == 1 ? "Ya" : "Tidak")
                ->setCellValue("I{$column}", $product->kategori->name)
                ->setCellValue("J{$column}", $product->desc_id);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Product-W2P-' . date('d-m-Y');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename={$filename}.xlsx");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
