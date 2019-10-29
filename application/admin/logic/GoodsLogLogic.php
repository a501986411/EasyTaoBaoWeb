<?php


namespace app\admin\logic;


use app\admin\model\Goods;
use app\admin\model\GoodsLog;

class GoodsLogLogic extends BaseLogic
{
    protected $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new GoodsLog();
    }

    public function getList($where = [])
    {
        $total = $this->model->where($where)->count();
        $data = $this->model->where($where)->order($this->order)->limit($this->offset,$this->pageSize)->select();
        $getTotal = count($data);
        for ($i = 0;$i < $getTotal;$i++){
            if($i != ($getTotal-1)){
                $data[$i]['increase'] = $data[$i]['monthly_sales'] - $data[$i+1]['monthly_sales'];
            }else{
                $data[$i]['increase'] = 0;
            }
        }
        return $this->getPageList($data,$total);
    }
}