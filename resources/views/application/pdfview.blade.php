<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            body{
                margin-left:1em;
                margin-right:1em;
                margin-top: 20px;
                padding-top: 10px;
            }

            table{
                border: none;
                width: 100%;
            }
            table td, table th{
                text-align: left;
            }
            label{
                padding-left: 10px;;
            }

            h3,h4{
                background: #d3ad4d;
                width: 100%;
                text-align: center;
                padding: 5px;
            }
            h3{
                font-size: 16pt;
            }
            h4{
                font-size: 20pt;
                font-weight: bold;
            }
            .page-break {
                page-break-after: always !important;
            }
            .main table tr td:first-child {
                width: 25%;
            }

            .page{
                height:947px;
                padding-top:30px;
                page-break-after : always;
                font-family: Arial, Helvetica, sans-serif;
                position:relative;
                border-bottom:1px solid #000;
            }

            .header,
            .footer {
                width: 100%;
                text-align: center;
                position: fixed;
            }
            .header {
                top: -25px;
            }
            .footer {
                bottom: 5px;
            }
            .pagenum:before {
                content: counter(page);
            }
            .footer hr  {
                /*border-top: 1px solid #8c8b8b;*/
                border-top: 1px solid #d3ad4d;
                text-align: center;
            }
            .footer hr:after {
                /*content: '§';*/
                display: inline-block;
                position: relative;
                top: -14px;
                padding: 0 10px;
                background: #f0f0f0;
                /*color: #8c8b8b;*/
                color: #d3ad4d;
                font-size: 18px;
                -webkit-transform: rotate(60deg);
                -moz-transform: rotate(60deg);
                transform: rotate(60deg);
            }
            .footer-left{
                width: 49%;
                display: inline;
                float: left;
                text-align: left;
                padding-left: 8px;

            }
            .footer-right{
                width: 49%;
                display: inline;
                float: left;
                text-align: right;
                padding-right: 8px;

            }
            .clear{
                clear:both;
            }
            .text-box{
                width: 98%;
                border: 1px solid lightslategrey;
                padding: 5px;
                min-height: 30px !important;
                margin: 0;
                border-radius: 5px;
            }

            @media print {
                .page-break {
                    height:0; page-break-before:always; margin:0; border-top:none;

                }
            }

            .header img{
                position: relative;
                /*bottom: 50px !important;*/
                /*width: 40px !important;*/
                height: 50px !important;
            }
            .header{
                /*background-color: green;*/
            }
            .container{
                text-align: center;
            }
            .note{
                padding: 3px;
                margin: 25px 2px;
            }
            .note h2{
                text-align: center;
            }
            .note li{
                padding: 5px;
                padding-left: 10px;
                font-size: 14pt;
            }
            .none-break { page-break-before: auto;page-break-after: avoid; }
            /*signature blog */
            table.declare{
                width: 300px;
            }
            table .declare td{
                padding: 5px;
            }
            table .declare tr td:first-child{
                width: 100px;
            }
            table .declare tr td:last-child{
                border-bottom: 1px solid black;
            }
            table .signature{
                height: 80px;
                /*width: 40px;*/
                /*background-color: green;*/
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="{!!URL::to('images/img/aictalogo.png')!!}">
            <table class="main">
                <tr>
                    <th colspan="4"><h4>ASEAN ICT AWARD ( AICTA ) 2017 ENTRY FORM </h4></th>
                </tr>
                <tr>
                    <td><label>Category</label> </td>
                    <td colspan="3"><div class="text-box">{!!$application->user->category->name!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Product Name</label> </td>
                    <td colspan="3"><div class="text-box">{!!$application->product_name!!}&nbsp;</div></td>
                </tr>

                <tr>
                    <td><label>Submission Date</label> </td>
                    <td colspan="3"><div class="text-box">{!! date('F d, Y', strtotime($application->updated_at)) !!}&nbsp;</div> </td>
                </tr>
                <tr >
                    <td colspan="4">
                        <div class="note text-box">
                            <h2>NOTE TO PARTICIPAINTS</h2>
                            <ul>
                                <li>Please ensure that you have read the "Entry Guidelines" for your company's and product's eligibility.</li>
                                <li>This entry form must be completed and submitted together with a video presentation (duration 2 - 5 mins) to respective ASEAN Member States AICTA Coordinator.</li>
                                <li>The Deadline for entry submisions to reach the AICTA Secretariat is <strong>17 <sup>th</sup>June 2017</strong></li>
                            </ul>
                        </div>
                    </td>

                </tr>
                </table>
        </div>
        <div class="page-break"></div>

        <div class="container">
            <table class="main">
                <tr class="page-break">
                    <td colspan="4" ><h3> AICTA 2017 ENTRY </h3></td>
                </tr>
                <tr>
                    <td><label>Product Name</label></td>
                    <td colspan="3"><div class="text-box">{!!$application->product_name!!}&nbsp;</div> </td>
                </tr>
                <tr><td colspan="4"> <label>Category :</label></td></tr>
                <tr>
                @foreach($categories as $key=> $category)
                        @if($key % 2 == 0 && $key >0)
                            </tr>
                            <tr>
                        @endif
                        <td>{!!$category->name!!}({!!$category->abbreviation!!})&nbsp;</td>
                        <td>
                            @if($application->user->category_id == $category->id)
                                <input type="checkbox" name="cat" value="" checked="" >
                             @else
                                <input type="checkbox" name="cat" value=""  >
                            @endif
                        </td>
                @endforeach
                 </tr>
                <tr ><td colspan="4"><h3>PARTICIPAINT (COMPANY) DETAILS</h3></td></tr>
                <tr>
                    <td><label>Company Name</label></td>
                    <td colspan="3"><div class="text-box">{!!$application->company_name!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Address</label></td>
                    <td colspan="3"><div class="text-box">{!!$application->address!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Country</label></td>
                    <td colspan="3"><div class="text-box">{!!$application->user->country->name!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Phone</label></td>
                    <td colspan="3"><div class="text-box">{!!$application->phone!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Fax</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->fax!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Website</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->website!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>E-mail Adrress</label></td>
                    <td colspan="3"><div class="text-box">{!!$application->email!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Company Profile</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->company_profile!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label>Name of CEO/ MD/ GM</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->ceo_name!!}&nbsp;</div></td>
                </tr>
                <tr >
                    <td><label>E-mail Adress</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->ceo_email!!}&nbsp;</div></td>
                </tr>

                <tr><td colspan="4"><h3>CONTACT PERSON DETAILS</h3></td></tr>
                <tr>
                    <td><label> Name</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->contact_name!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label> Position</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->contact_position!!}&nbsp;</div></td>
                </tr>
                <tr>
                    <td><label> Contact Number(s)</label></td>
                    <td colspan="3"><div class="text-box"> {!!$application->contact_phone!!}&nbsp;</div></td>
                </tr>
                <tr><td colspan="4"><h3>DESCRIPTION OF PRODUCT</h3></td></tr>
                <tr>
                    <td colspan="4"><div class="text-box"> {!!$application->product_description!!}&nbsp;</div></td>
                </tr>
                <tr><td colspan="4"><h3>UNIQUENESS</h3></td></tr>
                <tr>
                    <td colspan="4"><div class="text-box"> {!!$application->product_uniqueness!!}&nbsp;</div></td>
                </tr>
                <tr><td colspan="4"><h3>QUALITY / RECOGNITION</h3></td></tr>
                <tr>
                    <td colspan="4"><div class="text-box"> {!!$application->product_quality!!}&nbsp;</div></td>
                </tr>
                <tr><td colspan="4"><h3>MARKETABILITY</h3></td></tr>
                <tr>
                    <td colspan="4"><div class="text-box"> &nbsp;{!!$application->product_market!!} </div></td>
                </tr>
                <tr><td colspan="4"><h3>BUSINES MODEL</h3></td></tr>
                <tr>
                    <td colspan="4"><div class="text-box"> &nbsp; {!!html_entity_decode($application->business_model)!!}</div></td>
                </tr>
                <tr><td colspan="4"><h3>DECLARATION BY PARTICIPANT</h3></td></tr>
                <tr>
                    <td colspan="4"><div class="text-box">
                        <p>I hereby confirm that all the information provided by me for AICTA 2017 entry is true and correct.
                            I also agree to abide by the decisions of the AICTA judging panel whose decisions will be
                            deemed as final.
                        </p>
                        <div class="clear"></div>
                        <table class="declare" >
                            <tr>
                                <td colspan="1" class="signature"><label>Signature </label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Campany</td>
                                <td></td>
                            </tr>
                        </table>
                     </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="header">
            <img src="{!!URL::to('images/img/aictalogo.png')!!}">
        </div>
        <div class="footer">
            <hr>
            <div class="footer-left">AICTA 2017 ENTRY FORM</div>
            <div class="footer-right">
                Page <span class="pagenum"></span>
            </div>
            <div class="clear"></div>
        </div>
    </body>

</html>


