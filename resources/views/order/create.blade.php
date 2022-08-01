@extends('layouts.main')
@section('main')
    <div class="card">
        <x-alert />
        <div class="card-body">
            <form action="{{ route('create.order') }}" class="mb-5">
                <div class="row">
                    <label for="" class="col-md-2">Cari Invoice ERP</label>
                    <div class="col-md-5">
                        <x-input name="invoice" value="{{ request()->invoice }}" />
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-warning">Cari</button>
                    </div>
                </div>
            </form>
            @if ($erp)
                <form action="{{ route('store.order') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-3">Invoice</label>
                                <div class="col-md-7">
                                    <x-input name="no_inv" value="{{ $erp->sale->no }}" readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Nama</label>
                                <div class="col-md-7">
                                    <x-input name="cust_name" value="{{ $erp->customer->name }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Phone</label>
                                <div class="col-md-7">
                                    <x-input name="cust_phone" value="{{ $erp->customer->phone }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">PIC</label>
                                <div class="col-md-7">
                                    <x-input name="cs" value="{{ $erp->pic->name }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Operator</label>
                                <div class="col-md-7">
                                    <x-input name="operator" value="{{ $erp->sale_items[0]->operator }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Alamat Pengambilan</label>
                                <div class="col-md-7">
                                    <x-input name="pickup" value="Indoprinting {{ $erp->sale->outlet }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-3">Total</label>
                                <div class="col-md-7">
                                    <x-input name="total" value="{{ $erp->sale->grand_total }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Payment Method</label>
                                <div class="col-md-7">
                                    <x-input name="payment_method" value="{{ $erp->sale->paid_by }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Payment Status</label>
                                <div class="col-md-7">
                                    <x-input name="payment_status" value="{{ $erp->sale->payment_status }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Status</label>
                                <div class="col-md-7">
                                    <x-input name="sale_status" value="{{ $erp->sale->status }}" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Tanggal Pembuatan</label>
                                <div class="col-md-7">
                                    <input type="datetime-local" class="form-control" name="created_at" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-info w-100">Save</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
