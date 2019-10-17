<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 10:01
 */

namespace app\admin\logic;


use app\admin\model\RouteService;
use app\admin\model\ServerInfo;
use org\RouterosApi;
use org\RouterosInfo;
use think\Db;
use think\image\Exception;
use think\Model;

class ServiceLogic extends Model
{
    protected $model;
    protected $offset;
    protected $limit;
    protected $sortField;
    protected $sortWay;
    protected $way = ['asc'=>SORT_ASC,'desc'=>SORT_DESC];
    public function __construct(RouteService $model,$offset=0,$limit='',$sortField='id',$sortWay='desc')
    {
        parent::__construct();
        $this->model = $model;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->sortField = $sortField;
        $this->sortWay = $sortWay;
        if(!empty($this->limit)){
            $this->model->page($this->offset,$this->limit);
        }
    }

    /**
     * 保存
     * @param $data
     * @return bool
     */
    public function saveLogic($data)
    {
        $result = $this->model->isUpdate($data['id'] ? true : false)->save($data);
        if($result === false){
            return false;
        }
        return true;
    }

    /**
     * 获取列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList()
    {
        $list = $this->model
                     ->order('id','desc')
                     ->select();
        foreach ($list as $k=>$v){
            $v['overdue_str'] = $v->overdue_str;
        }
        return $list;
    }

    /**
     * 删除服务器信息
     * @param $delPk
     * @return array
     */
    public function delData($delPk)
    {
        $result = $this->model
            ->where('id','in',$delPk)
            ->delete();
        if($result===false){
            return ['success'=>false,'msg'=>lang('error server')];
        }
        return ['success'=>true,'msg'=>lang('success options')];
    }

    /**
     * 测试服务器是否能正常连接
     * @param $param
     * @return array
     */
    public function testLink($param)
    {
        $rosApi = new RouterosApi();
        if($rosApi->connect($param['domain'].':'.$param['port'],$param['username'],$param['password'])) {
            $rosApi->disconnect();
            return ['success'=>true,'msg'=>'连接成功'];
        } else {
            return ['success'=>false,'msg'=>'连接失败'];
        }
    }

    /**
     * 获取服务器状态列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRosStatusList(){
        $list = $this->model->select();
        $rosInfo = new ServerInfo();
        foreach ($list as $k=>&$v){
            unset($v['update_time']);
            $rosObj = $rosInfo->where('server_id',$v['id'])->find();
            if(is_null($rosObj)){
                $rosObj = new RouterosInfo($v['domain'],$v['port'],$v['username'],$v['password']);
            }
            $this->getRosInfo($rosObj,$v);
        }
        return $list;
    }

    /**
     * 获取ros信息
     * @access public
     * @param $rosObj
     * @param $v
     * @return void
     * @author knight
     */
    public function getRosInfo($rosObj,&$v)
    {
        $v['uptime'] = $rosObj->runTime;
        $v['version'] = $rosObj->version;//ROS系统版本
        $v['memory_float'] = $rosObj->memoryRate;
        $v['memory_ratio'] = ($rosObj->memoryRate * 100)."%" ;//内存占用率
        $v['cpu_float'] = $rosObj->cpuLoad;
        $v['cpu_ratio'] = $rosObj->cpuLoad.'%';
        $v['free_hdd_space'] = $rosObj->freeHddSpace;
        $v['active_float'] = round(($rosObj->onLineUserNum/(int)$v['max_number'])*100,2);
        $v['active_ratio'] = $v['active_float'].'%';
        $v['now_time'] = $rosObj->systemTime;
        $v['status'] = $rosObj->status;
        $v['update_t']  = isset($rosObj->update_time) ? $rosObj->update_time : date('Y-m-d H:i:s',time());
        $v['update_int']  = strtotime($v['update_t']);
    }

    /**
     * 获取一行数据
     * @access public
     * @param $id 服务器id
     * @return void
     * @author knight
     */
    public function getRowInfo($id){
        $ros = $this->model->find($id);
        $rosApi =  new RouterosInfo($ros['domain'],$ros['port'],$ros['username'],$ros['password']);
        $this->getRosInfo($rosApi,$ros);
        return $ros;
    }
}