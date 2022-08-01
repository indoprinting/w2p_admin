<div class="modal fade" id="addMenu" tabindex="-1" role="dialog" aria-labelledby="outletTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-100" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outletTitle"><b>Edit outlet</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('menu.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-5 col-form-label">Nama Menu</label>
                        <div class="col-sm-7">
                            <x-input type="text" name="name" value="{{ old('name') }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-5 col-form-label">Icon (Font-Awesome)</label>
                        <div class="col-sm-7">
                            <x-input type="text" name="icon" value="{{ old('icon') }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-5 col-form-label">Nama Route</label>
                        <div class="col-sm-7">
                            <x-input type="text" name="route" value="{{ old('route') }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-5 col-form-label">Kategori</label>
                        <div class="col-sm-7">
                            <x-select name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-select>
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
