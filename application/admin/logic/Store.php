<?php


namespace app\admin\logic;


use think\Model;
use think\Validate;

class Store extends BaseLogic
{
    protected $model;
    public function __construct()
    {
        $this->model = new \app\admin\model\Store();
    }

    public function saveData($data)
    {
        $validate = new \app\admin\validate\Store();
        $result = $validate->check($data);
        if($result !== true){
            return $this->error($validate->getError());
        }
        $ret = $this->model->isUpdate($data['id'])->save($data);
        if($ret === false){
            return $this->error();
        }
        return $this->success();
    }

    public function getList($where)
    {
        $total = $this->model->scope('IsDeleteNo')->where($where)->count();
        $data = $this->model->scope('IsDeleteNo')->where($where)->order($this->order)->limit($this->offset, $this->pageSize)->select();
        return $this->getPageList($data,$total);
    }
}