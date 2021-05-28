@extends('admin.dashboard')

@section('title') 
    {{ lang('Judge') }}
@endsection

@section('content_header')
    <h1>{{ lang('Judge') }}</h1>
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}">
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
            </div><!-- /.box-header -->
            <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs" id="judge_tab">
                                  <li class="active"><a href="#existed_user" data-toggle="tab" aria-expanded="true">Existed User</a></li>
                                  <li class=""><a href="#new_user" data-toggle="tab" aria-expanded="false">New User</a></li>
                                </ul>
                                <div class="tab-content">
                                  <div class="tab-pane active" id="existed_user">
                                  {{Form::open(['url'=>'judge/saveexisted','class'=>'form-vertical'])}}
                                    <div class="col-sm-12 ">
                                        <div class="col-sm-offset-3 col-sm-2">
                                            <label for="id_type">
                                              Type
                                            </label>
                                        </div>
                                        <div class="col-sm-5">
                                            {{Form::select('id_type',$type,'',['class'=>'cate form-control','id'=>'id_type','required'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 marg-top">
                                        <div class="col-sm-offset-3 col-sm-2">
                                            <label for="id_country">
                                              Country
                                            </label>
                                        </div>
                                        <div class="col-sm-5">
                                            {{Form::select('id_country',$arrco,'',['class'=>'form-control select2','id'=>'id_country','required'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 marg-top">
                                        <div class="col-sm-offset-3 col-sm-2">
                                            <label for="id_user">
                                              User
                                            </label>
                                        </div>
                                        <div class="col-sm-5">
                                            {{Form::select('id_user',[],'',['class'=>'form-control select2','id'=>'id_user','disabled','required'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 marg-top">
                                        <div class="col-sm-offset-3 col-sm-2">
                                            <label for="id_user">
                                              Category
                                            </label>
                                        </div>
                                        <div class="col-sm-5">
                                            {{Form::select('id_cate[]',$arrcate,'',['class'=>'cate form-control','id'=>'id_cate','disabled','multiple','required'])}}
                                            
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
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('username'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('username') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        {!! form_row($form->email) !!}
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('email'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        {!! form_row($form->password) !!}
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('password'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        {!! form_row($form->password_confirmation) !!}
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        {!! form_row($form->type) !!}
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('type'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('type') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {!! form_row($form->country_id) !!}
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('country_id'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('country_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        {!! form_row($form->category_id) !!}
                                        <div class="col-sm-12">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-8">
                                                @if ($errors->has('category_id'))
                                                    <span class="help-block required">
                                                        <strong >{{ $errors->first('category_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
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
    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            @if ($errors->any())
                @if($errors->first('category_id')||$errors->first('country_id')||
                    $errors->first('password_confirmation')||$errors->first('password')||
                    $errors->first('email')||$errors->first('username')||$errors->first('err_valid'))
                    $("#judge_tab a:last").tab("show");
                @endif
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
                    url:"{{url('judge/listcountry')}}",
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

                        $("#id_country").select2({
                            placeholder:"Select Country",
                            data:data,
                            disabled:false,
                        });
                        @if(session('err_form'))
                            error_select={!!htmlspecialchars_decode(session('err_cate'))!!};
                            $("#id_country").val(data.concat(error_select));
                            $("#id_country").select2();
                        @endif
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
                    url:"{{url('judge/listuser')}}/"+this.value,
                    type:"post",
                    data:{id:id_coun,'_token':"{{csrf_token()}}" },
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
                        @if(session('err_form'))
                            $("#id_user").val({{old('id_user')}});
                            $("#id_user").trigger("change");
                        @endif
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
                // $("#id_user").empty().trigger('change');
                $.ajax({
                    url:"{{url('judge/listcate')}}/"+this.value,
                    type:"post",
                    data:{id:id_user,'_token':"{{csrf_token()}}",utype:valtype },
                    dataType:"json",
                    beforeSend:function(){
                        $("#id_cate").select2({
                            placeholder:"Select category",
                            disabled:true,
                        });
                    },
                    success: function(data){
                        $("#id_cate").val(data);
                        $("#id_cate").select2({
                            placeholder:"Select category",
                            disabled:false,
                        });
                        $("#id_type").select2({
                            disabled:false,
                        });
                        @if(session('err_form'))
                            error_select={!!htmlspecialchars_decode(session('err_cate'))!!};
                            $("#id_cate").val(data.concat(error_select));
                            $("#id_cate").select2();
                        @endif
                    }
                });
            });
            @if(session('err_form'))
                $("#id_country").trigger('change');
            @endif
            $("#type").select2({
                width:'100%',
            });
            $("#country_id").select2({
                width:'100%',
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
                    url:"{{url('judge/listcountry')}}",
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

        });
        
        
    </script>
@stop
