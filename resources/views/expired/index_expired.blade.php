@extends('layouts.main')
@section('main')
    <section class="content">
        <div class="container-fluid">
            <x-alert />
            <div class="card">
                @include('expired._form_sort')
            </div>

            <div>
                <a href="{{ route('sync.status') }}" class="btn btn-danger w-100 loading">JANGAN LUPA SINKRONISASI STATUS W2P DENGAN PRINT ERP, <b>KLIK DISINI UNTUK SINKRONISASI</b></a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Date</th>
                                <th>No Invoice</th>
                                <th>Nama Customer</th>
                                <th>Harga</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Metode Pembayaran</th>
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
                                    <td>{{ rupiah($order->total) }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ $order->sale_status }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td><a class="d-block btn btn-danger" href="{{ route('order.delete', ['id_order' => $order->id_order]) }}" onclick='javascript:return confirm("Hapus invoice {{ $order->no_inv }} ? Pastikan sudah sinkron status !")' class="my-2">Hapus</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
