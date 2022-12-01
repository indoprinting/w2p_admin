<!-- Navbar -->
<nav class="main-header navbar navbar-expand {{ $theme == 'dark' ? 'navbar-dark' : 'navbar-white' }} navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block h5">
            <a href="javascript:;" id="theme-toggle" class="fas {{ $theme == 'dark' ? 'fa-adjust' : 'fa-sun' }}"></a>
        </li>
        @role([1, 5])
            <li class="ml-5 nav-items">
                <a href="/set-payment" class="btn btn-warning">Checkout {{ $set_payment == 1 ? 'ON' : 'OFF' }}</a>
            </li>
        @endrole
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link text-danger text-lg" data-toggle="dropdown" href="#">
                {{ Auth()->user()->name }}
                <i class="far fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <a href="{{ route('logout') }}" class="dropdown-item nav-link">
                    <div class="media">
                        <div class="media-body">
                            <p class="text-danger"><i class="fas fa-sign-out-alt mr-1"></i> Logout</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                @role([1, 5])
                    <a href="{{ route('cache.admin') }}" class="dropdown-item nav-link">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-danger"><i class="far fa-clock mr-1"></i> Clear Cache</p>
                            </div>
                        </div>
                    </a>
                @endrole
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
