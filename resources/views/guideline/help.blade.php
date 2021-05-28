@extends('admin.dashboard')

@section('title')
    {{ lang('Guideline') }}
@endsection

@section('content_header')
    <h1>{{ lang('Guideline') }}</h1>
@stop

@section('content')
    <div class="wraper container-fluid">
        <div class="box">
            <div class="box-header with-border text-center">
                    <h2 class="center guide-title">{{$guidelineInfor->title }}</h2>
                <div class="box-tools pull-right">
                    <span class="label label-primary"></span>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                        {!! $guidelineInfor->description !!}
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->

        </div><!-- /.box -->
    </div>
@endsection

@section('js')

    <script type="text/javascript">

        $(document).ready(function(){

        });

    </script>
@stop
