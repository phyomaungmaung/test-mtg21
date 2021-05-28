@extends('admin.dashboard')

@section('title') 
    {{ lang('Judge') }}
@endsection

@section('content_header')
    <h1>{{ lang('Judge') }}</h1>
@stop
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}">--}}
    <style type="text/css">
        .marg-top{
            margin-top: 10px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
          color: #333;
          width: 100%;
        }
    </style>
@stop
@section('content')
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('Create Judge') }}</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-warning" href="{{route('judge.index')}}">{{ lang('Back To List') }}</a>
                </div><!-- /.box-tools -->
                {{--<div class="clear-fix"></div>--}}
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" id="judge_tab">
                          <li class="active"><a href="#existed_user" data-toggle="tab" aria-expanded="true">Existed User</a></li>
                          <li class=""><a href="#new_user" data-toggle="tab" aria-expanded="false">New User</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="existed_user">
                          {{Form::open(['url'=>'judge/saveexisted','class'=>'form-horizontal'])}}
                            <div class="form-group ">
                                <label class="control-label col-sm-2" for="id_type"> Type  </label>

                                <div class="col-sm-10">
                                    {{Form::select('id_type',$type,'',['class'=>'cate form-control select2','id'=>'id_type','required'])}}
                                </div>
                            </div>
                            <div class="form-group ">
                                  <label class="control-label col-sm-2" for="id_country"> Country   </label>
                                  <div class="col-sm-10">
                                    {{Form::select('id_country',$country,'',['class'=>'form-control select2','id'=>'id_country','required'])}}
                                  </div>
                            </div>
                              <div class="form-group ">
                                  <label class="control-label col-sm-2" for="id_user"> User   </label>
                                  <div class="col-sm-10">
                                    {{Form::select('id_user',[],'',['class'=>'form-control select2','id'=>'id_user','disabled','required'])}}
                                  </div>
                            </div>
                            <div class="form-group ">
                              <label class="control-label col-sm-2" for="id_cat"> Category   </label>
                              <div class="col-sm-10">
                                    {{Form::select('id_cate[]',$category,'',['class'=>'cate form-control','id'=>'id_cate','disabled','multiple','required'])}}
                                </div>
                            </div>
                            <div class="col-sm-12 marg-top text-right">
                                <div class="">
                                    <button class="btn btn-primary"> submit</button>
                                </div>
                            </div>
                            {{Form::close()}}
                            <div class="clearfix"></div>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="new_user">
                                {!!form_start($form)!!}
                                {!! form_row($form->username) !!}
                                {{--<div class="col-sm-12">--}}
                                    {{--<div class="col-lg-3"></div>--}}
                                    {{--<div class="col-lg-8">--}}
                                        {{--@if ($errors->has('username'))--}}
                                            {{--<span class="help-block required">--}}
                                                {{--<strong >{{ $errors->first('username') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {!! form_row($form->email) !!}
                                {{--<div class="col-sm-12">--}}
                                    {{--<div class="col-lg-3"></div>--}}
                                    {{--<div class="col-lg-8">--}}
                                        {{--@if ($errors->has('email'))--}}
                                            {{--<span class="help-block required">--}}
                                                {{--<strong >{{ $errors->first('email') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {!! form_row($form->type) !!}
                                {{--<div class="col-sm-12">--}}
                                    {{--<div class="col-lg-3"></div>--}}
                                    {{--<div class="col-lg-8">--}}
                                        {{--@if ($errors->has('type'))--}}
                                            {{--<span class="help-block required">--}}
                                                {{--<strong >{{ $errors->first('type') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {!! form_row($form->country_id) !!}
                                {{--<div class="col-sm-12">--}}
                                    {{--<div class="col-lg-3"></div>--}}
                                    {{--<div class="col-lg-8">--}}
                                        {{--@if ($errors->has('country_id'))--}}
                                            {{--<span class="help-block required">--}}
                                                {{--<strong >{{ $errors->first('country_id') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {!! form_row($form->category_id) !!}
                                {{--<div class="col-sm-12">--}}
                                    {{--<div class="col-lg-3"></div>--}}
                                    {{--<div class="col-lg-8">--}}
                                        {{--@if ($errors->has('category_id'))--}}
                                            {{--<span class="help-block required">--}}
                                                {{--<strong >{{ $errors->first('category_id') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-sm-12 marg-top text-right">
                                    <div class="">
                                        <button class="btn btn-primary"> submit</button>
                                    </div>

                                </div>
                                {!!form_end($form)!!}
                          </div>
                          <div class="clearfix"></div>
                          <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                      </div>
                    
                    
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
           
        </div><!-- /.box -->
    </div>
@endsection

@section('js')
{{--    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>--}}
    <script type="text/javascript">
        $(function(){
            @if ($errors->any())
                @if($errors->first('category_id')||$errors->first('country_id')||
                    $errors->first('password_confirmation')||$errors->first('password')||
                    $errors->first('email')||$errors->first('username')||$errors->first('err_valid'))
                    $("#judge_tab a:last").tab("show");
                @endif
            @endif
            @if(session('err_form'))
                error_back=1;
            @else
                error_back=0;
            @endif
            // $("#judge_tab a:last").tab("show");
            $("#id_country").select2({
              placeholder: "Select a Country",
              allowClear: false,
              
            });

            $("#id_user").select2({
              placeholder: "Select a User",
              allowClear: false,
              
            });
            $("#id_cate").select2({
                placeholder:"Select category",
                
            });
            $("#category_id").select2({
                placeholder:"Select category",
                // dropdownAutoWidth : true,
                width: '100%'
            });
//            selecte type
            $("#id_type").on("change",function(){
                id_type=this.value;
                $("#id_cate").val('');
                $("#id_cate").select2({
                    placeholder:"Select Category",
                    disabled:true,
                });
                $("#id_country").empty();
                $("#id_country").select2({
                    placeholder:"Select Country",
                    disabled:true,
                });
                $("#id_user").empty();
                $("#id_user").select2({
                    placeholder:"Select User",
                    disabled:true,
                });

                // $("#id_user").empty().trigger('change');
                $.ajax({
                    url:"{{route('country.listJson')}}",
                    type:"POST",
                    data:{'_token':"{{csrf_token()}}",utype:id_type},
                    dataType:"json",
                    beforeSend:function(){
                        $("#id_country").select2({
                            placeholder:"Select category",
                            disabled:true,
                        });
                    },
                    success: function(data){
//                        console.log(data);
                        $("#id_country").select2({
                            placeholder:"Select Country",
                            data:data,
                            disabled:false,
                        });
                        if(error_back==1){
                            error_select='{!!htmlspecialchars_decode(session("err_cate"))!!}';
                            $("#id_country").val(data.concat(error_select));
                            $("#id_country").select2();
                        }
                    }
                });
            });

            $("#id_country").on("change",function(val){
                id_coun=this.value;
                $("#id_user").empty();
                $("#id_cate").val([]);
                $("#id_cate").select2({
                    placeholder:"Select category",
                    disabled:true,
                });
                $.ajax({
                    url:"{{route('user.listJson')}}",
                    {{--url:"{{url('judge/listuser')}}/"+this.value,--}}
                    type:"post",
                    data:{country_id:id_coun,'_token':"{{csrf_token()}}" },
                    dataType:"json",
                    beforeSend:function(){
                        $("#id_user").select2({
                            placeholder:"Select User",
                            disabled:true
                        });
                    },
                    success: function(data){
                        $("#id_user").select2({
                            placeholder:"Select User",
                            data: data,
                            disabled:false
                        });
                        if(error_back==1){
                            console.log("eer");
                            $("#id_user").val({{old('id_user')}});
                            $("#id_user").trigger("change");
                        }
                    }

                });
            });

            $("#id_user").on("change",function(){
                id_user=this.value;
                $("#id_cate").val('');
                $("#id_cate").select2({
                    placeholder:"Select category",
                    disabled:false,
                });
                valtype=$("#id_type").val();
                count_id=$("#id_country").val();
                // $("#id_user").empty().trigger('change');
                $.ajax({
                    url:"{{url('judge/listcate')}}/"+this.value,
                    type:"post",
                    data:{user_id:id_user,'_token':"{{csrf_token()}}",country_id:count_id,utype:valtype },
                    dataType:"json",
                    beforeSend:function(){
                        $("#id_cate").select2({
                            placeholder:"Select category",
                            disabled:true,
                        });
                    },
                    success: function(data){
                        $('#id_cate option').removeAttr('disabled');
                        $("#id_cate").val(data);
                        $("#id_cate").select2({
                            placeholder:"Select category",
                            disabled:false,
                        });
                        $("#id_type").select2({
                            disabled:false,
                        });
                        $.ajax({
                            url:"{{route('judge.listcat.used')}}",
                            type:"post",
                            data:{user_id:id_user,'_token':"{{csrf_token()}}",country_id:count_id,utype:valtype },
                            dataType:"json",
                            beforeSend:function(){
                                $("#id_cate").select2({
                                    placeholder:"Select category",
                                    disabled:true,
                                });
                            },
                            success: function(data){
                                l = data.length;
                               for(var i=0;i<l;i++) {
                                    $('#id_cate option[value="'+data[i]+'"]').attr('disabled','disabled');
                                };
                                $('#id_cate').select2({
                                    disabled:false,
                                });
                            }

                        });
                        if(error_back==1){
                            error_select='{!!htmlspecialchars_decode(session("err_cate"))!!}';
                            $("#id_cate").val(data.concat(error_select));
                            $("#id_cate").select2();
                            // error_back=0;
                        }
                    }
                });
            });
            if(error_back==1){
                $("#id_country").trigger('change');
            }

            $("#type").select2({
                width:'100%',
            });

// other tab  create new
            $("#country_id").select2({
                width:'100%',
                placeholder:"Select Country",
                disabled:true,
            });
            $("#category_id").select2({
                placeholder:"Select category",
                disabled:true,
                width:'100%'
            });
            $("#type").on("change",function(){
                id_type=this.value;
                $("#country_id").empty();
                $("#country_id").select2({
                    placeholder:"Select Country",
                    disabled:true,
                });
                // $("#id_user").empty().trigger('change');
                $.ajax({
                    {{--url:"{{url('judge/listcountry')}}",--}}
                    url:"{{route('country.listJson')}}",
                    type:"POST",
                    data:{'_token':"{{csrf_token()}}",utype:id_type},
                    dataType:"json",
                    beforeSend:function(){
                        $("#country_id").select2({
                            placeholder:"Select Country",
                            disabled:true,
                        });
                    },
                    success: function(data){
                        $("#country_id").select2({
                            placeholder:"Select Country",
                            data:data,
                            disabled:false,
                        });

                    }
                });
            });


            $("#country_id").on("change",function(){
                id_country=this.value;
                $("#category_id").val('');
                $("#category_id").select2({
                    placeholder:"Select category",
                    disabled:false,
                });
                valtype=$("#type").val();
                $.ajax({
                    url:"{{route('judge.listcat.used')}}",
                    type:"post",
                    data:{'_token':"{{csrf_token()}}",country_id:id_country,utype:valtype },
                    dataType:"json",
                    beforeSend:function(){
                        $("#id_cate").select2({
                            placeholder:"Select category",
                            disabled:true,
                        });
                    },
                    success: function(data){
                        $('#category_id option').removeAttr('disabled');
                        l = data.length;
                        for(var i=0;i<l;i++) {
                            $('#category_id option[value="'+data[i]+'"]').attr('disabled','disabled');
                        };
                        $('#category_id').select2({
                            placeholder:"Select category",
                            disabled:false,
                        });

                        if(error_back==1){
                            error_select='{!!htmlspecialchars_decode(session("err_cate"))!!}';
                            $("#category_id").val(data.concat(error_select));
                            $("#category_id").select2();
                            // error_back=0;
                        }
                    }
                });
            });

        });
        
        
    </script>
@stop
