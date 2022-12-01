<html>
<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.asset_css')
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}">
</head>

<body>
    <button class="btn btn-warning" id="print">Print</button>
    <div class="card" id="print-area">
        <div class="card-body shipping">
            <div class="row logo">
                <div class="col-6">
                    <img src="{{ asset('assets/images/logo/logo-idp.png') }}" alt="">
                </div>
                @if ($shipping->courier_name == 'Gosend')
                    <div class="col-6 text">NON-TUNAI</div>
                @else
                    <div class="col-6 text">TUNAI</div>
                @endif
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>{{ $shipping->no_inv }}</strong></p>
                            @if ($shipping->courier_name == 'AnterAja')
                                <img src="{{ asset('assets/images/logo/anteraja.png') }}" class="w-50 mh-50 mb-3">
                            @elseif ($shipping->courier_name == 'Gosend')
                                <img src="{{ asset('assets/images/logo/gosend.png') }}" class="w-50 mh-50 mb-3">
                            @elseif ($shipping->courier_name == 'SiCepat Express')
                                <img src="{{ asset('assets/images/logo/gosend.png') }}" class="w-50 mh-50 mb-3">
                            @else
                                <img src="{{ asset('assets/images/logo/jne.png') }}" class="w-50 mh-50 mb-3">
                            @endif
                        </div>
                        <div class="col-6">
                            <div>{{ $shipping->courier_name }}</div>
                            <div><strong>{{ $shipping->courier_service }}</strong></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div>Berat</div>
                            <div><strong>{{ $shipping->weight / 1000 . ' KG' }}</strong></div>
                        </div>
                        <div class="col-6">
                            @if ($shipping->courier_name != 'Gosend')
                                <div>Ongkos Kirim</div>
                                <div><strong>{{ rupiah($shipping->courier_price) }}</strong></div>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($shipping->courier_name != 'Gosend')
                    <div class="col-6">
                        <div class="kolom-resi">
                            <div>No Resi : {{ $shipping->resi }}</div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="pembatas">
                <div><strong>Pelanggan</strong> tidak perlu membayar apapun ke kurir, sudah dibayarkan <strong>Indoprinting</strong></div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p>Kepada :</p>
                    <div><strong>{{ $shipping->order->cust_name }}</strong></div>
                    <div>{{ $shipping->order->address }}</div>
                    <div>{{ $shipping->order->cust_phone }}</div>
                </div>
                <div class="col-6">
                    <p>Dari :</p>
                    <div><strong>Indoprinting</strong></div>
                    <div>Jalan Durian Raya no.100, Banyumanik, Kota Semarang, Jawa Tengah, 50263</div>
                    <div>+62 858-7799-2444</div>
                </div>
            </div>
            <div class="mt-4">
                <img src="{{ asset('assets/images/admin/fragile-sticker.jpg') }}" alt="" width="100%">
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.PrintArea.js') }}"></script>
    <script>
        $(document).ready(function() {
            // $('.btn-warning').hide();
            $('#print').trigger('click');
            $("#print").on("click", function() {
                $('#print-area').printArea();
            });
        });
    </script>
</body>

</html>

</html>
