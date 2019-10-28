<?php
	/**
	 *
	 * Created by PhpStorm.
	 * User: knight
	 * Date: 2017/5/11
	 * Time: 10:48
	 */

	namespace app\admin\controller;
	use app\admin\logic\LoginLogic;
	use app\admin\model\AdminUser;
    use think\Controller;
    use think\Request;

	class Login extends Controller
	{

        /**
		 * 登录页面
		 * @access public
		 * @return \think\response\View
		 * @author knight
		 */
		public function index()
		{
			if(Request::instance()->isPost()){
				$username = input('post.username');
				$password = input('post.password');
				$logic = new LoginLogic(new AdminUser());
				if($logic->login($username,$password)){
					$this->success('登录成功',url('/GoodsManage/index'),'',1);
				} else {
					$this->error('用户名或者密码错误',url('/Login/index'));
				}
			} else{
				//登录页面 不需要模板布局
				$this->view->engine->layout(false);
				return view();
			}

		}

        /**
         * 退出操作
         */
		public function loginOut()
        {
            cookie(null,'admin_');
            $this->success('退出成功！',url('/Login/index'));
        }

	}