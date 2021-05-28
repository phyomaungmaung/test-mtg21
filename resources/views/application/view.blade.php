


@extends('admin.dashboard')

@section('title')
    {{ lang('Application view') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{URL::to('css/fileinput.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/form-wizard.css')}}">
    <style>
        .box-comments{
            height: 200px;
            overflow: auto;
        }
        .box-comments .comment-text{
            margin-left: 2px;
        }
    </style>
@stop
@section('content_header')
    <h1>{{ lang('Application View') }}</h1>
@stop


@section('content')
    <meta name="_token" content="{{ csrf_token() }}" />
        <div class="wraper container-fluid">
            <div class="row">
                <div class="{!! (isset($can_comment) &&  $can_comment==true) ?'col-md-9' : 'col-md-12' !!}">
                    <div class="box">
                        <div class="box-body">
                            <div class="col-lg-12">
                            <div class="wizard">
                                <div class="wizard-inner">
                                    <div class="connecting-line"></div>
                                    <ul class="nav nav-tabs" role="tablist">

                                        <li role="presentation" class="active">
                                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                                <span class="round-tab">
                                                 <i class="glyphicon glyphicon-home"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                                <span class="round-tab">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                                <span class="round-tab">
                                                    <i class="glyphicon glyphicon-folder-open"></i>
                                                    {{--<i class="fa fa-product-hunt"  aria-hidden="true"></i>--}}
                                                </span>
                                            </a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Step 4">
                                                <span class="round-tab">
                                                    <i class="glyphicon glyphicon-folder-open"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Step 5">
                                                <span class="round-tab">
                                                    <i class="glyphicon glyphicon-facetime-video"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li role="presentation" class="">
                                            <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                                                <span class="round-tab">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                {!!form_start($form)!!}
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1">
                                            <div class="col-xs-12">
                                                <div class="col-xs-12 header-title">
                                                    <h3>Step 1 : PARTICIPATION(COMPANY) DETAIL</h3>
                                                    {!! form_row($form->company_name) !!}
                                                    {!! form_row($form->address) !!}
                                                    {!! form_row($form->phone) !!}
                                                    {!! form_row($form->fax) !!}
                                                    {!! form_row($form->website) !!}
                                                    {!! form_row($form->email) !!}
                                                    {!! form_row($form->ceo_name) !!}
                                                    {!! form_row($form->ceo_email) !!}
                                                    {!! form_row($form->company_profile) !!}
                                                </div>
                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        {{--<li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>--}}
                                                        @if($can_edite)
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">Save and continue <i class="fa fa-angle-right"></i></button></li>
                                                        @else
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">  next <i class="fa fa-angle-right"></i> </button></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step2">
                                            <div class="col-xs-12">
                                                <div class="col-xs-12 header-title">
                                                    <h3>Step 2 : CONTACT PERSON DETAILS</h3>
                                                    {!! form_row($form->contact_name) !!}
                                                    {!! form_row($form->contact_position) !!}
                                                    {!! form_row($form->contact_email) !!}
                                                    {!! form_row($form->contact_phone) !!}
                                                </div>
                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>
                                                        @if($can_edite)
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">Save and continue <i class="fa fa-angle-right"></i></button></li>
                                                        @else
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">  next <i class="fa fa-angle-right"></i> </button></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step3">
                                            <div class="col-xs-12">
                                                <div class="col-xs-12 header-title">
                                                    <h3>Step 3 :  PRODUCTS PART 1</h3>
                                                    {!! form_row($form->product_name) !!}
                                                    {!! form_row($form->product_description) !!}
                                                    {!! form_row($form->product_uniqueness) !!}
                                                </div>

                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>
                                                        @if($can_edite)
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">Save and continue <i class="fa fa-angle-right"></i></button></li>
                                                        @else
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">  next <i class="fa fa-angle-right"></i> </button></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step4">
                                            <div class="col-xs-12">
                                                <div class="col-xs-12 header-title">
                                                    <h3>Step 4 : PRODUCT PART 2</h3>
                                                    {!! form_row($form->product_quality) !!}
                                                    {!! form_row($form->product_market) !!}
                                                    {!! form_row($form->business_model) !!}
                                                </div>
                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>
                                                        @if($can_edite)
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">Save and continue <i class="fa fa-angle-right"></i></button></li>
                                                        @else
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">  next <i class="fa fa-angle-right"></i> </button></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step5">
                                            <div class="col-xs-12">
                                                <div class="col-xs-12 header-title">
                                                    <h3>Step 5 : DEMO</h3>
                                                    {!! form_row($form->video_demo) !!}
                                                </div>
                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>
                                                        @if($can_edite)
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">Save and continue <i class="fa fa-angle-right"></i></button></li>
                                                        @else
                                                            <li><button type="button" class="btn btn-primary next-step save-continue">  next <i class="fa fa-angle-right"></i> </button></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="complete">
                                            <div class="col-xs-12">
                                                <div class="col-xs-12 header-title">
                                                    <h3>final </h3>
                                                </div>
                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>


                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                {!!form_end($form)!!}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
               @if(isset($can_comment) &&  $can_comment==true)
                <div class="col-md-3">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ lang('Feedback') }}</h3>
                            <div class="box-tools pull-right">
                                <!--span class="label label-primary">Label</span-->
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <h4>comment form</h4>
                            {{--<form method="POST" action="http://aicta.local/application/store" accept-charset="UTF-8" role="form" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">--}}
                                {{--<input name="_token" type="hidden" value="hFapOjaQthRlpryQRBsgzH2Uw8KNgxvC96xZYT2P">--}}

                            {{--</form>--}}
                            <form id="fm_comment" method="POST" accept-charset="UTF-8" role="form" class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name="commented_on" value="register_form">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="hidden" name="meta_key" value="{!! $form->getModel()->id !!}">
                                <textarea class="form-control" name="comment" cols="20" rows="5" id="comment" placeholder="Enter a comment"></textarea>
                                <br>
                               <div class="col-xs-2"><div class="" id="loader"></div></div> <input type="submit" class="btn btn-info pull-right" id="btn_comment" value="comment ">
                            </form>

                        </div>
                        <div class="box-footer">
                            <div class="box-footer box-comments" id="list_comment">
                                @foreach($comments as $comment)
                                    <div class="box-comment">
                                        <!-- User image -->
                                        {{--<img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">--}}
                                        <div class="comment-text">
                                              <span class="username">
                                                {!! $comment->commenter->username !!}
                                                <span class="text-muted pull-right"><!--8:03 PM Today-->{!! $comment->created_at->format('Y-m-d h:i:s') !!}</span>
                                                 </span><!-- /.username -->
                                                 {!! $comment->comment !!}
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>
                                    <!-- /.box-comment -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('js/form-wizard.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
//            for comment
            var list_comment=$('#list_comment');
            var id ="{{$form->getModel()->id}}";
            $('#fm_comment').on('submit',function(e) {
                e.preventDefault();
                $('#btn_comment') .prop('disabled', true);

                $('#loader').addClass('loader');
                $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'JSON',
                    url: "{!! route('comment.add') !!}",
                    data: $('#fm_comment').serialize(),
                    success: function(data) {
                        list_comment.html();
                        $.each( data, function( key, comment ) {
                            ///-- add the result to the visual page
                            comm='<div class="box-comment"><div class="comment-text"> <span class="username">'+comment.username+'<span class="text-muted pull-right">'+comment.created_at+'</span> </span>'
                             + comment.comment+'</div></div>';
                            list_comment.prepend(comm);

                        });
                        $('#comment').val('');
//                        $('#btn_comment').disable(false);
//                        $('#loader').removeClass('loader');
                    },

                }).done(function() {
                    $('#btn_comment').prop('disabled', false);
                    $('#loader').removeClass('loader');
                });
                return false;
            });

//            end for comment
//                for application
           @if (isset($edited) && isset($video))
            var video_url = "{{ url('/') }}/{{$edited}}";
            $('#video_demo').fileinput({
                uploadUrl: "{!! route('video.upload') !!}",
                showCaption: false,
                autoReplace: true,
                showRemove: false,
                showClose:false,
                allowedFileTypes : ['video'],
                overwriteInitial: true,
                showUploadedThumbs: true,
                maxFileCount: 1,
                maxFileSize: "{{\Settings::get('VIDEO_UPLOAD_MAX_SIZE',100000000)}}",
                previewTemplates:'video',
                initialPreview: [
                    '<video class="videoPlayer" width="320" height="240" controls controlsList=" nodownload nopichture"  preload="none" ><source  src="{{$video->path}}" type="{{$video->mien_type}}" > </video>'
//                    '<video width="320" height="240" controls><source src="'+video_url+'" type="video/mp4"><source src="'+video_url+'" type="video/ogg"> </video>'
                ],
                previewSettings: {
                    video: {width: "320px", height: "240px"},
                },
                initialPreviewAsData: true,
                  layoutTemplates: {
                    footer: ''
                },
                uploadExtraData:function(previewId, index){
                    return{
                        id:  $('#app_id').val() ,
                        _token:"{!! csrf_token() !!}"
                    }
                }
            }).on('fileuploaded', function(event, data, id, index) {

              } );
            @else
            $('#video_demo').fileinput({
                uploadUrl: "{!! route('video.upload') !!}",
                showCaption: true,
                autoReplace: true,
                showRemove: false,
                showClose:false,
                captionClass:false,
                allowedFileTypes : ['video'],
                overwriteInitial: true,
                showUploadedThumbs: true,
                maxFileCount: 1,
                maxFileSize: 10240,
                previewTemplates:'video',
                previewSettings: {
                    video: {width: "320px", height: "240px"},
                },
                initialPreviewAsData: true,
                layoutTemplates: {
                    footer: ''
                },
                uploadExtraData:function(previewId, index){
                    return{
                        id:  $('#app_id').val() ,
                        _token:"{!! csrf_token() !!}"
                    }
                }
            });
            @endif

            $('.save-continue').on('click',function(e){
                e.preventDefault(e);

                that = $('#application');
                    go_next = function(){
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        nextTab($active);
                    };
                @if($can_edite)
                        $.ajax({
                        type:"POST",
                        url:"{!! route('application.draft') !!}",
                        data:$(that).serialize(),
                        dataType: 'json',
                        success: function(data){
                            $('input[name="id"]').val(data.id);
                            go_next();
//                            console.log("saved");
                        },
                        error: function(data){
                            console.log(data);
                            go_next();
                        }
                    });
                @else
                    go_next();
//                    console.log('next');
                 @endif

            });
        });
    </script>

@endsection