@extends('layouts.main')
@section('main')

        <section class="content text-md">
            <div class="container-fluid">
                <x-alert />
                <div class="card-body">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>
                                    <a href="javascript:void(0);" class="fad fa-copy mr-1" onclick="copyToClipboard('#invoice')"></a><span id="invoice">{{ $order->no_inv }}</span>
                                    <a href="{{ route('proced', ['id_order' => $order->id_order, 'proced' => $order->proced ? 0 : 1]) }}" class="loading">
                                        {!! $order->proced ? '<span class="badge badge-success">Sudah diproses</span>' : '<span class="badge badge-danger">Belum diproses</span>' !!}
                                    </a>
                                </h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-right">
                                    <small>{{ dateTimeID($order->created_at) }}</small>
                                </h4>
                            </div>
                        </div>
                        @include('order._detail_customer_info')

                        <div class="mb-4">
                            <a class="btn btn-secondary mx-2" href="{{ route('invoice.operator', ['invoice' => $order->no_inv]) }}" target="_blank">Invoice Operator</a>
                            <a class="btn btn-secondary mx-2" href="{{ route('approval.operator', ['invoice' => $order->no_inv]) }}" target="_blank">Approval Operator</a>
                        </div>

                        @if(!intval($order->items))
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Product name</th>
                                            <th>Quantity</th>
                                            <th>attributes</th>
                                            <th>Design <input type="checkbox" id="show-design"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($order->items)
                                            @foreach (json_decode($order->items) as $cart)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td style="width: 15%;">
                                                        <a href="http://indoprinting.co.id/produk/{{ $cart->id_product }}" target="_blank">{{ $cart->name }}</a>
                                                        <div>{{ isset($cart->satuan) ? '@' . rupiah($cart->satuan) : '' }}</div>
                                                    </td>
                                                    <td style="width: 5%;text-align:center">{{ $cart->qty }}</td>
                                                    <td style="width: 50%;">
                                                        @include('order._detail_attributes_item')
                                                    </td>
                                                    <td style="width: 30%;">
                                                        @include('order._detail_td_design')
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 2px">#</th>
                                            <th>Product name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Design</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($designs as $data)
                                                <?php
                                                $database = \Illuminate\Support\Facades\DB::table('nsm_order_products')
                                                    ->join('nsm_orders', 'nsm_orders.id', '=', 'nsm_order_products.order_id')
                                                    ->join('nsm_guests', 'nsm_guests.id', '=', 'nsm_orders.user_id')
                                                    ->where('nsm_order_products.order_id', $data->order_id)
                                                    ->get()
                                                ;
                                                ?>
                                                @foreach($database as $design)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="width: 30%;">
                                                    <a href="#" target="_blank">{{ $design->product_name }}
                                                </td>
                                                <td style="width: 10%;">{{ $design->qty }}</td>
                                                <td style="width: 20%;">{{ rupiah($design->product_price) }}</td>
                                                <td style="width: 40%;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <a href="https://indoprinting.co.id/studio/editor.php?pdf_download={{ $design->cart_id }}" class="btn btn-success" target=_blank>Download designs as PDF</a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="https://indoprinting.co.id/studio/editor.php?design_print={{ $design->design }}&order_print={{ $design->order_id }}&product_base={{ $design->product_base }}" class="btn btn-dark" target=_blank>View designs in IDP Studio</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>

    <script>
        $(document).ready(function() {
            $('.show-hide').hide();
            $('#show-design').on('click', function() {
                $('.show-hide').slideToggle("fast");
            });
        });

        function copyToClipboard(element) {
            let text = $(element).text();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            alert('Teks disalin');
            $temp.remove();
        }
    </script>
@endsection
