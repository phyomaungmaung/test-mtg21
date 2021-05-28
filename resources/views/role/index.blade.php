@extends('admin.dashboard')

@section('title') 
    {{ lang('Role') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Role List') }}</h1>
@stop

@section('content')
    <div class="wraper container-fluid">
        @include('flash::message')
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><a class="btn btn-primary" href="{{route('role.create')}}">{{ lang('New Role') }}</a></h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_role" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('ID')}}</th>
                                <th>{{ lang('Role name')}}</th>
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
            
            $('#tbl_role').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('role.list') !!}",
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'action', name:'action', orderable: false }
                ],
                "order": [[ 1, "asc" ]]
            });

        });

        function clickDestroy(item){

            alertDelete(item,"{!! route('role.destroy') !!}","{!! route('role.index') !!}","{{ csrf_token() }}","role");
            return true;
        }
    </script>
@stop
