<!-- secondary report  -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('dashboard') }}?order=unprocessed" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fal fa-cart-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Transaksi belum diproses</span>
                    <span class="info-box-number">{{ $count->unprocessed_order }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('recap.monthly') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fab fa-amazon-pay"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Recap bulan ini</span>
                    <span class="info-box-number">{{ rupiah($sum->monthly) }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('daily.visitor') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fal fa-portal-enter"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pengunjung hari ini</span>
                    <span class="info-box-number">{{ $count->visitor_today }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('product.index') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fal fa-box-full"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Jumlah produk</span>
                    <span class="info-box-number">{{ $count->products }}</span>
                </div>
            </div>
        </a>
    </div>
</div>
