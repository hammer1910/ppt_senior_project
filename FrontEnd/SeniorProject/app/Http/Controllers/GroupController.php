<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class GroupController extends Controller
{
    public function list_group(){
    return view('list_group');
    }

    public function create_Group(Request $request){
        Log::info("LOGIN");
        $id = session('user_id');
        $user = [
            'accountId'=>$id,
            'name' => $request->group_name,
            'description' => $request->description
        ];
        $data = json_encode($user);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/group/create', array(
            'headers' => array('Content-type' => 'application/json'),
            'body' => $data
        ));

        $response = $req->getBody();
        $data = json_decode($response);
        //Log::info("Group Info:",$data);
        //$message = $data->messageReturn;
        //$messaerror = $data->messageReturn;
        //$id = session()->get('user_id');


        if (($data->messageId) == 15) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        }
            //return redirect()->route('manager.user.profile',$id)->with(['id'=>$id,'lastname'=>$lastname,'firstname'=>$firstname,'phone'=>$phone,'address'=>$address]);
            //return redirect()->route('manager.user.profile',['data',$request->session()->get('user')]);
       // return redirect()->route('manager.user.create',$id)->with('message',$message);
    }
//    public function addMember(Request $request){
//            $id_group= $request['id_group'];
//            Log::info("GET ID Group".$id_group);
//            echo "true";
//    }
    public function getListGroup(){
        $id = session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistgroup/'.$id);
        $response = $req->getBody()->getContents();
        $arrays1 = json_decode($response, true);
        Log::info("GROUP",$arrays1);
       // return redirect()->route('Home')->with('arrays',$arrays);
        View::share('listGroups',$arrays1)  ;
        return view('Home',['arrays'=>$arrays1]);
    }

    // View group detail by groupId
    public function groupDetail(Request $request, $groupId){
        //get list group
        session()->forget('$groupId');
        $request->session()->put('groupId',$groupId);
        $examId=session('examId');
        $accountId = session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistgroup/'.$accountId);
        $response = $req->getBody()->getContents();
        $groups = json_decode($response, true);
        // get list member
        Log::info("GROUP ID: ".$groupId);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistmember/'.$groupId);
        $response = $req->getBody()->getContents();

        $members = json_decode($response, true);
        Log::info("Member:" ,$members);
        //get exam by Group
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistexam/'.$accountId.'/'.$groupId);
        $response = $req->getBody()->getContents();
        $listExam = json_decode($response, true);
        Log::info("Member:" ,$listExam);
        return view('groupExam.group_detail',['arrays' => $groups, 'members'=>$members,'groupId'=>$groupId,'listExams'=>$listExam]);


    }
//    public function getExamID(Request $request){
//        $examID = json_decode($request->idExam);
//        Log::info("Exam ID: ".$examID);
//    }
    public function createExam(Request $request){
        $name = $request->examName;
        Log::info("Exam name: ".$name);
        $groupId = $request->groupID;
        Log::info("Group ID: ".$groupId);
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/createexam',
            ['json' => [
                'name' => $name,
                'groupId'=>$groupId
            ],

            ]);
        $response = $req->getBody()->getContents();
        //$message = json_decode($response,true);
         $message = json_decode($response);
//        Log::info("MESSAGE: ", $message);
        if (($message->messageId) == 22) {
            $messages = $message->messageReturnTrue;
            return redirect()->back()->with('message', $messages);
        }
    }
    public function deleteMember(Request $request,$memberId){
//        $member_id = json_decode($request->memberId);
        Log::info("MEMBER ID: ".$memberId);
        $groupId = session('groupId');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('delete', 'http://192.168.20.152:8020/api/exam/deletemember/'.$groupId.'/'.$memberId);
        $response = $req->getBody()->getContents();
        $message = json_decode($response, true);
        Log::info("message: ", $message);
        return json_encode(["message" => $message]);
    }
    public function getGroupById(Request $request, $groupId) {
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getinformationgroup/'.$groupId);
        $response = $req->getBody()->getContents();
        $groupInfo = json_decode($response, true);
        Log::info("Question  : ",$groupInfo);

        return json_encode($groupInfo);
    }
    public function updateGroup(Request $request)
    {

        $groupId=$request['groupId'];
        $name =$request['groupName'];
        $description =$request['description'];
        $body = [
            'groupId'=> $groupId,
            'name' => $name,
            'description'=>$description,

        ];
        Log::info("Group Info: ", $body);
        $data = json_encode($body);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('put', 'http://192.168.20.152:8020/api/exam/updateinformationgroup',array(
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
    public function deleteGroup(Request $request,$groupId){
//        $member_id = json_decode($request->memberId);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('delete', 'http://192.168.20.152:8020/api/exam/deletegroup/'.$groupId);
        $response = $req->getBody()->getContents();
        $message = json_decode($response, true);
        Log::info("message: ", $message);
        return json_encode(["message" => $message]);
    }
    public function deleteExam(Request $request,$examId){
//        $member_id = json_decode($request->memberId);
        Log::info("Exam ID: ".$examId);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('delete', 'http://192.168.20.152:8020/api/exam/deletexam/'.$examId);
        $response = $req->getBody()->getContents();
        $message = json_decode($response, true);
        Log::info("message: ", $message);
        return json_encode(["message" => $message]);
//        return $request->idMember;
//        $member_id = json_decode($request->idMember);
//        Log::info("GROUP ID: ".$member_id);

    }
    public function listGroup(Request $request){
//        $member_id = json_decode($request->memberId);
        $id = session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistgroupowner/'.$id);
        $response = $req->getBody()->getContents();

        $listGroup = json_decode($response, true);
        return view('manageGroup',['listGroups' => $listGroup]);

    }




}
