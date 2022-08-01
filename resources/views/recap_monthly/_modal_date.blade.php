<div class="modal fade" id="created_update{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="created_updateTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="created_updateTitle">EDIT DATE {{ $recap->no_inv }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit.recap.monthly') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_order" value="{{ $recap->id_order }}">
                    <label for="">New Date</label>
                    <input class="form-control" type="datetime-local" name="new_date">
                    <div class="mt-2">
                        <button class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
