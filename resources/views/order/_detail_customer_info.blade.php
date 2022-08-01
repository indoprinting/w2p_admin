<div class="row invoice-info">
    <div class="col-sm-2 invoice-col">
        <div class="text-bold">Customer info</div>
        <address>
            <div>
                <a href="javascript:void(0);" class="fad fa-copy mr-1" onclick="copyToClipboard('#cust_name')"></a>
                <span class="badge badge-primary">
                    <span id="cust_name">{{ $order->cust_name }}</span>
                </span>
            </div>
            <div><a href="https://wa.me/{{ phone62($order->cust_phone) }}" class="text-success" target="_blank">{{ $order->cust_phone }}</a></div>
            <div>{{ $order->address }}</div>
            <div>{{ $order->cust_email }}</div>
        </address>
    </div>

    <div class="col-sm-2 invoice-col">
        <div class="text-bold">Payment info</div>
        <address>
            <div><span class="badge badge-primary">{{ rupiah($order->total) }}</span></div>
            <div>Payment status : {{ $sale_erp->sale->payment_status }}</div>
            <div>Sale status : <span class="badge badge-warning">{{ $order->sale_status }}</span></div>
            <div><a href="javascript:void(0);" data-toggle="modal" data-target="#bukti-tf">Bukti pembayaran</a></div>
            @if ($order->payment_method == 'Transfer')
                <div><a href="javascript:void(0);" data-toggle="modal" data-target="#manualValidation">Manual Validasi Mutasi Bank</a></div>
            @elseif($order->payment_method == 'Qris')
                <div><a href="javascript:void(0);" data-toggle="modal" data-target="#manualValidationQris">Manual Validasi Qris</a></div>
            @endif
        </address>
    </div>

    <div class="col-sm-2 invoice-col">
        <div class="text-bold">Pickup detail</div>
        <address>
            <div><span class="badge badge-primary">{{ $order->pickup }}</span></div>
            <div>{!! $order->target ? dateTime($order->target) : '<span class="badge badge-danger">Belum lunas</span>' !!}</div>
            <div>Outlet produksi : {{ $sale_erp->sale->warehouse ?? '' }}</div>
            <div><a href="https://indoprinting.co.id/trackorder?invoice={{ $order->no_inv }}" target="_blank">Tracking Order</a></div>
        </address>
    </div>

    <div class="col-sm-6 invoice-col mb-3">
        <form action="{{ route('update.invoice') }}" method="POST" id="form_update">
            @csrf
            <input type="hidden" name="id_order" value="{{ $order->id_order }}">
            <input type="hidden" name="wa" value="{{ $order->wa }}">
            <input type="hidden" name="cust_phone" value="{{ $order->cust_phone }}">
            <input type="hidden" name="invoice" value="{{ $order->no_inv }}">
            <input type="hidden" name="pickup_method" value="{{ $order->pickup_method == 'Delivery' ? 'Delivery' : '' }}">
            <div class="form-group row">
                <label class="col-md-3">PIC</label>
                <div class="col-md-9">
                    <x-select2 name="pic" id="pic" data-placeholder="Pilih PIC">
                        <option value=""></option>
                        @foreach ($tl_erp as $tl)
                            @if (in_array($tl->id, [42, 91, 96]))
                                <option value="{{ $tl->id }}" {{ $sale_erp->pic->id == $tl->id ? 'selected' : '' }}>{{ $tl->first_name . ' ' . $tl->last_name }}</option>
                            @endif
                        @endforeach
                        @foreach ($cs_erp as $cs)
                            @if ($cs->id == 92)
                                <option value="{{ $cs->id }}" {{ $sale_erp->pic->id == $cs->id ? 'selected' : '' }}>{{ $cs->first_name . ' ' . $cs->last_name }}</option>
                            @endif
                        @endforeach
                    </x-select2>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-3">Outlet Pengambilan</label>
                <div class="col-md-9">
                    <x-input type="text" name="pickup" value="{{ $order->pickup }}" readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-3">Outlet Produksi</label>
                <div class="col-md-9">
                    <x-select2 name="warehouse" id="warehouse" required>
                        @foreach ($warehouses as $wh)
                            <option value="{{ $wh->code }}" {{ $wh->name == $sale_erp->sale->warehouse ? 'selected' : '' }} data-warehouse="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </x-select2>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-3">Operator</label>
                <div class="col-md-9">
                    <x-select2 name="operator" id="operator" data-placeholder="Pilih Operator" required>
                        {{-- <option value=""></option> --}}
                    </x-select2>
                    {{ $sale_erp->sale_items[0]->operator }}
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-3">Estimasi selesai</label>
                <div class="col-md-9">
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input type="text" name="ets" class="form-control datetimepicker-input" data-target="#datetimepicker1" data-toggle="datetimepicker" required />
                    </div>
                    {{ $sale_erp->sale->est_complete_date }}
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-3">Note pelanggan</label>
                <div class="col-md-9">
                    <textarea rows="2" class=" form-control" name="message">{{ $order->message }}</textarea>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('wa.paid', [
                    'inv' => $order->no_inv,
                    'cust_phone' => $order->cust_phone,
                    'ets' => $sale_erp->sale->est_complete_date,
                    'id_order' => $order->id_order,
                ]) }}" class="btn btn-success mr-4" @if ($order->wa == 1) onclick="javascript:return confirm('WA sudah pernah dikirim, Mau kirim lagi ?')" @endif>Kirim WA PAID</a>

                <a href="{{ route('approved.invoice', ['invoice' => $order->no_inv]) }}" class="btn {{ $sale_erp->sale->approved == 1 ? 'btn-danger' : 'btn-warning' }} mr-4" onclick="javascript:return confirm('Yakin approve nota ? pastikan jika invoice privillege sudah OK!')">Approved Nota</a>
                @if ($order->proced)
                    <a href="javascript:0;" class="btn btn-primary" id="confirm">Update Sale</a>
                @else
                    <button class="btn btn-primary">Update Sale</button>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- modal lihat bukti pembayaran -->
<div class="modal fade" id="bukti-tf" tabindex="-1" role="dialog" aria-labelledby="bukti-tfTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-50 w-25" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-bold" id="bukti-tfTitle">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <img src="{{ asset("assets/images/bukti-transfer/{$order->payment_proof}") }}" class="w-100 h-100" alt="Tidak ada bukti pembayaran">
                </div>
                <div class="mt-2">
                    <a href="{{ route('payment.proof', $order->payment_proof) }}" class="btn btn-info">Download</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('order._modal_manual_validasi')

<script>
    $(function() {
        $('#datetimepicker3').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            inline: false,
            sideBySide: true
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            inline: false,
            sideBySide: true
        });
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            inline: false,
            sideBySide: true
        });
    });

    $(document).ready(function() {
        $(window).on('load', function() {
            $("#warehouse").trigger('change');
        });

        $("#confirm").on('click', function() {
            let r = confirm("Nota sudah diproses, yakin ingin memproses ulang?");
            if (r == true) {
                $("#form_update").submit();
            } else {
                console.log('CANCEL');
            }
        })

        $("#warehouse").on("change", function() {
            let data = "warehouse=" + $(this).val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                type: "POST",
                url: `/get-operator`,
                data: data,
                success: function(hasil) {
                    console.log(hasil);
                    $("#operator").html(hasil);
                },
            });
        });
        
        $('#warehouse').trigger('change');
    });
</script>
