<?php


namespace app\admin\controller;


use app\admin\logic\AdminMenuLogic;
use app\admin\model\AdminMenu;

class Left extends App
{
    public function left()
    {
        $adminMenuLogic = new AdminMenuLogic((new AdminMenu()));
        $menuTree = $adminMenuLogic->getTreeList();
        /**
         * 店铺
         */
        $storeLogic = new \app\admin\logic\Store();
        $where['uid'] = ['eq', $this->userInfo['id']];
        $storeList = $storeLogic->getSelectList($where);
        $nowStore = json_decode(cookie('now_store'), true);
        return view('',[
            'menuTree'=>$menuTree,
            'userInfo'=>$this->userInfo,
            "store_list" => $storeList,
            "now_store" => $nowStore,
            ]
        );
    }
}