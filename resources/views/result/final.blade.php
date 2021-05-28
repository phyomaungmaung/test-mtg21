@extends('admin.dashboard')

@section('title') 
    {{ lang('SemiFinal') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Final Result') }}</h1>
@stop



@section('content')

    <div class="wraper container-fluid">
        
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    @if(\Auth::user()->is_super_admin||\Auth::user()->can('export_final-result'))
                        <a class="btn btn-primary" href="{{route('report.finalScore')}}">{{ lang('Export') }}</a>
                    @endif
                    @if(\Auth::user()->is_super_admin||\Auth::user()->can('export_final_detail-result'))
                        <a class="btn btn-primary" href="{{route('report.finalScoreDetail')}}">{{ lang('Export Detail') }}</a>
                    @endif

                </h3>

                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-4 text-right" for="cate_id">{{ lang('Category') }}</label>
                    <div class="col-sm-4">
                        <select name="cate_id" id="cate_id" class="form-control">
                            <option value="" >All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <div class="clearfix"></div>
                <div class="col-lg-12 table-responsive no-padding">
                    <table id="tbl_form" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                               {{-- <th>{{ lang('ID')}}</th>--}}
                                <th style="min-width: 140px; max-width: 200px" rowspan="2">{{ lang('Company')}}</th>
                                <th style="min-width: 180px; max-width: 250px" rowspan="2">{{ lang('Product Name')}}</th>
                                <th rowspan="2">{{ lang('Country')}}</th>
                                <th colspan="{{$num_judge}}">{{lang("Judge")}}</th>
                                <th rowspan="2" style="width: 70px;">{{ lang('Medal')}}</th>
                                <th rowspan="2" >{{ lang('Score Base on Medal')}}</th>
                                @if(\Setting::get('FINAL_SHOW_SCORE','FALSE')=="TRUE")
                                    <th rowspan="2" >{{ lang('Average Score base on Criteria')}}</th>
                                @endif
                                <th rowspan="2">{{ lang('Win Medal')}}</th>
                            </tr>
                            <tr>
                                @foreach($judges as $j)
                                    <th >{{  lang($j->country->bref)}}<img height="15px" src="/{{$j->country->flag}}">  </th>
                                @endforeach
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
            tbl=$('#tbl_form').DataTable({
                processing: true,
                serverSide: true,
                dom:'t',
                ajax: {
                    url:"{!! route('result.finalResultList')!!}",
                    data:function(d){
                        d.cat=$('#cate_id').val();
                    }
                },
                columns: [
//                    { data: 'id', name: 'id',orderable: false},
                        { data: 'application.company_name', name: 'Company',orderable: false},
                        { data: 'application.product_name', name: 'product',orderable: false},
                        { data: 'application.user.country.name', name: 'Country' ,orderable: false},
                        @foreach($judges as $key=> $j)
                            { data:'users', name: "{{ $j->country->bref }}",orderable: false,render: function (data, type, full, meta) {
                            var md =["mdgold.png","mdsilver.png","mdbrown.png"];
                            //alert(data);
                            if(data["{{$key}}"]== null || data["{{$key}}"]['num_star'] == null) return "";
                            return   "<img src=\"" + "{{asset("images/img/")}}/"+md[3-data["{{$key}}"]['num_star']] + "\" height=\"30\"/>";
                                },
                            },
                        @endforeach
                        { data:'medals', name: "medal",orderable: false,render: function (data, type, full, meta) {
                                return   "<img src=\"" + "{{asset("images/img/mdgold.png")}}"+ "\" height=\"30\"/>"+":"+data[0]+"<br>"+
                                    "<img src=\"" + "{{asset("images/img/mdsilver.png")}}"+ "\" height=\"30\"/>"+":"+data[1]+"<br>"+
                                    "<img src=\"" + "{{asset("images/img/mdbrown.png")}}/"+ "\" height=\"30\"/>"+":"+data[2]+"<br>";

                            },
                         },
                        { data: 'stars', name: 'stars' ,orderable: false},
                        @if(\Setting::get('FINAL_SHOW_SCORE','FALSE')=="TRUE")
                        { data: 'score', name: 'score' ,orderable: false,render:function (data) {
                            return Number(data).toFixed(3);
                        }},
                        @endif
                        { data:'rank', name: "rank",orderable: false,render: function (data, type, full, meta) {
                            var md =["mdgold.png","mdsilver.png","mdbrown.png"];
                            return   "<img src=\"" + "{{asset("images/img/")}}/"+md[data-1] + "\" height=\"30\"/>";
                        },
                        },


                    ],

            });
            $('#cate_id').on('change', function(e) {
                tbl.draw();
                e.preventDefault();
            });



        });



    </script>
@stop

