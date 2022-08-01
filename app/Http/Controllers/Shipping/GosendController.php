<?php

namespace App\Http\Controllers\Shipping;

use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GosendController extends Controller
{
    protected $model_shipping;
    public function __construct()
    {
        $this->model_shipping   = new Shipping();
    }

    public function index()
    {
        $title  = "Shipping Gosend";
        $orders = Shipping::query()->where('courier_name', 'Gosend')->whereIn('payment_status', ['Paid', 'Partial'])->join('idp_orders', 'idp_orders.id_order', '=', 'idp_delivery.id_inv')->latest('id')->get();
        return view('shipping.index_shipping', compact('title', 'orders'));
    }

    public function getDriver($id)
    {
        $data_gosend    = Shipping::where('id', $id)->value('data_gosend');
        $get_driver     = $this->model_shipping->getDriverGosend($data_gosend);

        if ($get_driver->successful()) { // Must return >= 200 and < 300
            if ($this->model_shipping->getLiveTrackingGosend($get_driver->object()->orderNo, $id)) {
                file_put_contents(__DIR__ . '/GosendController.log', print_r($get_driver->object(), TRUE));
                Shipping::where('id', $id)->update(['resi' => $get_driver->object()->orderNo, 'terkirim' => 1]);
                return back()->with('success', 'Berhasil memanggil driver');
            }

            return back()->with('error', "No order dari GoSend tidak valid. [{$get_driver->status()}]: {$get_driver->throw()}");
        }

        return back()->with('error', "Gagal memanggil driver, code: {$get_driver->status()}, pesan: {$get_driver->throw()}");
    }

    public function cancelGosend($resi)
    {
        $api = $this->model_shipping->cancelGosend($resi);

        if ($api->successful()) :
            Shipping::where('resi', $resi)->update(['tracking_gosend' => null, 'resi' => null, 'terkirim' => 0]);
            return back()->with('warning', 'Pengiriman dicancel');
        else :
            return back()->with('error', "Gagal memanggil gosend, code: {$api->status()}, pesan: {$api->throw()}");
        endif;
    }

    public function hapusOrder($id)
    {
        // Bisa untuk selain Gosend.

        if (Shipping::where('id', $id)->delete()) {
            return back()->with('success', 'Berhasil menghapus order.');
        }
        return back()->with('error', 'Gagal menghapus order.');
    }

    public function cekGosend($resi)
    {
        if ($this->model_shipping->isValidGosendTracking($resi)) {
            return back()->with('success', 'Tracking valid.');
        }
        return back()->with('error', 'Tracking tidak valid.');
    }
}
