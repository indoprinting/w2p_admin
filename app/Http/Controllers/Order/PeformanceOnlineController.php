<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PeformanceOnlineController extends Controller
{
    protected $model_order;
    public function __construct()
    {
        $this->model_order = new Order();
    }

    public function index(Request $request)
    {
        $month  = $request->month ?? date('Y-m');
        $days   = Carbon::create($month)->daysInMonth;
        $day    = $month != date('Y-m') ? $days : Carbon::now()->isoFormat('D');
        $title  = "Peformance Tim Online " . Carbon::create($month)->isoFormat('MMMM Y');
        $target = optional(DB::table('adm_target')->where('created_at', $month)->first());
        $orders = $this->model_order->queryRecap($month)->selectRaw('DAY(created_at) as day, sum(total+IFNULL(courier_price, 0)) as revenue, count(id_order) as transaction')->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')->oldest('day')->groupBy('day')->get();
        $order  = $this->model_order->queryRecap($month)->selectRaw("sum(total+IFNULL(courier_price, 0)) as revenue,sum(total+IFNULL(courier_price, 0))/$day as avg_revenue,count(id_order) as transaction, count(id_order)/$day as avg_transaction")->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')->first();
        $visits = DB::table('idp_visitor_today')->where('created_at', 'like', "$month%")->selectRaw('DAY(created_at) as day, count(id) as visitor')->oldest('day')->groupBy('day')->get();
        $visit  = DB::table('idp_visitor_today')->where('created_at', 'like', "$month%")->selectRaw("count(id) as visitor, count(id)/$day as avg_visitor")->first();
        $products = Product::query()->where('created_at', 'like', "$month%")->selectRaw('DAY(created_at) as day, count(id_product) as product')->oldest('day')->groupBy('day')->get();
        $product  = Product::query()->count('id_product');

        return view('perform_online.index', compact('title', 'orders', 'order', 'visits', 'visit', 'product', 'products', 'days', 'day', 'target'));
    }

    public function setTarget(Request $request)
    {
        $month = $request->month ?? date('Y-m');
        DB::table('adm_target')->updateOrInsert(
            ['created_at' => $month],
            [
                'revenue'       => preg_replace('/[^0-9]/', '', $request->revenue),
                'transaction'   => $request->transaction,
                'visitor'       => $request->visitor,
                'product'       => $request->product
            ]
        );

        return redirect()->route('perform.online')->with('success', 'Berhasil update target');
    }

    public function rekapTimOnline(Request $request)
    {
        $month  = $request->month ?? date('Y-m');
        $title  = "Rekapan Tim Online Bulan " . Carbon::create($month)->isoFormat('MMMM Y');
        $cs     = explode(',', $request->cs);
        $id     = $cs[0] ?? Auth::user()->id;
        $name   = $cs[1] ?? Auth::user()->name;
        $chart  = $this->model_order->queryRecap($month)
            ->when(in_array($id, [9, 12, 13, 27]), function ($query, $id) use ($name) {
                return $query->where('cs', 'like', "%$name%");
            })->selectRaw('DAY(created_at) as label, sum(total+IFNULL(courier_price, 0)) as y, count(id_order) as jmlh_order')
            ->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')
            ->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $chart_eric  = $this->model_order->queryRecap($month)
            ->where('cs', 'Eric Noviyan Santri')
            ->selectRaw('DAY(created_at) as label, sum(total+IFNULL(courier_price, 0)) as y, count(id_order) as jmlh_order')
            ->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')
            ->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $chart_agung  = $this->model_order->queryRecap($month)
            ->where('cs', 'Agung Budi Setiyawan')
            ->selectRaw('DAY(created_at) as label, sum(total+IFNULL(courier_price, 0)) as y, count(id_order) as jmlh_order')
            ->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')
            ->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        // $chart_irman  = $this->model_order->queryRecap($month)
        //     ->where('cs', 'Irmansyah')
        //     ->selectRaw('DAY(created_at) as label, sum(total+IFNULL(courier_price, 0)) as y, count(id_order) as jmlh_order')
        //     ->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')
        //     ->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);
        $chart_david  = $this->model_order->queryRecap($month)
            ->where('cs', 'David Cahya Purnama')
            ->selectRaw('DAY(created_at) as label, sum(total+IFNULL(courier_price, 0)) as y, count(id_order) as jmlh_order')
            ->leftJoin('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')
            ->oldest('label')->groupBy('label')->get()->toJson(JSON_NUMERIC_CHECK);

        return view('recap_monthly.rekap_online', compact('title', 'chart', 'chart_eric', 'chart_agung', 'chart_david'));
    }
}
