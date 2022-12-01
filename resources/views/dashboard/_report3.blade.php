<!-- THIRD report  -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <a href="#" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-truck"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Shipping bulan ini</span>
                    <span class="info-box-number">{{ rupiah($total_shipping) }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('recap.monthly') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fab fa-amazon-pay"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Rekap Harian</span>
                    <span class="info-box-number">{{ rupiah($sum->daily) }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('tb') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fal fa-box-full"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">TB</span>
                    <span class="info-box-number">{{ $count->tb }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('best.seller') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon"><img src="{{ asset('assets/images/products-img/' . $best_seller->thumbnail) }}" alt=""></span>

                <div class="info-box-content">
                    <span class="info-box-text">Produk Terlaris</span>
                    <span class="info-box-number">{{ $best_seller->name }}</span>
                </div>
            </div>
        </a>
    </div>
</div>
