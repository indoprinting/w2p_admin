<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <a href="/adminidp/orders" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fal fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Semua transaksi</span>
                    <span class="info-box-number">{{ $count->orders }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="/adminidp/recent-orders" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fal fa-cart-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Transaksi belum diproses</span>
                    <span class="info-box-number">{{ $count->unprocessed_order }}</span>
                </div>
            </div>
        </a>
    </div>
</div>
