<?php
/**
 * Created by PhpStorm.
 * User: vitou
 * Date: 21/03/2017
 * Time: 19:00
 */
  ?>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">AICTA {{date('y')}}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">AICTA {{date('y')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(!Auth::guest())
                <ul class="nav navbar-nav">
                    <li><a href="{{route('user.profile')}}">Dashboard</a></li>
                    <li><a href="{{route('application.create')}}">My Form</a></li>
                    <li><a href="{{route('formSubmission.create')}}">PDF form</a></li>

                </ul>
                
              
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://www.aseanictaward.com/">{{ucwords('aseanictaward')}}</a></li>
                    <li >
                        <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                    </li>
                </ul>
                @else
                    <ul class="nav navbar-nav navbar-right">
                        
                            <li><a href="{{ route('login') }}">Login</a></li>
                       
                    </ul>
                @endif
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
