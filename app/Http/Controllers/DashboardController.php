<?php

namespace App\Http\Controllers;

use App\Models\PrintERP;
use App\Models\Dashboard;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Order\OverdueController;
use App\Models\Qris;

class DashboardController extends Controller
{
    protected $dashboard_model;
    protected $erp_model;
    protected $order_model;
    protected $qris_model;
    public function __construct()
    {
        $this->dashboard_model  = new Dashboard();
        $this->erp_model        = new PrintERP();
        $this->order_model      = new Order();
        $this->qris_model       = new Qris();
    }

    public function index(Request $request)
    {
        if (Auth()->user()->role == 6) return redirect()->route('tb');
        $unprocessed = request()->order;
        $orders     = $unprocessed ? $this->dashboard_model->unprocessedOrder() : $this->dashboard_model->recentOrder($request);
        return view('dashboard.index_dashboard', [
            'title'     => 'Dashboard',
            'count'     => $this->dashboard_model->countReport(),
            'sum'       => $this->dashboard_model->sumReport(),
            'orders'    => $orders,
            'best_seller' => $this->dashboard_model->bestSeller(),
            'total_shipping'    => $this->order_model->totalShipping(date('Y-m')),
        ]);
    }

    public function syncStatusSale(Request $request)
    {
        $overdue = new OverdueController();
        $orders = Order::when(
            $request->id_order,
            fn ($query, $id_order) => $query->where('id_order', $id_order),
            fn ($query) => $query->where('complete', 0)
        )->get();
        foreach ($orders as $order) :
            // if ($order->payment_method == "Qris" && $order->payment_status != "Paid") :
            //     $this->qris_model->checkQris($order->no_inv);
            // endif;
            $this->erp_model->syncStatusSale($order);
            $overdue->overdueGet($order->payment_date, $order->upload_date, $order->id_order, $order->sale_status);
        endforeach;
        return back()->with('success', 'Status selesai sinkronisasi');
    }

    public function printInvoice(Request $request)
    {
        $order      = Order::where('no_inv', $request->invoice)->first();
        $data_erp   = $this->erp_model->getSale($request->invoice);
        $harga_kurir = DB::table('idp_delivery')->where('no_inv', $request->invoice)->value('courier_price');
        $pdf        = App::make('dompdf.wrapper');
        $pdf->loadview("dashboard.invoice", compact('order', 'data_erp', 'harga_kurir'))->setPaper('letter', 'potrait')->setWarnings(false);
        return $pdf->stream(str_replace('/', '-', $order->no_inv) . ".pdf");
    }

    public function printInvoiceOperator(Request $request)
    {
        $order      = Order::where('no_inv', $request->invoice)->first();
        $data_erp   = $this->erp_model->getSale($request->invoice);
        $harga_kurir = DB::table('idp_delivery')->where('no_inv', $request->invoice)->value('courier_price');
        $pdf        = App::make('dompdf.wrapper');
        $pdf->loadview("dashboard.invoice_operator", compact('order', 'data_erp', 'harga_kurir'))->setPaper('legal', 'potrait')->setWarnings(false);
        return $pdf->stream(str_replace('/', '-', $order->no_inv) . ".pdf", array('Attachment' => 0));
    }

    public function approvalOperator(Request $request)
    {
        $order      = Order::where('no_inv', $request->invoice)->first();
        $data_erp   = $this->erp_model->getSale($request->invoice);
        // $pdf        = App::make('dompdf.wrapper');
        // $pdf->loadview("dashboard.approval_operator", compact('order', 'data_erp',))->setPaper('legal', 'potrait')->setWarnings(false);
        // return $pdf->stream(str_replace('/', '-', $order->no_inv) . ".pdf");
        return view("dashboard.approval_operator", compact('order', 'data_erp',));
    }
}
