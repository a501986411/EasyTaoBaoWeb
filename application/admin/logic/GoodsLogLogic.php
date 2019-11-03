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
                if (strpos($data[$i]['monthly_sales'],'+') > -1) { //处理 销量 x000+
                    $increase = intval($data[$i]['monthly_sales']) - intval($data[$i + 1]['monthly_sales']);
                    if ($increase == 0) {
                        $increase = "涨幅不足1000";
                    } else {
                        $increase = $increase.'+';
                    }
                } else {
                    $increase = intval($data[$i]['monthly_sales']) - intval($data[$i + 1]['monthly_sales']);
                }
                $data[$i]['increase'] = $increase;
            } else {
                $data[$i]['increase'] = 0;
            }
        }
        return $this->getPageList($data, $total);
    }

    /**
     * 获取商品昨日结束时的销量
     * @param array $goodsId
     * @return array
     */
    public function getYesterdayLastOne($goodsId = [])
    {
        $map['create_time'] = ['<', date('Y-m-d 00:00:00')];
        if (is_array($goodsId)) {
            $map['goods_id'] = ['in', $goodsId];
        } else {
            $map['goods'] = ['eq', $goodsId];
        }
        $data = $this->model->where($map)->order('id desc')->group('goods_id')->column('*','goods_id');
        return $data;
    }
}