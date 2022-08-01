<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $title  = "Delivery List";
        $date1  = $request->date1 ?? Carbon::now()->subDays(30);
        $date2  = $request->date2 ?? Carbon::now();
        $pickup = $request->outlet;
        $warehouse = $request->warehouse;

        $outlets = DB::table('adm_outlet')->get();
        $warehouses = Order::query()->where('warehouse', '!=', null)->groupBy('warehouse')->get();
        $orders = Order::query()->when($pickup, function ($query, $pickup) {
            $query->where('pickup', $pickup);
        })->when($warehouse, function ($query, $warehouse) {
            $query->where('warehouse', $warehouse);
        })->whereNotIn('pickup', ['Indoprinting Durian'])->where('payment_status', 'Paid')->whereBetween('created_at', [$date1, $date2])->latest('created_at')->get();

        return view('delivery.index_delivery', compact('title', 'orders', 'outlets', 'warehouses'));
    }

    public function exportDelivery(Request $request)
    {
        $date1  = $request->date1 ?? Carbon::now()->startOfDay()->toDate();
        $date2  = $request->date2 ?? Carbon::now()->toDate();
        $pickup = $request->outlet ?? "Indoprinting Durian";
        $data   = Order::where([
            'payment_status' => 'Paid',
            'pickup'    => $pickup
        ])->whereBetween('target', [$date1, $date2])->latest('created_at')->get();

        $spreadsheet    = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Create by SD2 Dev')->setLastModifiedBy('Modified by Admin Panel W2P');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'Tanggal Order')
            ->setCellValue('C1', 'Nama Pelanggan')
            ->setCellValue('D1', 'No. Telepon')
            ->setCellValue('E1', 'PIC')
            ->setCellValue('F1', 'Status')
            ->setCellValue('G1', 'Total Pembayaran')
            ->setCellValue('H1', 'Alamat Pickup');

        $column = 2;
        foreach ($data as $id => $report) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $id + 1)
                ->setCellValue('B' . $column, dateTime($report->created_at))
                ->setCellValue('C' . $column, $report->cust_name)
                ->setCellValue('D' . $column, $report->cust_phone)
                ->setCellValue('E' . $column, $report->cs)
                ->setCellValue('F' . $column, $report->sale_status)
                ->setCellValue('G' . $column, rupiah($report->total))
                ->setCellValue('H' . $column, $report->pickup);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Delivery-list-' . date('d-m-Y');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$filename.xlsx");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
