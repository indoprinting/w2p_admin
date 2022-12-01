<!-- primary report -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('order') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fal fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Semua transaksi</span>
                    <span class="info-box-number"> {{ $count->orders }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('order') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fal fa-shopping-basket"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Transaksi bulan ini</span>
                    <span class="info-box-number"> {{ $count->order_this_month }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('visitor') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fal fa-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total pengunjung website</span>
                    <span class="info-box-number"> {{ $count->visitor }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <a href="{{ route('customer') }}" style="color: black;">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fal fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total pelanggan</span>
                    <span class="info-box-number"> {{ $count->customers }}</span>
                </div>
            </div>
        </a>
    </div>
</div>
