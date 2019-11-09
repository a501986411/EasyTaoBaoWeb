<?php


namespace app\admin\model;


use think\Model;

class GoodsRelation extends Base
{
    protected $auto = ['store_id'];
    protected function setStoreIdAttr($value)
    {
        if($value){
            return $value;
        }
        return $this->nowStoreInfo['id'];
    }
}