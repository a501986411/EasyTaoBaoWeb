<?php


namespace app\admin\logic;


use app\admin\model\Goods;
use app\admin\model\GoodsRelation;
use app\admin\model\RouteService;
use think\Model;

class GoodsManageLogic extends Model
{
    protected $model;
    protected $offset;
    protected $limit;
    protected $sortField;
    protected $sortWay;
    protected $way = ['asc'=>SORT_ASC,'desc'=>SORT_DESC];

    public function __construct(GoodsRelation $model,$offset=1,$limit='',$sortField='id',$sortWay='desc')
    {
        parent::__construct();
        $this->model = $model;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->sortField = $sortField;
        $this->sortWay = $sortWay;
        if(!empty($this->limit)){
            $this->model->page($this->offset,$this->limit);
        }
    }


    /**
     * 获取列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList($uid)
    {
        $list = $this->model
            ->order($this->sortField,$this->way[$this->sortWay])
            ->where('uid','=', $uid)
            ->select();
        if(empty($list)){
            return [];
        }
        $ownGoodsId = array_column($list,'own_goods_id');
        $otherGoodsId = array_column($list,'other_goods_id');
        $goodsId = array_merge($ownGoodsId,$otherGoodsId);
        $goodsInfo = Goods::where('goods_id','in', $goodsId)->select();
        $goodsInfo = array_column($goodsInfo, null, 'goods_id');
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

            if(trim($v['own_title']) != trim($v['other_title'])){
                $v['title_is_change'] = '<span style="color: red;">已改变</span>';
            }else{
                $v['title_is_change'] = '<span style="color: green;">未改变</span>';
            }
        }
        return $list;
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