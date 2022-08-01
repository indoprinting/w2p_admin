<?php

namespace App\Http\Controllers\Webhook;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PrintERPWebhookController extends Controller
{
    public function salesERP()
    {
        $file = file_get_contents("php://input");
        $data_sale = json_decode($file);
        if ($data_sale->error == 0) :
            $data       = $data_sale->data;
            $order      = Order::query()->where('no_inv', $data->sale->no)->first();
            $payment    = $data->sale->payment_status;
            $status     = $data->sale->status;
            $payment_date = $data->payments[0]->date ?? null;
            $complete   = (in_array($status, ["Delivered", "Finished"]) || in_array($payment, ["Expired", "Due"])) ? 1 : 0;
            $proced     = in_array($payment, ["Expired", "Due"]) ? 1 : $order->proced;

            Order::where('id_order', $order->id_order)->update([
                'payment_status'    => $data->sale->payment_status,
                'sale_status'       => $status,
                'target'            => $data->sale->est_complete_date ?? 0,
                'payment_date'      => $payment_date,
                'cs'                => $data->pic->name,
                'operator'          => $data->sale_items[0]->operator,
                'amount_tf'         => $data->payment_validation->transfer_amount ?? null,
                'waiting_production' => $data->sale->waiting_production_date,
                'complete'          => $complete,
                'proced'            => $proced,
                'warehouse'         => $data->sale->warehouse,
            ]);

            if ($payment == "Paid" && DB::table('idp_best_seller')->where('id_order', $order->id_order)->doesntExist()) :
                foreach (json_decode($order->items) as $product) :
                    if (isset($product->id_product)) :
                        DB::table('idp_best_seller')->insert([
                            'id_order'      => $order->id_order,
                            'outlet'        => $order->pickup,
                            'created_at'    => $order->created_at,
                            'updated_at'    => $order->created_at,
                            'id_product'    => $product->id_product,
                            'name'          => $product->name,
                            'thumbnail'     => $product->thumbnail,
                            'qty'           => $product->qty,
                            'price'         => $product->price,
                        ]);
                    endif;
                endforeach;
            endif;
        endif;

        $date   = date('Y-m-d-H-i-s');
        $path   = public_path("webhook/printERP/{$date}.txt");
        file_put_contents($path, $file);
        return response('success', 200);
    }
}
