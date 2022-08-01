<div class="row">
    <div class="col-md-6 col-sm-12">
        <img src="{{ asset("images/promotion/{$promo}") }}" alt="" class="w-100" id="img-preview">
    </div>
    <div class="col-md-6 col-sm-12">
        <form action="{{ route('promo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="old_promo" value="{{ $promo }}">
            <input type="file" name="promo">
            <div class="mt-5">
                <button class="btn btn-warning w-100">Update</button>
            </div>
        </form>
    </div>
</div>
