<div class="modal fade" id="changePassword{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="changePasswordTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordTitle">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('change.password') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_customer" value="{{ $customer->id_customer }}">
                    <div class="form-group row">
                        <label for="name" class="col-4 col-form-label">New Password
                        </label>
                        <div class="col-8">
                            <x-input type="text" name="password" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
