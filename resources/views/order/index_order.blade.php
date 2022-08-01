@extends('layouts.main')
@section('main')
    <section class="content">
        <div class="container-fluid">
            <x-alert />
            <div class="card">
                @include('order._form_sort')
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="float-right">
                        @role([1, 5])
                            <a href="{{ route('create.order') }}">Create Invoice W2P</a>
                        @endrole
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Date</th>
                                <th>Cart ID</th>
                                <th>Customer name</th>
                                <th>Phone</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th>Total payment</th>
                                <th>Alamat Pickup</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ dateTime($order->created_at) }}</td>
                                    <td><a href="{{ route('order.detail', $order->id_order) }}">{{ $order->no_inv }}</a></td>
                                    <td>{{ $order->cust_name }}</td>
                                    <td>{{ $order->cust_phone }}</td>
                                    <td>{{ $order->cs }}</td>
                                    <td>{{ in_array($order->payment_status, ['Expired', 'Due']) ? $order->payment_status : $order->sale_status }}</td>
                                    <td>{{ rupiah($order->total) }}</td>
                                    <td>{{ $order->pickup }}</td>
                                    <td>
                                        <a href="{{ route('sync.status', ['id_order' => $order->id_order]) }}" class="d-block btn btn-info"> Sync</a>
                                        <a class="d-block btn btn-secondary my-2" href="{{ route('print.invoice', ['invoice' => $order->no_inv]) }}" target="_blank">Print</a>
                                        @if ($order->sale_status == 'Need Payment')
                                            @role([1, 5])
                                                <a class="d-block btn btn-danger" href="{{ route('order.delete', ['id_order' => $order->id_order]) }}" onclick='javascript:return confirm("Hapus invoice {{ $order->no_inv }} ? Pastikan sudah sinkron status !")' class="my-2">Hapus</a>
                                            @endrole
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
