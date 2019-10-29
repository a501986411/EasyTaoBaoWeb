<?php


namespace app\admin\command;


use app\admin\model\Goods;
use app\admin\model\GoodsRelation;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class checkGoodsTitle extends Command
{
    protected function configure()
    {
        $this->setName('checkTitle')->setDescription('检查追踪商品标题是否发生改变');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln(date("Y-m-d H:i:s")."check title 开始执行");
        $this->checkTitle();
        $output->writeln(date("Y-m-d H:i:s")."check title 执行结束");

    }
    public function checkTitle()
    {
        $relationMdl = new GoodsRelation();
        $data = $relationMdl->limit(5000)->select();
        $ownGoodsId = array_column($data,'own_goods_id');
        $otherGoodsId = array_column($data,'other_goods_id');
        $goodsId = array_merge($otherGoodsId,$ownGoodsId);
        $goodsMdl = new Goods();
        $goodsInfo = $goodsMdl->where('goods_id','in', $goodsId)->column('goods_id,title');
        $isSame = [];
        $notSame = [];
        foreach ($data as $row){
            if($goodsInfo[$row['own_goods_id']] != $goodsInfo[$row['other_goods_id']]){
                $notSame[] = $row['id'];
            }else{
                $isSame[] = $row['id'];
            }
        }
        if($notSame){
            $relationMdl->where('id','in',$notSame)->update(['title_is_change' => 0]);
        }
        if($isSame){
            $relationMdl->where('id','in',$isSame)->update(['title_is_change' => 1]);
        }
        return true;
    }
}