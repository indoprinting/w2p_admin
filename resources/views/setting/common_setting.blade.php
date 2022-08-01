@extends('layouts.main')
@section('main')
    <div class="card">
        <div class="card-title">

        </div>
        <div class="card-body">
            <div class="p-2">
                <ul class="nav nav-pills h5 ">
                    <li><a class="nav-item nav-link active" href="#privasi" data-toggle="tab">Kebijakan dan Privasi</a></li>
                    <li><a class="nav-item nav-link" href="#promologin" data-toggle="tab">Promo Login</a></li>
                    <li><a class="nav-item nav-link" href="#term" data-toggle="tab">Syarat dan Ketentuan</a></li>
                    <li><a class="nav-item nav-link" href="#about" data-toggle="tab">Tentang Indoprinting</a>
                    </li>
                </ul>
            </div>
            <x-alert />
            <div class="tab-content">
                {{-- privacy --}}
                <div class="active tab-pane" id="privasi">
                    @include('setting._common_privacy')
                </div>
                {{-- promo login --}}
                <div class=" tab-pane" id="promologin">
                    @include('setting._common_promo')
                </div>
                {{-- TERM --}}
                <div class=" tab-pane" id="term">
                    @include('setting._common_term')
                </div>
                {{-- Tentang IDP --}}
                <div class=" tab-pane" id="about">
                    @include('setting._common_about')
                </div>
            </div>
        </div>
    </div>
@endsection
