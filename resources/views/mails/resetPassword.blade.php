@extends("mails.template")

@section("mail_body")
    <tr>
        <td class="content-cell">

            @if (isset($greeting))
                 {{ $greeting }}
            @else
                <H2>Hello {{ ucwords(isset($name)?$name:"") }},</h2>
            @endif

            <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <p>
                                                @foreach ($introLines as $line)
                                                    {{ $line }}
                                                @endforeach
                                                </p>
                                                <a href="{{$actionUrl}}" class="button button-green" target="_blank">{{ lang($actionText) }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                                @foreach ($outroLines as $line)
                                                    {{ $line }}
                                                @endforeach
                                                </p>
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
            <p>{{ ucwords(isset($sender)?$sender:config('app.name')) }}</p>
        </td>
    </tr>
    <tr>
        <td class="">
            <hr/>

            <p><small>If you’re having trouble clicking the "{{ lang($actionText) }}" button, copy and paste the URL below
            into your web browser: <a href="{{$actionText}}">{{$actionUrl}}</a></small></p>
            <br/>
        </td>
    </tr>

@endsection

