<form action="{{ route('expired') }}" method="GET" class="card-body p-4 text-center">
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
    <div>
        <button class="btn btn-primary mr-2">Submit</button>
        <a href="{{ route('expired') }}" class="btn btn-warning text-white ml-2">Reset</a>
    </div>
</form>
