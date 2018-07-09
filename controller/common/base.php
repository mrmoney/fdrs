<?php
/**
 * police控制器基类
 */
class Base_Controller_Common extends Base_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->configTemplate();
	}
	
	public function configTemplate()
	{
		$this->config_tpl('common');	
	}
	
	protected function checkLogin()	
	{
		// $this->checkLogin_common();
	}
	
	protected function checkPriv(){}
	protected function addLog(){}
	public function message($content,$params=array()){}
}
?>