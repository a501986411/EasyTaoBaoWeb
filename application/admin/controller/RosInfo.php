<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 21:08
 */

namespace app\admin\controller;


use app\admin\logic\RosInfoLogic;
use app\admin\model\ServerInfo;
use think\Controller;
use think\Log;
use think\Request;

class RosInfo extends Controller
{
    public function getApi()
    {
        if(Request::instance()->isGet()){
            $data = input();
            $logic = new RosInfoLogic(new ServerInfo());
            $logic->saveInfo($data);
        } else {
            Log::write(lang('error param'),'ERROR');
        }
    }
}