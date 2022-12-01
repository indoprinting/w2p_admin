<div class="text-center">
    <form action="{{ route('tb') }}" method="GET">
        <div class="cart-body p-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Start from</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="date1" value="{{ request()->date1 }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">End date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="date2" value="{{ request()->date2 }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Pengambilan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="outlet">
                                <option value="" selected disabled hidden>Outlet pengambilan</option>
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->name }}" {{ $outlet->name == request()->outlet ? 'selected' : '' }}>{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Produksi</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="warehouse">
                                <option value="" selected disabled hidden>Outlet produksi</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->warehouse }}" {{ $warehouse->warehouse == request()->warehouse ? 'selected' : '' }}>{{ $warehouse->warehouse }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary">Submit</button>
        </div>
    </form>
    <form action="{{ route('export.delivery') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="date1" value="{{ request()->date1 }}">
        <input type="hidden" name="date2" value="{{ request()->date2 }}">
        <button class="btn btn-info mb-2">Export to Excell</button>
    </form>
</div>
