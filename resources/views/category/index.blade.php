@extends('admin.dashboard')

@section('title') 
    {{ lang('Category') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Category List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><a class="btn btn-primary" href="{{route('category.create')}}">{{ lang('New Category') }}</a></h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_category" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('Name')}}</th>
                                <th>{{ lang('abbreviation')}}</th>
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

            $('#tbl_category').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('category.list') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'name', name: 'category'},
                    { data: 'abbreviation', name: 'abbreviation' },
                    { data: 'action', name:'action', orderable: false,class:'dontprint',width:"60px" }
                ],
            });
            
        });

        function clickDestroy(item){

            alertDelete(item,"{!! route('category.destroy') !!}","{!! route('category.index') !!}","{{ csrf_token() }}","category");
            return true;
        }


    </script>
@stop
