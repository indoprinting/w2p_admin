<form action="{{ route('order') }}" method="GET" class="card-body p-4 text-center">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Start from</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="date1" value="{{ request()->date1 }}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">End date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="date2" value="{{ request()->date2 }}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select name="status" class="form-control">
                        <option value="" selected disabled>Pilih status</option>
                        <option value="Need Payment" {{ request()->status == 'Need Payment' ? 'selected' : '' }}>Need Payment</option>
                        <option value="Preparing" {{ request()->status == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="Waiting Production" {{ request()->status == 'Waiting Production' ? 'selected' : '' }}>Waiting Production</option>
                        <option value="Completed Partial" {{ request()->status == 'Completed Partial' ? 'selected' : '' }}>Completed Partial</option>
                        <option value="Completed" {{ request()->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Finished" {{ request()->status == 'Finished' ? 'selected' : '' }}>Finished</option>
                        <option value="Delivered" {{ request()->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-primary mr-2">Submit</button>
        <a href="{{ route('order') }}" class="btn btn-warning text-white ml-2">Reset</a>
    </div>
</form>
