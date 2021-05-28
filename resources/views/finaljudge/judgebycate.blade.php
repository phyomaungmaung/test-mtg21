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
                <div class=" text-center" align="center">
                    <div class="form-group col-sm-12">
                        <label class="control-label col-sm-4 text-right" for="cate_id"> 
                        
                        {{ lang('Category') }}</label>
                       
                        <div class="col-sm-4">
                            <select name="cate_id" id="cate_id" class="form-control">
                            @foreach($rcate as $rkey=>$rval)
                                <option value="{{$rkey}}">{{$rval}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                </div>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_form" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>{{ lang('star')}}</th>
                                @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                                    <th>{{ lang('Country')}}</th>
                                @endif
                                <th width="300px">{{ lang('Product Name')}}</th>
                                <th>{{ lang('Applicant')}}</th>
                                <th width="180px">{{ lang('Medal')}}</th>
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
            @if(Session::has('cate'))
                catback={{Session::get('cate')}};
                $("#cate_id").val(catback);
            @endif
            valcate=$("#cate_id").val();
            tbl=$('#tbl_form').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                ajax: {
                    url:"{!! route('finaljudge.finallist').'?cat='!!}"+valcate,
                    data:function(d){
                        d.valcate=$('#cate_id').val();
                    }
                },
                columns: [
                    { data: 'star', name: 'star'},
                    @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                        { data: 'country', name: 'country'},

                    @endif

                    { data: 'product', name: 'product'},
                    { data: 'applicant', name: 'applicant',orderable: false },
                    @if(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))
                    { data:'medal', name: 'medal',render: function (data, type, full, meta) {
                        // return data;
                        str="";
                        for(var k in data){
                            str+="<img src=\"" + data[k][0] + "\" height=\"30\"/>"+"<span class='badge badge-warning'>"+data[k][1]+"</span>";
                        }
                        return str;
                        },orderable: false,
                    },
                    @elseif(\Auth::user()->hasRole('Final Judge'))
                        { data:'medal', name: 'medal',render: function (data, type, full, meta) {
                        // return data;
                        str="";
                        for(var k in data){
                            if(data[k][1]>0){
                                str+="<img src=\"" + data[k][0] + "\" height=\"30\"/>";
                            }
                        }
                        return str;
                        },orderable: false,
                    },

                    @endif
                    { data: 'action', name:'action', orderable: false,width:"100px" }
                ],
            });

            $("#cate_id").change(function(){
                tbl.draw(); 
            });
            
        });
        


    </script>
@stop
