<?php
/**
 *
 * 菜单模型
 * User: knight
 * Date: 2017/5/3
 * Time: 10:41
 */
namespace app\admin\model;
use think\Model;

class AdminMenu extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'etb_admin_menu';

	protected $_status_one = ['id' => 1, 'name' => '启用'];
	protected $_status_two = ['id' => 2, 'name' => '停用'];
	protected $auto = ['path'];
	protected $insert = ['is_update_status'];
	protected function initialize()
	{
		parent::initialize();
	}

	/**
	 * 设置是否允许启停用操作
	 * @access public
	 * @return void
	 * @author knight
	 */
	protected function setIsUpdateStatusAttr()
	{
		if(!empty($this->pid)){
			$menu = $this->find($this->getAttr('pid'));
			return $menu->is_update_status;
		}
		return 1;
	}

	/**
	 * 设置路径
	 * 规则 是上级的path-pid
	 * @access public
	 * @return void
	 * @author knight
	 */
	public function setPathAttr()
	{
		if(!empty($this->pid)){
			$menu = $this->find($this->getAttr('pid'));
			return !empty($menu->path) ? $menu->path."-".$menu->id : $menu->id;
		}
		return '';
	}

	/**
	 * 菜单状态获取器 查询时不会自动调用
	 * @access public
	 * @param $value
	 * @return string
	 * @author knight
	 */
	public function getStatusNameAttr($value,$data){
		switch($data['status']){
			case $this->_status_one['id']:
				return $this->_status_one['name'];
			break;
			case $this->_status_two['id']:
				return $this->_status_two['name'];
				break;
			default :
				break;
		}
	}

	/**
	 * 上级菜单名称获取器 查询时不会自动调用
	 * @access public
	 * @param $value
	 * @return mixed|string
	 * @author knight
	 */
	public function getPidNameAttr($value,$data)
	{
		if($data['pid']){
			$adminMenu = $this->field('name')->find($data['pid']);
			if($adminMenu){
				return $adminMenu->getAttr('name');
			}
		}
	}

	/**
	 * 获取启用状态数据
	 * @access public
	 * @param $query
	 * @return void
	 * @author knight
	 */
	public function scopeStatusOne($query){
		$query->where('status',$this->_status_one['id']);
	}

}