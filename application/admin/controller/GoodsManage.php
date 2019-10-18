<?php


namespace app\admin\controller;


use app\admin\logic\GoodsManageLogic;
use app\admin\model\Goods;
use app\admin\model\GoodsRelation;
use think\Exception;
use think\Request;

class GoodsManage extends App
{
    protected $datetime_format = false;
    public function index()
    {
        return view();
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $logic = new GoodsManageLogic(new GoodsRelation());
        $data = $logic->getList($this->userInfo['id']);
        return $data;
    }

    public function save()
    {
        if(Request::instance()->isPost()){
            $data = input('post.');
            if(intval($data['own_goods_id']) == intval($data['other_goods_id'])){
                return ['success'=>false,'msg'=>'ID不能相同'];
            }
            $data['uid'] = isset($data['uid']) ? $data['uid'] : $this->userInfo['id'];
            //保存单个商品信息
            $goodsInfo[0]['goods_id'] = $data['own_goods_id'];
            $goodsInfo[0]['detail_url'] = $data['own_goods_url'];
            $goodsInfo[1]['goods_id'] = $data['other_goods_id'];
            $goodsInfo[1]['detail_url'] = $data['other_goods_url'];
            unset($data['own_goods_url'],$data['other_goods_url']);
            $goods = new Goods();
            try{
                $goods->startTrans();
                $logic = new GoodsManageLogic(new GoodsRelation());
                $result = $logic->saveLogic($data);
                if(!$result){
                    throw new Exception(lang('error server'));
                }
                $ret = $goods->saveAll($goodsInfo,$data['id']);
                if($ret === false){
                    throw new Exception(lang('error server'));
                }
                $goods->commit();
                return ['success'=>true,'msg'=>lang('success options')];
            }catch (Exception $e){
                $goods->rollback();
                return ['success'=>false,'msg'=>lang('error server')];
            }
        } else {
            throw new Exception(lang('error param'));
        }
    }
}