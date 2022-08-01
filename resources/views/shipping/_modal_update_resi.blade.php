<div class="modal fade" id="updateresi{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="updateresiTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Resi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.resi') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <div class="row">
                        <label class="col-sm-3">No. Resi</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="resi" value="{{ $order->resi }}">
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
