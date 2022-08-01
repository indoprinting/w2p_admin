<h3 class="text-center text-bold mb-3 bg-warning py-2 mt-5">LAYOUT DESIGN ONLINE</h3>
<div class="table-responsive ">
    <table class="table table-bordereless" id="table_atb">
        <tbody>
            @php
                $stage = json_decode($product->stages);
            @endphp
            @if (count($stage->ukuran) > 0)
                @foreach ($stage->ukuran as $id_u => $ukuran)
                    <tr class="size_design{{ $id_u }}">
                        <td>
                            <input type="text" class="form-control" name="ukuran[]" id="ukuran{{ $id_u }}" value="{{ $ukuran }}">
                        </td>
                        <td class="td_value_design">
                            @if (count($stage->design_layout->layout) > 0)
                                @foreach ($stage->design_layout->layout[$id_u] as $id_l => $layout)
                                    @if ($id_l == 0)
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="layout_name{{ $id_u }}[]" value="{{ $layout }}">
                                            </div>
                                            <div style="margin-right: 20px;">
                                                <a id="addDesign" href="javascript:void(0);" class="fal fa-plus-circle" style="font-size: 34px;color:darkmagenta;" data-design="{{ $id_u }}"></a>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="file" name="img_design{{ $id_u }}[]" class="img_design" data-image="{{ $id_u }}">
                                            </div>
                                            <div class="col-sm-4" style="max-height:30%; max-width:30%;">
                                                <img src="" alt="" class="img-thumbnail img_preview design{{ $id_u }}">
                                            </div>
                                        </div>
                                    @else
                                        <ww>
                                            <div class="form-group row">
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="layout_name{{ $id_u }}[]" value="{{ $layout }}">
                                                </div>
                                                <div style="margin-right: 20px;">
                                                    <a id="remove" href="javascript:void(0);" class="fal fa-minus-circle" style="font-size: 34px;color:red;"></a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="file" name="img_design{{ $id_u }}[]" class="img_design" data-image="40">
                                                </div>
                                                <div class="col-sm-4" style="max-height:30%; max-width:30%;">
                                                    <img src="" alt="" class="img-thumbnail img_preview design40">
                                                </div>
                                            </div>
                                        </ww>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <input type="text" class="form-control" name="ukuran[]" id="ukuran0" readonly>
                    </td>
                    <td class="td_value_design">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="layout_name0[]">
                            </div>
                            <div style="margin-right: 20px;">
                                <a id="addDesign" href="javascript:void(0);" class="fal fa-plus-circle" style="font-size: 34px;color:darkmagenta;" data-design="0"></a>
                            </div>
                            <div class="col-sm-4">
                                <input type="file" name="img_design0[]" class="img_design" data-image="90">
                            </div>
                            <div class="col-sm-4" style="max-height:30%; max-width:30%;">
                                <img src="" alt="" class="img-thumbnail img_preview design0">
                            </div>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
