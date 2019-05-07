<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Array_;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
//    public function doExam(Request $request,$examId){
//        session()->forget('examId');
//        $request->session()->put('examId',$examId);
//        return view('do_exam_master');
//    }
    public function uploadExam(Request $request,$examId){
        session()->forget('examId');
        $request->session()->put('examId',$examId);
        return view('uploadExam.upload');
    }

    public function getQuestionsById(Request $request, $questionId) {
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/getQuestionInformation/'.$questionId);
        $response = $req->getBody()->getContents();
        $Questions = json_decode($response, true);

        Log::info("Question  : ",$Questions);

        return json_encode($Questions);
    }

    public function getQuestionsByPart(Request $request, $partId) {
        $client = new \GuzzleHttp\Client();
        session()->forget('partId');
        $request->session()->put('partId',$partId);
        $examId=session('examId');
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/' . $partId);
        $response = $req->getBody()->getContents();
        $listQuestions = json_decode($response, true);

        Log::info("ExamID : ",$listQuestions);

        return json_encode($listQuestions);
    }
    public function deleteQuestion(Request $request,$questionId){
//        $member_id = json_decode($request->memberId);
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
        $req = $client->request('delete', 'http://192.168.20.152:8020/api/exam/'.$examId.'/deletequestion/'.$questionId);
        $response = $req->getBody()->getContents();
        $message = json_decode($response, true);
        Log::info("message: ", $message);
        return json_encode(["message" => $message]);
    }
    public function updateQuestion(Request $request)
    {
        $questionId=$request['questionId'];
        Log::info("Question ID --- : ".$questionId);
        $partId=$request['partId'];
//        $partId=session('partId');
        $ftp_server = "192.168.20.152";
        $ftp = "192.168.20.152/Part1";
        $dir = "Part1";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part1");
        $examId=session('examId');
        $questionNumber=$request['questionNumber'];
        $body = [
            'questionId'=> $questionId,
            'examId' => $examId,
            'questionNumber'=>$questionNumber,
            'part' => $partId,
            'fileMp3' => '',
            'image' => '',
            'correctAnswer' => ''
        ];
        if ($request->hasfile('mp3') && $request->hasfile('images'))
        {
                $fileMp3 = $request->file('mp3');
                $mp3FileName = $fileMp3->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part1/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $fileImage = $request->file('images');
                $imageFileName = $request->file('images')->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $fileImage, FTP_BINARY);
                $image = 'http://192.168.20.152:8069/Part1/' . $imageFileName;
                $body['image'] = $image;
                $correctAnswer = $request['correct_answer'];
                $body['correctAnswer'] = $correctAnswer;

        }
        else
        {   $Mp3 = $request['mp3Edit1'];
            Log::info("Mp33333 --- : ".$Mp3);
            $Image = $request['imagesEdit1'];
            $fileMp3=  'http://192.168.20.152:8069/Part1/' . $Mp3;
            Log::info("Mp33333 --- : ".$fileMp3);
            $fileImage=  'http://192.168.20.152:8069/Part1/' . $Image;
            Log::info("Imageeee --- : ".$fileImage);
            $body['fileMp3'] = $fileMp3;
            $body['image'] =$fileImage;
            $body['correctAnswer'] = $request['correct_answer'];;
        }

        Log::info("Question --- : ",$body);
        $data = json_encode($body);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('put', 'http://192.168.20.152:8020/api/exam/updatequestion',array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' => $data
        ));
        $response = $req->getBody();
        $data = json_decode($response);
        if (isset($data->messageReturnTrue)) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
        else{
            $message = $data->messageReturnFalse;
            return redirect()->back()->with('message', $message);
        }
    }
    public function updateQuestionPart2(Request $request)
    {
        $questionId=$request['questionId'];
        $partId=$request['partId'];
//        $partId=session('partId');
        $ftp_server = "192.168.20.152";
        $ftp = "192.168.20.152/Part2";
        $dir = "Part2";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part2");
        $examId=session('examId');
        $questionNumber=$request['questionNumber'];
        $body = [
            'questionId'=> $questionId,
            'examId' => $examId,
            'questionNumber'=>$questionNumber,
            'part' => $partId,
            'fileMp3' => '',
            'correctAnswer' => ''
        ];
        if ($request->hasfile('mp3'))
        {
            $fileMp3 = $request->file('mp3');
            $mp3FileName = $fileMp3->getClientOriginalName();
            ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
            $audio = 'http://192.168.20.152:8069/Part2/' . $mp3FileName;
            $body['fileMp3'] = $audio;
//            $fileImage = $request->file('images');
//            $imageFileName = $request->file('images')->getClientOriginalName();
//            ftp_put($ftp_conn, $imageFileName, $fileImage, FTP_BINARY);
//            $image = 'http://192.168.20.152:8069/Part1/' . $imageFileName;
//            $body['image'] = $image;
            $correctAnswer = $request['correct_answer'];
            $body['correctAnswer'] = $correctAnswer;

        }
        else
        {   $Mp3 = $request['mp3Edit2'];
            $fileMp3=  'http://192.168.20.152:8069/Part2/' . $Mp3;
            $body['fileMp3'] = $fileMp3;
//            $Image = $request['imagesEdit'];
//            $fileImage=  'http://192.168.20.152:8069/Part1/' . $Image;
//
//            $body['image'] =$fileImage;
            $body['correctAnswer'] = $request['correct_answer'];;
        }

        Log::info("Question --- : ",$body);
        $data = json_encode($body);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('put', 'http://192.168.20.152:8020/api/exam/updatequestion',array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' => $data
        ));
        $response = $req->getBody();
        $data = json_decode($response);
        if (isset($data->messageReturnTrue)) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
        else{
            $message = $data->messageReturnFalse;
            return redirect()->back()->with('message', $message);
        }
    }

