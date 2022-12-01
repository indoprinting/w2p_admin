@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align: center;">
        {!! session('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="text-align: center;">
        {!! session('warning') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@elseif (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
        {!! session('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif
