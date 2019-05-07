<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
            'fullName' =>  'bail|required|string',
            'confirmpassword'=>'bail|required|same:password',
    ],
                [
                    'email.required'=>'Email is required',
                    'password.required'=>'Password is required',
                    'fullName.required'=>'Full Name is required',
                    'confirmpassword.required'=>'Confirm Password is required',

                ],
            [
                'email' =>'Email',
                'password' => 'Password',
                'fullName' =>'Full Name',
                'confirmpassword'=> 'Confirm Password'   ,
            ]

            );
        $email= $request['email'];
        $password = $request['password'];
        $fullname=$request['fullName'];
        $lastname=$request['lastname'];
        $client = new \GuzzleHttp\Client();
        $req = $client->post('http://192.168.20.152:8020/api/exam/register',
            [      'json' => [
                'email' => $email,
                'password' =>$password,
                'fullName'=>$fullname,
            ],

            ]);
        $response = $req->getBody();
        $data = json_decode($response);
        if (($data->messageReturnTrue) != 'You registered the account successfully!') {

            $message =$data->messageReturnTrue;
            return view('register',['message'=>$message]);

        } else {
           return redirect()->route('login');
        }

    }
    public function return(){
        return redirect()->route('login');
    }
    public function register_user(){
        return view('register');
    }
}
