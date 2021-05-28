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
                <h3 class="box-title">{{ lang('Edit Judge') }}</h3>
                <div class="box-tools pull-right">
                    {{--<a class="btn btn-warning" href="{{route('judge.index')}}">{{ lang('Back To List') }}</a>--}}
                </div><!-- /.box-tools -->
                {{--<div class="clear-fix"></div>--}}
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    {!!form_start($form)!!}
                    {!! form_row($form->id) !!}
                    {!! form_row($form->username) !!}
                    {!! form_row($form->email) !!}
                    {!! form_row($form->type) !!}
                    {!! form_row($form->country_id) !!}
                    {!! form_row($form->category_id) !!}
                    <div class="col-sm-12 marg-top text-right">
                        <div class="">
                            <button class="btn btn-primary"> submit</button>
                        </div>
                    </div>
                    {!!form_end($form)!!}
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
                    $errors->first('email')||$errors->first('username')||$errors->first('err_valid'))
//                    $("#judge_tab a:last").tab("show");
                @endif
            @endif
            @if(session('err_form'))
                error_back=1;
            @else
                error_back=0;
            @endif
                disables = {{json_encode($disables)}}

            $("#country_id").select2({
                placeholder:"Select Country",
                width:'100%',
            });
            $("#category_id").select2({
                placeholder:"Select Category",
                width:'100%',
            });

            l = disables.length;
            for(var i=0;i<l;i++) {
                $('#category_id option[value="'+disables[i]+'"]').attr('disabled','disabled');
            };
            $('#category_id').select2({
                placeholder:"Select category",
                disabled:false,
            });

// other tab
            origin_con_id=-1;
            origin_type = $("#type").val();
            @if($is_start_online_judge )
                $("#type").attr("hidden",true);
                // $("#type").select2({
                //     disabled:true
                // });
            @else
                $("#type").select2({
                    width:'100%',
                    placeholder:"Select Type",
                });
                $("#type").on("change",function(){
    //                alert(origin_type);
                    id_type=this.value;
                    con_id = $("#country_id").val();
    //                if(count_id)
    //                alert("select country");
                    $("#country_id").empty();
                    $("#country_id").select2({
                        placeholder:"Select Country",
                        disabled:true,
                    });
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
                            if(origin_con_id==-1){
                                origin_con_id=$("#country_id").val();
                            }

                            if(data.length<=con_id){
                                $("#country_id").val(null);
                                $("#country_id").trigger("change",[con_id]);
                            }else{
                                $("#country_id").val(con_id);
                                $("#country_id").trigger("change",[con_id]);
                            }


                        }
                    });
                });
            @endif

            $("#country_id").on("change",function(event,old){
                id=$("#id").val();
//                if(old && old == id){
//                    return ;
//                }
                id_country=$("#country_id").val();
                $("#category_id").val('');
                $("#category_id").select2({
                    placeholder:"Select category",
                    disabled:false,
                });
                valtype=$("#type").val();

                $.ajax({
                    url:"{{url('judge/listcate')}}/"+id,
                    type:"post",
                    data:{user_id:id,'_token':"{{csrf_token()}}",country_id:id_country,utype:valtype },
                    dataType:"json",
                    beforeSend:function(){
                        $("#category_id").select2({
                            placeholder:"Select category",
                            disabled:true,
                        });
                    },
                    success: function(data){
                        $('#category_id option').removeAttr('disabled');
                        $("#category_id").val(data);
                        $("#category_id").select2({
                            placeholder:"Select category",
                            disabled:false,
                        });

                        $.ajax({
                            url:"{{route('judge.listcat.used')}}",
                            type:"post",
                            data:{user_id:id,'_token':"{{csrf_token()}}",country_id:id_country,utype:valtype },
                            dataType:"json",
                            beforeSend:function(){
                                $("#category_id").select2({
                                    placeholder:"Select category",
                                    disabled:true,
                                });
                            },
                            success: function(data){
                                l = data.length;
                                for(var i=0;i<l;i++) {
                                    $('#category_id option[value="'+data[i]+'"]').attr('disabled','disabled');
                                };
                                $('#category_id').select2({
                                    placeholder:"Select category",
                                    disabled:false,
                                });
                            }

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
