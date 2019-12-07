<?php


namespace app\admin\logic;


class GoodsLogic extends BaseLogic
{
    protected $model;
    public function __construct()
    {
        $this->model = new \app\admin\model\Goods();
    }

    /**
     * @param $where
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($where)
    {
        $list = $this->model
            ->where($where)
            ->order($this->order)
            ->limit($this->offset,$this->pageSize)
            ->select();
        $total = $this->model->where($where)->count();
        if(empty($list)){
            return $this->getPageList();
        }
        $logLogic = new GoodsLogLogic();
        $yesterdayInfo = $logLogic->getYesterdayLastOne(array_column($list,'goods_id'));
        $fStoreLg = new FollowStoreLogic();
        $fWh['shop_id'] = ['in', array_column($list,'shop_id')];
        $fStoreInfo = $fStoreLg->getStoreInfoByWh($fWh);
        $fStoreInfo = array_column($fStoreInfo, null, "shop_id");
        foreach ($list as $k=>$v){
            $v['yesterday_sales'] = isset($yesterdayInfo[$v['goods_id']]) ?
                $yesterdayInfo[$v['goods_id']]['monthly_sales'] : -1;
            $v['sales_diff'] = intval($v['monthly_sales']) - intval($v['yesterday_sales']);
            $v['shop_name'] = $fStoreInfo[$v['shop_id']]['name'];
        }
        return $this->getPageList($list,$total);
    }

}