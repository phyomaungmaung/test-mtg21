@extends('admin.dashboard')

@section('title') 
    {{ lang('Setting') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Setting List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><a class="btn btn-primary" href="{{route('setting.create')}}">{{ lang('New Setting') }}</a></h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_setting" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('Key')}}</th>
                                <th>{{ lang('Value')}}</th>
                                <th>{{ lang('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>  
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){

            $('#tbl_setting').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('setting.list') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'key', name: 'key'},
                    { data: 'value', name: 'value' },
                    { data: 'action', name:'action', orderable: false,class:'dontprint',width:"60px" }
                ],
            });
            
        });

        function clickDestroy(item){

            alertDelete(item,"{!! route('setting.destroy') !!}","{!! route('setting.index') !!}","{{ csrf_token() }}","setting");
            return true;
        }


    </script>
@stop
