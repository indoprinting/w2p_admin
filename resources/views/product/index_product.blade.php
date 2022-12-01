@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-header">
            <x-alert />
            <div class="row">
                <div class="col-6">
                    <h3 class="card-title">All products</h3>
                </div>
                <div class="col-6">
                    <form action="{{ route('product.index') }}" method="GET">
                        <div class="d-flex">
                            <input type="text" class="form-control mr-2" name="keyword" value="{{ request()->keyword }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @include('product._table_title')
                <table class="table table-bordered" style="overflow-x:auto;">
                    <thead>
                        <tr>
                            <th style="width: 10px;">#</i></th>
                            <th style="width: 10px;">ID</i></th>
                            <th>Tgl Upload</th>
                            <th style="width: 25%;">Nama produk</th>
                            <th>Thumbnail</th>
                            <th>Berat</th>
                            <th>Custom ukuran</th>
                            <th>Kategori</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="h5">
                                    <a class="far fa-trash-alt text-danger mb-4 d-block" href="{{ route('product.show', $product->id_product) }}" onclick="javascript:return confirm('Hapus produk ini ?')" />
                                    <a class="loading fad fa-sync text-success mb-4 d-block" href="{{ route('product.sync', $product->id_product) }}" />
                                    <a class="fas fa-copy text-primary mb-4 d-block" href="{{ route('product.duplicate', $product->id_product) }}" />
                                    <a class="fas fa-object-group text-info" href="{{ route('product.design', ['product_id' => $product->id_product]) }}" target="_blank" />
                                </td>
                                <td>{{ $product->id_product }}</td>
                                <td>{{ myDate($product->created_at) }}</td>
                                <td>
                                    <a href="{{ route('product.edit', $product->id_product) }}" target="_blank">
                                        <i class="far fa-edit" style="color:dodgerblue;"></i>
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('download.image.product', ['image' => $product->thumbnail, 'name' => $product->name]) }}">
                                        <img src="{{ asset('assets/images/products-img/' . $product->thumbnail) }}" alt="" style="max-width: 150px; max-height:150px;">
                                    </a>
                                </td>
                                <td width="5%">{{ $product->weight }}</td>
                                <td>{{ $product->customize == 1 ? 'YA' : 'TIDAK' }}</td>
                                <td>{!! $product->kategori->name !!}</td>
                                <td class="text-center h4">
                                    @if ($product->active == 1)
                                        <a href="{{ route('product.active', ['active' => 0, 'id_product' => $product->id_product]) }}"><i class="far fa-check text-success"></i></a>
                                    @else
                                        <a href="{{ route('product.active', ['active' => 1, 'id_product' => $product->id_product]) }}"><i class="far fa-times text-danger"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="float-right">{{ $products->links() }}</div>
        </div>
        <!-- /.card-body -->
    </div>
    <script>
        $(document).ready(function() {
            $('.submit2').on('click', function() {
                console.log('oke');
                $('.form2').submit();
            });
            $("#display").on("change", function() {
                $("#sub-display").trigger("click");
            });

        });
    </script>
@endsection
