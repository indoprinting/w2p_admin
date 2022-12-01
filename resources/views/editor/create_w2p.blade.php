@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-body">
            <h5 class="text-center text-bold mb-3 bg-warning py-2 mt-5">Layout design online produk <i>{{ $product->name }}</i></h5>
            <div class="table-responsive ">
                <form action="{{ route('save.product.design') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id_product }}">
                    <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}">
                    <table class="table table-bordereless" id="table_atb">
                        <tbody class="value_design">
                            @foreach ($sizes as $id => $size)
                                <tr>
                                    <td width="30%">
                                        <input type="text" class="form-control" name="ukuran[]" value="{{ $size }}" readonly>
                                    </td>
                                    <td class="td_value_design">
                                        @foreach ($layouts as $idl => $layout)
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="layout_name{{ $id }}[]" value="{{ $layout }}" readonly>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="file" name="img_design{{ $id }}[]" class="img_design" data-image="{{ $id . $idl }}" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <img src="" alt="" class="img-thumbnail img_preview design{{ $id . $idl }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button class="btn btn-primary">Save Design</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
