<?php


namespace app\admin\model;


use think\Model;

class Base extends Model
{

    protected $userInfo;
    protected $nowStoreInfo;
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->setUserInfo();
        $this->setNowStoreInfo();
    }


    protected function setUserInfo()
    {
        $this->userInfo = json_decode(cookie('user'),true);
    }

    protected function setNowStoreInfo()
    {
        $this->nowStoreInfo = json_decode(cookie('now_store'), true);
    }

    public function getCreateTimeAttr($time)
    {
        return $time;//返回create_time原始数据，不进行时间戳转换。
    }
    public function getUpdateTimeAttr($time)
    {
        return $time;//返回create_time原始数据，不进行时间戳转换。
    }
}