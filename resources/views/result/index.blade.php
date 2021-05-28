@extends('admin.dashboard')

@section('title') 
    {{ lang('Result') }}
@endsection

@section('content_header')
    <h1>{{ lang('Result') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
        <div class="box">

            <div class="box-body">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#semi" data-toggle="tab" aria-expanded="false">Online Result</a></li>
                            <li class=""><a href="#final" data-toggle="tab" aria-expanded="true">Final Result</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="semi">
                                <div class="col-sm-4">


                                    @if(\Auth::user()->is_super_admin||\Auth::user()->can('semi_score_detail-report'))
                                        <a href="{{route('report.judgeScoreDetail')}}" class="btn btn-sm btn-primary" title="Export Online Result">Export Online Result</a>
                                    @endif
                                    @if(\Auth::user()->is_super_admin||\Auth::user()->can('generate.semi-result'))
                                        <a href="{{route('result.semi.generate')}}" class="btn btn-sm btn-warning" title="Generate Online Result">Generate Online Result</a>
                                    @endif
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
                                <div class="col-lg-12">
                                    <table id="tbl_semi" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{ lang('ID')}}</th>
                                            <th>{{ lang('Country')}}</th>
                                            <th>{{ lang('Category')}}</th>
                                            <th>{{ lang('Form')}}</th>
                                        {{--<!-- <th>{{ lang('Score')}}</th>--}}
                                {{--<th>{{ lang('Order')}}</th> -->--}}
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane " id="final">
                                <div class="col-md-8 col-sm-6">
                                    @if(!$is_realtime)
                                        <a href="{{route('result.final.generate',['type'=>'final'])}}" class="btn btn-sm btn-warning" title="Generate Final Result">Generate Final Result</a>
                                    @endif
                                        @if(\Auth::user()->is_super_admin||\Auth::user()->can('export_final-result'))
                                            <a class="btn btn-success" href="{{route('report.finalScore')}}"> <i class="fa fa-file-excel-o"></i>{{ " ".lang('Export') }}</a>
                                        @endif
                                        @if(\Auth::user()->is_super_admin||\Auth::user()->can('export_final_detail-result'))
                                            <a class="btn btn-success" href="{{route('report.finalScoreDetail')}}"> <i class="fa fa-file-excel-o"></i>{{ " ".lang('Export Detail') }}</a>
                                        @endif

                                        @if(\Auth::user()->is_super_admin||\Auth::user()->can('freeze-final-judge'))
                                            <a class="btn btn-warning" href="{{route('finaljudge.dofreeze')}}"> {{ " ".lang('Freeze Result') }}</a>
                                        @endif



                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <select name="cate_id" id="cate_id" class="form-control">
                                        <option value="" >All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--<br>--}}
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-lg-12 table-responsive no-padding">
                                    <table id="tbl_final" class="table table-bordered table-striped text-center">
                                        <thead>
                                        <tr>
                                            {{-- <th>{{ lang('ID')}}</th>--}}
                                            <th style="min-width: 140px; max-width: 200px" rowspan="2">{{ lang('Company')}}</th>
                                            <th style="min-width: 180px; max-width: 250px" rowspan="2">{{ lang('Product Name')}}</th>
                                            <th rowspan="2">{{ lang('Country')}}</th>
                                            <th colspan="{{$num_judge}}">{{lang("Judges")}}</th>
                                            <th rowspan="2" style="width: 70px;">{{ lang('Medal')}}</th>
                                            <th rowspan="2" >{{ lang('Score Base on Medal')}}</th>
                                            @if(\Setting::get('FINAL_SHOW_SCORE','FALSE')=="TRUE")
                                                <th rowspan="2" >{{ lang('Average Score base on Criteria')}}</th>
                                            @endif
                                            <th rowspan="2">{{ lang('Win Medal')}}</th>
                                        </tr>
                                        <tr>
                                            @foreach($judge_countries as $jc)
                                                <th >{{  lang($jc->bref)}}<img height="15px" src="/{{$jc->flag}}">  </th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"></div>
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
           semi= $('#tbl_semi').DataTable({
                processing: true,
                serverSide: true,
                {{--ajax: "{!! route('result.semi.list') !!}",--}}
                ajax:{
                  url:"{!! route('result.semi.list') !!}", 
                  data:function (data) {
                      data.coun= $('#con').val();
                      data.cat= $('#cat').val();
                  }  
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'country', name:'country',},
                    { data: 'category', name:'category',},
                    { data: 'Form', name:'Form',},
//                    { data: 'Score', name:'Score',}
                ],
                "order": [[ 0, "asc" ]]
            });
            $('#con,#cat').on('change',function () {
               semi.draw();
            });

            var md =["mdgold.png","mdsilver.png","mdbrown.png"];
            final=$('#tbl_final').DataTable({
                processing: true,
                serverSide: true,
                'paging' : false,
                dom:'t',
                ajax: {
                    url:"{!! route('result.final.list.realtime')!!}",
                    data:function(d){
                        d.cat=$('#cate_id').val();
                        d.limit= 30;
                    }
                },
                columns: [
//                    { data: 'id', name: 'id',orderable: false},
                    { data: 'application.company_name', name: 'Company',orderable: false},
                    { data: 'application.product_name', name: 'product',orderable: false},
                    { data: 'application.user.country.name', name: 'Country' ,orderable: false},
                        @foreach($judge_countries as $key=> $j)
                    { data:"users.{{$j->name}}", name: "{{ $j->bref }}",orderable: false,render: function (data, type, full, meta) {

                            if(data == null || data== undefined ) return "";
                            return   "<img src=\"" + "{{asset("images/img/")}}/"+md[3-data]+ "\" height=\"30\"/>";
                        },
                    },
                        @endforeach
                    { data:'medals', name: "medal",orderable: false,render: function (data, type, full, meta) {
                            return   "<img src=\"" + "{{asset("images/img/mdgold.png")}}"+ "\" height=\"30\"/>"+":"+data[0]+"<br>"+
                                "<img src=\"" + "{{asset("images/img/mdsilver.png")}}"+ "\" height=\"30\"/>"+":"+data[1]+"<br>"+
                                "<img src=\"" + "{{asset("images/img/mdbrown.png")}}"+ "\" height=\"30\"/>"+":"+data[2]+"<br>";

                            }
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
                        }
                    },


                ],

            });
            $('#cate_id').on('change', function(e) {
                final.draw();
                e.preventDefault();
            });

            // var tab = window.location.hash;
            // // Fire click on the <li> that has the <a> with the proper 'href' attribute
            // $('ul.nav  li  a[href="' + tab + '"]').click();
            // $('#final').click(function () {
            //     window.location.hash = 'final s';
            //     // return false;
            // });
            // $('li a[href="#semi"]').click(function () {
            //     window.location.hash = 'semi';
            //     // return false;
            // });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save current clicked tab in local storage
                localStorage.setItem('lastActiveTab', $(this).attr('href'));
            });
            //get last active tab from local storage
            var lastTab = localStorage.getItem('lastActiveTab');

            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }


        });
        // function clickDestroy(item){

        //     alertDelete(item,"{!! route('role.destroy') !!}","{!! route('role.index') !!}","{{ csrf_token() }}","role");
        //     return true;
        // }
    </script>
@stop
