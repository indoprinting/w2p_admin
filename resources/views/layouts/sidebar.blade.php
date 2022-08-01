<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <x-logo class="mw-100" />
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu" data-accordion="true">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                @foreach ($sidebar_menu as $category)
                    <li class="nav-header text-bold">{{ $category->name }}</li>
                    @foreach ($category->menu as $menu)
                        <li class="nav-item">
                            <a href="{{ route($menu->route) }}" class="nav-link {{ Request::routeIs($menu->route) || Request::routeIs($menu->route . '.*') ? 'active' : '' }}">
                                <i class="{{ $menu->icon }} nav-icon"></i>
                                <p>{{ $menu->name }} <span class="right badge badge-danger" id="{{ $menu->route }}"></p>
                            </a>
                        </li>
                    @endforeach
                @endforeach
                <div style="margin-bottom: 100px"></div>
            </ul>
        </nav>
    </div>
</aside>

<script>
    $(document).ready(function() {
        let ajax_notif = function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: `/notification-sale`,
                success: function(hasil) {
                    if (hasil.count > 0) {
                        $('#dashboard').html(hasil.count);
                    }
                }
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: `/notification-rajaongkir`,
                success: function(hasil) {
                    if (hasil.count > 0) {
                        $('#rajaongkir').html(hasil.count);
                    }
                }
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: `/notification-gosend`,
                success: function(hasil) {
                    if (hasil.count > 0) {
                        $('#gosend').html(hasil.count);
                    }
                }
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: `/notification-tb`,
                success: function(hasil) {
                    if (hasil.count > 0) {
                        $('#tb').html(hasil.count);
                    }
                }
            });
        }
        ajax_notif();
        setInterval(function() {
            ajax_notif();
        }, 1000 * 60 * 10);
    });
</script>
