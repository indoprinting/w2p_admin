@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-body">
            <h3 class="text-center text-bold mb-3 bg-warning py-2 mt-5">LAYOUT DESIGN ONLINE</h3>
            <div class="table-responsive ">
                <form action="{{ route('save.product.design') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id">
                    <table class="table table-bordereless" id="table_atb">
                        <tbody class="value_design">
                            @foreach ($sizes as $id => $size)
                                <tr>
                                    <td width="30%">
                                        <input type="text" class="form-control" name="ukuran[]" value="{{ $size }}" readonly>
                                        {{-- <small class="text-danger">pastikan sesuai dengan nama ukuran</small> --}}
                                    </td>
                                    <td class="td_value_design">
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="layout_name{{ $id }}[]" placeholder="posisi desain">
                                            </div>
                                            <div style="margin-right: 20px;">
                                                <a id="addDesign" href="javascript:void(0);" class="fal fa-plus-circle" style="font-size: 34px;color:darkmagenta;" data-design="{{ $id }}"></a>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="file" name="img_design{{ $id }}[]" class="img_design" data-image="{{ $id }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <img src="" alt="" class="img-thumbnail img_preview design{{ $id }}">
                                            </div>
                                        </div>
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
