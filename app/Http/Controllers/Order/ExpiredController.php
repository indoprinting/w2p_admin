<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExpiredController extends Controller
{
    public function index(Request $request)
    {
        $title  = "List Expired";
        $date1  = $request->date1 ?? Carbon::now()->firstOfMonth();
        $date2  = $request->date2 ?? Carbon::now();
        $orders = Order::query()
            ->where('sale_status', 'Need Payment')
            ->where(function ($query) {
                $query->orWhere('payment_status', 'Pending')
                    ->orWhere('payment_status', 'Expired')
                    ->orWhere('payment_status', 'Due');
            })->whereBetween('created_at', [$date1, $date2])
            ->latest()->get();

        return view('expired.index_expired', compact('title', 'orders'));
    }

    public function checkOldCarts()
    {
        $carts  = DB::table('idp_carts')->get();
        foreach ($carts as $cart) :
            if (Carbon::create($cart->created_at)->diffInDays(Carbon::now()) > 90 && $cart->design) :
                foreach (json_decode($cart->design) as $design) :
                    if (file_exists(public_path('assets/images/design-upload/' . $design)) == true) :
                        unlink(public_path('assets/images/design-upload/' . $design));
                    endif;
                endforeach;
                DB::table('idp_carts')->where('id', $cart->id)->delete();
            endif;
        endforeach;
        return "DONE";
    }

    public function checkOldOrders()
    {
        $orders = DB::table('idp_orders')->where('checked', '!=', 1)->get();
        foreach ($orders as $order) :
            if (Carbon::create($order->created_at)->diffInDays(Carbon::now()) > 120) :
                $items = json_decode($order->items);
                foreach ($items as $item) :
                    if ($item->design) :
                        if (is_array($item->design)) :
                            foreach ($item->design as $design) :
                                if (file_exists(public_path('assets/images/design-upload/' . $design)) == true) :
                                    unlink(public_path('assets/images/design-upload/' . $design));
                                endif;
                            endforeach;
                        else :
                            foreach (json_decode($item->design) as $design) :
                                if (file_exists(public_path('assets/images/design-upload/' . $design)) == true) :
                                    unlink(public_path('assets/images/design-upload/' . $design));
                                endif;
                            endforeach;
                        endif;
                    endif;
                endforeach;
                Order::where('id_order', $order->id_order)->update(['checked' => 1]);
            endif;
        endforeach;

        return "CHECK ORDER DONE";
    }
}
