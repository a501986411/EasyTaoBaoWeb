<?php


namespace app\admin\controller;


use app\admin\logic\GoodsManageLogic;
use app\admin\logic\ServiceLogic;
use app\admin\model\GoodsRelation;
use app\admin\model\RouteService as Service;
use think\Exception;
use think\Request;

class GoodsManage extends App
{
    protected $datetime_format = false;
    public function index()
    {
        return view();
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $logic = new GoodsManageLogic(new GoodsRelation());
        $data = $logic->getList($this->userInfo['id']);
        return $data;
    }

    public function save()
    {
        if(Request::instance()->isPost()){
            $data = input('post.');
            $data['uid'] = isset($data['uid']) ? $data['uid'] : $this->userInfo['id'];
            $logic = new GoodsManageLogic(new GoodsRelation());
            $result = $logic->saveLogic($data);
            if($result){
                return ['success'=>true,'msg'=>lang('success options')];
            }
            return ['success'=>false,'msg'=>lang('error server')];
        } else {
            throw new Exception(lang('error param'));
        }
    }
}