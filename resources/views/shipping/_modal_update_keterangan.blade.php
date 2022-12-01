<div class="modal fade" id="updateKet{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="updateKetTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Resi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.keterangan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <div class="row">
                        <label class="col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="keterangan" value="{{ $order->keterangan }}">
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
