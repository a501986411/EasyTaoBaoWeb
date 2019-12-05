<?php


namespace app\admin\model;


class UserStore extends Base
{
    protected $insert = ['uid'];
    protected function setUidAttr($value)
    {
        if(!$value){
            return $this->userInfo['id'];
        }
        return $value;
    }

}