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
	    protected $nowStoreInfo;
		private $menuId;
		protected $beforeActionList = [
		    'interceptor' ,//拦截器
            'setUserInfo', //设置登录用户信息
            'setNowStore', //设置当前店铺信息
        ];


		public function __construct()
		{
		    parent::__construct();
		}

		protected function setUserInfo()
        {
            $this->userInfo = json_decode(cookie('user'),true);
        }
        protected function setNowStore()
        {
            $this->nowStoreInfo = json_decode(cookie('now_store'),true);
        }
        /**
         * 访问拦截器
         */
        protected function interceptor(){
            $logic = new LoginLogic(new AdminUser());
            if(!$logic->checkLoginStatus()){
                echo "<script>top.document.location.href='/Login/index';</script>";
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