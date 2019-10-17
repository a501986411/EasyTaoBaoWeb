<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 23:08
 */

namespace app\admin\logic;

use app\admin\model\RouteService;
use app\admin\model\ServerInfo;
use think\Log;
use think\Model;

class RosInfoLogic extends Model
{
    protected $model;
    public function __construct(ServerInfo $model)
    {
        parent::__construct();
        $this->model=$model;
    }

    /**
     * 保存服务器信息
     * @param $data
     * @return array
     */
    public function saveInfo($data)
    {
        $routeServer = new RouteService();
        if(isset($data['domain']) && !empty($data['domain'])){
            $routeId = $routeServer->getIdByDomain($data['domain']);
            if(!$this->model->find($routeId)){
                $data['server_id'] = $routeId;
                $result = $this->model->allowField(true)->save($data);
                if($result === false){
                    Log::write('服务器信息更新失败'.$this->model->getError(),'ERROR');
                    return retFalse();
                }
                return retTrue();
            } else {
                $result = $this->model->allowField(true)->isUpdate(true)->save($data,['server_id'=>$routeId]);
                if($result===false){
                    Log::write('服务器信息更新失败'.$this->model->getError(),'ERROR');
                    return retFalse();
                }
                return retTrue();
            }
        }
    }
}