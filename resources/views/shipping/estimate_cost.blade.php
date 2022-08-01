@extends('layouts.main')
@section('main')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <x-alert />
                <div class="card-body">
                    <h4 class="mb-3 text-primary border-bottom pb-2">Raja Ongkir</h4>
                    <form action="{{ route('estimate.cost') }}">
                        <div class="form-group row">
                            <label for="" class="col-md-3">Produk</label>
                            <div class="col-md-9">
                                <x-select2 name="weight" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->weight }}">{{ $product->name }}</option>
                                    @endforeach
                                </x-select2>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label"></label>
                            <div class="col-md-4">
                                <x-input name="berat" placeholder="Berat (KG) - optional" value="{{ request()->berat }}" />
                            </div>
                            <div class="col-md-5">
                                <x-input name="qty" placeholder="Qty Produk" value="{{ request()->qty }}" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label"></label>
                            <div class="col-md-3">
                                <x-input name="panjang" placeholder="Panjang (CM) - optional" value="{{ request()->panjang }}" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="lebar" placeholder="Lebar (CM) - optional" value="{{ request()->lebar }}" />
                            </div>
                            <div class="col-md-3">
                                <x-input name="tinggi" placeholder="Tinggi (CM) - optional" value="{{ request()->tinggi }}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Provinsi</label>
                            <div class="col-md-9">
                                <x-select2 name="province" id="province" data-placeholder="Pilih provinsi">
                                    <option value=""></option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                                    @endforeach
                                </x-select2>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Kota/Kabupaten</label>
                            <div class="col-md-9">
                                <x-select2 name="city" id="city" disabled></x-select2>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Kecamatan</label>
                            <div class="col-md-9">
                                <x-select2 name="suburb_id" id="suburb" disabled></x-select2>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Titik google maps</label>
                            <div class="col-md-9">
                                <x-input name="destination" value="{{ request()->destination }}" />
                                <small>Isi titik koordinate untuk mendapatkan harga gosend</small>
                                <small class="d-block">Sementara dapatkan titik koordinat dari google maps</small>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if ($gosend)
                <div class="card">
                    <div class="card-body">
                        <h5>GOSEND</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Biaya</th>
                                    <th>Estimasi (Hari)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gosend as $gosend)
                                    @if ($gosend->serviceable)
                                        <tr>
                                            <td>{{ $gosend->shipment_method }}</td>
                                            <td>{{ rupiah($gosend->price->total_price) }}</td>
                                            <td>{{ $gosend->shipment_method_description }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if ($rajaongkir)
                <div class="card">
                    <div class="card-body">
                        <h5>RAJAONGKIR</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Biaya</th>
                                    <th>Estimasi (Hari)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rajaongkir as $ongkir)
                                    @if (count($ongkir->costs) > 0)
                                        <tr>
                                            <td colspan="3" class="font-weight-bold {{ $loop->even ? 'text-warning' : 'text-primary' }}">{{ $ongkir->name }}</td>
                                        </tr>
                                        @foreach ($ongkir->costs as $cost)
                                            @if ($cost->description != 'Same Day')
                                                <tr>
                                                    <td>{{ $cost->description }}</td>
                                                    <td>{{ rupiah($cost->cost[0]->value) }}</td>
                                                    <td>{{ $cost->cost[0]->etd }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $("#city").prop("disabled", true);
            $("#suburb").prop("disabled", true);

            $("#province").on("change", function() {
                let data = "id=" + $(this).val();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    url: `/get-city`,
                    data: data,
                    success: function(hasil) {
                        console.log(hasil);
                        $("#city").prop("disabled", false);
                        $("#suburb").prop("disabled", true);
                        $("#suburb").val("");
                        $("#city").html(hasil);
                        $("#city").trigger("change");
                    },
                });
            });

            $("#city").on("change", function() {
                let data = "id=" + $(this).val();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    url: `/get-suburb`,
                    data: data,
                    success: function(hasil) {
                        $("#suburb").prop("disabled", false);
                        $("#suburb").html(hasil);
                        $("#suburb").trigger("change");
                    },
                });
            });
        });
    </script>
@endsection
