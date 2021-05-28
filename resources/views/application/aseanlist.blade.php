@extends('admin.dashboard')

@section('title') 
    {{ lang('Application') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Application List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('Application Form') }}</h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Pending Judging</a></li>
                          <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Judging Completed</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_1">
                            <table id="tbl_country" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ lang('Id')}}</th>
                                        <th>{{ lang('Product Name')}}</th>
                                        <th>{{ lang('Applicant')}}</th>
                                        <th>{{ lang('Category')}}</th>
                                        @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                                            <th>{{ lang('Country')}}</th>
                                        @endif
                                        <th>{{ lang('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>  
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane " id="tab_2">
                                <table id="tbl_judged" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ lang('Id')}}</th>
                                            <th>{{ lang('Product Name')}}</th>
                                            <th>{{ lang('Applicant')}}</th>
                                            <th>{{ lang('Category')}}</th>
                                            @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                                                <th>{{ lang('Country')}}</th>
                                            @endif
                                            @if(\Auth::user()->hasRole('Judge'))
                                                <th>{{ lang('score')}}</th>
                                            @endif
                                            <th>{{ lang('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>  
                          </div>
                        </div>
                               
                    </div>
                    
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

            $('#tbl_country').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('application.aseanlist') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'product', name: 'product'},
                    { data: 'applicant', name: 'applicant' },
                    { data: 'category', name: 'category'},
                    @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                        { data: 'country', name: 'country'},
                    @endif
                    { data: 'action', name:'action', orderable: false,width:"100px" }
                ],
            });
            $('#tbl_judged').DataTable({
                processing: true,
                serverSide: true,
                bAutoWidth: false , 
                ajax: "{!! route('application.judgedlist') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'product', name: 'product'},
                    { data: 'applicant', name: 'applicant','width':'300px' },
                    { data: 'category', name: 'category'},
                    @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                        { data: 'country', name: 'country'},
                    @endif
                    @if(\Auth::user()->hasRole('Judge'))
                        { data: 'score', name: 'score'},
                    @endif
                    { data: 'action', name:'action',width: '100px', orderable: false}
                ]
            });
            
        });
        


    </script>
@stop
