<?php


namespace app\admin\validate;


use think\Validate;

class Store extends Validate
{
    protected $rule = [
        'name|店铺名称'=>'require',
        'url|店铺新品列表页URL'=>'require|url'
    ];

}