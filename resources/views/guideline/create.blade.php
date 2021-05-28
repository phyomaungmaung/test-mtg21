@extends('admin.dashboard')

@section('title')
    {{ lang('Guideline') }}
@endsection

@section('content_header')
    <h1>{{ lang('Guideline') }}</h1>
@stop

@section('content')

    <script type="text/javascript">

        tooles = [
            { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton',
                'HiddenField' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },


            { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert', items : [ 'Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
            '/',
            { name: 'paragraph', items : [
                'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
                '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] },
            { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-' ] },
            { name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] }
        ];
    </script>

    <div class="wraper container-fluid">
        <div class="box">
            <div class="box-header with-border">
                @if(!$edited)
                    <h3 class="box-title">{{lang('Create New Guideline')}}</h3>
                @else
                    <h3 class="box-title">{{lang('Edit Guideline')}}</h3>
                @endif
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">

                    {!!form_start($form)!!}
                    {!! form_row($form->title) !!}
                    {!! form_row($form->role_id) !!}
                    {!! form_row($form->description) !!}



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
 
    {{--<script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>--}}
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script>
        var CSRFToken = $('meta[name="csrf-token"]').attr('content');
        CKEDITOR.replace( 'description',{
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token='+CSRFToken,
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
//            toolbar:tooles
        } ); 
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            for ( instance in CKEDITOR.instances ){
                CKEDITOR.instances[instance].updateElement();
            }
        });

    </script>
@stop
