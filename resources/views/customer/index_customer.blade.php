@extends('layouts.main')
@section('main')
    <div class="card">
        <x-alert />
        <div class="card-header">
            <h3 class="card-title">Data Customers</h3>
            <h3 class="card-title float-right"><a href="/adminidp/export-excel"><i class="fas fa-file-excel"></i> Export excel</a></h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="datatable">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama</th>
                        <th>No. Telp</th>
                        <th>Email</th>
                        <th>Bergabung sejak</th>
                        <th>Total Belanja</th>
                        <th>Total order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @role([1, 5])
                                    <a href="javascript;" data-toggle="modal" data-target="#changePassword{{ $loop->index }}">{{ $customer->name }}</a>
                                    @elserole
                                    {{ $customer->name }}
                                @endrole
                            </td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ dateTimeID($customer->created_at) }}</td>
                            <td>{{ rupiah($customer->order_sum_total) }}</td>
                            <td>{{ $customer->order_count }}</td>
                            <td><a href="{{ route('detail.belanja', $customer->id_customer) }}" class="far fa-info-circle"> Detail belanja</a></td>
                        </tr>
                        @include('customer._modal_password')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
