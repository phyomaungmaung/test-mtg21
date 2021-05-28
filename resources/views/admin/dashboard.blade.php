
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

@stop

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    {{--<link rel="stylesheet" href="{{asset('/css/admin_custom.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.toast.css') }}">
@endpush
@push('js')
   <script type="text/javascript" src="{{ asset('js/jquery.toast.js') }}"></script>
       <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
   <link href="//cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
   <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
   @stack('more_js')
   @yield('more_js')
@endpush
@include('includes.notify',['success'=>session('success')])