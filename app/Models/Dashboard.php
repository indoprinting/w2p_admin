<?php

namespace App\Models;

use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dashboard extends Model
{
    use HasFactory;
    protected $model_order;
    public function __construct()
    {
        $this->model_order = new Order();
    }

    public function countReport()
    {
        return (object)[
            'visitor'       => DB::table('idp_visitor')->count(),
            'visitor_today' => DB::table('idp_visitor_today')->where('created_at', 'like', date('Y-m-d') . '%')->count(),
            'customers'     => DB::table('idp_customers')->count(),
            'products'      => Product::count(),
            'orders'        => Order::count(),
            'tb'            => Order::query()->whereNotIn('pickup', ['Indoprinting Durian'])->whereRaw("pickup != concat('Indoprinting ',warehouse)")->where('payment_status', 'Paid')->whereNull('tb')->count(),
            'unprocessed_order' => $this->unprocessedOrder()->count(),
            'order_this_month'  => Order::where('created_at', 'like', date('Y-m') . '%')->count(),
        ];
    }

    public function sumReport()
    {
        return (object)[
            'monthly'   => Order::where('created_at', 'like', date('Y-m') . '%')->whereNotIn('sale_status', ['Need Payment'])->sum('total'),
            'daily'     => Order::where('created_at', 'like', date('Y-m-d') . '%')->whereNotIn('sale_status', ['Need Payment'])->sum('total'),
        ];
    }

    public function bestSeller()
    {
        return DB::table('idp_best_seller')
            ->selectRaw('name, thumbnail, sum(qty) as sold_out')
            ->whereNotIn('id_product', [197])
            ->groupBy('id_product')
            ->having('sold_out', '>', 0)
            ->latest('sold_out')
            ->first();
    }

    public function recentOrder($request)
    {
        $type = $request->type;
        return Order::query()
            ->select('*', 'idp_orders.no_inv as invoice')
            ->when($request->keyword, function ($query, $keyword) use ($type) {
                $query->where($type, 'like', "%$keyword%");
            })
            ->where(function ($query) {
                $query->where('proced', 0)
                    ->orWhere('complete', 0);
            })
            ->join('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order', 'left')
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();
    }

    public function unprocessedOrder()
    {
        return Order::query()
            ->select('*', 'idp_orders.no_inv as invoice')
            ->where('proced', 0)
            ->join('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order', 'left')
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();
    }
}
