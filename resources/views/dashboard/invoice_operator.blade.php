<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <style>
        .print-wrap {
            display: block;
            /* margin-top: 10px; */
            width: 100%;
            padding: 20px;
            font-size: 16px;
            max-height: 100%
        }

        .print-wrap .hr {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }


        .print-wrap .logo-idp img {
            max-width: 40%;
            /* max-height: 40%; */
        }

        .print-wrap .invoice {
            /* max-width: 100%; */
            border: 1px solid black;
            /* padding: 10px; */
            border-radius: 8px;
        }

        .print-wrap .dashed {
            margin: 10px 0;
            border-bottom: 1px dashed black;
        }

        .print-wrap .table {
            margin-bottom: 0;
        }

        .print-wrap .table td {
            border-top: none;
            padding: 2px;
        }

        .print-wrap .pembayaran {
            width: auto;
            border: 1px solid black;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .print-wrap .pembayaran h3 {
            color: #e6583f;
        }

        .print-wrap .total {
            font-weight: 700;
            margin-left: 40%;
            width: auto;
            border: 1px solid black;
            padding: 10px;
            border-radius: 8px;
        }

        .print-wrap .signature-wrap {
            text-align: center;
            margin: 10px auto;
        }

        .table-signa {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            background-image: url("assets/images/admin/stamp.png");
            background-position: center top;
            background-repeat: no-repeat;
            -webkit-print-color-adjust: exact;
        }

        .stamp {
            background-image: url("assets/images/admin/stamp.png");
            background-position: center top;
            background-repeat: no-repeat;
            -webkit-print-color-adjust: exact;
        }

        .print-wrap .logo-idp {
            text-align: center;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
            min-height: 100px;
            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .float-right {
            float: right;
        }

        /* .border-tr {
            border: 2px solid black;
        } */

    </style>
</head>

<body>
    <!-- <div class="head-print"> -->
    <div class="container">
        <div class="print-wrap">
            <div class="logo-idp">
                <img src="{{ asset('assets/images/logo/logo_idp.png') }}">
            </div>
            <div class="invoice">
                <div class="row">
                    <div class="column">
                        <table class="table table-responsive">
                            <tr style="font-weight:bold">
                                <td style="width: 20%;">Nama</td>
                                <td>: {{ $order->cust_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>No. Telepon</td>
                                <td>: {{ $order->cust_phone ?? '' }}</td>

                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td>: {{ $order->cust_email ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{ $order->address ?? '' }}</td>
                            </tr>
                        </table>

                    </div>
                    <div class="column">
                        <table class="table table-responsive">
                            <tr>
                                <td width="20%">No. Invoice</td>
                                <td>: {{ $order->no_inv }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Order</td>
                                <td>: {{ dateTime($order->created_at) }}</td>

                            </tr>
                            <tr>
                                <td>Sale Status</td>
                                <td>: {{ $data_erp->sale->status }}</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td {{ $data_erp->sale->payment_status == 'Paid'? 'style="color: green;font-weight:700"': 'style="color: red;font-weight:700"' }}>: <?= $data_erp->sale->payment_status ?></td>
                            </tr>
                            <tr>
                                <td>Approval</td>
                                <td>: {!! $data_erp->sale->approved ? 'approved' : '<span style="color:red">not approved</span>' !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h3 style="text-align: center">
                    <em> DEADLINE : {{ $data_erp->sale->est_complete_date ? dateTimeID($data_erp->sale->est_complete_date) : 'Belum Lunas' }}</em>
                    <div>{{ $order->pickup }}</div>
                    @isset($harga_kurir)
                        <em style="color: green;margin-top: 10px">DELIVERY</em>
                    @endisset
                </h3>
            </div>
            <div class="dashed"></div>
            <div class="pembayaran table-responsive">
                <h3>Rincian Belanja</h3>
                {{-- <table class="table table-borderless">
                    @foreach ($data_erp->sale_items as $id_i => $item)
                        <tbody class="border-tr">
                            <tr>
                                <td colspan="3"><strong>{{ $item->product_name }}</strong></td>
                            </tr>
                            <tr>
                                <td class="indent" width="100px">Qty</td>
                                <td>: {{ $item->quantity }}</td>
                            </tr>
                            @if ($item->length != 0 && $item->width != 0)
                                <tr>
                                    <td class="indent">Ukuran</td>
                                    <td>: {{ $item->length . ' x ' . $item->width . ' M' }}</td>
                                </tr>
                            @endif
                            @if ($item->spec)
                                <tr>
                                    <td class="indent">Item note</td>
                                    <td class="unwrap">: {!! $item->spec !!}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="indent">Harga</td>
                                <td style="padding-bottom: 10px">: {{ rupiah($item->subtotal) }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                </table> --}}
                @foreach (json_decode($order->items) as $cart)
                    <table class="table table-borderless" style="border: 1px dashed black;width:100%;margin:10px 0;padding:5px">
                        @foreach (json_decode($cart->attributes)->jenis_atb as $id => $jenis_atb)
                            <tr>
                                <td class="text-bold">{{ $jenis_atb }}</td>
                                <td>:</td>
                                <td>{{ json_decode($cart->attributes, true)['nama_atb'][$id] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-bold">Qty</td>
                            <td>:</td>
                            <td>{{ $cart->qty }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Harga</td>
                            <td>:</td>
                            <td>{{ rupiah($cart->price) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Item note</td>
                            <td>:</td>
                            <td>{!! $cart->product_note !!}</td>
                        </tr>
                    </table>
                @endforeach
                <div class="hr"></div>
                <div>
                    <strong>Total Belanja</strong>
                    <span class="float-right">{{ rupiah($order->total) }}</span>
                </div>
            </div>
            <div class="total">
                @if ($order->payment_method == 'Transfer')
                    @isset($harga_kurir)
                        <div>
                            <strong>
                                Kode Unik
                            </strong>
                            <span class="float-right">{{ $data_erp->payment_validation->unique_code }}</span>
                        </div>
                    @endisset
                    <div style="color: blueviolet;">
                        <strong>
                            Kode Unik
                        </strong>
                        <span class="float-right">{{ $data_erp->payment_validation->unique_code }}</span>
                    </div>
                    <div>
                        <strong>
                            Total Pembayaran
                        </strong>
                        <span class="float-right">{{ rupiah($data_erp->payment_validation->transfer_amount) }}</span>
                    </div>
                @else
                    <div>
                        Total Pembayaran
                        <span class="float-right">{{ rupiah($data_erp->sale->grand_total) }}</span>
                    </div>
                @endif
            </div>
            <table class="table-signa">
                <tr>
                    <td>Customer Service</td>
                    <td>Operator</td>
                </tr>
                <tr class="stamp">
                    <td style="padding-top: 50px;">{{ $data_erp->pic->name }}</td>
                    <td style="padding-top: 50px;">{{ $data_erp->sale_items[0]->operator }}</td>
                </tr>
            </table>
            <table style="margin-top: 20px;">
                <tr>
                    <td>Mohon cermati nota dan aproval cetak agar tidak salah cetak. Dan mohon dipastikan nota ini sudah paid / Waiting production karena nota yang masih need payment tidak narik bahan.</td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
