@extends('admin.dashboard')

@section('title') 
    {{ lang('Application') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
@stop
@section('content_header')
    <h1>{{ lang('Video') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('Video') }} {{$title}}</h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12" align="center">
                    @if(!$is_youtube)
                    <video id="video" class="video-js vjs-default-skin vjs-big-play-centered video"
                           controls preload="auto"  width="auto" height="auto" >
                        <source src="{{url(isset($video)?$video:'')}}" type="{{$mime}}" />
                    </video>
                    @else
                        <iframe width="806" height="453" src={{"https://www.youtube.com/embed/".$video}} frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @endif
                </div>
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
    <script src="//vjs.zencdn.net/4.12/video.js"></script>
    <script type="text/javascript">
        
        videojs(document.getElementById('video'), {}, function() {
            
        });

    </script>
@stop
