<form action="{{ route('customer') }}" method="GET">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-self-center">
                <input class="form-control" type="month" name="month" value="{{ request()->month }}">
                <button class="btn btn-primary ml-2 w-25" type="submit">Ganti Bulan</button>
            </div>
        </div>
    </div>
</form>
