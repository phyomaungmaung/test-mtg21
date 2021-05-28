@extends('admin.dashboard')

@section('title') 
    {{ lang('Judge') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Final Judging List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
        
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-primary" href="{{route('judge.create')}}">{{ lang('New Final Judging') }}</a>
                    <a class="btn btn-success" href="{{route('judge.index')}}">{{ lang('Report Judge') }}</a>
                </h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_judge" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('Username')}}</th>
                                <th>{{ lang('Email')}}</th>
                                <th>{{ lang('Country')}}</th>
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

            $('#tbl_judge').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('finaljudge.judgelist') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'username', name: 'username'},
                    { data: 'email', name: 'email' },
                    { data: 'country', name:'country'},
                    { data: 'action', name:'action', orderable: false,class:'dontprint',width:"60px" }
                ],
            });
            
        });

        function clickDestroy(item){

            alertDelete(item,"{!! route('finaljudge.destroy') !!}","{!! route('finaljudge.index') !!}","{{ csrf_token() }}","user");
            return true;
        }


    </script>
@stop
