<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group([
    'middleware'=>['web','auth']
],
    function (){
        Route::get('/',['as' => 'user.profile', 'uses' => 'UserController@profile' ] );
    });


Route::group([
    'prefix'=>'user',
    'middleware'=>['web','auth']
],
    function (){
        Route::get('/profile',['as' => 'user.profile', 'uses' => 'UserController@profile' ] );

    });




Auth::routes();
//faizin 
//Auth::routes(['verify' => true]);

Route::get('/home', function (){
    return redirect()->route('user.profile');
})->name('home');

require_once('groupes/Candidate.php');
require_once('groupes/Application.php');
require_once('groupes/Guideline.php');
require_once('groupes/Role.php');
require_once('groupes/Category.php');
require_once('groupes/Country.php');
require_once('groupes/User.php');
require_once('groupes/Mail.php');
require_once('groupes/Video.php');
require_once('groupes/OnlineJudging.php');
require_once('groupes/Judge.php');

require_once('groupes/Result.php');
require_once('groupes/FinalJudge.php');
require_once('groupes/Report.php');
// require_once('groupes/FinalJudge.php');
