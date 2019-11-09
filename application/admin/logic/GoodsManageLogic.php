<?php


namespace app\admin\logic;


use app\admin\model\Goods;
use app\admin\model\GoodsRelation;
use app\admin\model\RouteService;
use think\Model;

class GoodsManageLogic extends BaseLogic
{
    protected $model;

    public function __construct(GoodsRelation $model)
    {
        parent::__construct();
        $this->model = $model;
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
        $ownGoodsId = array_column($list,'own_goods_id');
        $otherGoodsId = array_column($list,'other_goods_id');
        $goodsId = array_merge($ownGoodsId,$otherGoodsId);
        $goodsInfo = Goods::where('goods_id','in', $goodsId)->select();
        $goodsInfo = array_column($goodsInfo, null, 'goods_id');
        $logLogic = new GoodsLogLogic();
        $yesterdayInfo = $logLogic->getYesterdayLastOne($otherGoodsId);
        foreach ($list as $k=>$v){
            if(isset($goodsInfo[$v->own_goods_id])){
                $ownGoods = $goodsInfo[$v->own_goods_id];
                $v['own_title'] = $ownGoods['title'];
                $v['own_goods_url'] = $ownGoods['detail_url'];
                $v['cover_img'] = $ownGoods['cover_img'];
            }else{
                $v['own_title'] = '';
                $v['own_goods_url'] = '';
                $v['cover_img'] = '';
            }

            if(isset($goodsInfo[$v->other_goods_id])){
                $otherGoods = $goodsInfo[$v->other_goods_id];
                $v['other_title'] = $otherGoods['title'];
                $v['other_goods_url'] = $otherGoods['detail_url'];
                $v['monthly_sales'] = $otherGoods['monthly_sales'];
                $v['other_update_time'] = $otherGoods['update_time'];
            }else{
                $v['other_title'] = '';
                $v['monthly_sales'] = '';
                $v['other_update_time']= '';
            }
            $v['title_is_change_text'] = trim($v['other_title']) == trim($v['own_title']) ?
                                        '<span>未改变</span>' :
                                        '<span style="color: red;">已改变</span>';
            $v['yesterday_sales'] = isset($yesterdayInfo[$v['other_goods_id']]) ?
                $yesterdayInfo[$v['other_goods_id']]['monthly_sales'] : -1;
            $v['sales_diff'] = intval($v['monthly_sales']) - intval($v['yesterday_sales']);
        }
        return $this->getPageList($list,$total);
    }

    /**
     * 保存
     * @param $data
     * @return bool
     */
    public function saveLogic($data)
    {
        $result = $this->model->isUpdate($data['id'] ? true : false)->save($data);
        if($result === false){
            return false;
        }
        return true;
    }



}