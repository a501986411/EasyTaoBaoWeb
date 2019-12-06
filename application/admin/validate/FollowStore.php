<?php


namespace app\admin\validate;


use think\Validate;

class FollowStore extends Validate
{
    protected $rule = [
        'name|店铺名称'=>'require',
        'unique_key|店铺唯一标识'=>'require'
    ];
}