@extends('admin.dashboard')

@section('title') 
    {{ lang('Judge') }}
@endsection

@section('content_header')
    <h1>{{ lang('Judge') }}</h1>
@stop

@section('content')
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
               
                    <h3 class="box-title">{{lang('Edit Judge')}}</h3>
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">

                    {!!form_start($form)!!}
                    {!! form_row($form->username) !!}
                    <div class="col-sm-12">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-8">
                            @if ($errors->has('username'))
                                <span class="help-block required">
                                    <strong >{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {!! form_row($form->email) !!}
                    <div class="col-sm-12">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-8">
                            @if ($errors->has('email'))
                                <span class="help-block required">
                                    <strong >{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
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
        

    </script>
@stop
