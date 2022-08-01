<table class="table table-borderless">
    @foreach (json_decode($cart->attributes)->jenis_atb as $id => $jenis_atb)
        <tr>
            <td class="text-bold">{{ $jenis_atb }}</td>
            <td>:</td>
            <td>{{ json_decode($cart->attributes, true)['nama_atb'][$id] }}</td>
        </tr>
    @endforeach
    <tr>
        <td class="text-bold">Note</td>
        <td>:</td>
        <td>{!! $cart->product_note !!}</td>
    </tr>
</table>
