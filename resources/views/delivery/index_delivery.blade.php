@extends('layouts.main')
@section('main')
    <section class="content">
        <div class="container-fluid">
            <x-alert />
            <div class="card">
                @include('delivery._form_export')
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
                                <th>PIC</th>
                                <th>Status</th>
                                <th>Estimasi Pengambilan</th>
                                <th>Warehouse</th>
                                <th>Alamat Pickup</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($orders as $x => $order)
                                @if ($order->pickup != 'Indoprinting ' . $order->warehouse && $order->warehouse)
                                    <tr class="@if (!$order->tb && $order->created_at > '2022-01-17 10:02') text-danger @endif">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ dateTime($order->created_at) }}</td>
                                        <td><a href="{{ route('order.detail', $order->id_order) }}">{{ $order->no_inv }}</a></td>
                                        <td>{{ $order->cust_name }}</td>
                                        <td>{{ $order->cs }}</td>
                                        <td>{{ $order->payment_status == 'Expired' ? $order->payment_status : $order->sale_status }}</td>
                                        <td>{{ dateTime($order->target) }}</td>
                                        <td>{{ $order->warehouse }}</td>
                                        <td>{{ $order->pickup }}</td>
                                        <td>
                                            @if ($order->created_at > '2022-01-17 10:02')
                                                @if ($order->tb)
                                                    {{ dateTime($order->tb) }}
                                                @else
                                                    <a href="{{ route('update.tb', ['id_order' => $order->id_order, 'invoice' => $order->no_inv]) }}" class="btn btn-info" onclick='javascript:return confirm("Apakah anda yakin barang dikirim? pelanggan akan dapat info pengambilan by whatsapp")'>Kirim</a>
                                                @endif

                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
