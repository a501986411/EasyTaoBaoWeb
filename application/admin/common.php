<?php
	/**
	 *
	 * Created by PhpStorm.
	 * User: knight
	 * Date: 2017/5/17
	 * Time: 17:52
	 */
	/**
	 * 返回错误信息
	 * @access public
	 * @param $msg='' 返回提示信息
	 * @return array
	 * @author knight
	 */
	function retFalse($msg=''){
		if(empty($msg)){
			$msg = lang('error server');
		}
		return ['success'=>false,'msg'=>$msg];
	}
	/**
	 * 返回操作成功信息
	 * @access public
	 * @param $msg='' 返回提示信息
	 * @return array
	 * @author knight
	 */
	function retTrue($msg=''){
		if(empty($msg)){
			$msg = lang('success options');
		}
		return ['success'=>true,'msg'=>$msg];
	}


