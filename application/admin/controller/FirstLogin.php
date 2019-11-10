<?php


namespace app\admin\controller;


use app\admin\logic\Store as StoreLg;
use think\Controller;

class FirstLogin extends Controller
{
    public function firstSetStore()
    {
        return view('first_set_store');
    }

    public function showEdit()
    {
        return view('edit');
    }

    public function save()
    {
        $logic = new StoreLg();
        $result = $logic->saveData(input('post.'));
        $userInfo = json_decode(cookie('user'), true);
        $logic->setNowStore($userInfo['id']);
        return $result;
    }
}