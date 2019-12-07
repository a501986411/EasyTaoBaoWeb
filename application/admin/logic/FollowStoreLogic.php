<?php


namespace app\admin\logic;


class FollowStoreLogic extends BaseLogic
{
    protected $model;

    public function __construct()
    {
        $this->model = new \app\admin\model\FollowStore();
    }

    public function saveData($data)
    {
        $validate = new \app\admin\validate\FollowStore();
        $result = $validate->check($data);
        if($result !== true){
            return $this->error($validate->getError());
        }
        $store = $this->getStoreInfoByName($data['name']);
        if(empty($store)){ //不存在 需要新增店铺
            //保存店铺
            $ret = $this->model->isUpdate(!empty($data['id']))->save($data);
            if($ret === false){
                return $this->error();
            }
            $store['id'] = $this->model->getLastInsID();
        }
        //添加 用户与店铺的关注关系
        $userStoreLg = new UserStore();
        $ret = $userStoreLg->follow($store['id'], $data['uid']);
        if(!$ret['success']){
            return $this->error($ret['msg']);
        }
        return $this->success();
    }

    public function getStoreInfoByName($name)
    {
        $store = $this->model->scope('IsDeleteNo')->where(['name'=>trim($name)])->find();
        if($store){
            return $store->toArray();
        }
        return [];
    }

    public function getStoreInfoByStoreIds(array $storeIdArr = [])
    {
        if(empty($storeIdArr)){
            return [];
        }
        $store = $this->model->scope('IsDeleteNo')->where('id','in', $storeIdArr)->select();
        return $store;
    }

    public function getStoreInfoByWh($where)
    {
        if(empty($where)){
            return [];
        }
        $store = $this->model->scope('IsDeleteNo')->where($where)->select();
        return $store;
    }
}