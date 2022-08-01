<form class="form-horizontal" action="{{ route('term') }}" method="POST">
    @csrf
    <div class="card-body">
        <label for="status_order" class="col-form-label">Syarat dan Ketentuan</label>
        <input type="hidden" name="term" id="term_value">
        <div id="editor-term">{!! $term !!}</div>
    </div>
    <div>
        <button type="submit" class="btn btn-warning w-100">Update</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        var quill = new Quill('#editor-term', {
            theme: 'snow'
        });
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("term_value").value = quill.root.innerHTML;
        });
    });
</script>
