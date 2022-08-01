<?php

namespace App\Models\Order;

use App\Models\Shipping;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'idp_orders';
    protected $primaryKey = 'id_order';
    protected $guarded  = ['id_order'];

    public function queryRecapIncome($date1, $date2)
    {
        // return Order::where('created_at', 'like', $month . '%')->whereNotIn('sale_status', ['Need Payment']);
        return Order::query()->whereBetween('created_at', [$date1, $date2])->whereNotIn('sale_status', ['Need Payment'])->whereNotIn('cs', ['Web2Print Account']);
    }

    public function queryRecap($month)
    {
        return Order::where('created_at', 'like', $month . '%')->whereNotIn('sale_status', ['Need Payment'])->whereNotIn('cs', ['Web2Print Account']);
    }

    public function totalShipping($month)
    {
        return DB::table('idp_orders')->join('idp_delivery', 'idp_delivery.id_inv', '=', 'idp_orders.id_order')
            ->where('created_at', 'like', $month . '%')->whereNotIn('sale_status', ['Need Payment'])->sum('courier_price');
    }

    public function queryExportRecap($month, $method)
    {
        return Order::where('created_at', 'like', $month . '%')
            ->whereNotIn('sale_status', ['Need Payment'])
            ->when($method, fn ($query, $method) => $query->where('payment_method', $method))
            ->get();
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'no_inv', 'id_order');
    }
}
