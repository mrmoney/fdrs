<?php
/**
 * police控制器基类
 */
class Base_Controller_Www extends Base_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->configTemplate();
	}

	public function configTemplate()
	{
		$this->config_tpl('www');
	}
	
	protected function checkLogin()	{ }

	protected function checkPriv() { }
	
	protected function addLog() { }
	 
	public function message($content,$params=array()){ }

	protected function head_menus($cat_id = 0)
	{
		$menus[] = array('index' => 0,'href' => '/','text' => '网站首页');
		$menus[] = array('index' => 1,'href' => '/about/intro','text' => '关于研究会');
		$menus[] = array('index' => 2,'href' => '/contents/2','text' => '金融聚焦');
		$menus[] = array('index' => 3,'href' => '/subject/index','text' => '研究课题');
		$menus[] = array('index' => 4,'href' => '/contents/6','text' => '活动公告');
		$menus[] = array('index' => 5,'href' => '/member/org','text' => '研究会成员');
		$menus[] = array('index' => 6,'href' => '/member/join','text' => '会员申请');

		$this->assign('cat_id',$cat_id);
		$this->assign('menus',$menus);
	}
}
?>