//    public function showViewCompare(){
//        return view('compare');
//    }
    public function getExamID(Request $request,$examID){
        Log::info("EXAMMM : ".$examID);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getinformationexam/'.$examID);
        $response = $req->getBody();
        $examInfo = json_decode($response);
        $examId = $examInfo->examId;
        $request->session()->put('examId',$examId);
        Log::info("Exam Info : ".$examId);

        return view('compare',['examInfo'=>$examInfo]);
    }

    public function listUserFinish(){
        $examID=session('examId');
        Log::info("ExamID  : ".$examID);
        $user_id=session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getListAccountFinishExam/'.$user_id.'/'.$examID);
        $response = $req->getBody()->getContents();
        $listQuestions = json_decode($response, true);

        Log::info("listUserFinish : ",$listQuestions);
        return json_encode($listQuestions);
    }
    public function compareAnswer($userID){
        $client = new \GuzzleHttp\Client();
        $examID=session('examId');
        $user_id=session('user_id');
        if($userID==0){
            $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$user_id.'/'.$examID.'/getanswerkeyandcorrectanswer/0');
            $response = $req->getBody()->getContents();
            $listQuestions = json_decode($response, true);
            Log::info("ListAnswer : ",$listQuestions);
            return json_encode($listQuestions);
        }
        else{
            $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$user_id.'/'.$examID.'/getanswerkeyandcorrectanswer/'.$userID);
            $response = $req->getBody()->getContents();
            $listQuestions = json_decode($response, true);
            Log::info("ListAnswer : ",$listQuestions);
            return json_encode($listQuestions);
        }


    }
    public function getQuestionPart1(){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/1');
        Log::info("ExamID : ".$examId);
        $response = $req->getBody()->getContents();
        $listQuestions = json_decode($response, true);
        //$test = array($response);
        //Log::info("Account : ",$arrays);
        return view('uploadExam.upload',['listQuestionsPart1'=>$listQuestions]);

    }
    public function getQuestionPart2(){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/1');
        Log::info("ExamID : ".$examId);
        $response = $req->getBody()->getContents();
        $listQuestions = json_decode($response, true);
        //$test = array($response);
        //Log::info("Account : ",$arrays);
        return view('uploadExam.upload',['listQuestionsPart2'=>$listQuestions]);

    }
    public function question_part1(Request $request,$examId){
        $client = new \GuzzleHttp\Client();
//        $examId=session('examId');
//        $request->session()->put('examId',$examId);
        session()->forget('examId');
        $request->session()->put('examId',$examId);
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/1');
        Log::info("ExamID : ".$examId);
        $response = $req->getBody()->getContents();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Question --- : ",$arrays);

            return view('doExam.do_part1', ['arrays' => $arrays]);


    }
    public function question_part_1(Request $request){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
//        $request->session()->put('examId',$examId);
//        session()->forget('examId');
//        $request->session()->put('examId',$examId);
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/1');
        Log::info("ExamID : ".$examId);
        $response = $req->getBody()->getContents();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Question --- : ",$arrays);
        return view('doExam.do_part1',['arrays'=>$arrays]);

    }
    //get user answer
    public function answerUserPart1(Request $request){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
//        $request->session()->put('examId',$examId);
//        session()->forget('examId');
//        $request->session()->put('examId',$examId);
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/1');
        Log::info("ExamID : ".$examId);
        $response = $req->getBody()->getContents();
        $listAnswer = json_decode($response, true);

        Log::info("listUser : ",$listAnswer);
        return json_encode($listAnswer);

    }
    public function answerUserPart2(Request $request){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
//        $request->session()->put('examId',$examId);
//        session()->forget('examId');
//        $request->session()->put('examId',$examId);
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/2');
        Log::info("ExamID : ".$examId);
        $response = $req->getBody()->getContents();
        $listAnswer = json_decode($response, true);

        Log::info("listUser : ",$listAnswer);
        return json_encode($listAnswer);

    }
    public function question_part2(){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/2');
        $response = $req->getBody();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Account : ",$arrays);

        $part2 = array();
        $team1 = [
            'team' => 1,
            'fileMp3' => '',
            'questions' => []
        ];
        $team2 = [
            'team' => 2,
            'fileMp3' => '',
            'questions' => []
        ];
        $team3 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team4 = [
            'team' => 4,
            'fileMp3' => '',
            'questions' => []
        ];
        $team5 = [
            'team' => 5,
            'fileMp3' => '',
            'questions' => []
        ];
        $team6 = [
            'team' => 6,
            'fileMp3' => '',
            'questions' => []
        ];
        $team7 = [
            'team' => 7,
            'fileMp3' => '',
            'questions' => []
        ];
        $team8 = [
            'team' => 8,
            'fileMp3' => '',
            'questions' => []
        ];
        $team9 = [
            'team' => 9,
            'fileMp3' => '',
            'questions' => []
        ];
        $team10 = [
            'team' => 10,
            'fileMp3' => '',
            'questions' => []
        ];
        for($i=0;$i<count($arrays);$i++){
            Log::info("Part 2 --- TEAM : " . $arrays[$i]["team"]);
            $question = [
                'questionId' => $arrays[$i]["questionId"],
                'correctAnswer' => $arrays[$i]["correctAnswer"]
            ];

            switch ($arrays[$i]["team"]) {
                case 1:
                    $team1['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team1['questions'][] = $question;
                    break;
                case 2:
                    $team2['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team2['questions'][] = $question;
                    break;
                case 3:
                    $team3['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team3['questions'][] = $question;
                    break;
                case 4:
                    $team4['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team4['questions'][] = $question;
                    break;
                case 5:
                    $team5['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team5['questions'][] = $question;
                    break;
                case 6:
                    $team6['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team6['questions'][] = $question;
                    break;
                case 7:
                    $team7['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team7['questions'][] = $question;
                    break;
                case 8:
                    $team8['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team8['questions'][] = $question;
                    break;
                case 9:
                    $team9['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team9['questions'][] = $question;
                    break;
                case 10:
                    $team10['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team10['questions'][] = $question;
                    break;
            }

        }
        if(!empty($team1['fileMp3'])){
            $part2[] = $team1;

        }
        if(!empty($team2['fileMp3'])){
            $part2[] = $team2;

        }
        if(!empty($team3['fileMp3'])){
            $part2[] = $team3;

        }
        if(!empty($team4['fileMp3'])){
            $part2[] = $team4;

        }
        if(!empty($team5['fileMp3'])){
            $part2[] = $team5;

        }
        if(!empty($team6['fileMp3'])){
            $part2[] = $team6;

        }
        if(!empty($team7['fileMp3'])){
            $part2[] = $team7;

        }
        if(!empty($team8['fileMp3'])){
            $part2[] = $team8;

        }
        if(!empty($team9['fileMp3'])){
            $part2[] = $team9;

        }
        if(!empty($team10['fileMp3'])){
            $part2[] = $team10;

        }


//        $part2[] = $team5;

//        $part2[] = $team7;
//        $part2[] = $team8;
//        $part2[] = $team9;
//        $part2[] = $team10;
        Log::info("Part 2 : ",$part2 );
        return view('doExam.do_part2',['arrays'=>$part2]);

    }

    private function addQuestionToTeam($team, $question) {
        $team['questions'][] = $question;
    }
    public function question_part3(){
        $client = new \GuzzleHttp\Client();
        $examId=session('examId');
        $user_id=session('user_id');
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/3');
        $response = $req->getBody();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Account : ",$arrays);

        $part3 = array();
        $team1 = [
            'team' => 1,
            'fileMp3' => '',
            'questions' => []
        ];
        $team2 = [
            'team' => 2,
            'fileMp3' => '',
            'questions' => []
        ];
        $team3 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team4 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team5 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team6 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team7 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team8 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team9 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team10 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        for($i=0;$i<count($arrays);$i++){
            Log::info("Part 3 --- TEAM : " . $arrays[$i]["team"]);
            $question = [
                'questionName'=>$arrays[$i]["questionName"],
                'questionId' => $arrays[$i]["questionId"],
                'a'=>$arrays[$i]["a"],
                'b'=>$arrays[$i]["b"],
                'c'=>$arrays[$i]["c"],
                'd'=>$arrays[$i]["d"],
                'correctAnswer' => $arrays[$i]["correctAnswer"]
            ];

            switch ($arrays[$i]["team"]) {
                case 1:
                    $team1['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team1['questions'][] = $question;
                    break;
                case 2:
                    $team2['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team2['questions'][] = $question;
                    break;
                case 3:
                    $team3['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team3['questions'][] = $question;
                    break;
                case 4:
                    $team4['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team4['questions'][] = $question;
                    break;
                case 5:
                    $team5['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team5['questions'][] = $question;
                    break;
                case 6:
                    $team6['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team6['questions'][] = $question;
                    break;
                case 7:
                    $team7['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team7['questions'][] = $question;
                    break;
                case 8:
                    $team8['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team8['questions'][] = $question;
                    break;
                case 9:
                    $team9['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team9['questions'][] = $question;
                    break;
                case 10:
                    $team10['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team10['questions'][] = $question;
                    break;
            }

        }
        if(!empty($team1['fileMp3'])){
            $part3[] = $team1;

        }
        if(!empty($team2['fileMp3'])){
            $part3[] = $team2;

        }
        if(!empty($team3['fileMp3'])){
            $part3[] = $team3;

        }
        if(!empty($team4['fileMp3'])){
            $part3[] = $team4;

        }
        if(!empty($team5['fileMp3'])){
            $part3[] = $team5;

        }
        if(!empty($team6['fileMp3'])){
            $part3[] = $team6;

        }
        if(!empty($team7['fileMp3'])){
            $part3[] = $team7;

        }
        if(!empty($team8['fileMp3'])){
            $part3[] = $team8;

        }
        if(!empty($team9['fileMp3'])){
            $part3[] = $team9;

        }
        if(!empty($team10['fileMp3'])){
            $part3[] = $team10;

        }
//        $part2[] = $team3;
//        $part2[] = $team4;
//        $part2[] = $team5;
//        $part2[] = $team6;
//        $part2[] = $team7;
//        $part2[] = $team8;
//        $part2[] = $team9;
//        $part2[] = $team10;
        Log::info("Part 2 : ",$part3 );
        return view('doExam.do_part3',['arrays'=>$part3]);

    }
    public function question_part4()
    {
        $examId=session('examId');
        $user_id=session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/4');
        $response = $req->getBody();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Account : ", $arrays);

        $part4 = array();
        $team1 = [
            'team' => 1,
            'fileMp3' => '',
            'questions' => []
        ];
        $team2 = [
            'team' => 2,
            'fileMp3' => '',
            'questions' => []
        ];
        $team3 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team4 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team5 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team6 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team7 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team8 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team9 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        $team10 = [
            'team' => 3,
            'fileMp3' => '',
            'questions' => []
        ];
        for ($i = 0; $i < count($arrays); $i++) {
            Log::info("Part 4 --- TEAM : " . $arrays[$i]["team"]);
            $question = [
                'questionName' => $arrays[$i]["questionName"],
                'questionId' => $arrays[$i]["questionId"],
                'a' => $arrays[$i]["a"],
                'b' => $arrays[$i]["b"],
                'c' => $arrays[$i]["c"],
                'd' => $arrays[$i]["d"],
                'correctAnswer' => $arrays[$i]["correctAnswer"]
            ];

            switch ($arrays[$i]["team"]) {
                case 1:
                    $team1['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team1['questions'][] = $question;
                    break;
                case 2:
                    $team2['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team2['questions'][] = $question;
                    break;
                case 3:
                    $team3['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team3['questions'][] = $question;
                    break;
                case 4:
                    $team4['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team4['questions'][] = $question;
                    break;
                case 5:
                    $team5['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team5['questions'][] = $question;
                    break;
                case 6:
                    $team6['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team6['questions'][] = $question;
                    break;
                case 7:
                    $team7['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team7['questions'][] = $question;
                    break;
                case 8:
                    $team8['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team8['questions'][] = $question;
                    break;
                case 9:
                    $team9['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team9['questions'][] = $question;
                    break;
                case 10:
                    $team10['fileMp3'] = $arrays[$i]['fileMp3'];
                    $team10['questions'][] = $question;
                    break;
            }

        }
        if(!empty($team1['fileMp3'])){
            $part4[] = $team1;

        }
        if(!empty($team2['fileMp3'])){
            $part4[] = $team2;

        }
        if(!empty($team3['fileMp3'])){
            $part4[] = $team3;

        }
        if(!empty($team4['fileMp3'])){
            $part4[] = $team4;

        }
        if(!empty($team5['fileMp3'])){
            $part4[] = $team5;

        }
        if(!empty($team6['fileMp3'])){
            $part4[] = $team6;

        }
        if(!empty($team7['fileMp3'])){
            $part4[] = $team7;

        }
        if(!empty($team8['fileMp3'])){
            $part4[] = $team8;

        }
        if(!empty($team9['fileMp3'])){
            $part4[] = $team9;

        }
        if(!empty($team10['fileMp3'])){
            $part4[] = $team10;

        }
//        $part2[] = $team3;
//        $part2[] = $team4;
//        $part2[] = $team5;
//        $part2[] = $team6;
//        $part2[] = $team7;
//        $part2[] = $team8;
//        $part2[] = $team9;
//        $part2[] = $team10;
        Log::info("Part 2 : ", $part4);
        return view('doExam.do_part4', ['arrays' => $part4]);
    }
    public function question_part5()
        {
            $examId=session('examId');
            $user_id=session('user_id');
            $client = new \GuzzleHttp\Client();
            $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/5');
            $response = $req->getBody()->getContents();
            $arrays = json_decode($response, true);
            //$test = array($response);
            //Log::info("Account : ",$arrays);
            return view('doExam.do_part5',['arrays'=>$arrays]);

        }
    public function question_part6()
    {
        $examId=session('examId');
        $user_id=session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/6');
        $response = $req->getBody();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Account : ", $arrays);

        $part6 = array();
        $team1 = [
            'team' => 1,
            'image' => '',
            'questions' => []
        ];
        $team2 = [
            'team' => 2,
            'image' => '',
            'questions' => []
        ];
        $team3 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team4 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team5 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team6 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team7 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team8 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team9 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team10 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        for ($i = 0; $i < count($arrays); $i++) {
            Log::info("Part 6 --- TEAM : " . $arrays[$i]["team"]);
            $question = [
                'questionId' => $arrays[$i]["questionId"],
                'a' => $arrays[$i]["a"],
                'b' => $arrays[$i]["b"],
                'c' => $arrays[$i]["c"],
                'd' => $arrays[$i]["d"],
                'correctAnswer' => $arrays[$i]["correctAnswer"]
            ];

            switch ($arrays[$i]["team"]) {
                case 1:
                    $team1['image'] = $arrays[$i]['image'];
                    $team1['questions'][] = $question;
                    break;
                case 2:
                    $team2['image'] = $arrays[$i]['image'];
                    $team2['questions'][] = $question;
                    break;
                case 3:
                    $team3['image'] = $arrays[$i]['image'];
                    $team3['questions'][] = $question;
                    break;
                case 4:
                    $team4['image'] = $arrays[$i]['image'];
                    $team4['questions'][] = $question;
                    break;
                case 5:
                    $team5['image'] = $arrays[$i]['image'];
                    $team5['questions'][] = $question;
                    break;
                case 6:
                    $team6['image'] = $arrays[$i]['image'];
                    $team6['questions'][] = $question;
                    break;
                case 7:
                    $team7['image'] = $arrays[$i]['image'];
                    $team7['questions'][] = $question;
                    break;
                case 8:
                    $team8['image'] = $arrays[$i]['image'];
                    $team8['questions'][] = $question;
                    break;
                case 9:
                    $team9['image'] = $arrays[$i]['image'];
                    $team9['questions'][] = $question;
                    break;
                case 10:
                    $team10['image'] = $arrays[$i]['image'];
                    $team10['questions'][] = $question;
                    break;
            }

        }
        if(!empty($team1['image'])){
            $part6[] = $team1;

        }
        if(!empty($team2['image'])){
            $part6[] = $team2;

        }
        if(!empty($team3['image'])){
            $part6[] = $team3;

        }
        if(!empty($team4['image'])){
            $part6[] = $team4;

        }
        if(!empty($team5['image'])){
            $part6[] = $team5;

        }
        if(!empty($team6['image'])){
            $part6[] = $team6;

        }
        if(!empty($team7['image'])){
            $part6[] = $team7;

        }
        if(!empty($team8['image'])){
            $part6[] = $team8;

        }
        if(!empty($team9['image'])){
            $part6[] = $team9;

        }
        if(!empty($team10['image'])){
            $part6[] = $team10;

        }
//        $part6[] = $team1;
//        $part6[] = $team2;
//        $part6[] = $team3;
//        $part2[] = $team4;
//        $part2[] = $team5;
//        $part2[] = $team6;
//        $part2[] = $team7;
//        $part2[] = $team8;
//        $part2[] = $team9;
//        $part2[] = $team10;
        Log::info("Part 6 : ", $part6);
        return view('doExam.do_part6', ['arrays' => $part6]);
    }
    public function question_part7()
    {   $examId=session('examId');
        $user_id=session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/'.$examId.'/'.$user_id.'/getListQuestionByPart/7');
        $response = $req->getBody();
        $arrays = json_decode($response, true);
        //$test = array($response);
        Log::info("Account : ", $arrays);

        $part7 = array();
        $team1 = [
            'team' => 1,
            'image' => '',
            'questions' => []
        ];
        $team2 = [
            'team' => 2,
            'image' => '',
            'questions' => []
        ];
        $team3 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team4 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team5 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team6 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team7 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team8 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team9 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        $team10 = [
            'team' => 3,
            'image' => '',
            'questions' => []
        ];
        for ($i = 0; $i < count($arrays); $i++) {
            Log::info("Part 7 --- TEAM : " . $arrays[$i]["team"]);
            $question = [
                'questionName' => $arrays[$i]["questionName"],
                'questionId' => $arrays[$i]["questionId"],
                'a' => $arrays[$i]["a"],
                'b' => $arrays[$i]["b"],
                'c' => $arrays[$i]["c"],
                'd' => $arrays[$i]["d"],
                'correctAnswer' => $arrays[$i]["correctAnswer"]
            ];

            switch ($arrays[$i]["team"]) {
                case 1:
                    $team1['image'] = $arrays[$i]['image'];
                    $team1['questions'][] = $question;
                    break;
                case 2:
                    $team2['image'] = $arrays[$i]['image'];
                    $team2['questions'][] = $question;
                    break;
                case 3:
                    $team3['image'] = $arrays[$i]['image'];
                    $team3['questions'][] = $question;
                    break;
                case 4:
                    $team4['image'] = $arrays[$i]['image'];
                    $team4['questions'][] = $question;
                    break;
                case 5:
                    $team5['image'] = $arrays[$i]['image'];
                    $team5['questions'][] = $question;
                    break;
                case 6:
                    $team6['image'] = $arrays[$i]['image'];
                    $team6['questions'][] = $question;
                    break;
                case 7:
                    $team7['image'] = $arrays[$i]['image'];
                    $team7['questions'][] = $question;
                    break;
                case 8:
                    $team8['image'] = $arrays[$i]['image'];
                    $team8['questions'][] = $question;
                    break;
                case 9:
                    $team9['image'] = $arrays[$i]['image'];
                    $team9['questions'][] = $question;
                    break;
                case 10:
                    $team10['image'] = $arrays[$i]['image'];
                    $team10['questions'][] = $question;
                    break;
            }

        }
        if(!empty($team1['image'])){
            $part7[] = $team1;

        }
        if(!empty($team2['image'])){
            $part7[] = $team2;

        }
        if(!empty($team3['image'])){
            $part7[] = $team3;

        }
        if(!empty($team4['image'])){
            $part7[] = $team4;

        }
        if(!empty($team5['image'])){
            $part7[] = $team5;

        }
        if(!empty($team6['image'])){
            $part7[] = $team6;

        }
        if(!empty($team7['image'])){
            $part7[] = $team7;

        }
        if(!empty($team8['image'])){
            $part7[] = $team8;

        }
        if(!empty($team9['image'])){
            $part7[] = $team9;

        }
        if(!empty($team10['image'])){
            $part7[] = $team10;
        }
//        $part7[] = $team1;
//        $part7[] = $team2;
//        $part6[] = $team3;
//        $part2[] = $team4;
//        $part2[] = $team5;
//        $part2[] = $team6;
//        $part2[] = $team7;
//        $part2[] = $team8;
//        $part2[] = $team9;
//        $part2[] = $team10;
        Log::info("Part 7 : ", $part7);
        return view('doExam.do_part7', ['arrays' => $part7]);
    }
//
    public function continueDoExam(Request $request){
        $examId=session('examId');
        $user_id= session()->get('user_id');
        $questions = json_decode($request->myData1);
        $listAnswerUser = array();
        $body = [
            'examId' => $examId,
            'accountId' => $user_id,
            'listAnswerUser' => []
        ];
        try {
            foreach ($questions as $question) {
                Log::info("POST:" . $question->answerKey . " ---- " . $question->questionId);
                $answer = [
                    'answerKey' => $question->answerKey,
                    'questionId' => $question->questionId
                ];
                $listAnswerUser[] = $answer;
            };

            $body['listAnswerUser'] = $listAnswerUser;
            Log::info("POST PART 1:", $body);
            $data1 = json_encode($body);
            Log::info("User:" . $data1);
            $client = new \GuzzleHttp\Client();

            $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/createansweruser', array(
                'headers' => array('Content-Type' => 'application/json'),
                'body' => $data1
            ));
            $response = $req->getBody();
            $data = json_decode($response);
            Log::info("POST PART 1:" . $response);
            if (($data->messageId) == 33) {
                $message = $data->messageReturnTrue;
                return view('do_exam_master', ['message' => $message]);
            } else {
                $message = $data->messageReturnFalse;
                return view('do_exam_master', ['message' => $message]);

            }
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }
    public function getListAnswerByAccount($partId){

    }
    public function submit_part1(Request $request){
        $examId=session('examId');
        $user_id= session()->get('user_id');
        $questions = json_decode($request->myData);
        $listAnswerUser = array();
        $body = [
            'status'=>'finish',
            'examId' => $examId,
            'accountId' => $user_id,
            'listAnswerUser' => []
        ];
        try {

                foreach ($questions as $question) {
                    Log::info("POST PART 1:" . $question->answerKey . " ---- " . $question->questionId);
                    $answer = [
                        'answerKey' => $question->answerKey,
                        'questionId' => $question->questionId
                    ];
                    $listAnswerUser[] = $answer;
                };

            $body['listAnswerUser'] = $listAnswerUser;
            Log::info("POST PART 1:", $body);

            $data1 = json_encode($body);
            Log::info("User Answer:" . $data1);
            $client = new \GuzzleHttp\Client();
//        $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/createansweruser',  ['json' => [
//            'examId' => 1,
//            'accountId' =>$user_id,
//            'listAnswerUser'=>$data1
//        ]
//        ]);

                $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/createansweruser', array(
                    'headers' => array('Content-Type' => 'application/json'),
                    'body' => $data1
                ));

                $response = $req->getBody()->getContents();
                $data = json_decode($response, true);
//        $response = $req->getBody();
//        $data = json_decode($response);
                Log::info("Data :----", $data);
                if (isset($data->messageReturnTrue)) {

                    return json_encode($data);

                } else if (isset($data->messageReturnFalse)) {
                    return json_encode($data);

                }

        }catch (\Exception $e){
            return $e->getMessage();
        };
    }
}




