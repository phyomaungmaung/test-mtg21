<?php namespace App\Http\Controllers;

use App\Entities\Application;
use App\Entities\FinalJudge;
use App\Entities\User;
use App\Exports\FinalResultsDetailExport;
use App\Exports\FinalResultsExport;
use App\Exports\SemiResultsDetailExport;
use App\Exports\UsersExport;
use App\Repositories\ApplicationRepository;
// use Validator;
use App\Repositories\CategoryRepository;
use App\Repositories\ResultRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

use App\Repositories\JudgeRepository;

class ReportController extends Controller {

    private $application;
    public function __construct(UserRepository $user,ApplicationRepository $application,CategoryRepository $category,JudgeRepository $judge,ResultRepository $result) {
        $this->user=$user;
        $this->application = $application;
        $this->idTable=1;
        $this->judge=$judge;
        $this->category = $category;
        //$this->result= $result;
    }

    public function index()
    {
        return view('application.index');
    }

    public function getList()
    {

    }

//    public function exportSemiJudgeScoresssd(){
    public function exportSemiJudgeScored(){
//        return Excel::download(new UsersExport,'user.xlsx');

        Excel::create('Judge Score '.date('Y-m-d'), function($excel) {
            $excel->setTitle("Judge Score");
            $categories = $this->category->all();
            foreach ($categories as $category) {
                $cat_id =$category->id;
                $excel->sheet($category->name, function ($sheet) use ( $cat_id  ) {
                    $sheet->disableHeadingGeneration();
//                $sheet->setAllBorders('thin');
                    $sheet->getStyle("A2:F2")->getFont()->setBold(true);
                    $sheet->fromArray(['Judge Name', 'Judge Country', 'Score', 'Company Name', 'Product Name', 'Country of Application'], null, 'A2', false, false);
                    $apps = $this->application->makeModel()
                        ->join('users', 'users.id', '=', 'applications.user_id')
                        ->where('applications.status', 'accepted')
                        ->where('users.category_id', $cat_id)
                        ->orderBy('applications.id', 'DESC')
                        ->get();
                    foreach ($apps as $app) {
                        foreach ($app->scores as $score) {
                            $sheet->appendRow(array(
                                $score->user->username,
                                $score->user->country->name,
                                $score->total,
                                $app->company_name,
                                $app->product_name,
                                $app->user->country->name
                            ));
                        }
                    }
                });
                // Call writer methods here
            }
        })->download('xls');
    }

//    public function exportSemiAppScored(){
    public function exportSemiJudgeScoredDetail(SemiResultsDetailExport $semiResultsExport, Request $request){

        return Excel::download($semiResultsExport,"semi_final_result_detail_".date('Y_m_d').".xlsx");
        /*
        Excel::create('Judge Score '.date('Y-m-d'), function($excel) {
            $excel->setTitle("Judge Score");
            $categories = $this->category->all();
           // try{
            foreach ($categories as $category) {
                $cat_id =$category->id;
                $excel->sheet($category->name, function ($sheet) use ( $cat_id  ) {
                    $sheet->disableHeadingGeneration();
                    $sheet->getStyle("A2:R2")->getFont()->setBold(true);
                    $sheet->fromArray(['Judge Name', 'Judge Country', 'Score', 'rank','in','cv','mk','bm','cp','at','eu','cr','qs','pw','cs','va','pc','rp'], null, 'A2', false, false);
                    $apps = $this->judge->semiRandInCategory($cat_id);
                    $not_complete_ids = $this->judge->__judgeNotComplete($cat_id,count($apps));
                    $arrs=['total','order','in','cv','mk','bm','cp','at','eu','cr','qs','pw','cs','va','pc','rp'];
                    foreach ($apps as $app) {
                        $scores = $this->judge->makeModel()
                            ->where('type','semi')->where('status',2)
                            ->where('app_id',$app->app_id)
                            ->whereNotIn('user_id',$not_complete_ids)
                            ->get();
                        $a = $this->application->find($app->app_id);
                        $sheet->appendRow([$a->user->username,$a->product_name,$a->user->country->name] );
                        foreach ($scores as $score) {
                            $row = [
                                $score->user->username,
                                $score->user->country->name,
                            ];
                            foreach ($arrs as $arr){
                                array_push($row,$score[$arr] );
                            }
                            $sheet->appendRow($row);
                        }
                        $row = [
                            "Average Score ",
                            " =  "
                        ];
                        foreach ($arrs as $arr){
                            array_push($row,$app[$arr] );
                        }
                        $sheet->appendRow($row);

                        $sheet->appendRow([' '] );
                    }
                });

                // Call writer methods here
            }

        })->download('xls');

        // */
    }
    public function export_semi_score(){

    }

    public function exportFinal(FinalResultsExport $finalResultsExport,Request $request){
        return Excel::download($finalResultsExport,"final_result_".date('Y_m_d').".xlsx");

    }

    public function exportFinalScoredDetail(FinalResultsDetailExport $detailExport){
        return Excel::download($detailExport,"final_result_detail_".date('Y_m_d').".xlsx");
    }

}



