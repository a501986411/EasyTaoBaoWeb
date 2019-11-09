<?php


namespace app\admin\controller;

use app\admin\logic\Store as StoreLg;

class Store extends App
{
    public function index()
    {
        return view();
    }

    public function getList()
    {
        $where['uid'] = ['eq',$this->userInfo['id']];
        $logic = new StoreLg();
        $logic->setPageInfo(input('get.page',1),input('get.limit'));
        return $logic->getList($where);
    }

    public function showEdit()
    {
        return view('edit');
    }

    public function save()
    {
       $logic = new StoreLg();
       $result = $logic->saveData(input('post.'));
       return $result;
    }



}