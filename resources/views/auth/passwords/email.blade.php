{{--@extends('adminlte::passwords.email')--}}

@extends("auth.template")

@section('body')

    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aling="center">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif

    <div class="login-box loginhead">
        <div class="login-logo">
            <div align="center" ><img src="{{asset('/images/img/aictalogo.png')}}" width="50%" class="imglogo"></div>

        <!--a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a-->
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body loginhead">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.password_reset_message') }}</p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ url(config('adminlte.password_email_url', 'password/email')) }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ isset($email) ? $email : old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                @if(session('status'))
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat"
                    >{{ trans('Resend Password Reset Link') }}</button>
                @else
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat"
                    >{{ trans('adminlte::adminlte.send_password_reset_link') }}</button>
                @endif
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

