@extends('admin.dashboard')

@section('title') 
    {{ lang('Guideline') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
@stop
@section('content_header')
    <h1>{{ lang('Guideline List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
             <div class="box-header with-border">
                 <h3 class="box-title"><a class="btn btn-primary" href="{{route('guideline.create')}}">{{ lang('New Guideline') }}</a></h3>
                 <div class="box-tools pull-right">
                     <!--span class="label label-primary">Label</span-->
                 </div><!-- /.box-tools -->
             </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_guideline" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('title')}}</th>
                                <th>{{ lang('role')}}</th>
                                <th>{{ lang('Status')}}</th>
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

            $('#tbl_guideline').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('guideline.list') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false,width:'10px'},
                    { data: 'title', name: 'title'},
                    { data: 'role', name: 'role' }, 
                    { data: 'status', name: 'status'},
                    { data: 'action', name:'action', orderable: false,width:"90px" }
                ],
            });
            
        });
      
        function alertAccept(item){
          var item_id  =   $(item).data('item');
          swal({   
              title: "Accepting this guideline?",
              text: "This guideline will be mark as accept and place in ASEAN Guideline menu.",
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
                      url: " ",
                      type: "POST",
                      dataType: "html",
                      data: {item:item_id, _token:"{{ csrf_token() }}"},
                      success: function(result)
                      {
                          if(result=="success"){
                              window.location = "{!!route('guideline.index')!!}";
                          }else{
                              swal("Warning!", "Cannot accept this guideline", "error");
                          }
                      },
                      error:function(){
                        swal("Warning!", "Disconnected while accept this guideline!", "error");
                      }
                  });
              }
              
          });
        }
        function clickDestroy(item){
            alertDelete(item,"{!! route('guideline.destroy') !!}","{!! route('guideline.index') !!}","{{ csrf_token() }}","guideline");
            return true;
        }

    </script>
@stop
