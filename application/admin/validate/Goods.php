<?php


namespace app\admin\validate;


use org\RouterosApi;
use think\Validate;

class Goods extends Validate
{
    protected $rule = [
        'own_goods_id|自己的商品ID'=>'require|number|checkSame',
        'other_goods_id|跟踪商品的ID'=>'require|number|checkSame',
        'own_goods_url|自己商品的URL'=>'require|url|checkSame',
        'other_goods_url|跟踪商品URL'=>'require|url|checkSame',
    ];

    /**
     *  验证服务器信息
     * @param $value
     * @param $rules
     * @param $data
     * @return bool|string
     */
    protected function checkSame($value, $rules, $data)
    {
        if($data['own_goods_id'] === $data['other_goods_id']){
            return '商品id不能相同';
        }
        if($data['own_goods_url'] === $data['other_goods_url']){
            return '商品URL不能相同';
        }
        return true;
    }
}