@extends('admin.dashboard')

@section('title') 
    {{ lang('Country') }}
@endsection

@section('content_header')
    <h1>{{ lang('Country') }}</h1>
@stop

@section('content')
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                @if(!$edited)
                    <h3 class="box-title">{{lang('Create New Country')}}</h3>
                @else
                    <h3 class="box-title">{{lang('Edit Country')}}</h3>
                @endif
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">

                    {!!form_start($form)!!}
                    {!! form_row($form->name) !!}
                    {!! form_row($form->bref) !!}
                    {!! form_row($form->flag) !!}
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
    </div>
@endsection

@section('js')
    
    <script type="text/javascript" src="{{ asset('js/fileinput.js') }}"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            @if ($edited)
                    var flag_url = "{{ url('/') }}/{{$edited}}";
                    $('#flag').fileinput({
                        showCaption: true,
                        autoReplace: true,
                        showRemove: false,
                        showClose:false,
                        allowedFileTypes : ['image'],
                        overwriteInitial: true,
                        showUploadedThumbs: true,
                        maxFileCount: 1,
                        maxFileSize: 1024,
                        previewTemplates:'image',
                        initialPreview: [
                            "<img style='height:160px' src='"+flag_url+"'>",
                        ],
                                                    
                    });
            @else

            $('#flag').fileinput({
                        showCaption: true,
                        autoReplace: true,
                        showRemove: false,
                        showClose:false,
                        captionClass:false,
                        allowedFileTypes : ['image'],
                        overwriteInitial: true,
                        showUploadedThumbs: true,
                        maxFileCount: 1,
                        maxFileSize: 10240,
                        previewTemplates:'image',
                        
                                                
                });
            @endif
            
        });


    </script>
@stop
