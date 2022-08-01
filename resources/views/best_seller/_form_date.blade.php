<form action="{{ route('best.seller') }}" method="GET">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <input class="form-control" type="month" name="month" value="{{ request()->month }}">
                </div>
                <div class="col-6">
                    <x-select2 name="outlet">
                        <option value="">Semua outlet</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->name }}" {{ $outlet->name == request()->outlet ? 'selected' : '' }}>{{ $outlet->name }}</option>
                        @endforeach
                    </x-select2>
                </div>
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-primary ml-2 w-25" type="submit">Ganti Bulan</button>
            </div>
        </div>
    </div>
</form>
