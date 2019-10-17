<?php
namespace app\admin\validate;
use think\Validate;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 22:24
 */
class AdminMenuCheck extends Validate
{
    protected $rule = [
        'name'=>'require|unique:admin_menu',
        'sort'=>'integer|gt:0'
    ];

    protected $message =[
        'name.require' =>'名称为必填项',
        'name.unique'  =>'名称已存在',
        'sort.integer'=>'排序字段必须是整数',
        'sort.gt'=>'排序字段必须大于0'
    ];

    protected $scene =[
        'edit'=>['sort']
    ];
}