<?php
	/**
	 * 后台用户管理模型
	 * Created by PhpStorm.
	 * User: knight
	 * Date: 2017/5/11
	 * Time: 13:37
	 */

	namespace app\admin\model;
	use think\Model;
	class AdminUser extends Model
	{
        // 设置当前模型对应的完整数据表名称
        protected $table = 'etb_user';
		protected $_status_zero = ['id' => 0, 'name' => '停用'];
		protected $_status_one = ['id' => 1, 'name' => '启用'];
		protected $insert = ['status','password_hash'];

		protected function initialize()
		{
			parent::initialize();
		}

        /**
         * 获取状态名称
         * @param $value
         * @param $data
         * @return mixed
         */
		public function getStatusNameAttr($value,$data)
        {
            switch ($data['status']){
                case $this->_status_one['id']:
                    return $this->_status_one['name'];
                    break;
                case $this->_status_zero['id']:
                    return $this->_status_zero['name'];
                    break;
            }
        }

        /**
         * 获取字符串
         */
        public function getLastLoginTimeStrAttr($value,$data)
        {
            return date('Y-m-d H:i:s',$data['last_login_time']);
        }

		/**
		 * hash加密密码
		 * @access public
		 * @param $value
		 * @param $data
		 * @return bool|string
		 * @author knight
		 */
		public function setPasswordHashAttr($value,$data)
		{
			return isset($data['password_hash']) ? md5(md5($data['password_hash'])):'';
		}
		/**
		 * 验证密码
		 * 成功返回true,失败返回false
		 * @access public
		 * @param $password
		 * @param $passwordHash
		 * @return bool
		 * @author knight
		 */
		public function checkPassword($password,$passwordHash)
		{
			if(password_verify($password,$passwordHash)){
				return true;
			}
			return false;
		}
        /**
         * 设置默认状态
         * @return array
         */
		public function setStatusAttr(){
		    return $this->_status_one;
        }
	}