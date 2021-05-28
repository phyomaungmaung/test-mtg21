@extends('admin.dashboard')

@section('title') 
    {{ lang('Application') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
    <style type="text/css">
        #video{
            min-height: 100%;
            min-width: 100%;
            padding-left: 0px!important;
            margin-left: 0px !important;
        }
        .vcenter {
            vertical-align: middle !important;
            text-align: center !important;
        }
        
    </style>
@stop
@section('content_header')
   {{--  <h1>{{ lang('Judge') }}</h1> --}}
@stop

@section('content')
    <div class="wraper container-fluid">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ lang('Judge on: ') }} {{$title}} </h3>
                <div class="box-tools pull-right">
                    <!--span class="label label-primary">Label</span-->
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="col-sm-4" align="" >
                        <div class="col-sm-12" style="width:100%" >
                            
                                @if(isset($video))
                                    <div class="embed-responsive embed-responsive-4by3">
                                        @if($is_youtube)
                                            <iframe class="embed-responsive-item" src="//www.youtube.com/embed/{{$video}}?modestbranding=0&autoplay=1&rel=0&showinfo=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                         @else
                                            <video id="video" class="video-js vjs-default-skin vjs-big-play-centered video"
                                               controls preload="auto"  width="100%" height="250px" >
                                                <source src="{{url(isset($video)?$video:'')}}" type="{{$mime}}" />
                                            </video>
                                        @endif
                                    </div>
                                @else
                                    <div class="callout callout-danger">
                                        <h4>Video Not Found !!!</h4>
                                        <p> Candidate hasn't upload any video.</p>
                                    </div>

                                @endif
                                <br>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="alert alert-success">Score: <span id="total">{{isset($form->total)?$form->total:"0.00"}}</span></h3>
                        </div>
                        <div class="col-sm-12 text-sm-left text-danger">
                            <div class="" >
                                <h3 class="alert alert-danger">Note:</h3>
                                <div class="">
                                    <p>Please enter the scores in field. Scores are from 1-10.</p>
                                    <p>Awarding participant a score of 0 is not acceptable

                                    Ration of the score is : </p>
                                    <ul class="text-sm-left">
                                        <li>1 = 10%</li>
                                        <li>2 = 20%</li>
                                        <li>....</li>
                                        <li>10 = 100%</li>
                                    </ul>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="col-sm-12 col-lg-12" style="overflow-y:scroll;">
                            @if($can_edit)
                                {!! Form::open(['url' => route('judge.save',$id)]) !!}
                            @else
                                {!! Form::open(['url' => "#",'method'=>'get']) !!}
                                <fieldset disabled="disabled">
                            @endif
                             <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sub-Criteria</th>
                                        <th>Weighting</th>
                                        <th colspan="2">Score</th>
                                        <th>Criteria</th>
                                        <th>Weighting</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(strcasecmp($cate,"Public Sector")==0)
                                        <tr>
                                            <td>{{lang('Innovation')}}</td>
                                            <td id="win">20</td>
                                            <td width="50px">{{Form::number('in',isset($form->in)?round($form->in):"0",['min'=>1,'max'=>10,'id'=>'in','class'=>'score'])}}</td>
                                            <td width="50px" id="ins">0</td>
                                            <td rowspan="4" class="vcenter">{{lang('Strategy Planning')}}</td>
                                            <td rowspan="4" class="vcenter" id="wstgin">40</td>
                                            <td id="ints" rowspan="4" class="vcenter">0</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Problem Solving')}}</td>
                                            <td id="wps">25</td>
                                            <td width="50px">{{Form::number('ps',isset($form->ps)?round($form->ps):"0",['min'=>1,'max'=>10,'id'=>'ps','class'=>'score'])}}</td>
                                            <td width="50px" id="pss">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Public Value')}}</td>
                                            <td id="wpv">30</td>
                                            <td width="50px">{{Form::number('pv',isset($form->pv)?round($form->pv):"0",['min'=>1,'max'=>10,'id'=>'pv','class'=>'score'])}}</td>
                                            <td width="50px" id="pvs">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Transparency & Impact on Quality of Life')}}</td>
                                            <td id="wti">25</td>
                                            <td width="50px">{{Form::number('ti',isset($form->ti)?round($form->ti):"0",['min'=>1,'max'=>10,'id'=>'ti','class'=>'score'])}}</td>
                                            <td width="50px" id="tis">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Efficiency')}}</td>
                                            <td id="wef">25</td>
                                            <td width="50px">{{Form::number('ef',isset($form->ef)?round($form->ef):"0",['min'=>1,'max'=>10,'id'=>'ef','class'=>'score'])}}</td>
                                            <td width="50px" id="efs">0.00</td>
                                            <td rowspan="4" class="vcenter">{{lang('Implementation')}}</td>
                                            <td rowspan="4" class="vcenter" id="woptef">40</td>
                                            <td id="efts" rowspan="4" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Performance')}}</td>
                                            <td id="wpm">25</td>
                                            <td width="50px">{{Form::number('pm',isset($form->pm)?round($form->pm):"0",['min'=>1,'max'=>10,'id'=>'pm','class'=>'score'])}}</td>
                                            <td width="50px" id="pms">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Quality')}}</td>
                                            <td id="wqt">25</td>
                                            <td width="50px">{{Form::number('qt',isset($form->qt)?round($form->qt):"0",['min'=>1,'max'=>10,'id'=>'qt','class'=>'score'])}}</td>
                                            <td width="50px" id="qts">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Reliability')}}</td>
                                            <td id="wrt">25</td>
                                            <td width="50px">{{Form::number('rt',isset($form->rt)?round($form->rt):"0",['min'=>1,'max'=>10,'id'=>'rt','class'=>'score'])}}</td>
                                            <td width="50px" id="rts">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Organization of Presentation')}}</td>
                                            <td id="wop">50</td>
                                            <td width="50px">{{Form::number('op',isset($form->op)?round($form->op):"0",['min'=>1,'max'=>10,'id'=>'op','class'=>'score'])}}</td>
                                            <td width="50px" id="ops">0.00</td>
                                            <td rowspan="2" class="vcenter">{{lang('Presentation')}}</td>
                                            <td rowspan="2" class="vcenter" id="wpstop">20</td>
                                            <td id="opts" rowspan="2" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Enquiries')}}</td>
                                            <td id="wen">50</td>
                                            <td width="50px">{{Form::number('en',isset($form->en)?round($form->en):"0",['min'=>1,'max'=>10,'id'=>'en','class'=>'score'])}}</td>
                                            <td width="50px" id="ens">0.00</td>
                                        </tr>
                                    @endif
                                    @if(strcasecmp($cate,"Private Sector")==0||strcasecmp($cate,"Digital Content")==0||strcasecmp($cate,"Research and Development")==0)
                                        @if(strcasecmp($cate,"Research and Development")==0)
                                            <tr>
                                                <td>{{lang('Innovation')}}</td>
                                                <td id="win">30</td>
                                                <td width="50px">{{Form::number('in',isset($form->in)?round($form->in):"0",['min'=>1,'max'=>10,'id'=>'in','class'=>'score'])}}</td>
                                                <td width="50px" id="ins">0</td>
                                                <td rowspan="4" class="vcenter">{{lang('Strategy Planning')}}</td>
                                                <td rowspan="4" class="vcenter" id="wstgin">40</td>
                                                <td id="ints" rowspan="4" class="vcenter">0</td>
                                            </tr>
                                            <tr>
                                                <td>{{lang('Problem Solving')}}</td>
                                                <td id="wps">30</td>
                                                <td width="50px">{{Form::number('ps',isset($form->ps)?round($form->ps):"0",['min'=>1,'max'=>10,'id'=>'ps','class'=>'score'])}}</td>
                                                <td width="50px" id="pss">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>{{lang('Marketing Strategy')}}</td>
                                                <td id="wms">20</td>
                                                <td width="50px">{{Form::number('ms',isset($form->ms)?round($form->ms):"0",['min'=>1,'max'=>10,'id'=>'ms','class'=>'score'])}}</td>
                                                <td width="50px" id="mss">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>{{lang('Customers')}}</td>
                                                <td id="wcu">20</td>
                                                <td width="50px">{{Form::number('cu',isset($form->cu)?round($form->cu):"0",['min'=>1,'max'=>10,'id'=>'cu','class'=>'score'])}}</td>
                                                <td width="50px" id="cus">0.00</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{lang('Innovation')}}</td>
                                                <td id="win">30</td>
                                                <td width="50px">{{Form::number('in',isset($form->in)?round($form->in):"0",['min'=>1,'max'=>10,'id'=>'in','class'=>'score'])}}</td>
                                                <td width="50px" id="ins">0</td>
                                                <td rowspan="4" class="vcenter">{{lang('Strategy Planning')}}</td>
                                                <td rowspan="4" class="vcenter" id="wstgin">40</td>
                                                <td id="ints" rowspan="4" class="vcenter">0</td>
                                            </tr>
                                            <tr>
                                                <td>{{lang('Problem Solving')}}</td>
                                                <td id="wps">20</td>
                                                <td width="50px">{{Form::number('ps',isset($form->ps)?round($form->ps):"0",['min'=>1,'max'=>10,'id'=>'ps','class'=>'score'])}}</td>
                                                <td width="50px" id="pss">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>{{lang('Marketing Strategy')}}</td>
                                                <td id="wms">30</td>
                                                <td width="50px">{{Form::number('ms',isset($form->ms)?round($form->ms):"0",['min'=>1,'max'=>10,'id'=>'ms','class'=>'score'])}}</td>
                                                <td width="50px" id="mss">0.00</td>
                                            </tr>
                                            <tr>
                                                <td>{{lang('Customers')}}</td>
                                                <td id="wcu">20</td>
                                                <td width="50px">{{Form::number('cu',isset($form->cu)?round($form->cu):"0",['min'=>1,'max'=>10,'id'=>'cu','class'=>'score'])}}</td>
                                                <td width="50px" id="cus">0.00</td>
                                            </tr>
                                        @endif
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Efficiency')}}</td>
                                            <td id="wef">25</td>
                                            <td width="50px">{{Form::number('ef',isset($form->ef)?round($form->ef):"0",['min'=>1,'max'=>10,'id'=>'ef','class'=>'score'])}}</td>
                                            <td width="50px" id="efs">0.00</td>
                                            <td rowspan="4" class="vcenter">{{lang('Operation')}}</td>
                                            <td rowspan="4" class="vcenter" id="woptef">40</td>
                                            <td id="efts" rowspan="4" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Performance')}}</td>
                                            <td id="wpm">25</td>
                                            <td width="50px">{{Form::number('pm',isset($form->pm)?round($form->pm):"0",['min'=>1,'max'=>10,'id'=>'pm','class'=>'score'])}}</td>
                                            <td width="50px" id="pms">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Quality')}}</td>
                                            <td id="wqt">25</td>
                                            <td width="50px">{{Form::number('qt',isset($form->qt)?round($form->qt):"0",['min'=>1,'max'=>10,'id'=>'qt','class'=>'score'])}}</td>
                                            <td width="50px" id="qts">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Reliability')}}</td>
                                            <td id="wrt">25</td>
                                            <td width="50px">{{Form::number('rt',isset($form->rt)?round($form->rt):"0",['min'=>1,'max'=>10,'id'=>'rt','class'=>'score'])}}</td>
                                            <td width="50px" id="rts">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Organization of Presentation')}}</td>
                                            <td id="wop">50</td>
                                            <td width="50px">{{Form::number('op',isset($form->op)?round($form->op):"0",['min'=>1,'max'=>10,'id'=>'op','class'=>'score'])}}</td>
                                            <td width="50px" id="ops">0.00</td>
                                            <td rowspan="2" class="vcenter">{{lang('Presentation')}}</td>
                                            <td rowspan="2" class="vcenter" id="wpstop">20</td>
                                            <td id="opts" rowspan="2" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Enquiries')}}</td>
                                            <td id="wen">50</td>
                                            <td width="50px">{{Form::number('en',isset($form->en)?round($form->en):"0",['min'=>1,'max'=>10,'id'=>'en','class'=>'score'])}}</td>
                                            <td width="50px" id="ens">0.00</td>
                                        </tr>
                                    @endif
                                    @if(strcasecmp($cate,"Corporate Social Responsible")==0)
                                        <tr>
                                            <td>{{lang('Innovation')}}</td>
                                            <td id="win">20</td>
                                            <td width="50px">{{Form::number('in',isset($form->in)?round($form->in):"0",['min'=>1,'max'=>10,'id'=>'in','class'=>'score'])}}</td>
                                            <td width="50px" id="ins">0</td>
                                            <td rowspan="4" class="vcenter">{{lang('Strategy Planning')}}</td>
                                            <td rowspan="4" class="vcenter" id="wstgin">40</td>
                                            <td id="ints" rowspan="4" class="vcenter">0</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Problem Solving')}}</td>
                                            <td id="wps">30</td>
                                            <td width="50px">{{Form::number('ps',isset($form->ps)?round($form->ps):"0",['min'=>1,'max'=>10,'id'=>'ps','class'=>'score'])}}</td>
                                            <td width="50px" id="pss">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Public Value')}}</td>
                                            <td id="wpv">30</td>
                                            <td width="50px">{{Form::number('pv',isset($form->pv)?round($form->pv):"0",['min'=>1,'max'=>10,'id'=>'pv','class'=>'score'])}}</td>
                                            <td width="50px" id="pvs">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Customers')}}</td>
                                            <td id="wcu">20</td>
                                            <td width="50px">{{Form::number('cu',isset($form->cu)?round($form->cu):"0",['min'=>1,'max'=>10,'id'=>'cu','class'=>'score'])}}</td>
                                            <td width="50px" id="cus">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Efficiency')}}</td>
                                            <td id="wef">25</td>
                                            <td width="50px">{{Form::number('ef',isset($form->ef)?round($form->ef):"0",['min'=>1,'max'=>10,'id'=>'ef','class'=>'score'])}}</td>
                                            <td width="50px" id="efs">0.00</td>
                                            <td rowspan="4" class="vcenter">{{lang('Operation')}}</td>
                                            <td rowspan="4" class="vcenter" id="woptef">40</td>
                                            <td id="efts" rowspan="4" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Performance')}}</td>
                                            <td id="wpm">25</td>
                                            <td width="50px">{{Form::number('pm',isset($form->pm)?round($form->pm):"0",['min'=>1,'max'=>10,'id'=>'pm','class'=>'score'])}}</td>
                                            <td width="50px" id="pms">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Quality')}}</td>
                                            <td id="wqt">25</td>
                                            <td width="50px">{{Form::number('qt',isset($form->qt)?round($form->qt):"0",['min'=>1,'max'=>10,'id'=>'qt','class'=>'score'])}}</td>
                                            <td width="50px" id="qts">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Reliability')}}</td>
                                            <td id="wrt">25</td>
                                            <td width="50px">{{Form::number('rt',isset($form->rt)?round($form->rt):"0",['min'=>1,'max'=>10,'id'=>'rt','class'=>'score'])}}</td>
                                            <td width="50px" id="rts">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Organization of Presentation')}}</td>
                                            <td id="wop">50</td>
                                            <td width="50px">{{Form::number('op',isset($form->op)?round($form->op):"0",['min'=>1,'max'=>10,'id'=>'op','class'=>'score'])}}</td>
                                            <td width="50px" id="ops">0.00</td>
                                            <td rowspan="2" class="vcenter">{{lang('Presentation')}}</td>
                                            <td rowspan="2" class="vcenter" id="wpstop">20</td>
                                            <td id="opts" rowspan="2" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Enquiries')}}</td>
                                            <td id="wen">50</td>
                                            <td width="50px">{{Form::number('en',isset($form->en)?round($form->en):"0",['min'=>1,'max'=>10,'id'=>'en','class'=>'score'])}}</td>
                                            <td width="50px" id="ens">0.00</td>
                                        </tr>
                                    @endif
                                    @if(strcasecmp($cate,"Start-up Company")==0)
                                        <tr>
                                            <td>{{lang('Innovation')}}</td>
                                            <td id="win">20</td>
                                            <td width="50px">{{Form::number('in',isset($form->in)?round($form->in):"0",['min'=>1,'max'=>10,'id'=>'in','class'=>'score'])}}</td>
                                            <td width="50px" id="ins">0</td>
                                            <td width="200px" rowspan="5" class="vcenter">{{lang('Strategy Planning / Unique Selling Proposition')}}</td>
                                            <td rowspan="5" class="vcenter" id="wstgin">40</td>
                                            <td id="ints" rowspan="5" class="vcenter">0</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Financial')}}</td>
                                            <td id="wfi">20</td>
                                            <td width="50px">{{Form::number('fi',isset($form->fi)?round($form->fi):"0",['min'=>1,'max'=>10,'id'=>'fi','class'=>'score'])}}</td>
                                            <td width="50px" id="fis">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Competitive Advantage & Differentiation')}}</td>
                                            <td id="wca">20</td>
                                            <td width="50px">{{Form::number('ca',isset($form->ca)?round($form->ca):"0",['min'=>1,'max'=>10,'id'=>'ca','class'=>'score'])}}</td>
                                            <td width="50px" id="cas">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Marketing Strategy')}}</td>
                                            <td id="wms">20</td>
                                            <td width="50px">{{Form::number('ms',isset($form->ms)?round($form->ms):"0",['min'=>1,'max'=>10,'id'=>'ms','class'=>'score'])}}</td>
                                            <td width="50px" id="mss">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Market Entry / IPR')}}</td>
                                            <td id="wme">20</td>
                                            <td width="50px">{{Form::number('me',isset($form->me)?round($form->me):"0",['min'=>1,'max'=>10,'id'=>'me','class'=>'score'])}}</td>
                                            <td width="50px" id="mes">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Scalability')}}</td>
                                            <td id="wsc">25</td>
                                            <td width="50px">{{Form::number('sc',isset($form->sc)?round($form->sc):"0",['min'=>1,'max'=>10,'id'=>'sc','class'=>'score'])}}</td>
                                            <td width="50px" id="scs">0.00</td>
                                            <td rowspan="4" class="vcenter">{{lang('Operation')}}</td>
                                            <td rowspan="4" class="vcenter" id="woptef">40</td>
                                            <td id="efts" rowspan="4" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Team Organization Structure')}}</td>
                                            <td id="wtm">25</td>
                                            <td width="50px">{{Form::number('tm',isset($form->tm)?round($form->tm):"0",['min'=>1,'max'=>10,'id'=>'tm','class'=>'score'])}}</td>
                                            <td width="50px" id="tms">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Stakeholder')}}</td>
                                            <td id="wsh">25</td>
                                            <td width="50px">{{Form::number('sh',isset($form->sh)?round($form->sh):"0",['min'=>1,'max'=>10,'id'=>'sh','class'=>'score'])}}</td>
                                            <td width="50px" id="shs">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Quality')}}</td>
                                            <td id="wqt">25</td>
                                            <td width="50px">{{Form::number('qt',isset($form->qt)?round($form->qt):"0",['min'=>1,'max'=>10,'id'=>'qt','class'=>'score'])}}</td>
                                            <td width="50px" id="qts">0.00</td>
                                        </tr>
                                        <tr class="bg-primary">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Organization of Presentation')}}</td>
                                            <td id="wop">50</td>
                                            <td width="50px">{{Form::number('op',isset($form->op)?round($form->op):"0",['min'=>1,'max'=>10,'id'=>'op','class'=>'score'])}}</td>
                                            <td width="50px" id="ops">0.00</td>
                                            <td rowspan="2" class="vcenter">{{lang('Presentation')}}</td>
                                            <td rowspan="2" class="vcenter" id="wpstop">20</td>
                                            <td id="opts" rowspan="2" class="vcenter">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>{{lang('Enquiries')}}</td>
                                            <td id="wen">50</td>
                                            <td width="50px">{{Form::number('en',isset($form->en)?round($form->en):"0",['min'=>1,'max'=>10,'id'=>'en','class'=>'score'])}}</td>
                                            <td width="50px" id="ens">0.00</td>
                                        </tr>
                                    @endif


                                </tbody>

                            </table>
                             <br>

                            @if(!$can_edit)
                                </fieldset>
                            @else
                                <div align="right">
                                        <button type="submit" class="btn btn-primary">{{lang('Submit')}}</button>
                                </div>
                            @endif
                            {!! Form::close() !!}
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
    <script src="//vjs.zencdn.net/4.12/video.js"></script>
    <script type="text/javascript">
        function getMinScore(wid,minscore){
            weight=$('#w'+wid).html();
            credit=10;
            score=getScore(weight,credit,minscore);
            $('#'+wid+'s').html(score);
        }

        function valueExistedId(id){
            if($("#"+id).length == 0){
                return 0;
            }else{
               return parseFloat(fixFloat($("#"+id).val()));
            }
        }

        function valueExistedIdScore(id){
            if($("#"+id).length == 0){
                return 0;
            }else{
               return parseFloat(fixFloat($("#"+id+'s').html()));
            }
        }

        function getStrategyScore(){
            // alert(valueExistedId('in'));
            stSum=valueExistedIdScore('in')+valueExistedIdScore('ps')
                    +valueExistedIdScore('pv')+valueExistedIdScore('ti')
                    +valueExistedIdScore('cp')+valueExistedIdScore('ms')
                    +valueExistedIdScore('cu')+valueExistedIdScore('fi')
                    +valueExistedIdScore('ca')+valueExistedIdScore('me');
            stscore=getScore(40,100,stSum);
            $('#ints').html(stscore);
            totalSum();
        }


        function getFeatureScore(){
            stSum=valueExistedIdScore('ef')+valueExistedIdScore('pm')
                    +valueExistedIdScore('qt')+valueExistedIdScore('rt')
                    +valueExistedIdScore('sc')+valueExistedIdScore('tm')
                    +valueExistedIdScore('sh');
            stscore=getScore(40,100,stSum);
            $('#efts').html(stscore);
            totalSum();
        }
        function getPresentationScore(){
            stSum=valueExistedIdScore('op')+valueExistedIdScore('en');
            stscore=getScore(20,100,stSum);
            $('#opts').html(stscore);
            totalSum();
        }

        function totalSum(){
            tsum=parseFloat(fixFloat($('#opts').html()))+parseFloat(fixFloat($('#efts').html()))+parseFloat(fixFloat($('#ints').html()));
            $('#total').html(fixFloat(tsum));
        }

        function getScore(weight,credit,score){
            num=(score/credit)*weight;
            return fixFloat(num);
        }

        function fixFloat(num){
            return parseFloat(Math.round(num * 100) / 100).toFixed(2);
        }

        @if(!$is_youtube)
            try{
                videojs(document.getElementById('video'), {}, function() {

                });
            }catch (eer){ }

        @endif
        // $(document).ready(function(){
            
        // });
        $(document).ready(function(){
                @if(strcasecmp("false",\Setting::get('CAN_FINAL_JUDGE'))==0)
                    $("#judgeform :input").prop("readonly", true);
                @endif
                jud_cat=['in','ps','pv','ti','ef','pm','qt','rt','op','en','ms','cu','fi','ca','me','sc','tm','sh'];
                $.each(jud_cat,function(key,value){
                    getMinScore(value,valueExistedId(value));
                });

                getStrategyScore();
                getFeatureScore();
                getPresentationScore();
          
            $('#in').change(function(){
                getMinScore('in',this.value);
                getStrategyScore();
            });

            $('#ps').change(function(){
                getMinScore('ps',this.value);
                getStrategyScore();
            });
            $('#pv').change(function(){
                getMinScore('pv',this.value);
                getStrategyScore();
            });
            $('#ti').change(function(){
                getMinScore('ti',this.value);
                getStrategyScore();
            });
            $('#ms').change(function(){
                getMinScore('ms',this.value);
                getStrategyScore();
            });
            $('#cu').change(function(){
                getMinScore('cu',this.value);
                getStrategyScore();
            });
            $('#fi').change(function(){
                getMinScore('fi',this.value);
                getStrategyScore();
            });
            $('#ca').change(function(){
                getMinScore('ca',this.value);
                getStrategyScore();
            });
             $('#me').change(function(){
                getMinScore('me',this.value);
                getStrategyScore();
            });
             //feature


            $('#ef').change(function(){
                getMinScore('ef',this.value);
                getFeatureScore();
            });
            $('#pm').change(function(){
                getMinScore('pm',this.value);
                getFeatureScore();
            });
            $('#qt').change(function(){
                getMinScore('qt',this.value);
                getFeatureScore();
            });
            $('#rt').change(function(){
                getMinScore('rt',this.value);
                getFeatureScore();
            });
            $('#sc').change(function(){
                getMinScore('sc',this.value);
                getFeatureScore();
            });
            $('#tm').change(function(){
                getMinScore('tm',this.value);
                getFeatureScore();
            });
            $('#sh').change(function(){
                getMinScore('sh',this.value);
                getFeatureScore();
            });

            // Presentation

            $('#op').change(function(){
                getMinScore('op',this.value);
                getPresentationScore();
            });
            $('#en').change(function(){
                getMinScore('en',this.value);
                getPresentationScore();
            });

        });

    </script>
@stop
