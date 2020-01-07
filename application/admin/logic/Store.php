<?php


namespace app\admin\logic;


use app\admin\logic\Store as StoreLg;
use think\Model;
use think\Request;
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

    public function getSelectList($where)
    {
        $data = $this->model->scope('IsDeleteNo')->where($where)->order($this->order)->limit($this->offset, $this->pageSize)->select();
        return $data;
    }

    public function getList($where)
    {
        $total = $this->model->scope('IsDeleteNo')->where($where)->count();
        $data = $this->model->scope('IsDeleteNo')->where($where)->order($this->order)->limit($this->offset, $this->pageSize)->select();
        return $this->getPageList($data,$total);
    }

    public function setNowStore($uid, $store_id = 0)
    {
        if ($store_id) {
            $where['id'] = ['eq', $store_id];
        } else {
            $where['is_default'] = ['eq', \app\admin\model\Store::IS_DEFAULT_YES];
        }
        $where['uid'] = ['eq', $uid];
        $nowStore = $this->model->scope('IsDeleteNo')->where($where)->find()->toArray();
        cookie('now_store', json_encode($nowStore, JSON_UNESCAPED_UNICODE), 0);
        return true;
    }

    /**
     * 该用户是否设置店铺
     * @param $uid
     * @return int|string
     */
    public function isExistStore($uid)
    {
        $where['uid'] = ['eq', $uid];
        $storeNum = $this->model->scope('IsDeleteNo')->where($where)->count();
        return $storeNum;
    }
}