<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Admin W2P X | Log in</title>

    @include('layouts.asset_css')
</head>

<body class="hold-transition login-page dark-mode">
    <div class="login-box">
        <div class="login-logo">
            <strong>Admin</strong> Web2Print
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <x-logo class="mw-100" />
                <x-alert />
                <x-validate-error />
                @include('layouts.preloader')

                <form action="{{ route('login.store') }}" method="POST">
                    {{-- @csrf --}}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    @include('layouts.asset_js')
</body>

</html>
