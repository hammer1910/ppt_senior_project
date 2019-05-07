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

//Route::get('house',['as'=>'home', function () {
//    return view('welcome');
//}]);

Route::get('login', function () {
    return view('login');
});
Route::post('login','AuthController@login')->name('login');
Route::get('login_user','AuthController@user_login')->name('login_user');
Route::post('forgotpassword','AuthController@forgotPass')->name('forgotpass');
Route::get('register', function () {
    return view('register');
});
Route::post('register','RegisterController@register')->name('register');
//Route::get('manager', function () {
//    return view('manager_acc_master');
//});
Route::get('register_user','RegisterController@register_user')->name('register_user');
Route::get('abc', function () {
    return view('test');
});
Route::get('manager', function () {
    return view('master');
});
//Route::get('do_exam', function () {
//    return view('do_exam_master');
//});
Route::get('doExam/{examID}','QuestionController@doExam')->name('doExam');

Route::post('manager','ManagerController@user')->name('manager');
Route::get('profile', function () {
    return view('user_profile');
});
//Route::post('profile','ManagerController@user')->name('profile');
//Route::get('logout','AuthController@logout')->name('logout');

//Route::get('login','RegisterController@return')->name('return');
Route::group(['prefix'=>'manager'],function (){
    Route::group(['prefix'=>'user'],function (){
        Route::get('profile','ManagerController@user')->name('manager.user.profile');
        Route::post('profile_update','UsersController@edit')->name('edit_profile');
        Route::get('change_password',['as'=>'manager.user.pass','uses'=>'ManagerController@changepass']);
        Route::post('change_password',['as'=>'change_pass','uses'=>'UsersController@update']);
    });
    Route::group(['prefix'=>'admin'],function (){
        //Route::get('list',['as'=>'manager.admin.list','uses'=>'ManagerController@list']);
        Route::get('profile',['as'=>'manager.admin.profile','uses'=>'ManagerController@profile']);
        Route::get('change_password',['as'=>'manager.admin.pass','uses'=>'ManagerController@adchangepass']);
        //        Route::post('add',['as'=>'admin.cate.postAdd','uses'=>'ManagerController@postAdd']);

    });
});
Route::get('create_group',['as'=>'createGroup','uses'=>'ManagerController@creategroup']);
Route::post('create_group',['as'=>'create_group','uses'=>'GroupController@create_Group']);


//Route::get('add_member',['as'=>'add_member','uses'=>'ManagerController@getMember']);
//Route::get('add_member',['as'=>'add_member','uses'=>'GroupController@getGroupID']);
Route::get('manager_ad', function () {
    return view('master_ad');
});
Route::get('upload','UploadController@upload')->name('upload');
Route::group(['prefix'=>'upload'],function (){






});
//Route::resource('users','UsersController');
//

Route::get('uploadPart6/{examID}','UploadController@upload_Part6')->name('upload.upload6');
Route::post('uploadPart6','UploadController@upload_partsix')->name('upload.part6');
Route::get('uploadPart7/{examID}','UploadController@upload_Part7')->name('upload.upload7');
Route::post('uploadPart7','UploadController@upload_partseven')->name('upload.part7');
Route::get('uploadPart5/{examID}','UploadController@upload_Part5')->name('upload.upload5');
Route::post('uploadPart5','UploadController@upload_partfive')->name('upload.part5');
Route::get('uploadPart4/{examID}','UploadController@upload_Part4')->name('upload.upload4');
Route::post('uploadPart4','UploadController@upload_partfour')->name('upload.part4');
Route::get('uploadPart3/{examID}','UploadController@upload_Part3')->name('upload.upload3');
Route::post('uploadPart3','UploadController@upload_partthree')->name('upload.part3');
Route::get('uploadPart2/{examID}','UploadController@upload_Part2')->name('upload.upload2');
Route::post('uploadPart2','UploadController@upload_parttwo')->name('upload.part2');
Route::get('uploadPart1/{examID}','UploadController@upload_Part1')->name('upload.upload1');
Route::post('uploadPart1','UploadController@upload_partone')->name('upload.part1');
//Route::post('uploadPart6','UploadController@upload_partone')->name('upload.part1');
Route::get('list_user', function () {
    return view('do_exam_part1');
});
Route::post('list_user','ManagerController@getListUser')->name('delete');
Route::get('list_user','ManagerController@getListUser')->name('question_part1');
Route::post('list_user_account','ManagerController@deleteUser')->name('delete_user');
//do part 1

//Route::post('dopart1','QuestionController@question_part1')->name('question_part1');
Route::get('dopart1','QuestionController@question_part_1')->name('question_part1');
//do part 2

//Route::post('dopart2','QuestionController@question_part2')->name('question_part2');
Route::get('dopart2','QuestionController@question_part2')->name('question_part2');
//do part 3

//Route::post('dopart3','QuestionController@question_part3')->name('question_part3');
Route::get('dopart3','QuestionController@question_part3')->name('question_part3');
//do part 4

