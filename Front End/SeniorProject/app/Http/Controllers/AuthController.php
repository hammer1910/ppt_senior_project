<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuzzlePost;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\JsonResponse;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class AuthController extends Controller
{
    //public function datauser(Request $request){
//    $user = [
//        'email' => $request->email,
//        'password' => $request->password
//    ];
//    $data = json_encode($user);
//    $client = new \GuzzleHttp\Client();
//    $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/login', array(
//        'headers' => array('Content-type' => 'application/json'),
//        'body' => $data
//    ));
//    Log::info("GET BODY");
//    $response = $req->getBody();
//    $data = json_decode($response);
//    //$message = $data->messageReturn;
//    $arr = array('accountId'=> $data->accountId,
//        'email'=> $data->email,
//        'password'=>$data->password,
//        'firstname'=>$data->firstname,
//        'lastname'=>$data->lastname,
//        'phone'=>$data->phone
//    );
//    $collections = collect();
//    $collections->push($arr);
//
//}

    public function login(Request $request)

    {
        Log::info("LOGIN");
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6'
        ]);
        $user = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $data = json_encode($user);
        $client = new \GuzzleHttp\Client();
        $req = $client->request('POST', 'http://192.168.20.152:8020/api/exam/login' , array(
            'headers' => array('Content-type' => 'application/json'),
            'body' => $data
        ));

        $response = $req->getBody();
        $data = json_decode($response);
//        Log::info("User". $data);
        //$message = $data->messageReturn;

        if(isset($data->messageReturnFalse))
            {   $messaerror =$data->messageReturnFalse;

                return redirect()->back()->with('messaerror',$messaerror) ;
            }

        if(isset($data->accountId)){

            $arr = array(   'accountId'=> $data->accountId,
                'email'=> $data->email,
                'password'=>$data->password,
                'fullName'=>$data->fullName,
                'address'=>$data->address,
                'phone'=>$data->phoneNumber
            );

            $fullName = $data->fullName;
            $phone = $data->phoneNumber;
            $address = $data->address;
            $id= $data->accountId;
            $email = $data->email;
            $request->session()->put('user_id',$id);
            $request->session()->put('fullName',$fullName);
            $request->session()->put('phone',$phone);
            $request->session()->put('email',$email);
          //
            //return view('user_profile',['id'=>$id,'lastname'=>$lastname,'firstname'=>$firstname,'phone'=>$firstname,'firstname'=>$firstname]);
          return redirect()->route('home');
            //return redirect()->route('manager.user.profile',['data',$request->session()->get('user')]);
    }

    }


    public function forgotPass(Request $request)
    {

            $this->validate($request, [
                'emailaddress' => 'bail|required|email',
            ],
                [
                    'emailaddress.required'=>'Email is required'

                ],
            [
                'emailaddress' =>'Email'

            ]);
            $emailaddress = $request['emailaddress'];
            $client = new \GuzzleHttp\Client();
            $req = $client->get('http://192.168.20.152:8020/api/exam/forgotpassword/'.$emailaddress);
            $response = $req->getBody();
            $data = json_decode($response);
            if (isset($data->messageReturnTrue)) {

                $message =$data->messageReturnTrue;
                return redirect()->route('login')->with('message',$message) ;
                    //view('login',['message'=>$message]);

            } else {
                return "Oops!";
            }
//        $data = new GuzzlePost();
//        $data->email=$request->get('email');
//        $data->save();
//        $response = $response->getBody()->getContents();
//        echo '<pre>';
//        print_r($response);


//    public function index()
//    {
//        $data = GuzzlePost::all();
//        return response()->json($data);
//    }
    }
    public function logout(){
        session()->flush();
        return redirect()->route('login');
    }
    public function user_login(){
        return view('login');
    }
}
