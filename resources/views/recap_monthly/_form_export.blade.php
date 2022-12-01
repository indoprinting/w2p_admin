<a href="javascript:;" data-toggle="modal" data-target="#down-report">Export recap</a>
<div class="modal fade" id="down-report" tabindex="-1" role="dialog" aria-labelledby="down-reportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="down-reportTitle"><b>Report</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('export.recap') }}" method="POST">
                    @csrf
                    <input type="hidden" name="month" value="{{ request()->month }}">
                    <div class="form-group row">
                        <label class="form-label col-md-4">Metode Pembayaran</label>
                        <div class="col-md-8">
                            <select class="form-control" name="payment_method">
                                <option value="">Semua</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-success" type="submit">Export to excell</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
