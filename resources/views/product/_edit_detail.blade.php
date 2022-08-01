<h3 class="text-center text-bold mb-3 bg-success py-2">DETAIL PRODUK</h3>
<input type="hidden" name="id_product" value="{{ $product->id_product }}">
<div class="form-group row">
    <label class="col-4 col-form-label">Nama Produk
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="name" value="{{ old('name') ?? $product->name }}" autofocus required />
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">Thumbnail (Gambar product)
        <x-important />
    </label>
    <div class="col-3">
        <label class="file">
            <input type="file" name="img_product" id="img_product" required>
            <span class="file-custom"></span>
        </label>
    </div>
</div>
<div class="row">
    <div class="col-4"></div>
    <div class="col-8">
        <div class="mw-50 mh-50 mb-2">
            <img src="{{ asset('assets/images/products-img/' . $product->thumbnail) }}" alt="" class="img-thumbnail" id="img-preview">
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">Additional thumbnails</label>
    <div class="col-3">
        <label class="file">
            <input type="file" name="img_product2[]" id="img_product2" multiple>
            <span class="file-custom"></span>
        </label>
    </div>
</div>
<div>
    <div class="img-preview2" id="img-preview2">
        @foreach (json_decode($product->thumbnail2) as $image)
            <img src="{{ asset('assets/images/products-img/' . $image) }}" style="max-height:45%; max-width:45%;margin:10px;" class="img-thumbnail">
        @endforeach
    </div>
</div>
<div class="form-group row">
    <label for="desc_id" class="col-4 col-form-label" style="display: inline-block;">Description (ID)</label>
    <div class="col-8">
        <div class="card-body pad">
            <div class="mb-3">
                <input type="hidden" name="desc_id" id="post-editor">
                <div id="editor">{!! $product->desc_id !!}</div>
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label ">Category
        <x-important />
    </label>
    <div class="col-8">
        <x-select2 name="category" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->id_category }}" {{ $product->category == $category->id_category ? 'selected' : '' }}>{!! $category->name !!}</option>
            @endforeach
        </x-select2>
    </div>
</div>
<div class="form-group row">
    <label class="col-4 col-form-label">Minimal Order
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="min_order" value="{{ old('min_order') ?? $product->min_order }}" required />
    </div>
</div>
@if ($product->min_isi)
    <div class="form-group row">
        <label class="col-4 col-form-label">Minimal Isi (Khusus buku)
            <x-important />
        </label>
        <div class="col-8">
            <x-input type="text" name="min_isi" value="{{ old('min_isi') ?? $product->min_isi }}" required />
        </div>
    </div>
@endif
@if ($product->min_ukuran || $product->min_luas)
    <div class="form-group row">
        <label for="name" class="col-4 col-form-label">Minimal Luas (cm<sup>2</sup>)
            <x-important />
        </label>
        <div class="col-8">
            <x-input type="text" name="min_luas" value="{{ old('min_luas') ?? $product->min_luas }}" required />
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-4 col-form-label">Minimal Panjang/Lebar (cm)
            <x-important />
        </label>
        <div class="col-8">
            <x-input type="text" name="min_ukuran" value="{{ old('min_ukuran') ?? $product->min_ukuran }}" required />
        </div>
    </div>
@endif
<div class="form-group row">
    <label class="col-4 col-form-label">Berat produk (KG)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="berat" value="{{ old('berat') ?? $product->weight }}" required />
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Panjang (CM)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="panjang" value="{{ $product->panjang }}" required />
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Lebar (CM)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="lebar" value="{{ $product->lebar }}" required />
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Tinggi (CM)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="tinggi" value="{{ $product->tinggi }}" required />
    </div>
</div>

<script>
    $(document).ready(function() {
        var quill = new Quill('#editor', {
            theme: 'snow'
        });
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("post-editor").value = quill.root.innerHTML;
        });
    });
</script>
