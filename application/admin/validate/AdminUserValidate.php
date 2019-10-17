<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 20:35
 */

namespace app\admin\validate;


use think\Validate;

class AdminUserValidate extends Validate
{
    protected $rule = [
        'username'=>'require|length:4,10',
        'password_hash|密码'=>'require|length:4,10',
        'old_password_hash|旧密码'=>'require',
        'new_password_hash1|新密码'=>'require|length:4,10|confirm:new_password_hash2',
        'new_password_hash2|确认密码'=>'require|length:4,10',

    ];
    protected $message = [
        'username.require' =>'用户名不能为空',
        'username.length' =>'用户名长度在4到10',
        'password_hash.require' =>'密码不能为空',
        'password_hash.length' =>'密码长度在4到10',
        'old_password_hash.require'=>'旧密码不能为空',
        'new_password_hash1.token'=>'请不要重复提交',
        'new_password_hash1.require'=>'请输入新密码',
        'new_password_hash1.length'=>'密码长度在4到10',
        'new_password_hash1.confirm'=>'两次密码输入不一致',

    ];
    protected $scene =[
        'updatePwd'=>['new_password_hash1','new_password_hash2','old_password_hash']
    ];
}