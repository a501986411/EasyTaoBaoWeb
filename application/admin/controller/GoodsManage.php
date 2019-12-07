<?php


namespace app\admin\controller;


use app\admin\logic\BaseLogic;
use app\admin\logic\GoodsLogLogic;
use app\admin\logic\GoodsManageLogic;
use app\admin\logic\UserStore;
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

    public function hots()
    {
        return view();
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $logic = new GoodsManageLogic(new GoodsRelation());
        $logic->setPageInfo(input('get.page',1), input('get.limit'));
        $where['store_id'] = ['eq', $this->nowStoreInfo['id']];
        if(input('?get.title')){
            $title = input('get.title');
            if($title){
                $goodsMdl = new Goods();
                $goodsId = $goodsMdl->getGoodsIdByTitle($title);
                $where['own_goods_id|other_goods_id'] = ['in', $goodsId];
            }
        }
        if(input('?get.title_is_change')){
            $titleIsChange = input('get.title_is_change');
            if($titleIsChange){
                $where['title_is_change'] = ['eq',($titleIsChange-1)];
            }
        }
        $data = $logic->getList($where);
        return $data;
    }

    /**
     * 获取热销商品列表
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHotsList()
    {
        $logic = new UserStore();
        $wh['a.uid'] = ['eq',$this->userInfo['id']];
        $shopIds = $logic->getFollowStoreShopIds($wh);
        $shopIds = array_diff($shopIds,[0]);
        $where['shop_id'] = ['in', $shopIds];
        $logic = new \app\admin\logic\GoodsLogic();
        $logic->setPageInfo(input('get.page',1), input('get.limit'));
        $logic->order = ['monthly_sales'=>'desc'];
        if(input('?get.title')){
            $title = input('get.title');
            if($title){
                $where['title'] = ['like', $title];
            }
        }
        $data = $logic->getList($where);
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

    public function showSaleLog()
    {
        return view('show_sale_log');
    }

    public function getSaleLog()
    {
        $where['goods_id'] = ['eq',input('get.goods_id')];
        $where['create_time'] = ['>=',date("Y-m-d H:i:s", (time()-24*3600))];
        $logic = new GoodsLogLogic();
        $logic->setPageInfo(input('get.page',1),input('get.limit'));
        return $logic->getList($where);
    }

    public function delData()
    {
        if(Request::instance()->has('data')){
            $delPk = json_decode(input('post.data'),true);
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

    public function showEdit()
    {
        return view('edit');
    }



}