//Route::post('dopart4','QuestionController@question_part4')->name('question_part4');
Route::get('dopart4','QuestionController@question_part4')->name('question_part4');
//do part 5

//Route::post('dopart5','QuestionController@question_part5')->name('question_part5');
Route::get('dopart5','QuestionController@question_part5')->name('question_part5');
// do part 6

//Route::post('dopart6','QuestionController@question_part6')->name('question_part6');
Route::get('dopart6','QuestionController@question_part6')->name('question_part6');
// do part 7

//Route::post('dopart7','QuestionController@question_part7')->name('question_part7');
Route::get('dopart7','QuestionController@question_part7')->name('question_part7');


Route::get('list_account', function () {
    return view('list_account');
});

Route::post('list_account','UsersController@destroy');
Route::get('list_account','ManagerController@getListUser');
Route::get('submit', function () {
    return view('submit');
});
Route::get('list', function () {
    return view('list');
});
Route::get('list','ManagerController@getListUser');
Route::post('complete','QuestionController@submit_part1')->name('submit');

//Route::post('submit','QuestionController@submit')->name('submit1');
// Route::post('/submitpart1','SubmitController@submit');
Route::get('index', function () {
    return view('index');
});
Route::get('group','GroupController@group')->name('getGroup');
Route::post('group','GroupController@ListMember')->name('ListMember');
//Route::get('group', function () {
//    return view('group');
//});
Route::get('getExamID/{examID}','QuestionController@question_part1')->name('getExamID');
//
Route::get('home','GroupController@getListGroup')->name('group_ID');
Route::post('home','GroupController@getListGroup')->name('home');

// Group Detail
Route::get('groupDetail/{groupId}','GroupController@groupDetail')->name('groupDetail');
//Route::delete('groupDetail','GroupController@deleteMember')->name('deleteMember');
//delete member ajax
Route::delete('deleteMember/{memberId}','GroupController@deleteMember');
Route::delete('deleteUser/{accountId}','ManagerController@deleteUser');
Route::delete('deleteExam/{examId}','GroupController@deleteExam');
Route::delete('deleteGroup/{groupId}','GroupController@deleteGroup');
Route::delete('deleteQuestion/{questionId}','QuestionController@deleteQuestion');

Route::post('list_group','GroupController@addMember')->name('add_member');
Route::get('list_group','GroupController@getListGroup')->name('list_group');
//Route::get('list_group','ManagerController@getMember')->name('getMember');
Route::get('index','HomeController@index_page')->name('index');
Route::get('index','HomeController@index_page')->name('index');
Route::get('index','AuthController@logout')->name('logout');

Route::get('Home','HomeController@home_page')->name('Home');

// create exam
Route::get('upload/{examID}','QuestionController@uploadExam')->name('upload');
Route::post('createExam','GroupController@createExam')->name('createExam');

//get list question by Part
Route::get('getQuestionsByID/{questionId}','QuestionController@getQuestionsById')->name('getQuestionsById');
Route::get('getQuestionsByPart/{partId}','QuestionController@getQuestionsByPart')->name('getQuestionsByPart');
Route::post('getQuestionsByPart','QuestionController@updateQuestion')->name('updateQuestion');
Route::post('uploadQuestionPart2','QuestionController@updateQuestionPart2')->name('updateQuestionPart2');
Route::get('uploadPart1','QuestionController@getQuestionPart1')->name('uploadPart1');
Route::get('uploadPart2','QuestionController@getQuestionPart2')->name('uploadPart2');

Route::get('searchMember/{userName}','ManagerController@searchMember');
//get question Part 1
Route::get('listQuestionPart1/{examId}','QuestionController@question_part1')->name('listQuestionPart1');
//Get list Question By Acount
Route::get('listQuestion/{partId}','QuestionController@getListAnswerByAccount');

Route::post('addMember','ManagerController@addMember')->name('addMember');
//get answer user for continue
Route::post('continue','QuestionController@continueDoExam')->name('continue');

//Route::get('/thu', function () {
//    return view('compare');
//});
//Compare the answer

Route::get('examID/{examID}','QuestionController@getExamID');


Route::get('compare','QuestionController@showViewCompare')->name('listUserFinish');
Route::get('compareAnswer/{userID}','QuestionController@compareAnswer');
Route::get('listUserFinish','QuestionController@listUserFinish');
// get user answer
Route::get('userAnswerPart1','QuestionController@answerUserPart1');
Route::get('userAnswerPart2','QuestionController@answerUserPart2');

Route::get('listGroup','GroupController@listGroup')->name('listGroup');
Route::get('getGroupById/{groupId}','GroupController@getGroupById')->name('getGroupById');
Route::post('updateGroup','GroupController@updateGroup')->name('updateGroup');
Route::get('met', function () {
    return view('uploadExam.upload_exam_part7');
});
