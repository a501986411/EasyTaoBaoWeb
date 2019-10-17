<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 19:34
 */

namespace app\admin\controller;


use app\admin\logic\AdminUserLogic;
use think\Exception;
use think\Request;
class AdminUser extends App
{
    public function index()
    {
        return view();
    }

    /**
     *  获取管理员用户列表
     */
    public function getList()
    {
        $logic = new AdminUserLogic(new \app\admin\model\AdminUser());
        return $logic->getList();
    }

    /**
     * 保存
     * @return array
     */
    public function save()
    {
        if(Request::instance()->isPost()){
            $data['username'] = input('username');
            $data['password_hash'] = input('password_hash');
            $data['id']       = input('id');
            $result = $this->validate($data,'AdminUserValidate');
            if($result !== true){
                return ['success'=>false,'msg'=>$result];
            }
            $logic = new AdminUserLogic(new \app\admin\model\AdminUser());
            return $logic->saveUser($data);
        } else{
            throw new Exception(lang('error param'));
        }
    }

    /**
     * 重置密码
     * @return mixed
     */
    public function pwdReset()
    {
        if(Request::instance()->has('id')){
            $logic = new AdminUserLogic(new \app\admin\model\AdminUser());
            return $logic->pwdReset(input('post.id'));
        }else{
            throw new Exception(lang('error param'));
        }
    }

    /**
     * 操作状态
     * @return array
     * @throws Exception
     */
    public function operateStatus()
    {
        if(Request::instance()->isPost()){
            $logic = new AdminUserLogic(new \app\admin\model\AdminUser());
            return $logic->operateStatus(input('post.lab'),json_decode(input('post.id'),true));
        }else{
            throw new Exception(lang('error param'));
        }
    }

    /**
     * 修改密码
     * @access public
     * @return array|\think\response\View
     * @author knight
     */
    public function updatePwdIndex()
    {
        $userInfo = cookie('user');
        $userInfo = json_decode($userInfo,true);
        return view('updatePwd',['username'=>$userInfo['username'],'id'=>$userInfo['id']]);

    }

    /**
     * 修改密码
     * @access public
     * @return array
     * @author knight
     */
    public function updatePwd()
    {
        if(Request::instance()->isPost()){
            $result = $this->validate(input(),'AdminUserValidate.updatePwd');
            if($result !==true){
                return retFalse($result);
            }
            $logic = new AdminUserLogic(new \app\admin\model\AdminUser());
            return $logic->updatePwd(input());
        }else{
            throw new Exception(lang('error param'));
        }
    }
}