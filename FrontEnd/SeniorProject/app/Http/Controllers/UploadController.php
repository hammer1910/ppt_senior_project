<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UploadController extends Controller
{
    public function upload_Part1(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part1');

    }

    public function upload_Part2(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part2');

    }

    public function upload_Part3(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part3');

    }

    public function upload_Part4(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part4');

    }

    public function upload_Part5(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part5');

    }

    public function upload_Part6(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part6');

    }

    public function upload_Part7(Request $request,$examID)
    {
        $request->session()->put('examId',$examID);
        return view('uploadExam.upload_exam_part7');

    }

    /**
     *
     */

    public function upload_partone(Request $request)
    {
        $examId = session('examId');
        $this->validate($request, [
            'mp3' => 'bail|required',
            'mp3.*' => 'mimes:mpga',
            'images' => 'bail|required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
                    'mp3.required'=>'File mp3 is required',
                    'images.required'=>'File Image is required',

                ],
            [
                'mp3' =>'File mp3',
                'images' => 'File image',
                'mp3.*' =>'File mp3',
                'images.*'=> 'File image'   ,
            ]
        );
        //$id = session()->get('user_id');
        $ftp_server = "192.168.20.152";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part1");
        //$file = "/home/walter/Downloads/user_profile.png";
        $body = [
            'examId' => $examId,
            'questionNumber'=>'',
            'part' => '1',
            'fileMp3' => '',
            'image' => '',
            'correctAnswer' => ''
        ];

        $data = [];
        $numberOfQuestions = sizeof($request['correct_answer']);
        Log::info("numberOfQuestions: " . $numberOfQuestions);
        $ftp = "192.168.20.152/Part1";
        $dir = "Part1";
        $count = $request->count;
        Log::info("COUNT: " . $count);
        if ($numberOfQuestions > 0 && $request->hasfile('mp3') && $request->hasfile('images')) {
            for ($i = 0; $i < $numberOfQuestions; $i++) {

                $body['questionNumber']=$count + 1;
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part1/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $fileImage = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $fileImage, FTP_BINARY);
                $image = 'http://192.168.20.152:8069/Part1/' . $imageFileName;
                $body['image'] = $image;
                $correctAnswer = $request['correct_answer'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $data[] = $body;
                $count++;
            }
        }
        Log::info("data: ", $data);
//        $correct_answer = $request['correct_answer'];
        $data1 = json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' => $data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);


        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }

    }
    public function upload_parttwo(Request $request)
    {
        $this->validate($request, [
        'mp3' => 'bail|required',
        'mp3.*' => 'mimes:mpga',
    ],
        [
            'mp3.required'=>'File mp3 is required',

        ],
        [
            'mp3' =>'File mp3',
            'mp3.*' =>'File mp3',
        ]
    );


        $examId=session('examId');
        $ftp_server = "192.168.20.152";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part2");
        $body=[
            'examId' =>$examId,
            'questionNumber'=>'',
            'part' => '2',
            'fileMp3'=>'',
            'correctAnswer' => '',
            'team'=>''
        ];

        $data=[];
        $numberOfQuestions1 = sizeof($request['correct_answer_1']);
        $numberOfQuestions2 = sizeof($request['correct_answer_2']);
        $numberOfQuestions3 = sizeof($request['correct_answer_3']);
        Log::info("numberOfQuestions1: " . $numberOfQuestions1);
        Log::info("numberOfQuestions2: " . $numberOfQuestions2);
        Log::info("numberOfQuestions3: " . $numberOfQuestions3);
        $ftp = "192.168.20.152/Part2";
        $dir = "Part2";

        if($numberOfQuestions1 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i <$numberOfQuestions1; $i++) {
                $body['questionNumber']=$request['questionNumber_1'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part2/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $correctAnswer = $request['correct_answer_1'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        if($numberOfQuestions2 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i < $numberOfQuestions2; $i++) {
                $body['questionNumber']=$request['questionNumber_2'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part2/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $correctAnswer = $request['correct_answer_2'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        if($numberOfQuestions3 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i < $numberOfQuestions3; $i++) {
                $body['questionNumber']=$request['questionNumber_3'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part2/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $correctAnswer = $request['correct_answer_3'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        Log::info("data: ", $data);
//        $correct_answer = $request['correct_answer'];
        $data1=json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' =>$data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);


        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
    }



    public function upload_partthree(Request $request)
    {
        $this->validate($request, [
            'mp3' => 'bail|required',
            'mp3.*' => 'mimes:mpga',
        ],
            [
                'mp3.required'=>'File mp3 is required',

            ],
            [
                'mp3' =>'File mp3',
                'mp3.*' =>'File mp3',
            ]
        );
        $examId=session('examId');
        $ftp_server = "192.168.20.152";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part3");
        $body=[
            'examId' =>$examId,
            'questionNumber'=>'',
            'part' => '3',
            'fileMp3'=>'',
            'questionName' => '',
            'a' => '',
            'b' => '',
            'c' => '',
            'd' => '',
            'correctAnswer' => '',
            'team' => ''
        ];

        $data=[];
        $numberOfQuestions1 = sizeof($request['question_1']);
        $numberOfQuestions2 = sizeof($request['question_2']);
        $numberOfQuestions3 = sizeof($request['question_3']);
        Log::info("numberOfQuestions1: " . $numberOfQuestions1);
        Log::info("numberOfQuestions2: " . $numberOfQuestions2);
        Log::info("numberOfQuestions3: " . $numberOfQuestions3);
        $ftp = "192.168.20.152/Part3";
        $dir = "Part3";
        if($numberOfQuestions1 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i <$numberOfQuestions1; $i++) {
                $body['questionNumber']=$request['questionNumber_4'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part3/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $questionName = $request['question_1'][$i];
                $body['questionName']=$questionName;
                $answer_a=$request['answer_1_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_1_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_1_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_1_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_1'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }

        if($numberOfQuestions2 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i < $numberOfQuestions2; $i++) {
                $body['questionNumber']=$request['questionNumber_5'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part3/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $questionName = $request['question_2'][$i];
                $body['questionName']=$questionName;
                $answer_a=$request['answer_2_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_2_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_2_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_2_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_2'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        if($numberOfQuestions3 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i < $numberOfQuestions3; $i++) {
                $body['questionNumber']=$request['questionNumber_6'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part3/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $questionName = $request['question_3'][$i];
                $body['questionName']=$questionName;
                $answer_a=$request['answer_3_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_3_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_3_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_3_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_3'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        Log::info("data: ", $data);
//        Log::info("data: ", $data);
////        $correct_answer = $request['correct_answer'];
        $data1=json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' =>$data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);


        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
    }
//

    public function upload_partfour(Request $request)
    {
        $this->validate($request, [
        'mp3' => 'bail|required',
        'mp3.*' => 'mimes:mpga',
    ],
        [
            'mp3.required'=>'File mp3 is required',

        ],
        [
            'mp3' =>'File mp3',
            'mp3.*' =>'File mp3',
        ]
    );
        $examId=session('examId');
        $ftp_server = "192.168.20.152";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part4");
        $body=[
            'examId' =>$examId,
            'questionNumber'=>'',
            'part' => '4',
            'fileMp3'=>'',
            'questionName' => '',
            'a' => '',
            'b' => '',
            'c' => '',
            'd' => '',
            'correctAnswer' => '',
            'team' => ''
        ];

        $data=[];
        $numberOfQuestions1 = sizeof($request['question_1']);
        $numberOfQuestions2 = sizeof($request['question_2']);
        $numberOfQuestions3 = sizeof($request['question_3']);
        Log::info("numberOfQuestions1: " . $numberOfQuestions1);
        Log::info("numberOfQuestions2: " . $numberOfQuestions2);
        Log::info("numberOfQuestions3: " . $numberOfQuestions3);
        $ftp = "192.168.20.152/Part4";
        $dir = "Part4";
        if($numberOfQuestions1 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i <$numberOfQuestions1; $i++) {
                $body['questionNumber']=$request['questionNumber_7'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part4/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $questionName = $request['question_1'][$i];
                $body['questionName']=$questionName;
                $answer_a=$request['answer_1_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_1_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_1_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_1_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_1'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }

        if($numberOfQuestions2 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i < $numberOfQuestions2; $i++) {
                $body['questionNumber']=$request['questionNumber_8'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part4/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $questionName = $request['question_2'][$i];
                $body['questionName']=$questionName;
                $answer_a=$request['answer_2_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_2_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_2_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_2_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_2'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        if($numberOfQuestions3 > 0 && $request->hasfile('mp3')) {
            for($i=0; $i < $numberOfQuestions3; $i++) {
                $body['questionNumber']=$request['questionNumber_9'][$i];
                $fileMp3 = $request->file('mp3')[$i];
                $mp3FileName = $request->file('mp3')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $mp3FileName, $fileMp3, FTP_BINARY);
                $audio = 'http://192.168.20.152:8069/Part4/' . $mp3FileName;
                $body['fileMp3'] = $audio;
                $questionName = $request['question_3'][$i];
                $body['questionName']=$questionName;
                $answer_a=$request['answer_3_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_3_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_3_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_3_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_3'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        Log::info("data: ", $data);
//        Log::info("data: ", $data);
////        $correct_answer = $request['correct_answer'];
        $data1=json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' =>$data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);


        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
//
    }

    public function upload_partfive(Request $request)
    {
        $examId=session('examId');
        $body=[
            'examId' =>$examId,
            'questionNumber'=>'',
            'part' => '5',
            'questionName'=>'',
            'a'=> '',
            'b'=> '',
            'c'=> '',
            'd'=> '',
            'correctAnswer' => ''
        ];

        $data=[];
        $count = $request->count5;
        $numberOfQuestions = sizeof($request['correct_answer']);
        Log::info("numberOfQuestions: " . $numberOfQuestions);
        if($numberOfQuestions > 0) {
            for($i=0; $i < $numberOfQuestions; $i++) {
                $body['questionNumber']=$count + 1;
                $questionName=$request['question'][$i];
                $body['questionName'] = $questionName;
                $answer_a=$request['answer_A'][$i];
                $body['a'] = $answer_a;
                $answer_b=$request['answer_B'][$i];
                $body['b'] = $answer_b;
                $answer_c=$request['answer_C'][$i];
                $body['c'] = $answer_c;
                $answer_d=$request['answer_D'][$i];
                $body['d'] = $answer_d;
                $correctAnswer = $request['correct_answer'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $data[]=$body;
                $count ++;
            }
        }
        Log::info("data: ", $data);
//        $correct_answer = $request['correct_answer'];
        $data1=json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' =>$data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);


        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
    }

    public function upload_partsix(Request $request)
    {
        $examId=session('examId');
        $ftp_server = "192.168.20.152";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part6");
        $body=[
            'examId' =>$examId,
            'questionNumber'=>'',
            'part' => '6',
            'image'=>'',
            'a' => '',
            'b' => '',
            'c' => '',
            'd' => '',
            'correctAnswer' => '',
            'team' => ''
        ];

        $data=[];
        $numberOfQuestions1 = sizeof($request['answer_1_A']);
        $numberOfQuestions2 = sizeof($request['answer_2_A']);
        $numberOfQuestions3 = sizeof($request['answer_3_A']);
        Log::info("numberOfQuestions1: " . $numberOfQuestions1);
        Log::info("numberOfQuestions2: " . $numberOfQuestions2);
        Log::info("numberOfQuestions3: " . $numberOfQuestions3);
        $ftp = "192.168.20.152/Part6";
        $dir = "Part6";
        if($numberOfQuestions1 > 0 && $request->hasfile('images')) {
            for($i=0; $i <$numberOfQuestions1; $i++) {
                $body['questionNumber']=$request['questionNumber_10'][$i];
                $image = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $image, FTP_BINARY);
                $images= 'http://192.168.20.152:8069/Part6/' . $imageFileName;
                $body['image'] = $images;
                $answer_a=$request['answer_1_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_1_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_1_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_1_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_1'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }

        if($numberOfQuestions2 > 0 && $request->hasfile('images')) {
            for($i=0; $i < $numberOfQuestions2; $i++) {
                $body['questionNumber']=$request['questionNumber_11'][$i];
                $image = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $image, FTP_BINARY);
                $images = 'http://192.168.20.152:8069/Part6/' . $imageFileName;
                $body['image'] = $images;
                $answer_a=$request['answer_2_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_2_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_2_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_2_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_2'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        if($numberOfQuestions3 > 0 && $request->hasfile('images')) {
            for($i=0; $i < $numberOfQuestions3; $i++) {
                $body['questionNumber']=$request['questionNumber_12'][$i];
                $image = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $image, FTP_BINARY);
                $images = 'http://192.168.20.152:8069/Part6/' . $imageFileName;
                $body['image'] = $images;
                $answer_a=$request['answer_3_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_3_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_3_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_3_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_3'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        Log::info("data: ", $data);
//        Log::info("data: ", $data);
////        $correct_answer = $request['correct_answer'];
        $data1=json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' =>$data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);


        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
    }

    public function upload_partseven(Request $request)
    {
        $examId=session('examId');
        $ftp_server = "192.168.20.152";
        $ftp_username = "FTP-User";
        $ftp_userpass = "123456";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        ftp_chdir($ftp_conn, "Part7");
        $body=[
            'examId' =>$examId,
            'questionNumber'=>'',
            'part' => '7',
            'image'=>'',
            'questionName' => '',
            'a' => '',
            'b' => '',
            'c' => '',
            'd' => '',
            'correctAnswer' => '',
            'team' => ''
        ];

        $data=[];
        $numberOfQuestions1 = sizeof($request['answer_1_A']);
        $numberOfQuestions2 = sizeof($request['answer_2_A']);
        $numberOfQuestions3 = sizeof($request['answer_3_A']);
        Log::info("numberOfQuestions1: " . $numberOfQuestions1);
        Log::info("numberOfQuestions2: " . $numberOfQuestions2);
        $ftp = "192.168.20.152/Part7";
        $dir = "Part7";
        if($numberOfQuestions1 > 0 && $request->hasfile('images')) {
            for($i=0; $i <$numberOfQuestions1; $i++) {
                $body['questionNumber']=$request['questionNumber_13'][$i];
                $image = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $image, FTP_BINARY);
                $images= 'http://192.168.20.152:8069/Part7/' . $imageFileName;
                $body['image'] = $images;
                $questionName=$request['question_1'][$i];
                $body['questionName'] = $questionName;
                $answer_a=$request['answer_1_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_1_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_1_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_1_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_1'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }

        if($numberOfQuestions2 > 0 && $request->hasfile('images')) {
            for($i=0; $i < $numberOfQuestions2; $i++) {
                $body['questionNumber']=$request['questionNumber_14'][$i];
                $image = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $image, FTP_BINARY);
                $images = 'http://192.168.20.152:8069/Part7/' . $imageFileName;
                $body['image'] = $images;
                $questionName=$request['question_2'][$i];
                $body['questionName'] = $questionName;
                $answer_a=$request['answer_2_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_2_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_2_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_2_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_2'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;
            }
        }
        if($numberOfQuestions3 > 0 && $request->hasfile('images')) {
            for($i=0; $i < $numberOfQuestions3; $i++) {
                $body['questionNumber']=$request['questionNumber_15'][$i];
                $image = $request->file('images')[$i];
                $imageFileName = $request->file('images')[$i]->getClientOriginalName();
                ftp_put($ftp_conn, $imageFileName, $image, FTP_BINARY);
                $images = 'http://192.168.20.152:8069/Part6/' . $imageFileName;
                $body['image'] = $images;
                $answer_a=$request['answer_3_A'][$i];
                $body['a']=$answer_a;
                $answer_b=$request['answer_3_B'][$i];
                $body['b']=$answer_b;
                $answer_c=$request['answer_3_C'][$i];
                $body['c']=$answer_c;
                $answer_d=$request['answer_3_D'][$i];
                $body['d']=$answer_d;
                $correctAnswer = $request['correct_answer_3'][$i];
                $body['correctAnswer'] = $correctAnswer;
                $body['team']=$i+1;
                $data[] = $body;

            }
        }
        Log::info("data: ", $data);
        $data1=json_encode($data);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createquestion', array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' =>$data1
        ));
        $response = $req->getBody();
        $data = json_decode($response);
        if (($data->messageId) == 29) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }

    }

}
