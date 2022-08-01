<?php

namespace App\Http\Controllers\Common;

use App\Models\PrintERP;
use App\Models\Shipping;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    protected $model_erp;
    public function __construct()
    {
        $this->model_erp    = new PrintERP();
    }
    public function notifSale()
    {
        $count      = Order::where('proced', 0)->count();
        return response()->json(['count' => $count]);
    }

    public function notifRajaOngkir()
    {
        $count  = Shipping::whereHas('order', fn ($query) => $query->whereIn('payment_status', ['Paid', 'Partial']))->where([['terkirim', '=', 0], ['courier_name', '!=', 'Gosend']])->count();
        return response()->json(['count' => $count]);
    }

    public function notifGosend()
    {
        $count  = Shipping::whereHas('order', fn ($query) => $query->whereIn('payment_status', ['Paid', 'Partial']))->where(['terkirim' => 0, 'courier_name' => 'Gosend'])->count();
        return response()->json(['count' => $count]);
    }

    public function notifTB()
    {
        $count  = Order::query()->whereNotIn('pickup', ['Indoprinting Durian'])->whereRaw("pickup != concat('Indoprinting ',warehouse)")->where('payment_status', 'Paid')->whereNull('tb')->count();
        return response()->json(['count' => $count]);
    }

    public function getOperators(Request $request)
    {
        $id = DB::table('adm_warehouses')->where('code', $request->warehouse)->value('id');
        $users  = collect($this->model_erp->getOperator())->where('warehouse_id', $id);
        foreach ($users as $user) :
            echo "<option value=''></option>";
            echo "<option value='$user->id'>$user->first_name $user->last_name</option>";
        endforeach;

        $users  = collect($this->model_erp->getTL())->where('warehouse_id', $id);
        foreach ($users as $user) :
            echo "<option value='$user->id'>$user->first_name $user->last_name</option>";
        endforeach;
    }

    public function ajaxGetCity(Request $request)
    {
        $cities = DB::table('local_cities')->where('province_id', $request->id)->get();
        foreach ($cities as $city) :
            echo "<option value='$city->city_id'>$city->city_name</option>";
        endforeach;
    }

    public function ajaxGetSuburb(Request $request)
    {
        $suburbs    = DB::table('local_suburbs')->where('city_id', $request->id)->get();
        foreach ($suburbs as $suburb) :
            echo "<option value='$suburb->suburb_id'>$suburb->suburb_name</option>";
        endforeach;
    }
}
