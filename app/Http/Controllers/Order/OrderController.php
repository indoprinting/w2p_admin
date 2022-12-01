<?php

namespace App\Http\Controllers\Order;

use Carbon\Carbon;
use App\Models\Qris;
use App\Models\PrintERP;
use App\Models\Shipping;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    protected $model_erp;
    protected $model_qris;
    public function __construct()
    {
        $this->model_erp    = new PrintERP();
        $this->model_qris   = new Qris();
    }

    public function index(Request $request)
    {
        $title   = "Semua Transaksi";
        $status  = $request->status;
        $date1   = $request->date1 ?? Carbon::now()->subDays(30);
        $date2   = $request->date2 ?? Carbon::now();
        $orders  = Order::whereBetween('created_at', [$date1, $date2])->when($status, fn ($query, $status) => $query->where('sale_status', $status))->latest('created_at')->get();

        return view('order.index_order', compact('title', 'orders'));
    }

    public function detail(Order $order)
    {
        $title      = "Detail invoice {$order->no_inv}";
        $sale_erp   = $this->model_erp->getSale($order->no_inv, $order->cust_phone);
        $tl_erp     = $this->model_erp->getTL();
        $cs_erp     = $this->model_erp->getCS();
        $operators  = collect($this->model_erp->getOperator());
        if (!$sale_erp) return back()->with('error', 'Nota di print erp tidak ditemukan');
        $warehouses = DB::table('adm_warehouses')->get();
        $design_id = $_SERVER["REQUEST_URI"];
        $id_design = basename($design_id);
        $designs = DB::table('idp_orders')
            ->join('nsm_order_products', 'nsm_order_products.id', '=', 'idp_orders.items')
            ->join('nsm_orders', 'nsm_orders.id', '=', 'nsm_order_products.order_id')
            ->join('nsm_guests', 'nsm_guests.id', '=', 'nsm_orders.user_id')
            ->where('idp_orders.id_order', $id_design)
            ->get()
        ;

        return view('order.detail_order', compact('title', 'order', 'sale_erp', 'warehouses', 'operators', 'tl_erp', 'cs_erp', 'designs'));
    }

    public function updateInvoice(OrderRequest $request)
    {
        $edit_sale  = $this->model_erp->editSale($request);
        return $edit_sale
            ? redirect()->route('order.detail', $request->id_order)->with('success', 'Berhasil update sale print erp')
            : redirect()->route('order.detail', $request->id_order)->with('error', 'Gagal update sale print erp');
    }

    public function procedInvoice(Request $request)
    {
        Order::where('id_order', $request->id_order)->update(['proced' => $request->proced]);
        return redirect()->route('order.detail', ['order' => $request->id_order]);
    }

    public function downloadDesign(Request $request)
    {
        return response()->download(public_path("assets/images/design-upload/{$request->image}"));
    }

    public function downloadDesignOnline(Request $request)
    {
        $design = json_decode(Order::query()->where('no_inv', $request->inv)->value('items'))[0]->design_online;
        $pdf    = App::make('dompdf.wrapper');
        $pdf->loadview("order.download_design_online", compact('design'))->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->stream(str_replace('/', '-', $request->no_inv) . ".pdf");
    }

    public function downloadBuktiTransfer(Request $request)
    {
        return response()->download(public_path("assets/images/bukti-transfer/{$request->image}"));
    }

    public function destroy(Request $request)
    {
        $order  = Order::find($request->id_order);
        $delete = $this->model_erp->deleteNota($order->no_inv, $order->cust_phone);
        if ($delete) :
            Shipping::where('id_inv', $request->id_order)->delete();
            Order::where('id_order', $request->id_order)->delete();
            return back()->with('warning', "Invoice sudah dihapus");
        endif;
        return back()->with('error', "Invoice gagal dihapus");
    }

    public function completeOrder(Request $request)
    {
        Order::where('no_inv', $request->invoice)->update(['sale_status' => 'Finished', 'complete' => 1]);
        return back()->with('success', 'Sale status sudah diganti complete');
    }

    public function create(Request $request)
    {
        $title  = "Buat nota Web2Print";
        $erp = null;
        if ($request->invoice) :
            $erp = $this->model_erp->getSale($request->invoice);
        endif;

        return view('order.create', compact('title', 'erp'));
    }

    public function storeOrder(Request $request)
    {
        Order::query()->create([
            'no_inv'        => $request->no_inv,
            'cust_id'       => 0,
            'cust_name'     => $request->cust_name,
            'cust_phone'    => $request->cust_phone,
            'total'         => $request->total,
            'sale_status'   => $request->sale_status,
            'pickup'        => $request->pickup,
            'cs'            => $request->cs,
            'proced'        => 1,
            'complete'      => 1,
            'payment_method'    => $request->payment_method,
            'payment_status'    => $request->payment_status,
        ]);

        return redirect()->route('create.order')->with('success', 'Berhasil membuat invoice w2p');
    }

    public function sendTB(Request $request)
    {
        $update_status  = $this->model_erp->statusFinished($request);
        if ($update_status) {
            Order::query()->where('id_order', $request->id_order)->update(['tb' => date('Y-m-d H:i:s')]);
            return back()->with('success', 'TB dikirim');
        }
        return back()->with('error', 'Gagal update status finished, print erp sedang overload');
    }

    public function manualValidation(Request $request)
    {
        $validation = $this->model_erp->manualValidation($request);
        if ($validation) {
            Order::query()->where('id_order', $request->id_order)->update(['payment_status' => 'Paid']);
            return back()->with('success', 'Nota berhasil manual validasi');
        }
        return back()->with('error', 'Gagal manual validasi, print erp sedang overload');
    }

    public function manualValidationQris(Request $request)
    {
        $validation =  $this->model_qris->manualValidationQris($request);
        return $validation
            ? back()->with('success', 'Nota berhasil manual validasi')
            : back()->with('error', 'Gagal manual validasi, print erp sedang overload');
    }

    public function approvedInvoice(Request $request)
    {
        $approved = $this->model_erp->approvedInvoice($request->invoice);
        if ($approved) {
            return back()->with('success', 'Nota berhasil di approved');
        }
        return back()->with('error', 'Nota gagal di approved');
    }

    public function waPaid(Request $request)
    {
        waPaid($request->inv, $request->cust_phone, $request->ets, $request->id_order);
        return back()->with('success', 'Wa berhasil dikirim');
    }
}
