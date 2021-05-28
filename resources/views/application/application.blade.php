{{--@extends('layouts.master')--}}
@extends('admin.dashboard')

@section('content')

    <div class="container">
        <div class="row">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                    <span class="round-tab">
                                     <i class="glyphicon glyphicon-folder-open"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Step 4">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Step 5">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab" title="Step 6">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#step7" data-toggle="tab" aria-controls="step7" role="tab" title="Step 7">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{--{!! Form::open(['url' => 'foo/bar']) !!}--}}

                    {!! BootForm::horizontal(['left_column_class' => 'col-md-3', 'left_column_offset_class' => '', 'right_column_class' => 'col-md-9' ]) !!}
                    {{--<form role="form" >--}}
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="step1">

                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 1 : PARTICIPATION(COMPANY) DETAIL</h3>

                                        <?php echo BootForm::text('companyName');?>
                                        <?php echo BootForm::text('address');?>
                                        <?php echo BootForm::tel('phone');?>
                                        <?php echo BootForm::tel('fax');?>
                                        <?php echo BootForm::text('website');?>
                                        <?php echo BootForm::email('email');?>

                                        <?php echo BootForm::text('CEO_Name');?>
                                        <?php echo BootForm::email('CEO_Email');?>
                                        <?php echo BootForm::textArea('company_profile');?>
                                        {{--<input name="c_profile" id="cprofile">--}}
                                        <script>
                                            CKEDITOR.replace( 'company_profile',{
                                                toolbar:tooles
                                            } );
                                        </script>
                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 2 : CONTACT PERSON DETAILS</h3>
                                        <?php echo BootForm::text('Name');?>
                                        <?php echo BootForm::text('position');?>
                                        <?php echo BootForm::email('email');?>
                                        <?php echo BootForm::tel('phone');?>
                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 3 : DESCRIPTION OF PRODUCTS</h3>
                                        <?php echo BootForm::textArea('product_description');?>
                                        {{--<input name="product_Description" id="pdesc">--}}
                                    </div>
                                    <script>
                                        CKEDITOR.replace( 'product_description',{
                                            toolbar:tooles
                                        } );
                                    </script>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 4 : UNIQUENESS</h3>
                                            <?php echo BootForm::textArea('uniqueness');?>
                                        <script>
                                            CKEDITOR.replace( 'uniqueness' ,{
                                                toolbar:tooles
                                            });
                                        </script>
                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step5">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 6 : QUALITY/RECOGNITION</h3>
                                        <?php echo BootForm::textArea('quality');?>
                                        {{--<input name="quality" id="pquality">--}}
                                        <script>
                                            CKEDITOR.replace( 'quality' ,{
                                                toolbar:tooles
                                            });
                                        </script>
                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step6">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 6 : MARKETABILITY</h3>
                                         <?php echo BootForm::textArea('marketability');?>
                                        {{--<input name="marketability" id="market">--}}
                                        <script>
                                            CKEDITOR.replace( 'marketability',{
                                                toolbar:tooles
                                            } );
                                        </script>
                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step7">
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <h3>Step 7 : BUSINESS MODEL </h3>
                                        <?php echo BootForm::textArea('business_model');?>
                                        {{--<input name="business_model" id="bmodel">--}}
                                        <script>
                                            CKEDITOR.replace( 'business_model',{
                                             toolbar:tooles
                                            });

                                        </script>

                                    </div>
                                    <div class="col-xs-12">
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            {{--<li><button type="button" class="btn btn-default next-step">Skip</button></li>--}}
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane" role="tabpanel" id="complete">
                                <h3>Complete</h3>
                                <p>You have successfully completed all steps.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    {{--</form>--}}
                    {!! BootForm::close() !!}

                </div>
            </section>
        </div>
    </div>

@endsection