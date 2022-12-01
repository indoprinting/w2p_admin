<form class="form-horizontal" action="{{ route('privacy') }}" method="POST">
    @csrf
    <div class="card-body">
        <label for="status_order" class="col-form-label">Kebijakan dan Privasi</label>
        <input type="hidden" name="privacy" id="post-editor">
        <div id="editor">{!! $privacy !!}</div>
    </div>
    <div>
        <button type="submit" class="btn btn-warning w-100">Update</button>
    </div>
</form>

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
