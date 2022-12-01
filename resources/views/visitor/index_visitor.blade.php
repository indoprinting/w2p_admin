@extends('layouts.main')
@section('main')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{ $mobile }}</h3>
                            <p>Akses dari mobile</p>
                        </div>
                        <div class="icon">
                            <i class="fal fa-mobile"></i>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $pc }}</h3>
                            <p>Akses dari personal computer</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-computer-classic"></i>
                        </div>
                    </div>
                </div>
            </div>
            @isset($chart)
                @include('visitor._cart_visitor')
            @endisset
            @include('visitor._form_date')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal akses</th>
                                <th>IP address</th>
                                <th>device</th>
                                <th>Platform</th>
                                <th>Browser</th>
                                <th>Detail browser</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $visitor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ dateTime($visitor->created_at) }}</td>
                                    <td><a href="https://whatismyipaddress.com/ip/{{ $visitor->ip_address }}" target="_blank">{{ $visitor->ip_address }}</a></td>
                                    <td>{{ $visitor->is_mobile == 1 ? $visitor->mobile_name : 'Personal Computer' }}</td>
                                    <td>{{ $visitor->platform }}</td>
                                    <td>{{ $visitor->browser_name }}</td>
                                    <td width="30%">{{ $visitor->user_agent }}</td>
                                    <td>{{ "{$visitor->country}, {$visitor->province}, {$visitor->city}" }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
