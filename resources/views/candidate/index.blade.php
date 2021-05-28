@extends('admin.dashboard')

@section('title') 
    {{ lang('Candidate') }}
@endsection
{{--@section('css')--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">--}}
{{--@stop--}}
@section('content_header')
    <h1>{{ lang('Candidate List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
            @if(\Auth::user()->is_super_admin||\Auth::user()->hasPermissionTo("create-candidate"))
                <h3 class="box-title"><a class="btn btn-primary" href="{{route('candidate.create')}}">{{ lang('New Candidate') }}</a></h3>
            @endif
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_country" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('Company')}}</th>
                                <th>{{ lang('Email')}}</th>
                                <th>{{ lang('Category')}}</th>
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
{{--    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>--}}
    <script type="text/javascript">
        
        $(document).ready(function(){

            $('#tbl_country').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('candidate.list') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'username', name: 'username'},
                    { data: 'email', name: 'email' },
                    { data: 'category', name:'category'},
                    { data: 'country', name:'country'},
                    { data: 'action', name:'action', orderable: false,class:'dontprint',width:"60px" }
                ],
            });
            
        });

        function clickDestroy(item){

            alertDelete(item,"{!! route('candidate.destroy') !!}","{!! route('candidate.index') !!}","{{ csrf_token() }}","candidate");
            return true;
        }


    </script>
@stop
