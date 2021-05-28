@extends('admin.dashboard')

@section('title') 
    {{ lang('Video') }}
@endsection

@section('content_header')
    <h1>{{ lang('Videos List') }}</h1>
@stop

@section('content')

    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('Video Form') }}</h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-12">
                    <table id="tbl_video" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ lang('Id')}}</th>
                                <th>{{ lang('Product Name')}}</th>
                                <th>{{ lang('Youtube id')}}</th>
                                <th>{{ lang('Path')}}</th>
                                <th>{{ lang('MineType')}}</th>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tbl_video').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('video.list') !!}",
                columns: [
                    { data: 'id', name: 'id',orderable: false,width:'10px'},
                    { data: 'product', name: 'product'},
                    { data: 'youtube_id', name: 'youtube_id' },
                    { data: 'path', name: 'path'},
                    { data: 'minetype', name: 'MineType'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name:'action', orderable: false,width:"90px" }
                ],
            });
            
        });


    </script>
@stop
