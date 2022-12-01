<div class="modal fade" id="editSale" tabindex="-1" role="dialog" aria-labelledby="editSaleTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-bold" id="editSaleTitle">Edit Sale Print ERP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.invoice') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_order" value="{{ $order->id_order }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-3">Invoice</label>
                                <div class="col-md-9">
                                    <x-input type="text" name="invoice" value="{{ $order->no_inv }}" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Estimasi Selesai</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="datetime-local" name="ets" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">PIC</label>
                                <div class="col-md-9">
                                    <x-select2 clas name="pic" required>
                                        @foreach ($tl_erp as $tl)
                                            <option value="{{ $tl->id }}" {{ $sale_erp->pic->id == $tl->id ? 'selected' : '' }}>{{ $tl->fullname }}</option>
                                        @endforeach
                                    </x-select2>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Note</label>
                                <div class="col-md-9">
                                    <textarea cols="40" rows="4" class="border border-dark" name="message">{{ $order->message }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-md-3">Warehouse</label>
                                <div class="col-md-9">
                                    <x-select2 clas name="warehouse" required>
                                        @foreach ($warehouses as $wh)
                                            <option value="{{ $wh->code }}" {{ $wh->name == $sale_erp->sale->warehouse ? 'selected' : '' }}>{{ $wh->name }}</option>
                                        @endforeach
                                    </x-select2>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Operator</label>
                                <div class="col-md-9">
                                    <x-select2 clas name="operator" required>
                                        @foreach ($operators as $operator)
                                            <option value="{{ $operator->id }}" {{ $sale_erp->sale_items[0]->id == $operator->id ? 'selected' : '' }}>{{ $operator->first_name . ' ' . $operator->last_name }}</option>
                                        @endforeach
                                    </x-select2>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3">Due Date</label>
                                <div class="col-md-9">
                                    <x-input type="datetime-local" name="due_date" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary w-100">Update Sale</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
