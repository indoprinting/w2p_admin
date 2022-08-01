<h3 class="text-center text-bold mb-3 bg-info py-2">ATRIBUT PRODUK</h3>
<div class="table-responsive">
    <table class="table table-bordereless" id="table_atb">
        <tbody class="coloum_atb">
            <tr class="custom_atb">
                <td class="align-items-start w-25">
                    <div class="d-flex">
                        <h5>Bahan</h5>
                        <x-important />
                    </div>
                </td>
                <td class="td_value_material">
                    <x-select2 multiple="multiple" name="material_name[]" data-placeholder="Pilih bahan" id="bahan" style="width: 100%;">
                        @php
                            $material = json_decode($product->material);
                        @endphp
                        @if (count($material->material_code) > 0)
                            @foreach ($material->material_code as $idc => $code)
                                <option selected value="{{ $code .',,' .$material->material_name[$idc] .',,' .$material->material_price[$idc] .',,' .$material->material_qty[$idc] .',,' .$material->material_range[$idc] .',,' .$material->material_category[$idc] }}">
                                    {{ $code . ' : ' . $material->material_name[$idc] . ' (' . rupiah($material->material_price[$idc]) . ')' }}
                                </option>
                            @endforeach
                        @endif
                        @foreach ($product_erp as $bahan)
                            <option value="{{ $bahan->code .',,' .$bahan->name .',,' .$bahan->price .',,' .$bahan->price_ranges_value .',,' .$bahan->product_prices .',,' .$bahan->category_code }}">
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
                    <div style="font-size: 12px" class="text-warning">
                        <label><input type="checkbox" name="customize" value="1" @if ($product->customize) checked @endif> Ukuran bisa dicustom ?</label>
                        <label class="d-block"><input type="checkbox" name="luas" value="1" @if ($product->luas) checked @endif> DPI 1x1 </label>
                        <label class="d-block"><input type="checkbox" name="mmt_fixed" value="1" @if ($product->mmt_fixed) checked @endif> MMT < 1M<sup>2<sup> </label>
                        <label for="">Satuan ukuran</label>
                        <div>
                            <x-input type="text" name="unit_measure" value="{{ old('unit_measure') ?? $product->unit_measure }}" />
                        </div>
                    </div>
                </td>
                <td class="td_value_size">
                    @include('product._edit_atribut_size')
                </td>
            </tr>
            @include('product._edit_atribut_custom')
        </tbody>
    </table>
    <div class="text-center">
        <a href="javascript:void(0);" class="btn btn-default" id="addAtb">Tambah atribut</a>
    </div>
</div>
