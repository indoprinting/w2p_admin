@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-bag"></i>
                {{ $title }}
            </h3>
            <div class="float-right">
                <a href="javascript:;" data-toggle="modal" data-target="#down-report">Report Overdue Tim Online</a>
                @include('overdue._modal_export')
            </div>
        </div>
        <div class="card-body" style="font-size: 12px">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Order</th>
                        <th>No. Invoice</th>
                        <th>Tanggal Pembayaran/PAID</th>
                        <th>Tanggah Unggah Bukti Transfer</th>
                        <th>Status GET</th>
                        <th>PIC</th>
                        <th>Waktu GET</th>
                        <th>Preparing to Waiting Production</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->no_inv }}</td>
                            <td>{{ dateTime($order->created_at) }}</td>
                            <td>{{ dateTime($order->payment_date) }}</td>
                            <td>{{ $order->upload_date }}</td>
                            <td>{{ $order->status_get }}</td>
                            <td>{{ $order->cs }}</td>
                            <td>{{ dateTime($order->time_get) }}</td>
                            <td>{{ dateTime($order->waiting_production) }}</td>
                            <td>
                                @if ($order->status_get != 1)
                                    <a href="{{ route('overdue.invalid', ['id_order' => $order->id_order]) }}" onclick='javascript:return confirm("Invoice {{ $order->no_inv }} tidak valid overduenya ?")'>Overdue Not Valid</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
