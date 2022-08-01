@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Transaksi</h3>
            <h3 class="card-title float-right">Total paid : {{ rupiah($total) }}</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="datatable">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Tanggal transaksi</th>
                        <th>No. Invoice</th>
                        <th>Total Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Alamat Pickup</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ dateTime($order->created_at) }}</td>
                            <td>{{ $order->no_inv }}</td>
                            <td>{{ rupiah($order->total) }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->sale_status }}</td>
                            <td>{{ $order->pickup }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
