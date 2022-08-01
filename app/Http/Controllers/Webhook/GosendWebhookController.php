<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GosendWebhookController extends Controller
{

    public function GosendIntegration()
    {
        $file   = file_get_contents("php://input");
        $date     = date("Y-m-d(His)");
        $path     = public_path("webhook/gosend-integration/$date.txt");
        file_put_contents($path, $file);
        return response('success', 200);
    }

    public function GosendProduction()
    {
        $file   = file_get_contents("php://input");
        $gosend = json_decode($file);
        DB::table('idp_delivery')->where('resi', $gosend->booking_id)->update([
            'status_delivery'   => $gosend->status,
            'keterangan'        => $gosend->cancellation_reason,
            'driver_name'       => $gosend->driver_name,
        ]);
        $date     = date("Y-m-d(His)");
        $path     = public_path("webhook/gosend-production/$date.txt");
        file_put_contents($path, $file);
        return response('success', 200);
    }
}
