@extends('admin.dashboard')

@section('title') 
    {{ lang('Judge') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Judge') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
        
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                    <a class="btn btn-primary" href="{{route('judge.create')}}">{{ lang('New Judge') }}</a>
                    <a class="btn btn-warning" href="{{route('finaljudge.jlist')}}">{{ lang('List Judge') }}</a>
                        @if(\Auth::user()->is_super_admin)
                            <a class="btn btn-warning" href="{{route('result.generateSemiResult')}}">{{ lang('Generate Semi Result') }}</a>
                        @endif
                @else
                   {{lang('Final Judging List')}}
                @endif


                
                </h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_role" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>{{ lang('ID')}}</th>
                                <th>{{ lang('Name')}}</th>
                                <th>{{ lang('Email')}}</th>
                                @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                                <th>{{ lang('Country')}}</th>
                                @endif
                                <th>{{ lang('Category')}}</th>
                                <th>{{ lang('Form')}}</th>
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
                ajax: "{!! route('finaljudge.list') !!}",
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name:'email',},
                    @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                    { data: 'country', name:'country',},
                    @endif
                    { data: 'category', name:'category',},
                    { data: 'Form', name:'Form',}
                ],
                "order": [[ 1, "asc" ]]
            });

        });

        
    </script>
@stop
