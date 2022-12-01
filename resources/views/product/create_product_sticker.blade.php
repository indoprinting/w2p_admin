@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <form action="{{ route('product.store') }}" method="POST" class="form-horizontal formAddProduct" enctype="multipart/form-data">
                    @csrf
                    <x-validate-error />
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            @include('product._create_detail_sticker')
                        </div>
                        <div class="col-md-6 col-sm-12">
                            @include('product._create_atribut_sticker')
                            @include('product._create_design')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 20px;">
        <button type="submit" name="save" id="saveproduct" class="btn btn-info w-100">Save product</button>
    </div>
@endsection
