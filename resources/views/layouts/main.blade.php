<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title ?? '' }} | Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/images/logo/favicon.png') }}" rel="icon">

    @include('layouts.asset_css')

</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm {{ $theme == 'dark' ? 'dark-mode' : '' }}">
    <div class="wrapper">
        <x-loader />
        @include('layouts.preloader')

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('layouts.breadcrumb')

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('main')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        @include('layouts.footer')

    </div>
    <!-- ./wrapper -->
    @include('layouts.asset_js')
</body>

</html>
