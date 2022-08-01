<div class="modal fade" id="addAdmin" tabindex="-1" role="dialog" aria-labelledby="outletTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-100" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outletTitle"><b>Edit outlet</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-5 col-form-label">Admin name</label>
                        <div class="col-sm-7">
                            <x-input type="text" name="name" value="{{ old('name') }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-5 col-form-label">Username</label>
                        <div class="col-sm-7">
                            <x-input type="text" name="username" value="{{ old('username') }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-5 col-form-label">Admin role</label>
                        <div class="col-sm-7">
                            <x-select2 name="role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->user_role }}</option>
                                @endforeach
                            </x-select2>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-5 col-form-label">Password</label>
                        <div class="col-sm-7">
                            <x-input type="password" name="password" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password2" class="col-sm-5 col-form-label">Confirm password</label>
                        <div class="col-sm-7">
                            <x-input type="password" name="password_confirmation" />
                        </div>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-info" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
