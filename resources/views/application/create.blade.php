
@extends(Setting::get('IS_USE_ADMIN_TEMPLATE','yes')=="yes"?'admin.dashboard':'layouts.master')

@section('css')

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

@endsection

@section('title')
    {{ lang('Application form') }}
@endsection

@section('content')

    <meta name="_token" content="{{ csrf_token() }}" />
    <div class="wraper container-fluid">
        <div class="row">
            <div class="{{ count($comments)>0? 'col-md-9':'col-md-12' }}">
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
                                                    <div class="box box-warning box-solid">
                                                        <div class="box-header with-border">
                                                            <h2 class="box-title">Attention !!!</h2>
                                                            <div class="box-tools pull-right">
                                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                            <!-- /.box-tools -->
                                                        </div>
                                                        <!-- /.box-header -->
                                                        <div class="box-body">
                                                            <p>Once you click on button <a class="btn btn-warning" disabled href="#"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Submit Final</a>, you will
                                                                -                                                            not able to edit the entry form unless your application form has any comments from your country representer before dateline.</p>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <ul class="list-inline pull-right">
                                                        <li><button type="button" class="btn btn-primary prev-step"><i class="fa fa-angle-left"></i> Previous</button></li>
                                                        {{--<a class="btn btn-primary"  target="_blank" href="{{route('application.pdfview',[$form->getModel()->id ,'download'=>true])}}"><i class="fa fa-download"></i> {{lang('download pdf')}}</a>--}}
                                                        {{--<button id="savepdf" class="btn btn-primary" type="buttom"><i class="fa fa-save"></i> {{lang('download pdf')}}</button>--}}
                                                        @if($can_edite)
                                                            <button id="submitRole" class="btn btn-primary" name="action" value="save" type="submit"><i class="fa fa-save"></i> {{lang('Save')}}</button>
                                                            <button id="makefinal" class="btn btn-warning"   name="action" value="final" type="submit"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{lang('Submit Final')}}</button>
                                                        @else
                                                            <button id="submitRole" class="btn btn-primary" name="action" value="save" disabled="disabled" type="submit"><i class="fa fa-save"></i> {{lang('Save')}}</button>
                                                            <button id="makefinal" class="btn btn-warning"  name="action" value="final" disabled="disabled" type="button"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{lang('Submit Final')}}</button>
                                                        @endif

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
            @if(count($comments))
                <div class="col-md-3">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ lang('List comment') }}</h3>
                            <div class="box-tools pull-right">
                                <!--span class="label label-primary">Label</span-->
                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
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
        var test=0;
        $(document).ready(function(){

            $('#makefinal').on('click',function(e){
                e.preventDefault();
//                $(this).attr('action','final');
                var form = $(this).parents('form');
//                var form = this;
                swal({
                    title: "Are you sure ?",
                    text: "You will not be able to edit your application !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Submit Final !",
                    closeOnConfirm: false
                }, function(isConfirm){
                    form.append('<input type="hidden" name="action" value="final" /> ');

                    if (isConfirm) form.submit();
                });
            });
            var initialPreviews = [];
            @if ($video)
            var video_url = "{{ url($video->path) }}";
                initialPreviews =  [
                            '<video class="videoPlayer" width="320" height="240" controls controlsList=" nodownload nopichture"  preload="none" ><source  src="'+video_url+'" type="{{$video->mien_type}}" > </video>'
                        ];
           @endif
           var videoUpload= $('#video_demo');
             videoUpload
            .fileinput({
                uploadUrl: "{!! route('video.upload') !!}",
                showCaption: false,
                autoReplace: true,
                showRemove: false,
                showClose:false,
//               uploadAsync: false,

//
//                showCaption: true,
//                autoReplace: true,
                captionClass:false,
                allowedFileTypes : ['video'],
                overwriteInitial: true,
                showUploadedThumbs: false,
                maxFileCount: 1,
                maxFileSize: "{{\Settings::get('VIDEO_UPLOAD_MAX_SIZE',100000000)}}",
                previewTemplates:'video',
                initialPreview:initialPreviews,
                previewSettings: {
                    video: {width: "320px", height: "240px"},
                },
                initialPreviewAsData: true,
                  layoutTemplates: {
                    footer: ''
                },showUpload: false,
                uploadExtraData:function(previewId, index){
//                    console.log("uploadExtraData");

                    return{
                        id:  $('#app_id').val() ,
                        _token:"{!! csrf_token() !!}"
                    }
                }
            })
//             .on('fileuploaded', function(event, data, id, index) {
//                    console.log(data);
//              })
//             .on('fileloaded', function(event, file, previewId, index, reader) {
//                console.log("fileloaded");
////                videoUpload.fileinput("upload");
//            })
//             .on('fileerror', function(event, data, msg) {
//                 console.log("on file error");
//             })
             .on("filebatchselected", function(event, files) {
                   // trigger upload method immediately after files are selected
                 videoUpload.fileinput("upload");
             })
           ;



            $('.save-continue').on('click',function(e){
                e.preventDefault(e);
                $(this).addClass('disabled');
                var $active = $('.wizard .nav-tabs li.active');
//                    $active.addClass('disabled');
                that = $('#application');
                    go_next = function(){
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
//                                console.log("saved");
                            },
                            error: function(data){
//                                console.log(data);
                                go_next();
                            }
                        });
                    @else
                        go_next();
                     @endif

            });
        });
    </script>

@endsection