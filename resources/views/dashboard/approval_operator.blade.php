<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Aproval</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
    <style>
        .print-wrap {
            padding: 20px;
            font-size: 16px;
        }

        .print-wrap .hr {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .print-wrap .dashed {
            margin: 10px 0;
            border-bottom: 1px dashed black;
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

        .stamp {
            background-image: url("assets/images/admin/stamp.png");
            background-position: center;
            background-repeat: no-repeat;
            -webkit-print-color-adjust: exact;
        }

    </style>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.PrintArea.js') }}"></script>
</head>

<body>
    <!-- <div class="head-print"> -->
    <div id="print-area">
        <div class="fluid-container">
            <div class="print-wrap">
                <h3 class="text-center">NOTA APPROVAL</h3>
                <div class="text-center">
                    <img src="{{ asset('assets/images/logo/logo_idp.png') }}" class="w-25">
                </div>
                <div class="dashed"></div>
                <div class="pembayaran">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Product name</th>
                                <th>Quantity</th>
                                <th>attributes</th>
                                <th>Design</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($order->items)
                                @foreach (json_decode($order->items) as $cart)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="width: 15%;">
                                            {{ $cart->name }}
                                            <div>{{ isset($cart->satuan) ? '@' . rupiah($cart->satuan) : '' }}</div>
                                        </td>
                                        <td style="width: 5%;text-align:center">{{ $cart->qty }}</td>
                                        <td style="width: 50%;">
                                            @include('order._detail_attributes_item')
                                        </td>
                                        <td style="width: 30%;">
                                            <table class="table-borderless">
                                                @if (isset($cart->design))
                                                    @foreach (json_decode($cart->design) as $design)
                                                        @if (file_exists(public_path('assets/images/design-upload/' . $design)) == true)
                                                            @php
                                                                $ext = pathinfo($design)['extension'];
                                                                $images_ext = ['PNG', 'png', 'JPG', 'jpg', 'JPEG', 'jpeg', 'tif'];
                                                                $images_pdf = ['PDF', 'pdf'];
                                                                $images_archieve = ['RAR', 'ZIP', '7zip', '7z', 'rar', 'zip'];
                                                                $image = match (true) { in_array($ext, $images_ext) => "assets/images/design-upload/{$design}",  in_array($ext, $images_pdf) => "assets/images/design-upload/{$design}",  in_array($ext, $images_archieve) => 'assets/images/logo/logo_rar.png',  default => false };
                                                            @endphp

                                                            @if ($image)
                                                                <tr>
                                                                    <td style="text-align: center">
                                                                        <div>
                                                                            @if (in_array($ext, $images_ext))
                                                                                <img src="{{ asset($image) }}" alt="no files" width="100%">
                                                                            @elseif(in_array($ext, $images_pdf))
                                                                                <embed type="application/pdf" src="{{ asset($image) }}?page=1#toolbar=0" width="100%" height="300" />
                                                                                {{-- <embed src="{{ asset($image) }}?page=1#toolbar=0" width="100%" height="365px" /> --}}
                                                                            @endif
                                                                        </div>
                                                                        <div style="text-align: center">{{ $design }}</div>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td style="vertical-align: middle;width:10%">
                                                                        {{ $design }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @elseif($cart->link)
                                                    {{ $cart->link }}
                                                @else
                                                    <div class="text-center">No design</div>
                                                @endif
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <table class="table table-borderless text-center mt-5">
                    <tr>
                        <td>Customer Service</td>
                        <td>Operator</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img src="{{ url('assets/images/admin/stamp.png') }}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $data_erp->pic->name }}</td>
                        <td>{{ $data_erp->sale_items[0]->operator }}</td>
                    </tr>
                </table>
                <table style="margin-top: 20px;">
                    <tr>
                        <td>Mohon cermati nota dan aproval cetak agar tidak salah cetak. Dan mohon dipastikan nota ini sudah paid / Waiting production karena nota yang masih need payment tidak narik bahan.</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // $('#print-area').printArea();
        });
    </script>
</body>

</html>
