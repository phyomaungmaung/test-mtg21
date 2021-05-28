@extends('admin.dashboard')


@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

@stop


@push('css')
    <link rel="stylesheet" href="{{asset('/css/admin_custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.toast.css') }}">

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.min.css"
          integrity="sha256-nFp4rgCvFsMQweFQwabbKfjrBwlaebbLkE29VFR0K40=" crossorigin="anonymous"/>


@endpush


@push('more_js')
    
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"
            integrity="sha256-urCxMaTtyuE8UK5XeVYuQbm/MhnXflqZ/B9AOkyTguo=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"
            integrity="sha256-0lDCetJx/wJYWmLR1yr17IiofI6mcH+ohE5nLOYP7ZY=" crossorigin="anonymous"></script>
    @include('settings::layout.notifications')

@endpush





