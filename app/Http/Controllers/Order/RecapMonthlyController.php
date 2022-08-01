<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RecapMonthlyController extends Controller
{
    protected $model_order;
    public function __construct()
    {
        $this->model_order  = new Order();
    }

    public function index(Request $request)
    {
        $date1  = $request->date1 ? Carbon::create($request->date1) : Carbon::now()->startOfMonth();
        $date2  = $request->date2 ? Carbon::create($request->date2)->endOfHour() : Carbon::now();
        $diff   = $date1->diffInDays($date2) + 1;
        $title  = "Recap Bulanan";
        $recaps = $this->model_order->queryRecapIncome($date1, $date2)->latest('created_at')->get();
        $chart  = $this->model_order->queryRecapIncome($date1, $date2)->selectRaw('DAY(created_at) as label,DAY(created_at) as day, sum(total+IFNULL(courier_price, 0)) as y,format(sum(total+IFNULL(courier_price, 0))/count(id_order),0) as avg, count(id_order) as id_order')->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $chart_outlet  = $this->model_order->queryRecapIncome($date1, $date2)->selectRaw('pickup as label, sum(total+IFNULL(courier_price, 0)) as y, count(id_order) as id_order')->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')->latest('y')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $total  = $this->model_order->queryRecapIncome($date1, $date2)->sum('total');
        $avg_7  = $this->model_order->queryRecapIncome($date1, $date2)->selectRaw("sum(total+IFNULL(courier_price, 0))/$diff as avg, round(count(id_order)/$diff,0) as count_order")->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')->first();

        return view('recap_monthly.index', compact('title', 'recaps', 'chart', 'chart_outlet', 'total', 'avg_7'));
    }

    public function updateDate(Request $request)
    {
        Order::where('id_order', $request->id_order)->update(['created_at' => $request->new_date]);
        return back();
    }

    public function recapOrder(Request $request)
    {
        $month  = $request->month ?? Carbon::now()->format('Y-m');
        $title  = "Recap jumlah order " . Carbon::create($month)->isoFormat('MMMM Y');
        $daily_order  = Order::where('created_at', 'like', $month . '%')->selectRaw("DAY(created_at) as label, count(id_order) as y, sum(sale_status != 'Need Payment') as paid")->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $chart_login  = Order::where('created_at', 'like', $month . '%')->selectRaw('DAY(created_at) as label, sum(cust_id != 0) as y')->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $chart_no_login  = Order::where('created_at', 'like', $month . '%')->selectRaw('DAY(created_at) as label, sum(cust_id = 0) as y')->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);

        return view('recap_monthly.recap_order', compact('title', 'chart_login', 'chart_no_login', 'daily_order'));
    }

    public function exportRecap(Request $request)
    {
        $month  = $request->month ?? Carbon::now()->format('Y-m');
        $method = $request->payment_method;
        $data   = $this->model_order->queryExportRecap($month, $method);

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
                ->setCellValue('G' . $column, $report->total)
                ->setCellValue('H' . $column, $report->pickup);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Report-Pembayaran-' . date('d-m-Y');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$filename.xlsx");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
