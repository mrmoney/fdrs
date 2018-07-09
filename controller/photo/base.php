<?php
/**
 * police控制器基类
 */
class Base_Controller_Photo extends Base_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->configTemplate();
	}

	public function configTemplate()
	{
		$this->config_tpl('photo');
	}
	
	protected function checkLogin()	
	{
		$this->checkLogin_common();
	}
	
	protected function checkPriv()
	{
		$ary_acts = array('remove_photo');
		if(in_array(ACT,$ary_acts))
		{
			//只有门店、CAD部的人做以上操作
			$ary_need_roles = array('门店服务员','着装顾问','设计师','公司团体部');
			$ary_cad_users = Config::$ary_user_roles['CAD部'];
			$ary_need_roles = array_merge($ary_need_roles,$ary_cad_users);
			$this->is_valid_user($ary_need_roles,false);
		}
	}
	
	protected function is_upload()
	{
		//只有门店、CAD部的人做以上操作
		$ary_need_roles = array('门店服务员','着装顾问','设计师','公司团体部');
		$ary_cad_users = Config::$ary_user_roles['CAD部'];
		$ary_need_roles = array_merge($ary_need_roles,$ary_cad_users);
		$is_valid_user = $this->is_valid_user($ary_need_roles,false,false);
		$this->assign('is_valid_user',$is_valid_user);
	}
	
	protected function addLog() { }
	 
	public function message($content,$params=array()){ }
}
?>