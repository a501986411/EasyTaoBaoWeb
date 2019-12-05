<?php


namespace app\admin\model;


use think\Model;

class Base extends Model
{
    const IS_DELETE_NO = 0;
    const IS_DELETE_YES = 1;
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
    /**
     * 获取启用状态数据
     * @access public
     * @param $query
     * @return void
     * @author knight
     */
    public function scopeIsDeleteNo($query){
        $query->where('is_delete',self::IS_DELETE_NO);
    }
}