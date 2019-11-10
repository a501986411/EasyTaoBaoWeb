<?php


namespace app\admin\model;


class Store extends Base
{
    const IS_DELETE_NO = 0;
    const IS_DELETE_YES = 1;
    const IS_DEFAULT_NO = 0;
    const IS_DEFAULT_YES = 1;
    protected $auto = ['remark', 'uid', 'is_default'];
    protected function setRemarkAttr($value)
    {
        if($value){
            return $value;
        }
        return '';
    }

    protected function setUidAttr($value)
    {
        if(!$value){
            return $this->userInfo['id'];
        }
        return $value;
    }

    protected function setIsDefaultAttr($value)
    {
        if($value){
            $this->where("uid",'=', $this->userInfo['id'])->update(['is_default'=>0]);
            return $value;
        }
        return self::IS_DEFAULT_NO;
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