
@extends('admin.dashboard')

@section('title') 
    {{ lang('Message') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ isset($title)?$title:lang('Message') }}</h1>
@stop

@section('content')
    <div class="wraper container-fluid">
        
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-{{isset($type)?$type:session()->get('type')}}"><i class="fa fa-exclamation-triangle"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">&nbsp;</span>
                  <span class="info-box-number">{!!isset($msg)?$msg:session('msg')!!}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
              <!-- /.info-box -->
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
    
@stop
