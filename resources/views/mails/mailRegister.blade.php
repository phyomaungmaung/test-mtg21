@extends("mails.template")

@section("mail_body")
    <!-- Body content -->
    <tr>
        <td class="content-cell">
            <H2>Hello {{ ucwords($name) }},</h2>
            <p>{{lang('general.register',['role'=>$role])}}</p>
            <p>Email : {{$loginmail}}</p>
            <p>Password : {{$loginpwd}}</p>
            <p>{{lang('general.click_login')}}</p>
                <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <a href="{{$urlLink}}" class="button button-green" style="color: white;" target="_blank">{{ lang('general.login') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <p>{{ "Regards," }}</p>
            <p>{{ ucwords($sender) }}</p>
        </td>
    </tr>
    <tr>
        <td>
            <hr/>

            <p><small>
                    {{--If you’re having trouble clicking the "{{ lang('general.login') }}" button, copy and paste the URL below--}}
            into your web browser: <a href="{{$urlLink}}">{{$urlLink}}</a></small></p>
            <br/>
        </td>
    </tr>

@endsection
