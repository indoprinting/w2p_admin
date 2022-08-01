@props(['products'])

<div class="row">
    @foreach ($products as $product)
    <div class="icon-box">
        <div class="box">
            <div class="frame">
                <a href="{{ route('product',$product->id_product) }}">
                    <div class="icon"><img src="{{ asset('assets/images/products-img/'.$product->thumbnail) }}"></div>
                    <div class="text">
                        {{ $product->name }}
                    </div>
                    <div class="price">Start
                        <b>
                            {{ rupiah($product->min_price) }}
                        </b>
                    </div>
                    <div class="rating-sold">
                        <i class="fas fa-star"></i>
                        {{ $product->review_avg_rating ?? 0 }} | Terjual
                        {{ soldThousand($product->best_seller_sum_qty ?? 0) }}

                    </div>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
