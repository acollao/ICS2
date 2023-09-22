<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{url('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- Core CSS -->
<link rel="preconnect" href="{{url('css/simple-datatables.min.css')}}">
<link href="{{url('css/styles.css')}}" rel="stylesheet" />
<link href="{{url('css/loader.css')}}" rel="stylesheet" />
<link href="{{url('css/custom.css')}}" rel="stylesheet" />
@stack('styles')
<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')