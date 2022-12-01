<h3 class="text-center text-bold mb-3 bg-info py-2">ATRIBUT PRODUK</h3>
<div class="table-responsive">
    <table class="table table-bordereless" id="table_atb">
        <tbody class="coloum_atb">
            <tr class="custom_atb">
                <td class="align-items-start w-25">
                    <div class="d-flex">
                        <input type="text" value="Cover" class="form-control" readonly>
                    </div>
                </td>
                <td class="td_value_material">
                    <x-select2 multiple="multiple" name="material_name[]" data-placeholder="Pilih bahan" id="bahan" style="width: 100%;">
                        @foreach ($product_erp as $bahan)
                            <option value="{{ $bahan->code . ',,' . $bahan->name . ',,' . $bahan->price . ',,' . $bahan->price_ranges_value . ',,' . $bahan->product_prices . ',,' . $bahan->category_code }}">
                                {{ $bahan->code . ' : ' . $bahan->name . ' (' . rupiah($bahan->price) . ')' }}
                            </option>
                        @endforeach
                    </x-select2>
                </td>
            </tr>
            <tr>
                <td class="align-items-start w-25">
                    <div style="display:flex;">
                        <input type="text" class="form-control" name="atb_name0" value="Isi" readonly>
                    </div>
                </td>
                <td class="td_value">
                    <x-select2 multiple="multiple" name="value_name0[]" data-placeholder="Pilih atribut" style="width: 100%;">
                        @foreach ($product_erp as $bahan)
                            <option value="{{ $bahan->code . ',,' . $bahan->name . ',,' . $bahan->price . ',,' . $bahan->price_ranges_value . ',,' . $bahan->product_prices . ',,' . $bahan->category_code }}">
                                {{ $bahan->code . ' : ' . $bahan->name . ' (' . rupiah($bahan->price) . ')' }}
                            </option>
                        @endforeach
                    </x-select2>
                </td>
            </tr>
            <tr>
                <td class="align-items-start w-25">
                    <div style="display:flex;">
                        <input type="text" class="form-control" name="atb_name1" value="Jilid" readonly>
                    </div>
                </td>
                <td class="td_value">
                    <x-select2 multiple="multiple" name="value_name1[]" data-placeholder="Pilih atribut" style="width: 100%;">
                        @foreach ($product_erp as $bahan)
                            <option value="{{ $bahan->code . ',,' . $bahan->name . ',,' . $bahan->price . ',,' . $bahan->price_ranges_value . ',,' . $bahan->product_prices . ',,' . $bahan->category_code }}">
                                {{ $bahan->code . ' : ' . $bahan->name . ' (' . rupiah($bahan->price) . ')' }}
                            </option>
                        @endforeach
                    </x-select2>
                </td>
            </tr>
            <!-- Ukuran -->
            <tr class="tr_value">
                <td class="align-items-start">
                    <div class="d-flex">
                        <h5>Ukuran</h5>
                        <x-important />
                    </div>
                </td>
                <td class="td_value_size">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <x-input type="text" name="size_price[]" value="1" />
                        </div>
                        <div class="col-sm-7">
                            <x-input type="text" name="size_name[]" id="size_name0" data-index="0" value="Buku" />
                        </div>
                        <div class="col-sm-1">
                            {{-- <a id="addSize" href="javascript:void(0);" class="h2 text-success"><i class="fal fa-plus-circle"></i></a> --}}
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <a href="javascript:void(0);" class="btn btn-default" id="addAtb">Tambah atribut</a>
    </div>
</div>

<script>
    var count_atb = 5;
</script>
