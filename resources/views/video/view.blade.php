@extends('admin.dashboard')

@section('css')
    <style>
        div.ytp-title{
            display: none !important;
        }
        .ytp-chrome-top, .ytp-chrome-bottom{
            diplay:none !important;
        }
    </style>
@endsection

@section('title') 
    {{ lang('Video') }}
@endsection


@section('content_header')
    {{--<h1>{{ lang('Videos List') }}</h1>--}}
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('Video View') }}</h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    @if($video->youtube_id)
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/{{$video->youtube_id}}?controls=0&autoplay=1" frameborder="0" allow="accelerometer; autoplay=true; encrypted-media; gyroscope; picture-in-picture" allowfullscreen frameborder="0"></iframe>
                        </div>
                    @else
                        <video class="videoPlayer" style="margin-left: 5%" width="90%" height="auto" controls controlsList=" nodownload nopichture"  preload="none" >
                            <source  src="{{$video->path}}" type="{{$video->mien_type}}" >
                        </video>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            var myVar = setInterval(myTimer, 1000);
            function myStopFunction() {
                clearInterval(myVar);
            }
            function myTimer() {
                    $('.ytp-show-watch-later-title').remove();
                    $('.ytp-share-button-visible').remove();
                $('.ytp-share-button-visible').attr('disabled');

            }

        });



    </script>


@endsection
