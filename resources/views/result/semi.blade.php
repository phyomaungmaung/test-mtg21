@extends('admin.dashboard')

@section('title') 
    {{ lang('SemiFinal') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Result') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
        
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                        {{lang('Result')}}
                @else 
                   {{lang('Result')}}
                @endif

                </h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-6">
                    <select name="con" id="con" class="form-control" style="max-width: 220px">
                        <option value="" >All Country</option>
                        @foreach($countries as $c):
                        <option value="{{$c->id}}" >{{$c->name}}</option>
                        @endforeach;
                    </select>
                </div>
                <div class="col-sm-6">
                    <select name="cat" id="cat" class="form-control" style="max-width: 220px">
                        <option value="" >All Category</option>
                        @foreach($categories as $cat):
                            <option value="{{$cat->id}}" >{{$cat->name}}</option>
                        @endforeach;
                    </select>
                </div>
                <hr>
                <div class="col-lg-12">
                    <table id="tbl_role" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('ID')}}</th>
                                <th>{{ lang('Country')}}</th>
                                <th>{{ lang('Category')}}</th>
                                <th>{{ lang('Form')}}</th>
                                <!-- <th>{{ lang('Score')}}</th>
                                <th>{{ lang('Order')}}</th> -->
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
            var obje =$('#tbl_role').DataTable({
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                {{--ajax: "{!! route('result.semiFinalList') !!}",--}}
                ajax: {
                    url: "{!! route('result.semiFinalList') !!}",
                    data: function (d) {
                        d.coun = $('#con').val();
                        d.cat = $('#cat').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
//                    { data: 'name', name: 'name' },
                    { data: 'country', name:'country',},
                    { data: 'category', name:'category',},
                    { data: 'Form', name:'Form',},
                    // { data: 'Score', name:'Score',},
                    // { data: 'Order', name:'Order',},
                ],
                "order": [[ 0, "asc" ]]
            });
            $('#cat,#con').on('change', function(e) {
                obje.draw();
                e.preventDefault();
            });

        });

    </script>
@stop
