<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">BPKPAD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Administrator</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @guest
                <x-nav-link :active="request()->is('/')" href="/">
                    <i class="nav-icon fa fa-user-lock"></i>
                    <p>Log In</p>
                </x-nav-link>
                @endguest

                @auth
                <x-nav-link :active="request()->routeIs('beranda')" href="/beranda">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </x-nav-link>
                <x-nav-link :active="request()->routeIs('superadmin.skpd')" href="/superadmin/skpd">
                    <i class="nav-icon fas fa-list"></i>
                    <p>SKPD</p>
                </x-nav-link>
                <li class="nav-item">
                    <a href="/logout" class="nav-link" onclick="return confirm('Yakin Ingin Keluar Aplikasi?');">
                        <i class="nav-icon fas fa-arrow-right"></i>
                        <p>Log Out</p>
                    </a>
                </li>
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>