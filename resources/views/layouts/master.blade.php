@extends('adminlte::master')

@section('body')

    @include('includes.header')
    <div class="main">
    @yield('content')

    </div>

 @endsection

{{--<!doctype html>--}}
 {{--<html lang="en">--}}
  {{--<head>--}}
    {{--<meta charset="UTF-8">--}}
      {{--<meta charset="utf-8">--}}
      {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
      {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}

      {{--<!-- CSRF Token -->--}}
      {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

      {{--<title>@yield('title')</title>--}}
      {{--<link rel="stylesheet" href="{{URL::to('vendor/adminlte/bootstrap/css/bootstrap.min.css')}}">--}}
      {{--<link rel="stylesheet" href="{{URL::to('css/app.css')}}">--}}
      {{--<link rel="stylesheet" href="{{URL::to('css/form-wizard.css')}}">--}}
      {{--<link rel="stylesheet" href="{{URL::to('template/adminlte/bootstrap/css/bootstrap.min.css')}}">--}}
      {{--<!-- Font Awesome -->--}}
      {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">--}}
      {{--<!-- Ionicons -->--}}
      {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">--}}
      {{--<link rel="stylesheet" href="{{URL::to('css/admin_custom.css')}}">--}}
      {{--@yield('css')--}}
      {{--<script src="{{URL::to('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>--}}
  {{--</head>--}}
{{--<body>--}}
    {{--@include('includes.header')--}}
    {{--<div class="main">--}}
        {{--@yield('content')--}}

    {{--</div>--}}

{{--</body>--}}
  {{--@push('js')--}}
  {{--<script type="text/javascript" src="{{ asset('js/general.js') }}"></script>--}}

  {{--<script type="text/javascript" src="{{ URL::to('vendor/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ URL::to('vendor/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>--}}
  {{--<script type="text/javascript" src="{{ URL::to('js/form-wizard.js') }}"></script>--}}
  {{--@endpush--}}
  {{--@yield('js')--}}
{{--</html>--}}

