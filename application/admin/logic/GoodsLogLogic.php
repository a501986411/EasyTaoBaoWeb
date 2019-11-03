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
        $data = $this->model->where($where)->order($this->order)->limit($this->offset, $this->pageSize)->select();
        $getTotal = count($data);
        for ($i = 0; $i < $getTotal; $i++) {
            if ($i != ($getTotal - 1)) {
                if (intval($data[$i]['monthly_sales']) != $data[$i]['monthly_sales']) { //处理 销量 x000+
                    $increase = intval($data[$i]['monthly_sales']) - intval($data[$i + 1]['monthly_sales']);
                    print_r($increase);die;
                    if ($increase == 0) {
                        $increase = "涨幅不足1000";
                    } else {
                        $increase = $increase.'+';
                    }
                } else {
                    $increase = $data[$i]['monthly_sales'] - $data[$i + 1]['monthly_sales'];
                }
                $data[$i]['monthly_sales'] = $increase;
            } else {
                $data[$i]['increase'] = 0;
            }
        }
        return $this->getPageList($data, $total);
    }
}