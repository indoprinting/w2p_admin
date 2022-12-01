@extends('layouts.main')
@section('main')
    <div class="card">
        <x-alert />
        <div class="card-body">
            <form action="{{ route('rating.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-md-3">Pilih Produk</label>
                            <div class="col-md-7">
                                <x-select2 name="id_product">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                                    @endforeach
                                </x-select2>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3">Nama Customer</label>
                            <div class="col-md-7">
                                <x-select2 name="id_user">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id_customer }}">{{ $user->name }}</option>
                                    @endforeach
                                </x-select2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-md-3">Rating</label>
                            <div class="col-md-7">
                                <x-input type="number" min="1" max="5" name="rating" value="5" />
                                <small class="text-warning">min 1, max 5</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3">Review</label>
                            <div class="col-md-7">
                                <x-textarea name="review"></x-textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-info w-100">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
