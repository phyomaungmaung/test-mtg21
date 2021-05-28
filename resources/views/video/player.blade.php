@extends('admin.dashboard')

@section('title') 
    {{ lang('Video View') }}
@endsection
@section('css')
    {{--<link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">--}}
@stop
@section('content_header')
    <h1>{{ $title }}</h1>
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
                    @if($video->youtube_id)
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/{{$video->youtube_id}}?controls=0&autoplay=1" frameborder="0" allow="accelerometer; autoplay=true; encrypted-media; gyroscope; picture-in-picture" allowfullscreen frameborder="0"></iframe>
                        </div>
                    @else
                        <video class="videoPlayer" style="margin-left: auto" width="90%" height="auto" controls controlsList=" nodownload nopichture"  preload="none" >
                            <source  src="{{$video->path}}" type="{{$video->mien_type}}" >
                        </video>
                    @endif
                    {{--<video id="video" class="video-js vjs-default-skin vjs-big-play-centered video"--}}
                           {{--controls preload="auto"  width="auto" height="auto" >--}}
                        {{--<source src="{{url(isset($video)?$video:'')}}" type="{{$mime}}" />--}}
                    {{--</video>--}}
                </div>
                <br>
                {{--<div align="right">--}}
                    {{--<a href="{{url()->previous()}}" class="btn btn-primary">{{lang('Back')}}</a>--}}
                {{--</div>--}}
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
             <div class="box-footer">
                 <div class="col-lg-12" align="right">
                     <a href="{{url()->previous()}}" class="btn btn-primary">{{lang('Back')}}</a>
                 </div>
             </div>
           
        </div><!-- /.box -->
    </div>
@endsection

@section('js')
    {{--<script src="//vjs.zencdn.net/4.12/video.js"></script>--}}
    <script type="text/javascript">
        try{
            videojs(document.getElementById('video'), {}, function() {

            });
        }catch (err){

        }


    </script>
@stop
