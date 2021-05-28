<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\AlertMailForm;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Repositories\UserRepository;
class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->user=$user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AlertMailForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('mail.alert'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate'
            ]
        );
        return view('mails.alertMail',compact('form'));
       
    }

    public function alert(Request $request)
    {
        $auth=\Auth::user();
        $user=[];
        $allUser=$this->user->makeModel()->where('parent_id','!=',null)->orderBy('username', 'asc')->get();

        foreach ($allUser as $key => $attemp_user) {
            
            if(isset($attemp_user->application)&&$attemp_user->application->status!='accepted'){
                \Mail::send('mails.sendingAlertCandidate', ['content'=>$request->get('content'),'urlLink'=>route('application.create'),'sender'=>$auth->username], function ($message) use ($attemp_user,$auth)
                    {
                        $message->from(env('MAIL_USERNAME'), ucwords($auth->username));
                        $message->to($attemp_user->email);
                        $message->subject(lang('general.validate_form'));
                    });
            }
        }
        flash()->info(lang('Mail was sent to applicants.'));
        return redirect(route('mail.sending'));
    }

}
