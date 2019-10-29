<?php


namespace app\admin\model;


use think\Model;

class Goods extends Base
{
    public function getGoodsIdByTitle($title){
        $data = $this->where('title','like','%'.$title.'%')->field('goods_id')->select();
        if($data){
            return array_column($data,'goods_id');
        }
        return [];
    }
}