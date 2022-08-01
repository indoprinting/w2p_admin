<?php

use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

function cacheTime()
{
    return 60 * 60 * 24;
}

function clearCache()
{
    return DB::table('adm_cache')->whereNotIn('key', ['cache_warehouse_erp'])->delete();
}

function storeError($location, $detail, $messages)
{
    return DB::table('adm_error_report')->insert([
        'location'  => $location,
        'detail'    => $detail,
        'messages'  => $messages,
        'created_at'    => date('Y-m-d H:i:s')
    ]);
}

function rupiah($angka)
{
    if ($angka == null || $angka == '') {
        $angka = 0;
    }
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function rupiah2($angka)
{
    if ($angka == null || $angka == '') {
        $angka = 0;
    }
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function set62($phone)
{
    if (substr(trim($phone), 0, 1) == 0) :
        return "62" . substr($phone, 1);
    elseif (substr(trim($phone), 0, 3) == '+62') :
        return $phone;
    elseif (substr(trim($phone), 0, 2) == '62') :
        return "$phone";
    endif;
}

function phone62($phone)
{
    if (substr(trim($phone), 0, 1) == 0) :
        return "62" . substr($phone, 1);
    elseif (substr(trim($phone), 0, 3) == '+62') :
        return "62" . substr($phone, 3);
    elseif (substr(trim($phone), 0, 2) == '62') :
        return "$phone";
    endif;
}

function checkDesign($design)
{
    $file       = new SplFileInfo(public_path("assets/images/design-upload/{$design}"));
    $img_size   = $file->getSize();
    $size       = round($img_size / 1024 / 1024, 2);
    $ext        = pathinfo($design)['extension'];
    $images_ext = ['PNG', 'png', 'JPG', 'jpg', 'JPEG', 'jpeg', 'tif'];
    $images_pdf = ['PDF', 'pdf'];
    $images_archieve = ['RAR', 'ZIP', '7zip', '7z', 'rar', 'zip'];
    $image =  match (true) {
        in_array($ext, $images_ext)  => "assets/images/design-upload/{$design}",
        in_array($ext, $images_pdf)  => "assets/images/design-upload/{$design}",
        in_array($ext, $images_archieve)  => "assets/images/logo/logo_rar.png",
        default => false,
    };

    return $image ? (object)['size' => $size, 'image' => $image] : false;
}

function waPaid($invoice, $phone, $estimasi, $id_order)
{
    $api    = Http::withToken('gWC4p3Kr3V15ImUlUd4R1DuLu94kK3l4rkELaR')->baseUrl("https://api.indoprinting.co.id/v1/");
    // Order::query()->where('id_order', $id_order)->update(['wa' => 1]);
    $tgl_exp    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 1days'));
    $tgl_exp    = dateTimeID($tgl_exp);
    $wa_phone   = set62($phone);
    $message    = "Pembayaran untuk no invoice *{$invoice}* sudah tervalidasi. Estimasi produk jadi *{$estimasi}*. \r\n\r\nPantau Status Orderan kaka (produksi sd pengiriman) \r\ndengan klik tautan berikut : \r\n*https://indoprinting.co.id/trackorder?invoice=$invoice*.\r\n\r\nTerimakasih, \r\nindoprinting.co.id \r\n#PesanOtomatis";
    // $api->asForm()->post("whatsapp/send", ['phone' => $wa_phone, 'message' => $message])->body();
    if ($api->asForm()->post("whatsapp/send", ['phone' => $wa_phone, 'message' => $message])->successful()) {
        Order::query()->where('id_order', $id_order)->update(['wa' => 1]);
        return true;
    }
    return false;
}
