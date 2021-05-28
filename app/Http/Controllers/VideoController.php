<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Youtube;
use App\Repositories\VideoRepository;
use App\Repositories\UserRepository;
use App\Forms\ApplicationForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{

    private $video;
    public function __construct(UserRepository $user,VideoRepository $video) {
        $this->user=$user;
        $this->video = $video;
        $this->idTable = (intval(Input::get('start')))+1;
    }
    public function index()
    {
        return view('video.index');
    }

    public function getList()
    {
        $video = $this->video->makeModel()
            ->orderByDesc('id')
            ->get()
            ->unique('appliaction_id') // for group by
            ;
        return Datatables::of($video)
            ->addColumn('id',function ($video){
                return $this->idTable++;
//                return $video->id;
            })
            ->addColumn('product', function ($video) {
                return ucwords($video->application->product_name);
//                return "";
            })
            ->addColumn('youtube_id', function ($video) {
                return $video->youtube_id;
            })
            ->addColumn('path', function ($video) {
                return $video->path;
            })
            ->addColumn('minetype', function ($video) {
                return $video->mine_type;
            })
            ->addColumn('action', function ($video) {
                $result="";
                $result = '<a href="'.route('video.view', $video->id).'" class="btn btn-icon btn-danger btn-xs m-b-3" title="Play" style="margin-right: 5px;"><i class="fa fa-youtube-play"></i></a>';
//                $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$video->id.'" href="'.route('video.destroy', $video->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                return $result;
            })
            ->make(true);
    }


    public function player($id){
        $video=$this->video->find($id);
        if($video){

            $title = $video->application->product_name;
            return view('video.player')->with(compact('video','title'));
        }
        return redirect()->back()->withErrors(['error'=>"Video on found"]);

    }


    public function view($id)
    {

        $video =$this->video->find($id);

        return view('video.view', compact('video'));

    }

    public function store(Request $request)
    {
        $video = Youtube::upload($request->file('video')->getPathName(), [
            'title'       => 'My Video',
            'description' => 'This video is uploaded through API.',
            'tags'        => ['api', 'youtube'],
        ]);

        return $video->getVideoId();
    }
    // upload video demo to host
    public function upload(FormBuilder $formBuilder , Request $request){
        $id = $request->get('id');
        $data = $request->all();
        $response = array('not'=>'no');
        if(Input::hasFile('video_demo')) {
            $file = Input::file('video_demo');
            $tmpFilePath = '/videos/';
            $tmpFileName = $id.'_' .time()  .'.'.$file->getClientOriginalExtension();
            $file = $file->move(public_path() .$tmpFilePath, $tmpFileName);
            $path = $tmpFilePath . $tmpFileName;
            $data = ($request->except(['video_demo']));
            $mine_type=$file->getMimeType();
            $data['video_demo'] = ''.$path;
//            dd($file->getMimeType());
            $this->video->create([
                'application_id'=>$id,
                'path'=>$data['video_demo'],
                'mine_type'=>$mine_type,
                'status'=>'host'
            ]);

            $response = array(
                'showRemove'=> false,
                'initialPreview' => array(
//                    url($path)
                    '<video width="320" height="240" controls class="videoPlayer" controls controlsList=" nodownload nopichture" ><source   src="'.$path.'" type="'.$mine_type.'">  </video>'
                ),
                'initialPreviewAsData'=> false,
                'fileActionSettings'=>'',
                'initialPreviewThumbTags'=>'',
                'initialPreviewConfig' => array(
//                    array('caption' => "video demo", 'size' => 222, 'width' => '120px', 'url' => route("application.uploadfile"), 'key' => $id)
                    array('type'=> "video", 'size'=> \Settings::get('VIDEO_UPLOAD_MAX_SIZE',100000000), 'filetype'=> "$mine_type", 'caption'=> "video demo", 'url'=> $path, 'key'=> $id),
                ),
                'append' => false
            );
        }
        return response()->json($response);
    }


}
