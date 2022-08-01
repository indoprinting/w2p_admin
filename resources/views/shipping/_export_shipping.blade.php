<a href="javascript:;" data-toggle="modal" data-target="#down-report">Report Shipping</a>
<div class="modal fade" id="down-report" tabindex="-1" role="dialog" aria-labelledby="down-reportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="down-reportTitle"><b>Report Shipping</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('export.shipping') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="form-label col-md-4">Dari Tanggal</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="date1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-md-4">Sampai Tanggal</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="date2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-md-4">Ekspedisi</label>
                        <div class="col-md-8">
                            <x-select2 name="kurir">
                                <option value="rajaongkir">Raja Ongkir (TUNAI)</option>
                                <option value="gosend">Gosend (NON-TUNAI)</option>
                            </x-select2>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
