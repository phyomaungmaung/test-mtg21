@extends('admin.dashboard')
{{--@section('css')--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">--}}
{{--@stop--}}
{{-- @section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')
 --}}
@section('content_header')
    <h1>{{ lang('Candidate') }}</h1>
@stop

@section('content')     
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                @if(!$edited)
                    <h3 class="box-title">{{lang('Create Candidate')}}</h3>
                @else
                    <h3 class="box-title">{{lang('Edit Candidate')}}</h3>
                @endif
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    
                    {!!form_start($form)!!}
                    {!! form_row($form->username) !!}
                    {!! form_row($form->email) !!}

                    @if(\Setting::get("LIMIT_CAT_PER_CANDIDATE",1)<=1)
                        {!! form_row($form->category_id) !!}

                    @else
                        {!! form_row($form->categories) !!}

                    @endif
                    {{--@if(!$edited)--}}
                    {{--{!! form_row($form->category) !!}--}}
                     {{--<div class="col-sm-12">--}}
                        {{--<div class="col-lg-3"></div>--}}
                        {{--<div class="col-lg-8">--}}
                            {{--@if ($errors->has('category'))--}}
                                {{--<span class="help-block required">--}}
                                    {{--<strong >{{ $errors->first('category') }}</strong>--}}
                                {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@else--}}
                        {{--{!! form_row($form->category_id) !!}--}}
                     {{--<div class="col-sm-12">--}}
                        {{--<div class="col-lg-3"></div>--}}
                        {{--<div class="col-lg-8">--}}
                            {{--@if ($errors->has('category_id'))--}}
                                {{--<span class="help-block required">--}}
                                    {{--<strong >{{ $errors->first('category_id') }}</strong>--}}
                                {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    @if($isadmin)
                        {!! form_row($form->country_id) !!}
                    @endif
                    <div class="col-sm-12">{!! form_row($form->id) !!}</div>
                   
                    <div class="form-group">
                        <label for="height" class="control-label col-lg-3">
                       
                        </label>  
                        <div class="col-lg-8 text-right">
                            <button id="submitRole" class="btn btn-primary" type="submit" onsubmit="return Confirmation();"><i class="fa fa-save"></i> {{lang('Save')}}</button>
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

 {{--    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>--}}
    <script type="text/javascript">
   
$('#submitRole').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "Are you sure?",
        text: "Please ensure the category of company is correct before submit!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, save it!",
        closeOnConfirm: false
    }, function(isConfirm){
        if (isConfirm) form.submit();
    });
});

    </script>
    @if(\Setting::get("LIMIT_CAT_PER_CANDIDATE",1)>1)
        <script>
            $(document).ready(function() {
                $('.cat_multi').select2();
            });
			
        </script>
    @endif
@stop
