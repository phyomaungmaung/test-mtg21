@extends('admin.dashboard')

@section('title') 
    {{ lang('Application') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('View PDF Form') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('PDF FORM') }}</h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12 pdf-box"  align="center">
                    {{--<video id="video" class="video-js vjs-default-skin vjs-big-play-centered video"--}}
                           {{--controls preload="auto"  width="auto" height="auto" >--}}
                        {{--<source src="{{url($video)}}" type="{{$mime}}" />--}}
                    {{--</video>--}}
                    <object type="application/pdf" data="/{{$pdf}}" width="100%" height="100%" >
                        <embed src="/{{$pdf}}" type="application/pdf" width="100%" height="100%" />
                    </object>
                </div>
                <div class="clearfix"></div>
                <br>
                <div align="right">
                    <a href="{{url()->previous()}}" class="btn btn-primary">{{lang('Back')}}</a>
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
           
        </div><!-- /.box -->
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>

@stop
