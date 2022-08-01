<h3 class="card-title">
    <form action="{{ route('product.index') }}" class="mb-2" method="GET" id="form-display">
        <select name="display" class="form-control" id="display">
            <option value="" selected hidden disabled>Pilih display</option>
            <option value="0">Limit</option>
            <option value="1">Show All</option>
        </select>
        <button type="submit" id="sub-display" hidden></button>
    </form>
</h3>
<h3 class="card-title float-right mb-3">
    <a href="{{ route('product.create') }}" class="mr-3 text-info">Add <i class="fal fa-plus" style="font-size: 18px;"></i></a>
    <a href="{{ route('product.book', ['category' => 'book']) }}" class="mr-3 text-info">Add Book <i class="fal fa-plus" style="font-size: 18px;"></i></a>
    <a href="{{ route('product.sticker', ['category' => 'sticker']) }}" class="mr-3 text-info">Add Sticker <i class="fal fa-plus" style="font-size: 18px;"></i></a>
    <a href="{{ route('product.sticker', ['category' => 'acrylic']) }}" class="mr-3 text-info">Add Acrylic <i class="fal fa-plus" style="font-size: 18px;"></i></a>
    <a class="loading" href="{{ route('product.sync', 0) }}">Sync <i class="fad fa-sync" style="font-size: 18px;"></i></a>
    <a href="{{ route('product.export') }}" class="mx-3 text-primary">Export Excel</a>
    <a href="{{ route('clear.cache') }}" class="btn btn-warning ml-4">Clear Cache</a>
</h3>
