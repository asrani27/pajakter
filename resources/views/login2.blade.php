<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAJAK TER ASN</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/notif/dist/css/iziToast.min.css">
    <script src="/notif/dist/js/iziToast.min.js" type="text/javascript"></script>
    <style>
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
        <nav class="main-header navbar navbar-expand-md navbar-light bg-gray bg-gray-dark" style="border-bottom: 0px;">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <img src="https://cdn-icons-png.flaticon.com/512/9134/9134408.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light" style="color: silver">AJAK ASN</span>
                </a>

                <button class="navbar-toggler order-1 ml-auto ml-md-0" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="background-color: white"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav ml-md-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: silver; padding-left:1rem">Masuk</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background: rgb(255,255,255);
background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(144,189,197,1) 57%, rgba(61,139,153,1) 100%);">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">


                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="card card-widget widget-user">
                                <div class="widget-user-header text-white"
                                    style="background: url('https://img.lovepik.com//photo/50062/7188.jpg_860.jpg') center center;height:12rem; background-size:cover">

                                </div>
                                <form action='login' method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="card-body">
                                        <h2 class="text-center">LOGIN APLIKASI</h2><br />
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <div class="input-group-text"
                                                    style="border-top-left-radius: 18px;border-bottom-left-radius: 18px;">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            <input type="text" name="username" class="form-control"
                                                placeholder="Username"
                                                style="border-top-right-radius: 18px; border-bottom-right-radius: 18px;"
                                                autocomplete="new-password">
                                            @error('username')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <div class="input-group-text"
                                                    style="border-top-left-radius: 18px;border-bottom-left-radius: 18px;">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Password"
                                                style="border-top-right-radius: 18px;border-bottom-right-radius: 18px;"
                                                autocomplete="new-password">
                                            @error('password')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block"
                                                style="border-radius: 18px;"><i class=" fa fa-sign-in"></i>
                                                MASUK</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
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
    <script type="text/javascript">
        @include('layouts.notif')
    </script>
</body>

</html>