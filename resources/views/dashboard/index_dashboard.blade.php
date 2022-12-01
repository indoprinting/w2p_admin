@extends('layouts.main')
@section('main')
    @role([1, 3, 5])
        @include('dashboard._report1')
        @include('dashboard._report2')
        @include('dashboard._report3')
    @endrole

    @role([4])
        @include('dashboard._report_cashier')
    @endrole

    <x-alert />
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-bag"></i>
                    Recent orders
                </h3>
                <div class="float-right">
                    @auth
                        @include('dashboard._export_overdue_get')
                    @endauth
                </div>
            </div>
            <div class="card-body text-sm">
                <div class="mb-4">
                    <a href="{{ route('sync.status') }}" class="btn btn-danger w-100 loading">JANGAN LUPA SINKRONISASI STATUS W2P DENGAN PRINT ERP, <b>KLIK DISINI UNTUK SINKRONISASI</b></a>
                </div>
                <form style="display: flex;align-items: center;" class="mb-2 w-50 float-right">
                    <x-select name="type" style="margin-right: 5px;width: 25%">
                        <option value="idp_orders.no_inv" @if (request()->type == 'idp_orders.no_inv') selected @endif>Invoice</option>
                        <option value="idp_orders.cust_name" @if (request()->type == 'idp_orders.cust_name') selected @endif>Customer</option>
                        <option value="idp_orders.operator" @if (request()->type == 'idp_orders.operator') selected @endif>Operator</option>
                        <option value="idp_orders.cs" @if (request()->type == 'idp_orders.cs') selected @endif>PIC</option>
                    </x-select>
                    <x-input name="keyword" value="{{ request()->keyword }}" style="margin-right: 5px" />
                    <button class="btn btn-info">Search</button>
                </form>
                <table class="table table-bordered table-responsive display" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th width="20px">Action</th>
                            <th class="non-mobile">Tanggal Order</th>
                            <th>No. Invoice</th>
                            <th>Nama Pelanggan</th>
                            <th class="non-mobile">Total pembayaran</th>
                            <th>Status</th>
                            <th class="non-mobile">Bukti TF</th>
                            <th>Alamat Pickup</th>
                            <th>Shipping</th>
                            <th class="non-mobile">Due Date</th>
                            <th class="non-mobile">Approval</th>
                            <th class="non-mobile">PIC</th>
                            <th class="non-mobile">Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $i => $order)
                            <tr class="{{ $order->proced == 0 ? 'text-danger text-bold' : '' }}">
                                <td>{{ ($orders->currentpage() - 1) * $orders->perpage() + $loop->index + 1 }}</td>
                                <td>
                                    <a href="{{ route('sync.status', ['id_order' => $order->id_order]) }}" class="loading btn btn-info d-block my-2">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                    <a class="d-block btn btn-secondary my-2" href="{{ route('print.invoice', ['invoice' => $order->invoice]) }}" target="_blank">Print</a>
                                    @role([1, 5])
                                        @if ($order->sale_status == 'Need Payment')
                                            <a class="d-block btn btn-danger" href="{{ route('order.delete', ['id_order' => $order->id_order]) }}" onclick='javascript:return confirm("Hapus invoice {{ $order->invoice }} ? Pastikan sudah sinkron status !")' class="my-2">Hapus</a>
                                        @else
                                            <a class="d-block btn btn-success" href="{{ route('order.complete', ['invoice' => $order->invoice]) }}" onclick='javascript:return confirm("Invoice {{ $order->invoice }} ganti status ke Finished ? hanya berubah di web2print saja tidak mempengaruhi print erp.")' class="my-2">Finished</a>
                                        @endif
                                    @endrole
                                </td>
                                <td>
                                    {{ dateTime($order->created_at) }}
                                </td>
                                <td><a href="{{ route('order.detail', $order->id_order) }}" target="_blank">{{ $order->invoice }}</a></td>
                                <td width="10%">
                                    {{ $order->cust_name }} <i class="{{ $order->cust_id == 0 ? 'fas fa-external-link-alt text-warning' : '' }}" style="font-size:8px"></i>
                                </td>
                                <td>
                                    {{ rupiah($order->amount_tf ? $order->amount_tf : $order->total) }}
                                </td>
                                <td>
                                    {{ $order->sale_status }}
                                </td>
                                <td class="text-center">
                                    @if ($order->payment_proof)
                                        @include('dashboard._payment_proof')
                                    @endif
                                </td>
                                <td>
                                    {{ $order->pickup }} {{ $order->pickup_method == 'Delivery' ? ' - Delivery' : '' }}
                                </td>
                                <td>
                                    @if ($order->courier_name)
                                        {{ $order->courier_name == 'Gosend' ? 'Gosend' : 'Raja Ongkir' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $order->target ? dateTime($order->target) : 'Belum dibayar' }}
                                </td>
                                <td>{{ $order->approved == 1 ? 'Approved' : 'Not Approved' }}</td>
                                <td>
                                    @if ($order->payment_method == 'Cash')
                                        {{ $order->cs == 'Web2Print Account' ? 'Cashier' : $order->cs }}
                                    @else
                                        {{ $order->cs == 'Web2Print Account' ? 'Tim Online' : $order->cs }}
                                    @endif
                                </td>
                                <td>
                                    {{ $order->operator != 'Web2Print Account' ? $order->operator : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right mt-2">{{ $orders->links() }}</div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#loading").hide();
            $(".loader").hide();
            $('.sync').on('load', function() {
                $("#loading").hide();
                $(".loader").hide();
            });

            $(".confirm").on('click', function() {
                let r = confirm("Hapus " + $(this).data("delete"));
                if (r == true) {
                    console.log($(this).data("delete"));
                    let d = $(this).data('delete');
                    $("#formDelete" + d).submit();
                } else {
                    console.log('CANCEL');
                }
            });
        });
    </script>
@endsection
