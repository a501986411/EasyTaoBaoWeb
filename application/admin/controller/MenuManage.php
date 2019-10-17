<?php
/**
 * 菜单管理
 * User: knight
 * Date: 2017/5/3
 * Time: 13:48
 */
namespace app\admin\controller;
use app\admin\model\AdminMenu;
use think\Db;
use think\image\Exception;
use \app\admin\logic\AdminMenuLogic;
use think\Request;

class MenuManage extends App
{

	public function __construct()
	{
		parent::__construct();

	}


	/**
	 * 菜单管理列表
	 * @access public
	 * @return \think\response\View
	 * @author knight
	 */
	public function index()
	{
		$logic = new AdminMenuLogic(new AdminMenu());
		$list = $logic->getMenuSelect();
		return view('',['pMenu'=>$list]);
	}

	/**
	 * 菜单管理列表
	 * @access public
	 * @return false|\PDOStatement|string|\think\Collection
	 * @author knight
	 */
	public function getList(){
		$logic = new AdminMenuLogic(new AdminMenu());
		$list = $logic->getList();
		return $list;
	}

	/**
	 * 改变菜单状态
	 * @access public
	 * @return void
	 * @author knight
	 */
	public function operateStatus()
	{
		if(input('?post.pkArr') && input('?post.status') ){
			$pkArr = json_decode(input('pkArr'),true);
			$status = input('status');
			Db::startTrans();
			try{
				$logic = new AdminMenuLogic(new AdminMenu());
				foreach($pkArr as $v){
				    if(!$logic->checkIsUpdateStatus($v)){ //检查是否支持启停用操作
                        throw new Exception(lang('no options'));
                    }
					if(false === $logic->changeStatus($v,$status)){
						throw new Exception(lang('error server'));
					}
				}
				Db::commit();
				return ['success'=>true,'msg'=>lang('success options')];
			}catch (Exception $e){
				Db::rollback();
				return ['success'=>false,'msg'=>$e->getMessage()];
			}
		} else {
			throw new Exception(lang('error param'));
		}
	}


	/**
	 * 保存菜单
	 * @access public
	 * @return array
	 * @author knight
	 */
	public function save()
	{
		if(Request::instance()->isPost()){
			$data = input();
			if($data['id']){
                $result = $this->validate($data,'AdminMenuCheck.edit');
            } else {
                $result = $this->validate($data,'AdminMenuCheck');
            }
			if($result !== true){
                return ['success'=>false,'msg'=>$result];
            }
			$logic = new AdminMenuLogic(new AdminMenu());
			$result = $logic->saveData($data);
			if($result){
				return ['success'=>true,'msg'=>lang('success options')];
			}
			return ['success'=>false,'msg'=>lang('error server')];
		} else {
			throw new Exception(lang('error param'));
		}

	}
}