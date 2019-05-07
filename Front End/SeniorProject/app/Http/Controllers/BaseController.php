<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function __construct()
    {
        $id = session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistgroup/'.$id);
        $response = $req->getBody()->getContents();
        $arrays1 = json_decode($response, true);
        Log::info("GROUP",$arrays1);
        View::share('listGroups',$arrays1)  ;
    }
}
