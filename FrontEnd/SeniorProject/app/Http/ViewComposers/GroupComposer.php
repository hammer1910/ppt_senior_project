<?php

namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;

class GroupComposer{

    public function compose(View $view){
        $id = session('user_id');
        $client = new \GuzzleHttp\Client();
        $req = $client->request('get', 'http://192.168.20.152:8020/api/exam/getlistgroup/'.$id);
        $response = $req->getBody()->getContents();
        $arrays1 = json_decode($response, true);

        $view->with('listGroups',$arrays1);
    }
}
