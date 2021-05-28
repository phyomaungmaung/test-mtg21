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
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#draft" data-toggle="tab" aria-expanded="false">Form Submitted</a></li>
                            <li class=""><a href="#accepted" data-toggle="tab" aria-expanded="true">Form Accepted</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="draft">
                                @if($is_admin)
                                    <div class="col-sm-4">
                                        <select name="country_id" id="con" class="form-control" style="max-width: 220px">
                                            <option value="" >All Country</option>
                                            @foreach($countries as $id=> $name):
                                            <option value="{{$id}}" >{{$name}}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                @endif
                                <div class="{{$is_admin?'col-sm-offset-2':'col-sm-offset-4'}} col-sm-4">
                                    <select name="cat" id="cat" class="form-control" style="max-width: 220px" >
                                        <option value="" >All Category</option>
                                        @foreach($categories as $id=> $name):
                                        <option value="{{$id}}" >{{$name}}</option>
                                        @endforeach;
                                    </select>
                                </div>

                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-lg-12">
                                    <table id="tbl_app" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{ lang('Id')}}</th>
                                            <th>{{ lang('Product Name')}}</th>
                                            <th>{{ lang('Applicant')}}</th>
                                            <th>{{ lang('Category')}}</th>
                                            <th>{{ lang('Country')}}</th>
                                            <th>{{ lang('Status')}}</th>
                                            <th width="100ox" >{{ lang('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="tab-pane" id="accepted">
                                @if($is_admin)
                                    <div class="col-sm-4">
                                        <select name="country_id" id="country_id" class="form-control" style="max-width: 220px">
                                            <option value="" >All Country</option>
                                            @foreach($countries as $id=> $name):
                                            <option value="{{$id}}" >{{$name}}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                @endif
                                <div class="{{$is_admin?'col-sm-offset-2':'col-sm-offset-4'}} col-sm-4">
                                    <select name="cat" id="category_id" class="form-control" style="max-width: 220px" >
                                        <option value="" >All Category</option>
                                        @foreach($categories as $id=> $name):
                                        <option value="{{$id}}" >{{$name}}</option>
                                        @endforeach;
                                    </select>
                                </div>

                                <div class="clearfix"></div>
                                <hr>

                                <div class="col-lg-12 table-responsive">
                                    <table id="tbl_app_accepted" class="table table-bordered table-striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>{{ lang('Id')}}</th>
                                            <th>{{ lang('Product Name')}}</th>
                                            <th>{{ lang('Applicant')}}</th>
                                            <th>{{ lang('Category')}}</th>
                                            <th>{{ lang('Country')}}</th>
                                            <th>{{ lang('Status')}}</th>
                                            <th width="100ox" >{{ lang('Action')}}</th>
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

            app =$('#tbl_app').DataTable({
                processing: true,
                serverSide: true,
{{--                ajax: "{!! route('application.list') !!}",--}}
                ajax: {
                    url:"{!! route('application.list') !!}",
                    data: function (data) {
                        data.country_id = $('#con').val();
//                        data.country_id = 1;
                        data.category_id = $('#cat').val();
                        data.status ="draft";
//                        d.type =$('#type').val();
                    },
                },
                columns: [
                    { data: 'id', name: 'id',orderable: false,width:'10px'},
                    { data: 'product', name: 'product'},
                    { data: 'applicant', name: 'applicant' },
                    { data: 'category', name: 'category'},
                    { data: 'country', name: 'country'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name:'action', orderable: false, width :"105px", style:{minwidth:"60px" , maxwidth:"120px"} }
                ],
            });
            $('#cat,#con,#type').on('change', function(e) {
                app.draw();
//                e.preventDefault();
            });


            app_accepted =$('#tbl_app_accepted').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                {{--                ajax: "{!! route('application.list') !!}",--}}
                ajax: {
                    url:"{!! route('application.list') !!}",
                    data: function (data) {
                        data.country_id = $('#country_id').val();
//                        data.country_id = 1;
                        data.category_id = $('#category_id').val();
                        data.status ="accepted";
//                        d.type =$('#type').val();
                    },
                },
                columns: [
                    { data: 'id', name: 'id',orderable: false,width:'10px'},
                    { data: 'product', name: 'product'},
                    { data: 'applicant', name: 'applicant' },
                    { data: 'category', name: 'category'},
                    { data: 'country', name: 'country'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name:'action', orderable: false, width :"105px"  }
                ],
            });
            $('#category_id,#country_id').on('change', function(e) {
                app_accepted.draw();
//                e.preventDefault();
            });
        });
      var tt=0;
        function alertAccept(item){
          var item_id  =   $(item).data('item');
          swal({   
              title: "Accepting this application?",   
              text: "This application will be mark as accept and place in ASEAN Application menu.",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "Yes, accept",   
              cancelButtonText: "No, cancel",
              closeOnConfirm: false,
              closeOnCancel: true
          }, function(isConfirm){

              if (isConfirm)
              {
                  $.ajax({
                      url: "{!!route('application.accept')!!}",
                      type: "POST",
                      dataType: "html",
                      data: {item:item_id, _token:"{{ csrf_token() }}"},
                      success: function(result)
                      {

                          try{
                              result =JSON.parse(result);
                          }catch (e){ }
                          if(result=="success"){
                              window.location = "{!!route('application.index')!!}";
                          }else if(result.mess ){
                              swal("Warning!", "Cannot accept this application!!!\n "+result.mess, "error");
                          } else{
                              swal("Warning!", "Cannot accept this application!!!\n some application's information may missing!!", "error");
                          }
                      },
                      error:function(){
                        swal("Warning!", "Disconnected while accept this application!", "error");
                      }
                  });
              }
              
          });
        }


    </script>
@stop
