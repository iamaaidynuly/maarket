<!DOCTYPE html>
<html dir="{{ config('adminlte.appearence.dir') }}" lang="{{ app()->getLocale() }}">
<head>
    @include('adminlte::layout.assets.head')
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/daterangepicker/daterangepicker.css">
</head>
<body class="hold-transition skin-{{ config('adminlte.appearence.skin') }} sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    @include('adminlte::layout.header')

    @include('adminlte::layout.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('adminlte::layout.footer')
</div>
<!-- ./wrapper -->

@include('adminlte::layout.assets.footer')

@stack('scripts')
</body>
</html>
