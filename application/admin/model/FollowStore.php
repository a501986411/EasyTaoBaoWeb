<?php


namespace app\admin\model;


class FollowStore extends Base
{
    const TYPE_TB = 1; //淘宝
    const TYPE_TM = 2; //天猫
    const TYPE_KEY_WORDS = 'tmall';
    protected $typeText = [
        self::TYPE_TB => '淘宝',
        self::TYPE_TM => '天猫'
    ];
    protected $insert = ['remark', 'uid', 'type'];
    protected $auto = ['domain'];
    protected function setRemarkAttr($value)
    {
        if($value){
            return $value;
        }
        return '';
    }

    protected function setTypeAttr($value, $data)
    {
        return self::TYPE_TM;
        if(strpos( $data['domain'],self::TYPE_KEY_WORDS)){
            return self::TYPE_TM;
        }
        return self::TYPE_TB;
    }

    protected function setUidAttr($value)
    {
        if(!$value){
            return $this->userInfo['id'];
        }
        return $value;
    }
    protected function setDomainAttr($value,$data)
    {
        //默认是天猫
        return "https://" . $data['unique_key'] . ".m.tmall.com";
    }

}