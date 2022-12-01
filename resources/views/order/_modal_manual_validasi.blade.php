<!-- modal manual validation Mutasi Bank -->
<div class="modal fade" id="manualValidation" tabindex="-1" role="dialog" aria-labelledby="manualValidationTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-bold" id="manualValidationTitle">Manual Validasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manual.validation') }}" method="POST" enctype="multipart/form-data" id="formManualValidation">
                    @csrf
                    <input type="hidden" name="id_order" value="{{ $order->id_order }}">
                    <input type="hidden" name="invoice" value="{{ $order->no_inv }}">
                    <div class="form-group row">
                        <label for="" class="col-md-4">No. Rekening</label>
                        <div class="col-md-8">
                            <x-select2 name="rekening" required>
                                <option value="008301001092565">Bank BRI</option>
                                <option value="559209008">Bank BNI</option>
                                <option value="1360000555323">Mandiri</option>
                                <option value="8030200234">BCA BU Anita</option>
                                <option value="8030800100">BCA IDP</option>
                            </x-select2>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4">Amount/Total Transfer</label>
                        <div class="col-md-8">
                            <x-input type="number" name="amount" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4">Waktu Transaksi</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                <input type="text" name="transaction_date" class="form-control datetimepicker-input" data-target="#datetimepicker3" data-toggle="datetimepicker" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4">Bukti Transfer</label>
                        <div class="col-md-8">
                            <x-input type="file" name="bukti_tf" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4"></label>
                        <div class="col-md-8">
                            <img src="" alt="" class="img-thumbnail" id="img-preview">
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="javascript:;" type="submit" class="btn btn-primary confirm">Submit</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- modal manual validation QRIS -->
<div class="modal fade" id="manualValidationQris" tabindex="-1" role="dialog" aria-labelledby="manualValidationQrisTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-bold" id="manualValidationQrisTitle">Manual Validasi QRIS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manual.validation.qris') }}" method="POST" enctype="multipart/form-data" id="formManualValidationQris">
                    @csrf
                    <input type="hidden" name="id_order" value="{{ $order->id_order }}">
                    <input type="hidden" name="invoice" value="{{ $order->no_inv }}">
                    <input type="hidden" name="rekening" value="2222004005">
                    <div class="form-group row">
                        <label for="" class="col-md-4">Amount/Total Transfer</label>
                        <div class="col-md-8">
                            <x-input type="number" name="amount" required />
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="javascript:;" class="btn btn-primary confirmQris">Submit</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $(".confirm").on('click', function() {
            let r = confirm("Pastikan anda sudah cek di Mutasi Bank / Lucretia, transfer tersebut benar masuk");
            if (r == true) {
                $("#formManualValidation").submit();
            } else {
                console.log('CANCEL');
            }
        });
        $(".confirmQris").on('click', function() {
            let r = confirm("Pastikan anda sudah cek di  Qris, transfer tersebut benar masuk");
            if (r == true) {
                $("#formManualValidationQris").submit();
            } else {
                console.log('CANCEL');
            }
        });
    })
</script>
