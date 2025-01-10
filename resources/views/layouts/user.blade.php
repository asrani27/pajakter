<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAJAK TER</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/notif/dist/css/iziToast.min.css">
    <script src="/notif/dist/js/iziToast.min.js" type="text/javascript"></script>

    @stack('css')
    <style>
        .active {
            background-color: #3d8b99;
            border-radius: 25px;
            color: white
        }

        @media (max-width: 768px) {
            .navbar-toggler {
                margin-left: auto;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand>img {
                max-width: 290px;
            }
        }

        @media (min-width: 768px) {
            .navbar-nav.ml-md-auto .nav-item {
                margin-left: auto;
            }
        }
    </style>

</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light bg-gray bg-gray-dark" style="border-bottom:0px;">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <img src="https://cdn-icons-png.flaticon.com/512/9134/9134408.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light" style="color: silver">AJAK ASN</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">

                        @if (Auth::user()->roles == 'superadmin')
                        <li class="nav-item" style="">
                            <a href="/superadmin" class="nav-link {{request()->is('superadmin') ? 'active':''}}"
                                style="color: white"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item" style="">
                            <a href="/superadmin/pajakter"
                                class="nav-link {{request()->is('superadmin/pajakter*') ? 'active':''}}"
                                style="color: white"><i class="fa fa-money-bill"></i> Pajak TER</a>
                        </li>
                        <li class="nav-item" style="">
                            <a href="/superadmin/skpd"
                                class="nav-link {{request()->is('superadmin/skpd*') ? 'active':''}}"
                                style="color: white"><i class="fa fa-university"></i> SKPD</a>
                        </li>
                        @endif

                        @if (Auth::user()->roles == 'dpd')
                        <li class="nav-item">
                            <a href="/dpd/rfk" class="nav-link {{request()->is('dpd/rfk*') ? 'active':''}}"
                                style="color: white"><i class="fa fa-money-bill"></i> RFK</a>
                        </li>
                        @endif

                    </ul>


                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="color: silver" href="/logout" role="button"
                            onclick="return confirm('Yakin ingin keluar?');">
                            Logout <i class="fa fa-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background: rgb(255,255,255);
background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(144,189,197,1) 57%, rgba(61,139,153,1) 100%);">
            <br />
            <div class="content">
                @yield('content')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer text-center"
            style="box-shadow: inset 0px 1px 4px rgba(0,0,0,0.4); padding:0.2rem; font-size:12px; font-weight:bold">
            <!-- Default to the left -->
            Copyright © 2025 <span class="text-red">Pemerintah Kota Banjarmasin</span><br>
            Badan Kepegawaian Daerah
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    @stack('js')
    <script type="text/javascript">
        @include('layouts.notif')
    </script>
</body>

</html>