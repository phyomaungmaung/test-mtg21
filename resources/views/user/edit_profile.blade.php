@extends('admin.dashboard')

{{-- @section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')
 --}}
@section('content_header')
    @if(!$edited)
        <h1>{{ lang('User') }}</h1>
    @else
        <h1>{{ lang('Profile') }}</h1>
    @endif
@stop

@section('content')
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                @if(!$edited)
                    <h3 class="box-title">{{lang('Create User')}}</h3>
                @else
                    <h3 class="box-title">{{lang('Edit Profile')}}</h3>
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

                    @if($admin && !$is_edit_profile)
                        {!! form_row($form->roles) !!}
                    @endif

                    @if(!$edited)
                    
                    {!! form_row($form->country) !!}
                    @else
                        @if(\Auth::user()->is_super_admin==1||\Auth::user()->hasPermissionTo('edit-user'))
                            {!! form_row($form->country_id) !!}


                        @endif
                        
                    @endif
                    @if(\Auth::user()->hasRole('Candidate'))
                        {!! form_row($form->category_id) !!}
                    @endif
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

