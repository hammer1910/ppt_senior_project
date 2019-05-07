<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {   echo "11111";
//        $user = [
//            $id_user=$id
//        ];
//        $data = json_encode($user);
//        $client = new \GuzzleHttp\Client();
//        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getinformationaccount/' , array(
//            'headers' => array('Content-type' => 'application/json'),
//            'body' => $data
//        ));
//        Log::info("GET BODY");
//        $response = $req->getBody();
//        $data = json_decode($response);
//        //$message = $data->messageReturn;
//
//        if(isset($data->messageId))
//        {   $messaerror =$data->messageId;
//
//            echo $messaerror;
//        }
//
//        if(isset($data->accountId)){
//
//            $arr = array(
//                'firstname'=>$data->firstName,
//                'lastname'=>$data->lastName,
//                'address'=>$data->address,
//                'phone'=>$data->phone
//            );
//
//            $firstname = $data->firstName;
//            $lastname = $data->lastName;
//            $request->session()->put('user',$lastname);
//            $id= $data->accountId;
//echo "aaaaaaaaaaaa";
//            // echo $ID;
//            // return view('user_profile',['id'=>$id]);
//            //return redirect()->route('manager.user.profile',$firstname);
//            //return view('user_profile',$arr);
//
//        }


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = [
            'email'=>$request->email,
            'firstName' => $request->first_name,
            'lastName' => $request->last_name,
            'phone' => $request->phone_number,
            'address' => $request->address,
        ];
        $data = json_encode($user);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('PUT', 'http://192.168.20.152:8020/api/exam/updateinformationaccount/'.$id, array(
            'headers' => array('Content-type' => 'application/json'),
            'body' => $data
        ));
        Log::info("GET BODY");
        $response = $req->getBody();
        $data = json_decode($response);
        //$message = $data->messageReturn;

        if (isset($data->messageReturn)) {
            $messaerror = $data->messageReturn;

            return redirect()->route('manager.user.profile',$id)->with('messaerror', $messaerror);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {    $this->validate($request, [
        'password' => 'bail|required|min:6',
        'new_pass' => 'bail|required|min:6',
        'confirm_pass' =>  'bail|required|same:new_pass',

    ],
        [
            'password.required'=>'Password is required',
            'new_pass.required'=>'New password is required',
            'confirm_pass.required'=>'Confirm Password is required',

        ],
        [

            'password' => 'Password',
            'new_pass' =>'New Password',
            'confirm_pass'=> 'Confirm Password'   ,
        ]

    );
        $id= session()->get('user_id');
        $user = [
            'accountId'=>$id,
            'oldPassword' => $request->password,
            'newPassword' => $request->new_pass
        ];

        $data = json_encode($user);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/updatepasswordaccount', array(
            'headers' => array('Content-type' => 'application/json'),
            'body' => $data
        ));
        Log::info("GET BODY".$data );
        $response = $req->getBody();
        $data = json_decode($response);
        //$message = $data->messageReturn;

        if (isset($data->messageReturnTrue)) {
            $messaerror = $data->messageReturnTrue;
            Log::info("GET BODY". $messaerror);
            return redirect()->back()->with('messaerror', $messaerror);
        }
//
//        if (isset($data->accountId)) {
//
//            $arr = array('accountId' => $data->accountId,
//                'email' => $data->email,
//                'password' => $data->password,
//                'firstname' => $data->firstName,
//                'lastname' => $data->lastName,
//                'address' => $data->address,
//                'phone' => $data->phoneNumber
//            );
//
//            $firstname = $data->firstName;
//            $lastname = $data->lastName;
//            $phone = $data->phoneNumber;
//            $address = $data->address;
//            $request->session()->put('user', $lastname);
//            $id = $data->accountId;
//            // echo $ID;
//            //
//            //return view('user_profile',['id'=>$id,'lastname'=>$lastname,'firstname'=>$firstname,'phone'=>$firstname,'firstname'=>$firstname]);
//            return redirect()->route('manager.user.profile', $id)->with(['id' => $id, 'lastname' => $lastname, 'firstname' => $firstname, 'phone' => $phone, 'address' => $address]);
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
