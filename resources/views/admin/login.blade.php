@php
    $allsetting = allsetting();
@endphp
    <!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="{{allsetting()['meta_description']}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{allsetting()['meta_title']}}"/>
    <meta property="og:image" content="{{asset('assets/admin/images/logo.svg')}}">
    <meta property="og:site_name" content="{{allsetting()['app_title']}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta itemprop="image" content="{{asset('assets/admin/images/logo.svg')}}" />

    <link rel="shortcut icon" href="{{asset(IMG_PATH.allsetting()['favicon'])}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
    <style>
        .main-content__area.bg-img {
            /* background-image: url("../images/background/bg-img.png"); */
            background-image: url("{{asset('assets/admin/images/bg-img.png')}}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }
    </style>
    @yield('style')
    <title>@yield('title') {{'| '.allsetting()['meta_title']}}</title>
</head>
{{-- <body class="hold-transition login-page"> --}}
<body>
{{-- <div class="login-box"> --}}
<div class="main-content__area bg-img">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-logo">
                    {{-- <a href="{{route('login')}}"><b>{{$allsetting['app_title']}}</b></a> --}}
                    <div class="authentication__item__logo">
                        <a href="#">
                            <img src="{{asset('assets/admin/images/logo.png')}}" alt="icon">
                        </a>
                    </div>
                </div>
                <!-- /.login-logo -->
                {{-- <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">{{__('Sign in to start your session')}}</p>

                        {{Form::open(['route' => 'login_process', 'files' => true, 'data-handler'=>"showMessage" ,'class' => 'ajax'])}}
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="email" placeholder="{{__('Email')}}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="{{__('Password')}}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            {{__('Remember Me')}}
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{__('Sign In')}}</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        {{Form::close()}}

                    </div>
                    <!-- /.login-card-body -->
                </div> --}}


                <div class="authentication__item">
                    {{-- <div class="authentication__item__logo">
                        <a href="#">
                            <img src="http://localhost:8000/assets/admin/images/logo.png" alt="icon">
                        </a>
                    </div> --}}
                    <div class="authentication__item__title mb-30">
                        <h2>Sign In</h2>
                    </div>
                    <div class="authentication__item__content">
                        {{Form::open(['route' => 'login_process', 'files' => true, 'data-handler'=>"showMessage" ,'class' => 'ajax'])}}
                            @csrf
                            <div class="input__group mb-25">
                                <label>Email Address</label>
                                <div class="input-overlay">
                                    <input type="email" name="email" placeholder="{{__('Email')}}">
                                    <div class="overlay">
                                        <img src="{{asset('assets/admin/images/mail.svg')}}" alt="icon">
                                    </div>
                                </div>
                            </div>
                            <div class="input__group mb-20">
                                <label>Password</label>
                                <div class="input-overlay">
                                    <input type="password" name="password" placeholder="{{__('Password')}}">
                                    <div class="overlay">
                                        <img src="{{asset('assets/admin/images/lock.svg')}}" alt="icon">
                                    </div>
                                    {{-- <div class="password-visibility">
                                        <img src="http://localhost:8000/assets/admin/images/eye.svg" alt="icon">
                                    </div> --}}
                                </div>
                            </div>
                            <div class="item__group__between mb-20">
                                <div class="input__group">
                                    {{-- <div class="icheck-primary"> --}}
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            {{__('Remember Me')}}
                                        </label>
                                    {{-- </div> --}}

                                </div>
                                {{-- <div class="input__group">
                                    <a href="forget-pass-classic.html">Forget Password?</a>
                                </div> --}}
                            </div>
                            <div class="input__group mb-27">
                                <button type="submit" class="btn btn-blue">{{__('Sign In')}}</button>
                            </div>
                        {{Form::close()}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /.login-box -->
<!-- js file start -->
<!-- jQuery -->
<script src="{{asset('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('assets/admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('assets/admin/plugins/sparklines/sparkline.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('assets/admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('assets/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('assets/admin/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('assets/admin/dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('assets/admin/chart/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/admin/dist/js/custom.js')}}"></script>
@include('user.common')
@yield('script')
<!-- End js file -->
</body>
</html>
