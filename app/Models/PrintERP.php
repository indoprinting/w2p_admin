<?php

namespace App\Models;

use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrintERP extends Model
{
    use HasFactory;
    protected $api_erp;
    public function __construct()
    {
        $this->api_erp  = Http::withOptions(['http_errors' => false])->baseUrl("https://printerp.indoprinting.co.id/api/v1/");
    }

    public function getSale($invoice)
    {
        $api_sale = $this->api_erp->get('sales', ['invoice' => $invoice])->object();
        if ($api_sale->error == 0) {
            return $api_sale->data;
        }
        return false;
    }

    public function getTL()
    {
        return cache()->rememberForever('list-tl', fn () => $this->api_erp->get('users', ['group' => 'tl'])->object()->users);
    }

    public function getCS()
    {
        return cache()->rememberForever('list-cs', fn () => $this->api_erp->get('users', ['group' => 'cs'])->object()->users);
    }

    public function approvedInvoice($invoice)
    {
        $api_sale = $this->api_erp->asForm()->post('sales/edit', [
            'invoice' => $invoice,
            'approved' => 1
        ])->object();
        if ($api_sale->error == 0) {
            Order::where('no_inv', $invoice)->update(['approved' => 1]);
            return true;
        }
        return false;
    }

    public function getOperator()
    {
        return cache()->rememberForever('list-operator', fn () => $this->api_erp->get('users', ['group' => 'operator'])->object()->users);
    }

    public function getWarehouse()
    {
        return cache()->remember('warehouse_erp', cacheTime(), function () {
            return $this->api_erp->get('warehouses')->object()->data;
        });
    }

    public function editSale($request)
    {
        $memo       = dateTimeID($request->ets) . ' ' . $request->pickup . ' ' . $request->pickup_method;
        $warehouse  = $request->warehouse;
        $inv        = $request->invoice;
        $order      = Order::where('no_inv', $inv)->first();
        try {
            $this->api_erp->asForm()->post('sales/edit', [
                'invoice'   => $inv,
                'note'      => $memo,
                'warehouse' => $warehouse,
                'pic_id'    => $request->pic,
                'est_complete_date' => $request->ets
            ]);

            foreach ($this->getSale($inv)->sale_items as $sale_item) :
                $sale_items = $this->api_erp->asJson()->post('saleitems', [
                    [
                        'id'            => $sale_item->id,
                        'due_date'      => $request->ets,
                        'operator_id'   => $request->operator
                    ]
                ]);
            endforeach;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

        return Order::where('no_inv', $inv)->update([
            'message'   => $request->message,
            'proced'    => 1
        ]);
    }

    public function getProduct()
    {
        return cache()->rememberForever('product_erp', function () {
            return $this->api_erp->get('products')->object()->products;
        });
    }

    public function deleteNota($invoice, $phone)
    {
        return $this->api_erp->asForm()->post('sales/delete',  ['invoice' => $invoice, 'phone' => $phone]);
    }

    public function statusFinished($request)
    {
        $api_sale = $this->api_erp->asForm()->post('sales/status', ['invoice' => $request->invoice, 'status' => 'finished']);
        if ($api_sale->successful() || $api_sale->object()->error == 0) {
            return true;
        }
        return false;
    }

    public function manualValidation($request)
    {
        $img   = $request->bukti_tf;
        if (!$img->isValid()) :
            return false;
        endif;

        $bukti_tf = $img->getClientOriginalName();
        $api    = $this->api_erp->asMultipart()->post('mutasibank/manualValidation', [
            'account_no'    => $request->rekening,
            'amount'        => $request->amount,
            'invoice'       => $request->invoice,
            'attachment'    => $bukti_tf,
            'transaction_date'    => $request->transaction_date,
        ]);

        if ($api->successful() || $api->object()->error == 0) {
            return true;
        }
        return false;
    }

    public function syncStatusSale($order)
    {
        try {
            $api_sale   = $this->api_erp->get('sales', ['invoice' => $order->no_inv])->object();
            if ($api_sale->error == 0) :
                $data       = $api_sale->data;
                $payment    = $data->sale->payment_status;
                $status     = $data->sale->status;
                $payment_date = $data->payments[0]->date ?? null;
                $complete   = (in_array($status, ["Completed", "Delivered", "Finished"]) || in_array($payment, ["Expired", "Due"])) ? 1 : 0;
                $proced     = in_array($payment, ["Expired", "Due"]) ? 1 : $order->proced;
                if ($order->payment_method == "Cash" &&  $data->sale->payment_due_date < date('Y-m-d H:i:s') && $status == "Need Payment") :
                    $proced = 1;
                    $complete = 1;
                endif;

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
                    'approved'          => $data->sale->approved
                ]);

                if ($payment == "Paid" && DB::table('idp_best_seller')->where('id_order', $order->id_order)->doesntExist() && $order->items) :
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
                return true;
            endif;
        } catch (\Throwable $th) {
            dd($th->getMessage() . ', Terdapat error di no invoice : ' . $order->no_inv . ' atas nama : ' . $order->cust_name);
            return storeError("Dashboard", "Sync status di dashboard, {$order->no_inv}", $th->getMessage());
        }
    }

    public function syncProduct($id = null)
    {
        $products        = Product::all();
        // dd($products);
        foreach ($products as $product) :
            try {
                $id             = $product->id_product;
                $attributes     = json_decode($product->attributes['attributes']);
                $material       = json_decode($product->material);
                $atb_name       = $attributes->name;
                $temp_v_code    = array();
                $temp_v_name    = array();
                $temp_v_price   = array();
                $temp_v_qty     = array();
                $temp_v_range   = array();
                $value_code     = array();
                $value_name     = array();
                $value_price    = array();
                $value_qty      = array();
                $value_range    = array();
                $m_code         = array();
                $m_name         = array();
                $m_price        = array();
                $m_qty_range    = array();
                $m_price_range  = array();
                $m_category     = array();
                $m_min_price    = array();
                //----------------------------------------material----------------------------------------------------------
                foreach ($material->material_code as $kode) :
                    $api = $this->api_erp->get('products', ['code' => $kode])->object();
                    if ($api->error == 0) :
                        $bahan  = $api->products[0];
                        array_push($m_code, $bahan->code);
                        array_push($m_name, $bahan->name);
                        array_push($m_price, $bahan->price);
                        array_push($m_qty_range, $bahan->price_ranges_value);
                        array_push($m_price_range, $bahan->product_prices);
                        array_push($m_category, $bahan->category_code);
                        array_push($m_min_price, min(json_decode($bahan->product_prices, true)));
                    endif;
                endforeach;
                //----------------------------------------atribut selain bahan dan ukuran--------------------------------------
                foreach ($attributes->value->value_code as $v_code) :
                    foreach ($v_code as $v) :
                        $api = $this->api_erp->get('products', ['code' => $v])->object();
                        if ($api->error == 0) :
                            $bahan  = $api->products[0];
                            array_push($temp_v_code, $bahan->code);
                            array_push($temp_v_name, $bahan->name);
                            array_push($temp_v_price, $bahan->price);
                            array_push($temp_v_qty, $bahan->price_ranges_value);
                            array_push($temp_v_range, $bahan->product_prices);
                        endif;
                    endforeach;
                    array_push($value_code, $temp_v_code);
                    array_push($value_name, $temp_v_name);
                    array_push($value_price, $temp_v_price);
                    array_push($value_qty, $temp_v_qty);
                    array_push($value_range, $temp_v_range);
                    $temp_v_code   = array();
                    $temp_v_name   = array();
                    $temp_v_price  = array();
                    $temp_v_qty    = array();
                    $temp_v_range  = array();
                endforeach;

                $bahan          = array(
                    'material_code'     => $m_code,
                    'material_name'     => $m_name,
                    'material_price'    => $m_price,
                    'material_qty'      => $m_qty_range,
                    'material_range'    => $m_price_range,
                    'material_category' => $m_category,
                );
                $atribut        = array(
                    'name'      => $atb_name,
                    'value'     => array(
                        'value_code'    => $value_code,
                        'value_name'    => $value_name,
                        'value_price'   => $value_price,
                        'value_qty'     => $value_qty,
                        'value_range'   => $value_range,
                    ),
                );
                $min_price      = min($m_min_price);
                $bahan_json     = json_encode($bahan);
                $atribut_json   = json_encode($atribut);
                //----------------------------------------update database w2p----------------------------------------------------------
                Product::where('id_product', $id)->update([
                    'material'      => $bahan_json,
                    'attributes'    => $atribut_json,
                    'min_price'     => $min_price,
                ]);
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        endforeach;
        return true;
    }
}
