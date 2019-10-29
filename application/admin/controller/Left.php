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
        return view('',['menuTree'=>$menuTree,'userInfo'=>$this->userInfo]);
    }
}