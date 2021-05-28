
@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <style>
        .bglogin{
            background-image: url( {{asset( \Settings::get('LOGIN_BG_IMG', "/../../images/img/angkor.jpg"))}});
            background-color: #cccccc;
            background-repeat:no-repeat;
            background-size: cover;
            height: auto;
        }
        .loginhead{
            background-color: rgba(255,255,255,0.5);
        }
        .imglogo{
            margin-top: 20px;
        }
        .formlogin{
            background: none;
        }
        body{
            margin: 0; height: 100%;
        }

    </style>
@section('title','AICTA')
@yield('css')
@stop

@section('body_class', 'login-page bglogin')



@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
