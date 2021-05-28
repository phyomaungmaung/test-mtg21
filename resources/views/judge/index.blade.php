@extends('admin.dashboard')

@section('title') 
    {{ lang('Judge') }}
@endsection
{{--@section('css')--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">--}}
{{--@stop--}}
@section('content_header')
    <h1>{{ lang('Judge List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
        
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><a class="btn btn-primary" href="{{route('judge.create')}}">{{ lang('New Judge') }}</a></h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                        @if(\Auth::user()->is_super_admin)
                            <a href="{{route('judge.clean')}}" class="btn btn-sm btn-primary" title="clean">clean</a>
                        @endif
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control" style="max-width: 220px">
                        <option value="" >All Roles</option>
                        @foreach([['id'=>'semi','name'=>'Judge'],['id'=>'final','name'=>'Final Judge']] as $c):
                            <option value="{{$c['id']}}" >{{$c['name']}}</option>
                        @endforeach;
                    </select>
                </div>
                <div class="col-sm-4">
                    <select name="con" id="con" class="form-control" style="max-width: 220px">
                        <option value="" >All Country</option>
                        @foreach($countries as $c):
                        <option value="{{$c->id}}" >{{$c->name}}</option>
                        @endforeach;
                    </select>
                </div>
                <div class="col-sm-4">
                    <select name="cat" id="cat" class="form-control" style="max-width: 220px">
                        <option value="" >All Category</option>
                        @foreach($categories as $cat):
                        <option value="{{$cat->id}}" >{{$cat->name}}</option>
                        @endforeach;
                    </select>
                </div>
                <div class="clearfix"></div>
                <hr>

                <div class="col-lg-12 table-responsive">
                    <table id="tbl_judge" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('Username')}}</th>
                                <th>{{ lang('Email')}}</th>
                                <th>{{ lang('Role')}}</th>
                                <th>{{ lang('Country')}}</th>
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
    {{--<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>--}}
    <script type="text/javascript">
        $(document).ready(function(){
             tbl_judge =$('#tbl_judge').DataTable({
//                dom: "<'row'<'col-xs-12'<'col-xs-4'l><'#test.col-xs-4' 'B > <'col-xs-4'f>>r>"+
//                "<'row'<'col-xs-12't>>"
//                + "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{!! route('judge.list') !!}",
                    data: function (d) {
                        d.coun = $('#con').val();
                        d.cat = $('#cat').val();
                        d.type =$('#type').val();
                    },
                },
                columns: [
                    { data: 'id', name: 'id',orderable: false},
                    { data: 'username', name: 'username'},
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'country', name:'country'},
                    { data: 'category', name:'category'},
                    { data: 'action', name:'action', orderable: false,class:'dontprint',style:{minwidth:"60px" , maxwidth:"120px"} }
//                    { data: 'action', name:'action', orderable: false,class:'dontprint',width:"60px" }
                ],
            });
            $('#cat,#con,#type').on('change', function(e) {
                tbl_judge.draw();
                e.preventDefault();
            });
            
        });

        function alertDeleteJudge(item,urldelete,urlindex,token,banner){
            data = $(item).data('item');
            data._token = token;
            var  url = $(item).attr('href');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this "+banner+" file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete",
                cancelButtonText: "No, cancel",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm){

                if (isConfirm)
                {
                    $.ajax({
//                        url: urldelete,
                        url:url,
                        type: "POST",
                        dataType: "html",
//                        data: {item:item_id, _token:token},
                        data:data,
                        success: function(result)
                        {
                            try{
                                result =JSON.parse(result);
                            }catch (e){ }

                            if(result=="success"){
                                window.location = urlindex;
                            }else if(result.mess ){
                                swal("Warning!", "Cannot delete this item !!!\n "+result.mess, "error");
                            } else{

                                swal("Warning!", "This item is used by other or you don't have permission!", "error");
                            }

                        },
                        error:function(){
                            swal("Warning!", "This item is used by other or you don't have permission!", "error");
                        }
                    });
                }

            });
        }
        function clickDestroy(item){

            alertDeleteJudge(item,"{!! route('judge.destroy') !!}","{!! route('judge.index') !!}","{{ csrf_token() }}","judge");
            return true;
        }


    </script>
@stop
