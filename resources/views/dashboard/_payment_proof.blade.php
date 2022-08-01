<a href="javascript:void(0);" data-toggle="modal" data-target="#bukti-tf{{ $loop->index }}"><i class="fal fa-file-image" style="font-size: 28px;"></i></a>
<!-- modal lihat bukti pembayaran -->
<div class="modal fade" id="bukti-tf{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="bukti-tfTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bukti-tfTitle"><b>Bukti Pembayaran</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <img src="{{ asset('assets/images/bukti-transfer/' . $order->payment_proof) }}" alt="" class="mw-100 mh-100">

                </div>
                <div class="mt-2">
                    {{-- <a href="{{ route('download.bukti_tf', ['image' => $order->payment_proof]) }}" class="btn btn-info">Download</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
