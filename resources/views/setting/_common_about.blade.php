<form action="{{ route('about.idp') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <label for="status_order" class="col-form-label">Tentang Indoprinting</label>
            <input type="hidden" name="about" id="about_idp">
            <div id="about_editor">{!! $about !!}</div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label for="status_order" class="col-form-label">Kantor Pusat</label>
            <input type="hidden" name="pusat" id="pusat">
            <div id="pusat-editor">{!! $pusat !!}</div>
        </div>
    </div>
    <div class="mt-5">
        <button class="btn btn-warning w-100 mt-5">Update</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        var quill = new Quill('#about_editor', {
            theme: 'snow'
        });
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("about_idp").value = quill.root.innerHTML;
        });
        var quill2 = new Quill('#pusat-editor', {
            theme: 'snow'
        });
        quill2.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("pusat").value = quill2.root.innerHTML;
        });
    });
</script>
