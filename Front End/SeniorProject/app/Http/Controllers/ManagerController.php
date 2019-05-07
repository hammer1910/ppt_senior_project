<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ManagerController extends Controller
{

//    public function user($id){
//
//
//        return view('user_profile',['id'=>$id]);
//    }
    public function user(Request $request){
        $id= session()->get('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getinformationaccount/'.$id);
        Log::info("GET BODY");
        $response = $req->getBody();
        $data = json_decode($response);
        Log::info("BODY Response: " . $response);
        //$message = $data->messageReturn;
        if(isset($data->messageId))
        {   $messaerror =$data->messageId;

            echo $messaerror;
        }

        if(isset($data->accountId)){
            $email=$data->email;
            $fullName = $data->fullName;
            $phone = $data->phone;
            $address = $data->address;

           $request->session()->put('fullName',$fullName);
            $id= $data->accountId;
            return view('user_profile',['id'=>$id,'email'=>$email,'fullName'=>$fullName,'phone'=>$phone,'address'=>$address]);
        }

//        // TODO - You should to show the error message if no user information found
//       return view('user_profile',['id'=>$id]);
    }
    public function changepass(){
        return view('change_pass');
    }
    public function list(){
        return view('list_account');
    }

    public function deleteUser(Request $request,$accountId){
//        $member_id = json_decode($request->memberId);
        Log::info("MEMBER ID: ".$accountId);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('delete', 'http://192.168.20.152:8020/api/exam/deleteaccount/'.$accountId);
        $response = $req->getBody()->getContents();
        $message = json_decode($response, true);
        Log::info("message: ", $message);
        return json_encode(["message" => $message]);

    }
    public function getListUser(){
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getallaccounts');
        $response = $req->getBody()->getContents();
        $arrays = json_decode($response, true);
        Log::info("Account : ",$arrays);
        return view('list_user',['arrays'=>$arrays]);
    }
    public function getMember(){
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getallaccounts');
        $response = $req->getBody()->getContents();
        $arrays = json_decode($response, true);
        Log::info("Account : ",$arrays);

        //return view('list',['arrays',$arrays]);

        return view('list_group',['datas'=>$arrays]);
    }

    public function searchMember(Request $request,$user){
        $client = new \GuzzleHttp\Client();
        Log::info("List Member: ".$user);
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/searchmember/'.$user);
        $response = $req->getBody()->getContents();
        $listMember= json_decode($response, true);
        Log::info("List Member: ",$listMember);
        return json_encode($listMember);
    }

    public function addMember(Request $request)
    {
        $groupId=session('groupId');
        $accountId=$request['accountId'];
        Log::info("Account ==-==: ".$accountId);
        $client = new \GuzzleHttp\Client();
        Log::info("Part ID: ".$groupId);
        $req = $client->request('post', 'http://192.168.20.152:8020/api/exam/group/addmembers/'.$groupId ,
            [      'json' => [
                'accountID' => $accountId,
            ],
        ]);
        $response = $req->getBody();
        $data = json_decode($response);
        if (isset($data->messageReturnTrue)) {
            $message = $data->messageReturnTrue;
            return redirect()->back()->with('message', $message);
        } else{
            $message = $data->messageReturnFalse;
            return redirect()->back()->with('message', $message);
            }
    }

//    public function deleteUser(Request $request){
//        $id =$request->data;
//        Log::info("ID :".$id);
//        $client = new \GuzzleHttp\Client();
//        $req = $client->request('Delete', 'http://192.168.20.152:8020/api/exam/deleteaccount/'.$id );
//        $response = $req->getBody();
//        $data = json_decode($response);
//        Log::info("BODY Response: ". $response);
//        //$message = $data->messageReturn;
//
//        if(isset($data->messageReturnTrue))
//        {   $messaerror =$data->messageReturnTrue;
//            return view('list_user')->with('messaerror',$messaerror);
////            echo $messaerror;
//        }
//
//            else{
//                $messaerror =$data->messageReturnFalse;
//
//                echo $messaerror;
//            }
//    }

    public function profile(){
        return view('ad_profile');
    }
    public function adchangepass(){
        return view('ad_change_pass');
    }
    public function creategroup(){
        return view('create_group');
    }
    public function add_member(){
        return view('group_master');
    }
}
