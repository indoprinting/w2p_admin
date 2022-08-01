@props(['banners'])

<div class="carousel-inner">
    @foreach ($banners as $banner)
    <div class="carousel-item {{ $banner->main == 1 ? 'active' :'' }}">
        <a href="{{ $banner->link ?? 'javascript:void(0);' }}">
            <img src="{{ asset('images/banner/'.$banner->img) }}" class="w-100" alt="">
        </a>
    </div>
    @endforeach
</div>
<a class="carousel-control-prev" href="#carousel-idp" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon fal fa-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carousel-idp" role="button" data-slide="next">
    <span class="carousel-control-next-icon fal fa-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>