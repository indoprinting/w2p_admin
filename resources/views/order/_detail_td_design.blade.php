<table class="table-borderless">
    @if (isset($cart->design))
        @foreach (json_decode($cart->design) as $design)
            @if (file_exists(public_path('assets/images/design-upload/' . $design)) == true)
                @php
                    $image = checkDesign($design);
                @endphp

                @if ($image)
                    <tr>
                        <td class="text-center d-block">
                            <div>
                                ({{ $image->size . ' MB' }})<br>
                                <a href="{{ route('download.design', ['image' => $design]) }}">
                                    <img class="show-hide" src="{{ asset($image->image) }}" alt="no files" style="max-width: 100%;max-height:100%">
                                    <div class="d-block">{{ $design }}</div>
                                </a>
                            </div>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td style="vertical-align: middle;width:10%">
                            <a href="{{ route('download.design', ['image' => $design]) }}">
                                {{ $design }}
                            </a>
                        </td>
                    </tr>
                @endif
            @endif
        @endforeach
    @elseif($cart->link)
        @if (strtolower(substr($cart->link, 0, 4)) == 'http')
            <a href="{{ $cart->link }}" target="_blank">{{ $cart->link }}</a>
        @else
            <div class="text-bold">{{ $cart->link }}</div>
        @endif
    @else
        <div class="text-bold text-center">No design</div>
    @endif
</table>
