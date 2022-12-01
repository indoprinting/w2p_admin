@extends('layouts.main')
@section('main')
    @include('best_seller._chart')
    @include('best_seller._form_date')
    <div class="card">
        <div class="card-body">
            <h5>{{ $title }}</h5>
            <div class="table-responsive">
                <table class="table table-bordered datatable2">
                    <thead>
                        <tr>
                            <th style="width: 10px;">#</i></th>
                            <th>Gambar Produk</th>
                            <th>Nama produk</th>
                            <th>Qty terjual</th>
                            <th>Total value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><img src="{{ asset('assets/images/products-img/' . $product->thumbnail) }}" alt="" style="max-width: 150px; max-height:150px;"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sold_out }}</td>
                                <td>{{ rupiah($product->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#submit_outlet").hide();
            $("#id_outlet").on("change", function() {
                $("#submit_outlet").trigger("click");
            });
        });
    </script>
@endsection
