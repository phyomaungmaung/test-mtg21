@extends('admin.dashboard')

@section('title') 
    {{ lang('Freeze') }}
@endsection

@section('content_header')
    <h1>{{ lang('Freeze') }}</h1>
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
                <h3 class="box-title">{{ lang('Freeze') }}</h3>
                <div class="box-tools pull-right">
                   
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                @if(count($arruser)>0)

                    @if($canFreezze == 1)
                        <div class="alert alert-warning">Base on current setting you can freeze it now! But there are remained form to be judged. We recommend Complete the remaining.</div>
                    @elseif($canFreezze == 0)
                        <div class="alert alert-warning">You cannot Freeze it now! There are remained form to be judged.</div>
                    @endif


                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Judge</th>
                            <th>Country</th>
                            <th>Category</th>
                            <th>Form Remained</th>
                        </tr>
                    </thead>
                    @foreach($arruser as $users)
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user['name']}}</td>
                            <td>{{$user['country']}}</td>
                            <td>{{$user['category']}}</td>
                            <td>{{$user['num_star']}}</td>
                        </tr>
                        @endforeach
                        
                    @endforeach
                    
                </table>
                    @if($canFreezze == 1)
                        <a class="btn btn-primary" href="{{route('finaljudge.dofreeze')}}">{{ lang('Freeze') }}</a>
                    @elseif($canFreezze == 0)
                        <a class="btn btn-default disabled" href="{{route('finaljudge.dofreeze')}}">{{ lang('Freeze') }}</a>
                    @elseif($canFreezze == 2)
                        <a class="btn btn-default disabled" href="{{route('finaljudge.dofreeze')}}">{{ lang('Freeze') }}</a>
                    @endif
                @else
                    @if($canFreezze == 1)
                        <div class="alert alert-success">You can Freeze it now!!</div>
                        <a class="btn btn-primary" href="{{route('finaljudge.dofreeze')}}">{{ lang('Freeze') }}</a>
                        
                    @elseif($canFreezze == 0)
                        <div class="alert alert-success">You cannot Freeze it now!!</div>
                        <a class="btn btn-default disabled" href="{{route('finaljudge.dofreeze')}}">{{ lang('Freeze') }}</a>
                    @elseif($canFreezze == 2)
                        
                        <div class="alert alert-info">You already freezed!!</div>
                    @endif

                  
                @endif

                
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
           
        </div><!-- /.box -->
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>

@stop
