<a href="{{ route('print.shipping', ['id' => $order->id]) }}" class="btn btn-success d-block" target="_blank">Shipping</a>
@if ($order->courier_name == 'Gosend')
    @if ($order->resi)
        <a href="{{ route('cancel.gosend', $order->resi) }}" class="btn btn-warning my-2 d-block" onclick="javascript:return confirm('Cancel Gosend ?')">Batal</a>
    @else
        <a href="{{ route('get.driver', $order->id) }}" class="btn btn-primary my-2 d-block" onclick="javascript:return confirm('Dapatkan driver ?')">Get Driver</a>
    @endif
@else
    @if ($order->resi && $order->terkirim)
        @if ($order->terkirim > 1)
            <div>{{ dateTimeID($order->terkirim) }}</div>
        @endif
        <form action="{{ route('detail.rajaongkir') }}" method="POST" class="my-2">
            @csrf
            <input type="hidden" name="resi" value="{{ $order->resi }}">
            <input type="hidden" name="kurir" value="{{ $order->courier_name == 'AnterAja' ? 'anteraja' : 'jne' }}">
            <button type="submit" class="btn btn-info w-100">Detail</button>
        </form>
    @elseif(!$order->terkirim)
        <a href="{{ route('dikirim', $order->id) }}" class="btn btn-danger d-block my-2">Kirim</a>
    @endif
@endif
<a href="{{ route('hapus.order', $order->id) }}" class="btn btn-danger my-2 d-block" onclick="javascript:return confirm('Hapus order ?')">Hapus</a>