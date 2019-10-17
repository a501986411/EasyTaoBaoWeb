<?php
	/**
	 *Action基类
	 * User: knight
	 * Date: 2017/4/24
	 * Time: 13:39
	 */
	namespace app\admin\controller;
	use app\admin\logic\LoginLogic;
    use app\admin\model\AdminUser;
    use think\Request;
    use think\Controller;
	class App extends Controller
	{
	    protected $userInfo;
		private $menuId;
		protected $beforeActionList = [
		    'interceptor' ,//拦截器
            'setMenuId',//设置菜单cookie 用于菜单回显
            'setUserInfo', //设置登录用户信息
        ];


		public function __construct()
		{
		    parent::__construct();
		}

		protected function setUserInfo()
        {
            $this->userInfo = json_decode(cookie('user'),true);
        }

        /**
         * 设置菜单Id缓存
         */
		protected function setMenuId(){

            if(Request::instance()->has('menuId')){
                $this->menuId = input('param.menuId');
                if($this->menuId){
                    cookie('menuId',$this->menuId);
                }
            }
        }

        /**
         * 访问拦截器
         */
        protected function interceptor(){
            $logic = new LoginLogic(new AdminUser());
            if(!$logic->checkLoginStatus()){
                $this->error(lang('login timeout'),url('/Login/index'));
            } else {
                cookie('user',cookie('user'));
            }
        }

		/**
		 * 空操作默认方法
		 * @access public
		 * @return string
		 * @author knight
		 */
		public function _empty()
		{
			return lang('error url');
		}

	}