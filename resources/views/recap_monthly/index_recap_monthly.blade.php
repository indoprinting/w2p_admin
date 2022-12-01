@extends('layouts.main')
@section('main')
    @include('recap_monthly._chart_recap')
    @include('recap_monthly._form_date')
    <div class="card" style="width: 100%;">
        <div class="card-header">
            <h3 class="card-title">
                @include('recap_monthly._form_export')
            </h3>
            {{-- <h4 class="card-title text-bold float-right">Total :
                {{ rupiah($total) }}
            </h4> --}}
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered display datatable2" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Tanggal Order</th>
                        <th>No. Invoice</th>
                        <th>Nama Pelanggan</th>
                        <th>Total pembayaran</th>
                        <th>Alamat Pickup</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recaps as $recap)
                        <tr class="{{ $recap->proced == 0 ? 'text-bold text-danger' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @role([1, 5])
                                    <a href="javascript;" data-toggle="modal" data-target="#created_update{{ $loop->index }}">{{ dateTime($recap->created_at) }}</a>
                                    @elserole
                                    {{ dateTime($recap->created_at) }}
                                @endrole
                            </td>
                            <td><a href="{{ route('order.detail', $recap->id_order) }}">{{ $recap->no_inv }}</a></td>
                            <td>{{ $recap->cust_name }}</td>
                            <td>{{ rupiah($recap->total) }}</td>
                            <td>{{ $recap->pickup }}</td>
                        </tr>
                        @include('recap_monthly._modal_date')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
