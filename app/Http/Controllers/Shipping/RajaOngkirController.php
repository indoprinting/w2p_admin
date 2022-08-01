<?php

namespace App\Http\Controllers\Shipping;

use Carbon\Carbon;
use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RajaOngkirController extends Controller
{
    protected $model_shipping;
    public function __construct()
    {
        $this->model_shipping   = new Shipping();
    }

    public function index()
    {
        $title  = "Shipping Raja Ongkir";
        $orders = Shipping::query()->whereIn('payment_status', ['Paid', 'Partial'])->whereNotIn('courier_name', ['Gosend'])->join('idp_orders', 'idp_orders.id_order', '=', 'idp_delivery.id_inv')->latest('id')->get();

        return view('shipping.index_shipping', compact('title', 'orders'));
    }

    public function allShipping()
    {
        $title  = "All Shipping";
        $orders = Shipping::query()->whereIn('payment_status', ['Paid', 'Partial'])->join('idp_orders', 'idp_orders.id_order', '=', 'idp_delivery.id_inv')->latest('id')->get();

        return view('shipping.index_shipping', compact('title', 'orders'));
    }

    public function detailRajaOngkir(Request $request)
    {
        $title      = "Detail shipping no resi " . $request->resi;
        $waybill    = $this->model_shipping->getDetailRajaongkir($request);

        return view('shipping.detail_rajaongkir', compact('title', 'waybill'));
    }

    public function updateResi(Request $request)
    {
        Shipping::where('id', $request->id)->update(['resi' => $request->resi]);
        return redirect()->back();
    }

    public function updateKeterangan(Request $request)
    {
        Shipping::where('id', $request->id)->update(['keterangan' => $request->keterangan]);
        return redirect()->back();
    }

    public function markSend($id)
    {
        Shipping::where('id', $id)->update(['terkirim' => date('Y-m-d H:i:s')]);
        return redirect()->back();
    }

    public function printShipping(Request $request)
    {
        $shipping = Shipping::where('id', $request->id)->with('order')->first();
        return view('shipping.print_shipping', compact('shipping'));
    }

    public function estimateCost(Request $request)
    {
        $title      = "Estimasi Ongkos Kirim Rajaongkir";
        $products   = Product::query()->get(['name', 'weight']);
        $provinces  = Cache::rememberForever('provinces', fn () => DB::table('local_provinces')->get());
        $rajaongkir = $request->suburb_id ? $this->model_shipping->getRajaOngkir($request) : null;
        $gosend     = $request->destination ? $this->model_shipping->getGosend($request->destination) : null;

        return view('shipping.estimate_cost', compact('title', 'products', 'provinces', 'rajaongkir', 'gosend'));
    }

    public function exportShipping(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Create by Admin')->setLastModifiedBy('Modified by Admin');

        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'No. Invoice')
            ->setCellValue('C1', 'Tanggal Order')
            ->setCellValue('D1', 'Kurir')
            ->setCellValue('E1', 'Service')
            ->setCellValue('F1', 'Biaya');

        $column = 2;
        $data   = $this->model_shipping->getDataExport($request);
        foreach ($data as $id => $report) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A{$column}", $id + 1)
                ->setCellValue("B{$column}", $report->no_inv)
                ->setCellValue("C{$column}", dateTime($report->order->created_at))
                ->setCellValue("D{$column}", $report->courier_name)
                ->setCellValue("E{$column}", $report->courier_service)
                ->setCellValue("F{$column}", $report->courier_price);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Shipping-Report-' . date('d-m-Y');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename={$filename}.xlsx");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
