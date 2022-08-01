@extends('layouts.main')
@section('main')
    <a href="/adminidp/delivery-list" class="btn btn-warning mb-2"><i class="fas fa-arrow-circle-left"></i> kembali</a>
    <div class="row">
        <div class="col-md-6">
            <!-- Detail Resi  -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail pengiriman</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="20%">No. Resi</td>
                                <td>: {{ $waybill->detail->waybill_number }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Ekspedisi</td>
                                <td>: {{ $waybill->summary->courier_name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Nama Kurir</td>
                                <td>: {{ $waybill->detail->shippper_name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Alamat Tujuan</td>
                                <td>: {{ $waybill->detail->receiver_address1 }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Penerima</td>
                                <td>: {{ $waybill->detail->receiver_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Status pengiriman  -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status pengiriman</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="20%">Status</td>
                                <td>: {{ $waybill->status->status }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Penerima</td>
                                <td>: {{ $waybill->status->pod_receiver }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Waktu</td>
                                <td>: {{ dateID($waybill->status->pod_date) . ' ' . $waybill->status->pod_time }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- The time line -->
            <div class="timeline">
                @foreach ($waybill->manifest as $tl)
                    <!-- timeline time label -->
                    <div class="time-label">
                        <span class="bg-info">{{ dateID($tl->manifest_date) }}</span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                        @if ($tl->manifest_code == 1)
                            <i class="fas fa-shipping-fast bg-blue"></i>
                        @elseif ($tl->manifest_code == 2)
                            <i class="fas fa-spinner bg-warning"></i>
                        @else
                            <i class="fas fa-box bg-success"></i>
                        @endif
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ $tl->manifest_time }}</span>
                            <h3 class="timeline-header">{{ $tl->manifest_description }} Kota {{ $tl->city_name }}</h3>
                        </div>
                    </div>
                    <!-- END timeline item -->
                @endforeach
                <div>
                    <i class="fas fa-genderless bg-black"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
