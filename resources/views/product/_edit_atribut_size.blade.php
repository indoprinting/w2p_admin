@php
$size = json_decode($product->size);
$panjang_size = count($size->size);
@endphp
@if ($panjang_size > 0)
    @foreach ($size->size as $idz => $size_name)
        @if ($idz == 0)
            <div class="form-group row">
                <div class="col-sm-4">
                    <x-input type="text" name="size_price[]" value="{{ $size->price[$idz] }}" />
                </div>
                <div class="col-sm-7">
                    <x-input type="text" name="size_name[]" id="size_name{{ $idz }}" data-index="{{ $idz }}" value="{{ $size_name }}" />
                </div>
                <div class="col-sm-1">
                    <a id="addSize" href="javascript:void(0);"><i class="fal fa-plus-circle" style="font-size: 34px;color:seagreen;"></i></a>
                </div>
            </div>
        @else
            <ww>
                <div class="form-group row size-design{{ $idz }}">
                    <div class="col-sm-4">
                        <x-input type="text" name="size_price[]" value="{{ $size->price[$idz] }}" />
                    </div>
                    <div class="col-sm-7">
                        <x-input type="text" name="size_name[]" id="size_name{{ $idz }}" data-index="{{ $idz }}" value="{{ $size_name }}" />
                    </div>
                    <div class="col-sm-1">
                        <a id="removeSize" href="javascript:void(0);" data-delete="{{ $idz }}"><i class="fal fa-minus-circle" style="font-size: 34px;color:red"></i></a>
                    </div>
                </div>
            </ww>
        @endif
    @endforeach
@else
    <div class="form-group row">
        <div class="col-sm-4">
            <x-input type="text" name="size_price[]" placeholder="Harga (x bahan)" />
        </div>
        <div class="col-sm-7">
            <x-input type="text" name="size_name[]" id="size_name0" data-index="0" placeholder="Nama ukuran" />
        </div>
        <div class="col-sm-1">
            <a id="addSize" href="javascript:void(0);" class="h2 text-success"><i class="fal fa-plus-circle"></i></a>
        </div>
    </div>
@endif

<script>
    var count_size = <?= $panjang_size ?>;
</script>
