@extends('admin.dashboard')

{{-- @section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')
 --}}
@section('content_header')
    <h1>{{ lang('Password') }}</h1>
@stop

@section('content')     
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
               
                <h3 class="box-title">{{ lang('Change Password') }}</h3>
                
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    
                    <div class="col-lg-12">
                    
                    {!!form_start($form)!!}
                    {!! form_row($form->old_password) !!}
                    {!! form_row($form->new_password) !!}
                    {!! form_row($form->password_confirmation) !!}
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






