@extends('admin.dashboard')
{{--@extends('layouts.master')--}}

@section('title') 
    {{ lang('Application Form') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{URL::to('css/fileinput.css')}}">
@endsection
@section('content_header')
    <h1>{{ lang('Application Form') }}</h1>
@stop

@section('content')
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border text-center">
                @if(!$edited)
                    <h3 class="box-title">{{lang('Create New Application Form')}}</h3>
                @else
                    <h3 class="box-title">{{lang('Edit Application Form')}}</h3>
                @endif
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">

                    {!!form_start($form)!!}
                    {!! form_row($form->form_path) !!}
                    <div class="col-sm-12">{!! form_row($form->id) !!}</div>

                    <div class="form-group">
                        <label for="height" class="control-label col-lg-3">
                       
                        </label>  
                        <div class="col-lg-8 text-right">
                            <button id="submitRole" class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{lang('Save')}}</button>
                        </div>
                    </div>
                    
                    {!!form_end($form)!!}
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
           
        </div><!-- /.box -->

@endsection

@section('js')
    
    <script type="text/javascript" src="{{ asset('js/fileinput.js') }}"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            @if ($edited)
                    var flag_url = "{{ url('/') }}/{{$edited}}";
                    $('#form_path').fileinput({
                        showCaption: true,
                        autoReplace: true,
                        showRemove: false,
                        showClose:false,
                        allowedFileTypes : ['pdf'],
                        allowedFileExtensions : ['pdf'],
                        overwriteInitial: true,
                        showUploadedThumbs: true,
                        maxFileCount: 1,
                        maxFileSize: 1024,
                        previewTemplates:'pdf',
                        previewSettings:{
                            pdf:{ width:"500px",height:"200px"},
                            object:{ width:"500px",height:"200px"},
                        } ,
                        initialPreview: [
                        '<embed class="kv-preview-data" src="'+flag_url+'" width="500" height="200" type="application/pdf">'
                        ],
                        initialPreviewAsData: true,
                        layoutTemplates: {
                            footer: ''
                        },

                                                    
                    });
            @else

            $('#form_path').fileinput({
                        showCaption: true,
                        autoReplace: true,
                        showRemove: false,
                        showClose:false,
                        captionClass:false,
//                        allowedFileTypes : ['pdf'],
                        allowedFileExtensions : ['pdf'],
                        overwriteInitial: true,
                        showUploadedThumbs: true,
                        maxFileCount: 1,
                        maxFileSize: 10240,
                        previewTemplates:'pdf',
                        previewSettings:{
                            pdf:{ width:"500px",height:"200px"},
                            object:{ width:"500px",height:"200px"},
                        } ,
                        initialPreviewAsData: true,
                        layoutTemplates: {
                            footer: ''
                        },
                        
                                                
                });
            @endif
            function clickDestroy(item){
                {{--alertDelete(item,"{!! route('formsubmission.destroy') !!}","{!! route('formsubmission.index') !!}","{{ csrf_token() }}","{{lang('account')}}");--}}
                return true;
            }
        });


    </script>
@stop
