<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Qris extends Model
{
    use HasFactory;
    protected $api_qris;
    protected $api_erp;
    public function __construct()
    {
        $this->api_qris = Http::baseUrl('https://qris.id/restapi/qris');
        $this->api_erp  = Http::withOptions(['http_errors' => false])->baseUrl("https://printerp.indoprinting.co.id/api/v1/");
    }

    public function getQris($invoice, $price)
    {
        $qris   =  $this->api_qris->get('show_qris.php', [
            'do'        => 'create-invoice',
            'apikey'    => '139139211228911',
            'mID'       => '195255685725',
            'cliTrxNumber'  => $invoice,
            'cliTrxAmount'  => $price
        ]);
        if ($qris->successful()) :
            $data = $qris->object()->data;
            return DB::table('idp_qris')->updateOrInsert(
                ['invoice'  => $invoice],
                [
                    'invoice'   => $invoice,
                    'price'     => $price,
                    'qris_content'  => $data->qris_content,
                    'qris_nmid'     => $data->qris_nmid,
                    'qris_invoiceid'    => $data->qris_invoiceid,
                    'qris_request_date' => $data->qris_request_date
                ]
            );
        else :
            return false;
        endif;
    }

    public function checkQris($invoice)
    {
        $data = DB::table('idp_qris')->where('invoice', $invoice)->first();
        if (!$data) return false;
        $qris = $this->api_qris->get('checkpaid_qris.php', [
            'do'        => 'checkStatus',
            'apikey'    => '139139211228911',
            'mID'       => '195255685725',
            'invid'     => $data->qris_invoiceid,
            'trxvalue'  => $data->price,
            'trxdate'   => date('Y-m-d')
        ]);

        if ($qris->successful() && $qris->object()->data->qris_status == 'paid') :
            DB::table('idp_qris')->where('invoice', $invoice)->update(['qris_status' => $qris->object()->data->qris_status]);
            $this->api_erp->asForm()->post('validateQRIS', [
                'account_no'    => '2222004005',
                'amount'        => $data->price,
                'invoice'       => $data->invoice,
            ]);
            // DB::table('idp_orders')->where('no_inv', $invoice)->update(['payment_status' => 'Paid']);
            return true;
        else :
            return false;
        endif;
    }

    public function manualValidationQris($request)
    {
        DB::table('idp_qris')->where('invoice', $request->invoice)->update(['qris_status' => 'paid']);
        DB::table('idp_orders')->where('no_inv', $request->invoice)->update(['payment_status' => 'Paid']);
        $this->api_erp->asForm()->post('validateQRIS', [
            'account_no'    => '2222004005',
            'amount'        => $request->amount,
            'invoice'       => $request->invoice,
        ]);

        return true;
    }
}
