<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'idp_delivery';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $rajaongkir;
    protected $gosend;
    public function __construct()
    {
        $this->rajaongkir   = Http::baseUrl("https://pro.rajaongkir.com/api/")->withHeaders(['key' => 'a8d6b05e4211851c4d307d28263ff8e6'])->withOptions(['http_errors' => false]);

        if (env('APP_ENV') == "production") {
            $this->gosend   = Http::baseUrl("https://kilat-api.gojekapi.com/gokilat/v10/")
                ->withHeaders([
                    "Client-ID"    => "indoprinting-engine",
                    "Pass-Key"    => "6e86c4e7da59aefc450a253dbc5bee22bdd5937e06885ff6ef2f61c89e3805c3",
                ])->withOptions(['http_errors' => false]);
        } else {
            // $this->gosend   = Http::baseUrl("https://integration-kilat-api.gojekapi.com/gokilat/v10/")
            //     ->withHeaders([
            //         "Client-ID"    => "indoprinting-engine",
            //         "Pass-Key"    => "635e9496ebf113291f53e6c99ee2805363db7fe46b442db29e29b906a71a40c3",
            //     ])->withOptions(['http_errors' => false]);
        };
    }


    public function order()
    {
        return $this->hasOne(Order::class, 'id_order', 'id_inv');
    }

    public function getDetailRajaongkir($request)
    {
        // $waybill	= file_get_contents("waybill-success.json");
        $waybill    = $this->rajaongkir->asForm()->post("waybill", ['waybill' => $request->resi, 'courier' => $request->kurir]);
        if ($waybill->successful()) :
            return (object)[
                'summary'   => $waybill->object()->rajaongkir->result->summary,
                'detail'    => $waybill->object()->rajaongkir->result->details,
                'status'    => $waybill->object()->rajaongkir->result->delivery_status,
                'manifest'  => $waybill->object()->rajaongkir->result->manifest,
            ];
        endif;
        return redirect()->route('rajaongkir')->with('error', 'Nomor resi tidak valid');
    }

    public function getDataExport($request)
    {
        $date1  = $request->date1 ?? Carbon::now()->startOfMonth();
        $date2  = $request->date2 ?? Carbon::now();
        $kurir  = $request->kurir;
        $query  = fn ($query) => $query->where('payment_status', 'Paid')->whereBetween('created_at', [$date1, $date2]);
        return Shipping::whereHas('order', $query)->with('order')->when(
            $kurir == "gosend",
            fn ($query) => $query->where('courier_name', 'Gosend'),
            fn ($query) => $query->whereNotIn('courier_name', ['Gosend'])
        )->where('terkirim', 1)->latest('id')->get();
    }

    public function getDriverGosend($data_gosend)
    {
        return $this->gosend->asJson()->post('booking', json_decode($data_gosend, true));
    }

    public function getLiveTrackingGosend($no_order, $id)
    {
        // Changed 2022-07-01 10:56:57
        $request = $this->gosend->get("booking/orderno/$no_order");

        if ($request->successful() && $api = $request->object()) {
            // if ($api = $this->gosend->get("booking/orderno/$no_order")->object()) {
            Shipping::where('id', $id)->update(['tracking_gosend' => $api->liveTrackingUrl]);
            return TRUE;
        }
        return FALSE;
    }

    public function cancelGosend($resi)
    {
        return $this->gosend->asJson()->put("booking/cancel", ['orderNo' => $resi]);
    }

    public function getRajaOngkir($post)
    {
        $berat  = $post->weight ?? $post->berat;
        $data   = [
            'origin'            => 5498,
            'originType'        => "subdistrict",
            'destination'       => $post->suburb_id,
            'destinationType'   => "subdistrict",
            "weight"            => ($berat * 1000) * $post->qty,
            'courier'           => "sicepat:ide:anteraja:jne:pos:jnt"
        ];

        $rajaongkir = Http::withHeaders(['key' => 'a8d6b05e4211851c4d307d28263ff8e6'])
            ->post('https://pro.rajaongkir.com/api/cost', $data);
        return $rajaongkir->successful() ? $rajaongkir->object()->rajaongkir->results : false;
    }

    public function getGosend($destination)
    {
        $gosend = $this->gosend->get("calculate/price", [
            'http_errors'   => false,
            "origin"        => '-7.065086600767203,110.42756631026865',
            "destination"   => $destination,
            "paymentType"   => 3,
        ]);
        return $gosend->successful() ? $gosend->object() : null;
    }

    public function isValidGosendTracking($resi)
    {
        $req = $this->gosend->get("booking/orderno/{$resi}");

        if ($req->successful() && !empty($req->body())) {
            $api = $req->object();

            if (isset($api->driverId) && $api->driverId) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
