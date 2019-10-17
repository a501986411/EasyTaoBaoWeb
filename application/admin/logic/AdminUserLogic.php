<?php
/**
 * 后台管理员操作逻辑
 * User: Administrator
 * Date: 2017/5/16
 * Time: 19:54
 */

namespace app\admin\logic;

use app\admin\model\AdminUser;
use think\Model;

class AdminUserLogic extends Model
{
    protected $model;
    public function __construct(AdminUser $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * 获取后台用户列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList()
    {
        $list = $this->model->select();
        foreach ($list as $k=>&$v){
            $v['status_name'] = $v['status_name'];
            $v['last_login_time_str'] = $v['last_login_time_str'];
        }
        return $list;
    }

    /**
     *  保存用户数据
     * @param $data
     * @return array
     */
    public function saveUser($data)
    {
        $result = $this->model
            ->allowField(true)
            ->isUpdate($data['id'] ? true : false)
            ->save($data);
        if($result){
            return ['success'=>true,'msg'=>lang('success options')];
        }
        return ['success'=>true,'msg'=>lang('error server')];
    }

    /**
     * 重置密码
     * @return array
     */
    public function pwdReset($id)
    {
        $password = rand(12345,99999999);
        $data['password_hash'] = $password;
        $data['id'] = $id;
        $result = $this->model->allowField(['password_hash'])->save($data,['id'=>$data['id']]);
        if($result){
            return ['success'=>true,'msg'=>lang('success options').'新密码:'.$password];
        }
        return ['success'=>false,'msg'=>lang('error server')];
    }

    /**
     * 修改状态
     * @param $status int
     * @param $id array
     */
    public function operateStatus($status,$id)
    {
        $data['status'] = $status;
       $result = db('admin_user')->where('id','in',$id)->update($data);
       if($result === false){
           return ['success'=>false,'msg'=>lang('error server')];
       }
        return ['success'=>true,'msg'=>lang('success options')];
    }

    /**
     * @access public
     * @param $data
     * @return void
     * @author knight
     */
    public function updatePwd($data)
    {
        $passwordHash= $this->model
            ->where('id',$data['id'])
            ->field(['password_hash'])
            ->find();
        if(!$this->model->checkPassword($data['old_password_hash'],$passwordHash['password_hash'])){
            return retFalse(lang('error password'));
        }
        $newPwd['password_hash'] = $data['new_password_hash1'];
        $result = $this->model->allowField(['password_hash'])->save($newPwd,['id'=>$data['id']]);
        if($result === false){
            return  retFalse();
        }
        cookie(null,'admin_');
        return retTrue();
    }
}