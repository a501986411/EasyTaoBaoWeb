<?php


namespace app\admin\controller;

use app\admin\logic\Store as StoreLg;
use think\Request;

class Store extends App
{
    /**
     * 我的店铺列表页面
     * @return \think\response\View
     */
    public function index()
    {
        return view();
    }

    /**
     * 获取我的店铺列表
     * @return array
     */
    public function getList()
    {
        $where['uid'] = ['eq',$this->userInfo['id']];
        $logic = new StoreLg();
        $logic->setPageInfo(input('get.page',1),input('get.limit'));
        return $logic->getList($where);
    }

    /**
     * 查看店铺详情
     * @return \think\response\View
     */
    public function showEdit()
    {
        return view('edit');
    }

    /**
     * 保存店铺信息
     * @return array
     */
    public function save()
    {
       $logic = new StoreLg();
       $result = $logic->saveData(input('post.'));
       return $result;
    }

    /**
     * 设置当前店铺
     * @return array|void
     */
    public function setNowStore()
    {
        $storeId = input('store_id');
        $logic = new StoreLg();
        $res = $logic->setNowStore($this->userInfo['id'], $storeId);
        return ['success'=>$res];
    }


}