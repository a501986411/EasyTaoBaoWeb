<?php


namespace app\admin\controller;


use app\admin\logic\FollowStoreLogic;
use app\admin\logic\Store as StoreLg;
use app\admin\logic\UserStore;

class FollowStore extends App
{
    public function index()
    {
        return view();
    }

    public function edit()
    {
        return view();
    }

    public function save()
    {
        $logic = new FollowStoreLogic();
        $data = input('post.','trim');
        $data['uid'] = $this->userInfo['id'];
        $result = $logic->saveData($data);
        return $result;
    }

    public function getList()
    {
        $where['uid'] = ['eq',$this->userInfo['id']];
        $logic = new UserStore();
        $logic->setPageInfo(input('get.page',1),input('get.limit'));
        return $logic->getList($where);
    }
}