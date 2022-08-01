@php
$cus_atb = json_decode($product['attributes']);
@endphp
@if (count($cus_atb->name) > 0)
    @foreach ($cus_atb->name as $idn => $atb_name)
        <tr class="custom_atb">
            <td style="vertical-align: top;">
                <div style="display:flex;">
                    <a id="removeAtb" href="javascript:void(0);"><i class="fal fa-times" style="font-size: 20px;color:red;margin-right:5px;"></i></a>
                    <input type="text" class="form-control" name="atb_name{{ $idn }}" value="{{ $atb_name }}" placeholder="Nama atribut">
                </div>
            </td>
            <td class="td_value">
                <div class="col-sm-12">
                    <x-select2 multiple="multiple" name="value_name{{ $idn }}[]" data-placeholder="Pilih atribut" style="width: 100%;">
                        @foreach ($cus_atb->value->value_code[$idn] as $idc => $code)
                            <option selected value="{{ $code . ',,' . $cus_atb->value->value_name[$idn][$idc] . ',,' . $cus_atb->value->value_price[$idn][$idc] . ',,' . $cus_atb->value->value_qty[$idn][$idc] . ',,' . $cus_atb->value->value_range[$idn][$idc] }}">
                                {{ $code . ' : ' . $cus_atb->value->value_name[$idn][$idc] . ' (' . $cus_atb->value->value_price[$idn][$idc] . ')' }}
                            </option>
                        @endforeach
                        @foreach ($product_erp as $bahan)
                            <option value="{{ $bahan->code . ',,' . $bahan->name . ',,' . $bahan->price . ',,' . $bahan->price_ranges_value . ',,' . $bahan->product_prices . ',,' . $bahan->category_code }}">
                                {{ $bahan->code . ' : ' . $bahan->name . ' (' . rupiah($bahan->price) . ')' }}
                            </option>
                        @endforeach
                    </x-select2>
                </div>
            </td>
        </tr>
    @endforeach
@endif

<script>
    var count_atb = 60;
</script>
