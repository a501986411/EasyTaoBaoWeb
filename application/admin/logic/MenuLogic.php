<?php
	/**
	 * 菜单操作基类
	 * User: knight
	 * Date: 2017/5/8
	 * Time: 16:12
	 */
	namespace app\admin\logic;
	use think\Model;
	use app\admin\model\AdminMenu;
	class MenuLogic extends Model
	{
		const STATUS_ONE = 1; //启用
		const STATUS_TWO = 2; //停用
        const IS_UPDATE_STATUS_TRUE = 1; //支持启停用操作
        const IS_UPDATE_STATUS_FALSE = 0;//不支持启停用操作
		protected $model;
		public function __construct()
		{
			parent::__construct();
		}

        /**
         * 坚持是否支持启用停用操作
         * @param $id
         * @return bool
         */
       public function checkIsUpdateStatus($id){
           $menu = $this->model->find($id);
           if($menu->is_update_status == self::IS_UPDATE_STATUS_FALSE){
               return false;
           }
           return true;
       }

        /**
		 * 修改菜单状态
		 * @access public
		 * @param $id
		 * @param $status
		 * @return bool
		 * @author knight
		 */
		public function changeStatus($id,$status)
		{
			if($status == self::STATUS_ONE){ //启用，同时启用本身及所有父节点
				return $this->startMenu($id);
			} else if($status == self::STATUS_TWO) { //停用，同时停用所有子节点
				return $this->stopMenu($id);
			}
		}

		/**
		 * 启用菜单
		 * 同时启用其所有上级节点
		 * @access public
		 * @param $id
		 * @return bool
		 * @author knight
		 */
		protected function startMenu($id)
		{
			$menu = $this->model->find($id);
			if(!empty($menu->path)){ //启用 上级菜单
				$pathArr = explode('-',$menu->path);
				$result = $this->model
					->where('id','in',$pathArr)
					->update(['status'=>self::STATUS_ONE]);
				if($result === false){
					return false;
				}
			}
			//启用自身
			$result = $this->model
				->where('id',$id)
				->update(['status'=>self::STATUS_ONE]);
			if($result === false){
				return false;
			}
			return true;

		}

		/**
		 * 停用菜单操作
		 * 同时停用起所有子节点
		 * @access public
		 * @param $id
		 * @return bool
		 * @author knight
		 */
		protected function stopMenu($id)
		{
			$result = $this->model->where('id',$id)
				->whereOr('path',$id)
				->whereOr('path','like',"-{$id}-")
				->whereOr('path','like',"-{$id}")
				->update(['status'=>self::STATUS_TWO]);
			if($result === false){
				return false;
			}
			return true;
		}

		/**
		 * 检查是否存在子节点
		 * @access public
		 * @param $id
		 * @return bool
		 * @author knight
		 */
		protected function isHasChildNode($id){
			$model = new AdminMenu();
			$menu = $model->field(['id'])->where(['pid'=>$id])->find();
			if($menu->id){
				return true;
			}
			return false;
		}
	}