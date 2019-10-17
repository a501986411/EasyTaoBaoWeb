<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 9:42
 */

namespace app\admin\validate;


use org\RouterosApi;
use think\Validate;

class ServiceInfo extends Validate
{
    protected $rule = [
//        'name'=>'require|string|length:1,30',
        'domain'=>'unique:route_service|checkDomain',
        'port'=>'require|integer|length:4',
        'username'=>'require',
        'password'=>'require'
    ];

    /**
     *  验证服务器信息
     * @param $value
     * @param $rules
     * @param $data
     * @return bool|string
     */
    protected function checkDomain($value, $rules, $data)
    {
        $rosApi = new RouterosApi();
        if($rosApi->connect($data['domain'].':'.$data['port'],$data['username'],$data['password'])){
            return true;
        }
        return '请输入正确的服务器连接信息';
    }
}