@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <!-- edit product -->
                <form action="{{ route('product.update', $product->id_product) }}" method="POST" class="form-horizontal formAddProduct" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-validate-error />
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            @include('product._edit_detail')
                        </div>
                        <div class="col-md-6 col-sm-12">
                            @include('product._edit_atribut')
                            @include('product._edit_design')
                        </div>
                    </div>
                </form>
            </div>
            <div class="my-5">
                <button type="submit" name="save" id="saveproduct" class="btn btn-info w-100">Save product</button>
            </div>
        </div>
    </div>
@endsection
