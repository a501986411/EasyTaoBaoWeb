<?php
/**
 * 服务器管理
 * User: Administrator
 * Date: 2017/5/12
 * Time: 21:22
 */

namespace app\admin\controller;


use app\admin\logic\ServiceLogic;
use think\Exception;
use think\Request;
use app\admin\model\RouteService as Service;
class RouteService extends App
{

    public function index()
    {
        return view();
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $logic = new ServiceLogic(new Service());
        $data = $logic->getList();
        return $data;
    }


    public function testLink()
    {
        if(Request::instance()->isPost()){
            if(!Request::instance()->has('domain')){
                return ['success'=>false,'msg'=>lang('error link params')];
            }
            if(!Request::instance()->has('port')){
                return ['success'=>false,'msg'=>lang('error link params')];
            }
            if(!Request::instance()->has('username')){
                return ['success'=>false,'msg'=>lang('error link params')];
            }
            if(!Request::instance()->has('password')){
                return ['success'=>false,'msg'=>lang('error link params')];
            }
            $param = input();
            $logic = new ServiceLogic(new Service());
            return $logic->testLink($param);
        } else{
            throw new Exception(lang('error param'));
        }
    }


    /**
     * 保存信息操作
     * @return array
     */
    public function save()
    {
        if(Request::instance()->isPost()){
            $data = input();
            $result = $this->validate($data,'ServiceInfo');
            if($result !== true){
                return ['success'=>false,'msg'=>$result];
            }
            $logic = new ServiceLogic(new Service());
            $result = $logic->saveLogic($data);
            if($result){
                return ['success'=>true,'msg'=>lang('success options')];
            }
            return ['success'=>false,'msg'=>lang('error server')];
        } else {
            throw new Exception(lang('error param'));
        }
    }

    /**
     * 删除服务器操作
     * @return array
     */
    public function delData()
    {
        if(Request::instance()->has('pkArr')){
            $delPk = json_decode(input('post.pkArr'),true);
            $logic = new ServiceLogic(new Service());
            return $logic->delData($delPk);
        } else {
            throw new Exception(lang('error param'));
        }
    }

    /**
     * ros状态列表
     * @return \think\response\View
     */
    public function rosStatusList()
    {
        return view('ros_index');
    }

    /**
     * 获取状态列表数据
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRosStatus()
    {   
        $logic = new ServiceLogic(new Service());
        return $logic->getRosStatusList();
    }

    /**
     * 获取单台服务器ROS信息
     * @access public
     * @return void
     * @author knight
     */
    public function getRowInfo()
    {
        if(Request::instance()->has('id')){
            $logic = new ServiceLogic(new Service());
            return $logic->getRowInfo(input('id'));
        } else {
            throw new Exception(lang('error param'));
        }
    }
}