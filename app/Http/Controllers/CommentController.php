<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Validator;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\CommentRepository;
use App\Repositories\ApplicationRepository;
use App\Forms\CommentForm;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class CommentController extends Controller {

    private $comment;

    public function __construct(CommentRepository $comment,ApplicationRepository $application,UserRepository $user) {

        $this->comment = $comment;
        $this->application=$application;
        $this->idTable = 1;
        $this->user=$user;

    }
    public function create(FormBuilder $formBuilder){
        $form = $formBuilder->create(CommentForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('comment.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate'
            ]
        );
        
        $edited = false;
        return view('comment.create', compact('form','edited'));
    }

    public function index()
    {
        return view('comment.index');
        
    }
    
     public function getList()
    {
        $comment = $this->comment->makeModel()->orderBy('created_at', 'asc')->get();
        
        return Datatables::of($comment)
            ->addColumn('id',function ($comment){
                    return $this->idTable++;
                })
            ->addColumn('comment', function ($comment) {
                    return ucwords($comment->comment);
                })
            ->addColumn('action', function ($comment) {
                    $result = '<a href="'.route('comment.edit', $comment->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    
                    
                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$comment->id.'" href="'.route('comment.destroy', $comment->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    return $result;
                })
            ->make(true);
    }

    public function store(FormBuilder $formBuilder , Request $request)
    {
        $id = $request->get('id');
        $form = $formBuilder->create(CommentForm::class);
        $data = $request->all();
        if (!$form->isValid()) {
            return redirect()->back()
                            ->withErrors($form->getErrors())
                            ->withInput()
                            ->with(['edited'=>true]);
        }
        if(!$id){
            $this->comment->create($data);
        }else{
            $commentInfor = $this->comment->find($id);
            $commentInfor->update($data);
        }
        
        flash()->info('Your data was created.');
        return redirect(route('comment.index'));
        // Do saving and other things...
    }

    public function addcomment(FormBuilder $formBuilder , Request $request)
    {
        $auth=\Auth::user();
        $form = $formBuilder->create(CommentForm::class);
        $data = $request->all();
        $data['commented_by']=\Auth::id();
        $cand_info=$this->application->find($data['meta_key'])->user;
        $is_representer=false;
        if($auth->hasRole('Representer')){
            $is_representer =true;
            try {
                \Mail::send('mails.sendingCommentCandidate', ['name' => $cand_info->username, 'urlLink' => route('application.create'), 'sender' => $auth->username], function ($message) use ($cand_info, $auth) {
                    $message->from(env('MAIL_USERNAME'), ucwords($auth->username));
                    $message->to($cand_info->email);
                    $message->subject(lang('general.validate_form'));
                });
            }catch (\Exception $e){
                flash()->warning("could not send comment to your candidate.");
            }
        }elseif($auth->hasRole('Admin')||$auth->hasRole('Reviewer')||$auth->is_super_admin==1){
            $parent=$this->user->find($cand_info->parent_id);
            try {
            \Mail::send('mails.sendingCommentRepresenter', ['name'=>$parent->username,'urlLink'=>route('application.view',$data['meta_key']),'sender'=>$auth->username,'cand_name'=>$cand_info->username], function ($message) use ($parent,$auth)
                {
                    $message->from(env('MAIL_USERNAME'), ucwords($auth->username));
                    $message->to($parent->email);
                    $message->subject(lang('general.validate_form'));
                });
            }catch (\Exception $e){
                flash()->warning("could not send comment to your candidate.");
            }
        }
        $comment =$this->comment->create($data);
        $comment['username']=\Auth::user()->username;

        $start_judge = Carbon::createFromFormat('m/d/Y', \Setting::get('CLOSED_FORM_DATE','07/27/2019'));
        if($is_representer && !$start_judge->isPast()){
            $this->application->find($data['meta_key'])->update(['status'=>'comment']);
        }

        return response()->json(['comment'=>$comment]);

    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $this->comment->delete($id_item);
            return "success";
        }
        
        return "failed";
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $commentInfor = $this->comment->find($id);
        $form = $formBuilder->create(CommentForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('comment.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $commentInfor
            ]
        );

        if (empty($commentInfor)):

//            flash()->error(lang('The record not found.'));
            return redirect(route('comment.index'))->withErrors(['error'=>'The record not found.']);

        endif;
        $edited = $commentInfor->flag;
        return view('comment.create', compact('form','edited'));

    }

}



