<?php


namespace app\admin\model;


use think\Model;

class Base extends Model
{
    public function getCreateTimeAttr($time)
    {
        return $time;//返回create_time原始数据，不进行时间戳转换。
    }
    public function getUpdateTimeAttr($time)
    {
        return $time;//返回create_time原始数据，不进行时间戳转换。
    }
}