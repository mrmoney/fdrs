<?php 
class View extends Smarty
{
	static $instance;	
	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}
	
	public function __construct()
	{
		$this->configTemplate();
	}

	//配置模版和缓存路径
	public function configTemplate()
	{
		$this->template_dir  = ROOT . '/templates/default';
        $this->compile_dir   = ROOT . '/cache/compiled/templates/default';
        $this->cache_dir      =  ROOT . '/cache/cached/templates/default';
        $this->allow_php_tag = true;
		$this->left_delimiter = '<!--{';
		$this->right_delimiter = '}-->';
	}
}
?>