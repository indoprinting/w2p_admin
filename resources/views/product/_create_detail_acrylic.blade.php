<h3 class="text-center text-bold mb-3 bg-success py-2">DETAIL PRODUK</h3>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Nama Produk
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="name" value="{{ old('name') }}" autofocus required />
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
            <img src="" alt="" class="img-thumbnail" id="img-preview">
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
    <div class="img-preview2" id="img-preview2"></div>
</div>
<div class="form-group row">
    <label for="desc_id" class="col-4 col-form-label" style="display: inline-block;">Description (ID)</label>
    <div class="col-8">
        <div class="card-body pad">
            <div class="mb-3">
                <input type="hidden" name="desc_id" id="post-editor">
                <div id="editor"></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="category" value="21">
<input type="hidden" name="min_order" value="1">
<input type="hidden" name="customize" value="1">
<input type="hidden" name="min_ukuran" value="5">
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Berat produk (KG)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="berat" value="{{ old('berat') ?? 0.2 }}" required />
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Panjang (CM)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="panjang" value="{{ old('panjang') ?? 0 }}" required />
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Lebar (CM)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="lebar" value="{{ old('lebar') ?? 0 }}" required />
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-4 col-form-label">Tinggi (CM)
        <x-important />
    </label>
    <div class="col-8">
        <x-input type="text" name="tinggi" value="{{ old('tinggi') ?? 0 }}" required />
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
