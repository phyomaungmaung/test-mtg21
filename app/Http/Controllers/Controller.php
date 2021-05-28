<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function _getGeneratePassword(){
       return str::random(\Settings::get("MIN_PWD",6));
    }

    protected function _sendMailRegistered($request,$pwd){

//        @todo: check validat then redirect to ...
        $validator = \Validator::make($request->all(), [
                'username' => 'required|max:255',
                'email' => 'required|email|max:255',
                'roles' => 'required',
                'bodymessage' => 'required']
        );

        $mail = [
            'name'=>$request->get('username'),
            'loginpwd'=>$pwd,
            'loginmail'=>$request->get('email'),
            "role"=>$request->get('roles'),
            'urlLink'=>route('login'),
            'sender'=>\Auth::user()->username,
        ];

        $reciever = $mail['loginmail'];
        $sender =  $mail['sender'];
        try{
            \Mail::send('mails.mailRegister', $mail, function ($message) use ($reciever,$sender)
//            \Mail::send('mails.mailRegister', ['name' => $request->get('username'),'loginmail'=>$request->get('email'),'loginpwd'=>$pwd,'role'=>$request->get('roles'),'urlLink'=>route('login'),'sender'=>$auth->username], function ($message) use ($reciever,$auth)
            {
                //faizin
                // $message->from('aseanictawardmalaysia@gmail.com',$sender);
				//$message->from(env('MAIL_USERNAME'),$sender);
     
			   $message->from(config('mail.username'), $sender);
                $message->to($reciever);
                $message->subject(lang('general.subject_register'));
            });
        }catch(\Exception $e){
//            $mes["warning"]="We met some problems during sending email to user";
                return false;
        }

        return true;
    }

}
