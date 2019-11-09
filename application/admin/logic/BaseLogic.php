<?php


namespace app\admin\logic;


use phpDocumentor\Reflection\Types\Integer;
use think\Model;

class BaseLogic extends Model
{
    public $offset = 0;
    public $pageSize = 15;
    public $order = ['id' => 'desc'];

    public function __construct()
    {
        parent::__construct();
    }

    public function setPageInfo($page, $pageSize)
    {
        $this->pageSize = $pageSize ? $pageSize : $this->pageSize;
        $this->offset = $page ? ($page-1) * $this->pageSize : $this->offset;
    }

    public function setOrder($order = [])
    {
        $this->order = $order;
    }

    public function getPageList($data = [],$total = 0,$code = 0, $msg = '')
    {
       $ret = [];
       $ret['code'] = $code;
       $ret['count'] = $total;
       $ret['message'] = $msg;
       $ret['data'] = $data;
       return $ret;
    }

    public function success($msg = '操作成功')
    {
        return ['success'=>true, 'msg'=>$msg];
    }

    public function error($msg = '操作失败')
    {
        return ['success'=>false, 'msg'=> $msg];
    }


}