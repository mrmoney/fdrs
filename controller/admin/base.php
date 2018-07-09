<?php
/**
 * 控制器基类
 */
class Base_Controller_Admin extends Base_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->configTemplate();
	}

	public function configTemplate()
	{
		$this->config_tpl('mrmoney');
	}
	
	//检查登录
	protected function checkLogin()	
	{
		if(!$this->is_manager())
		{
			if($this->is_ajax)
			{
				$this->json('DENY',403);	
			}	
			else
			{
				$this->display('deny.html');	
				exit;
			}
		}
	}
	
	protected function checkPriv() { }
	
	protected function addLog() { }
	 
	public function message($content,$params=array()){ }
}
?>