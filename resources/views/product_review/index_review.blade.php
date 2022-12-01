@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-bag"></i>
                {{ $title }}
            </h3>
            <div class="float-right">Rating Toko : <strong>{{ $average }} <i class="text-warning fas fa-star"></i></strong></div>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Invoice</th>
                        <th>Tanggal Pembelian</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Produk</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Respon IDP</th>
                        <th class="text-center" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review?->order?->no_inv }}</td>
                            <td>{{ dateTime($review->created_at) }}</td>
                            <td>{{ $review?->customer?->name }}</td>
                            <td>{{ $review?->product?->name }}</td>
                            <td>{{ $review->rating }} <i class="text-warning fas fa-star"></i></td>
                            <td>{{ $review->review }}</td>
                            <td>{{ $review->respon }}</td>
                            <td>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#responReview{{ $loop->index }}">
                                    Update Respon
                                </a>
                            </td>
                        </tr>
                        @include('product_review._modal_response')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
