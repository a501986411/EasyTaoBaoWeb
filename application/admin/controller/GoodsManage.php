<?php


namespace app\admin\controller;


use app\admin\logic\GoodsManageLogic;
use app\admin\model\Goods;
use app\admin\model\GoodsLog;
use app\admin\model\GoodsRelation;
use think\Exception;
use think\Request;

class GoodsManage extends App
{
    public function index()
    {
        return view('list');
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
            $result = $this->validate($data,'Goods');
            if($result !== true){
                return ['success'=>false,'msg'=>$result];
            }
            $data['uid'] = isset($data['uid']) ? $data['uid'] : $this->userInfo['id'];
            //保存单个商品信息
            $goodsInfo[0]['goods_id'] = $data['own_goods_id'];
            $goodsInfo[0]['detail_url'] = $data['own_goods_url'];
            $goodsInfo[1]['goods_id'] = $data['other_goods_id'];
            $goodsInfo[1]['detail_url'] = $data['other_goods_url'];
            unset($data['own_goods_url'],$data['other_goods_url']);
            try{
                $logic = new GoodsManageLogic(new GoodsRelation());
                $result = $logic->saveLogic($data);
                if(!$result) {
                    throw new Exception(lang('error server'));
                }
                foreach ($goodsInfo as $row){
                    if($row['goods_id']){
                        $goods = new Goods();
                        $info = $goods->where('goods_id',$row['goods_id'])->find();
                        $ret = $goods->isUpdate(isset($info['goods_id']))->save($row);
                        if($ret === false){
                            throw new Exception(lang('error server'));
                        }
                    }
                }
                return ['success'=>true,'msg'=>lang('success options')];
            }catch (Exception $e){
                return ['success'=>false,'msg'=>lang('error server')];
            }
        } else {
            throw new Exception(lang('error param'));
        }
    }

    public function getSaleLog()
    {
        $goodsId = input('get.goods_id');
        $logMdl = new GoodsLog();
        $data = $logMdl->where(['goods_id'=>$goodsId])
            ->where('create_time','>=', date("Y-m-d H:i:s", (time()-24*3600)))
            ->order('id','desc')->select();
        $total = count($data);
         for ($i = 0;$i < $total;$i++){
             if($i != ($total-1)){
                 $data[$i]['increase'] = $data[$i]['monthly_sales'] - $data[$i+1]['monthly_sales'];
             }else{
                 $data[$i]['increase'] = 0;
             }
        }
        return $data;
    }

    public function delData()
    {
        if(Request::instance()->has('pkArr')){
            $delPk = json_decode(input('post.pkArr'),true);
            $goodsRelationMdl = new GoodsRelation();
            $result = $goodsRelationMdl->where('id','in', $delPk)->delete();
            if($result===false){
                return ['success'=>false,'msg'=>lang('error server')];
            }
            return ['success'=>true,'msg'=>lang('success options')];
        } else {
            throw new Exception(lang('error param'));
        }
    }


}