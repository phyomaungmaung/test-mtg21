@extends('admin.dashboard')

{{-- @section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')
 --}}
@section('content_header')
    <h1>{{ lang('Profile') }}</h1>
@stop

@section('content')     
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
               
                <h3 class="box-title"><a class="btn btn-primary" href="{{route('user.edit',\Auth::id())}}">{{ lang('Edit Profile') }}</a></h3>
                
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    
                    <div class="col-lg-12">
                    
                    {!!form_start($form)!!}
                    {!!form_end($form)!!}
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
           
        </div><!-- /.box -->
    </div>
 @endsection


{{--@section('js')--}}

{{--@stop--}}
