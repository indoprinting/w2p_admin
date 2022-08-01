@extends('layouts.main')
@section('main')
    <x-alert />
    <div class="card w-100">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-bag"></i>
                {{ $title }}
            </h3>
            <div class="float-right">
                @include('shipping._export_shipping')
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Order</th>
                        <th>No. Invoice</th>
                        <th>Nama</th>
                        <th>Kurir</th>
                        <th>Layanan</th>
                        <th>Biaya</th>
                        <th>Estimasi Pengiriman</th>
                        <th>No. Resi</th>
                        <th width="15%">Keterangan</th>
                        <th class="text-center" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="{{ !$order->terkirim ? 'text-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ dateTime($order->created_at) }}</td>
                            <td><a href="{{ route('order.detail', $order->id_order) }}">{{ $order->no_inv }}</a></td>
                            <td>{{ $order->cust_name }}</td>
                            <td>{{ $order->courier_name }}</td>
                            <td>{{ $order->courier_service }}</td>
                            <td>{{ rupiah($order->courier_price) }}</td>
                            <td>{{ isset($order->order->target) ? dateTime($order->order->target) : '' }}</td>
                            <td>{{ $order->resi }} <a href="#" class="text-primary" data-toggle="modal" data-target="#updateresi{{ $loop->index }}"><i class="fal fa-edit"></i></a></td>
                            <td>
                                @if ($order->courier_name == 'Gosend')
                                    <a href="{{ $order->tracking_gosend }}" target="_blank">{{ $order->tracking_gosend }}</a>
                                @else
                                    {{ $order->keterangan }} <a href="#" class="text-primary" data-toggle="modal" data-target="#updateKet{{ $loop->index }}"><i class="fal fa-edit"></i></a>
                                @endif
                            </td>
                            <td class="justify-content-center">
                                @include('shipping._action')
                            </td>
                        </tr>
                        @include('shipping._modal_update_resi')
                        @include('shipping._modal_update_keterangan')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
