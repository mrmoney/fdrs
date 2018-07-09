<?php
define('IN_SYS', true);
/**
 * 中央控制器
 */
class Core 
{
	private static $logger;
	
	public function __construct()
	{
		//绑定自动加载环境
		spl_autoload_register(array($this,'loadClasses'));
	 	self::$logger = Log4php::getLogger(__CLASS__);
	}
	
	//设置session的保存方式
	public function initSess()
    {
		/*
		if(class_exists('Memcache'))
		{
			ini_set('session.save_handler', 'memcache');
			ini_set('session.save_path', 'tcp://127.0.0.1:11211');
		}
		*/
        //不使用 GET/POST 变量方式
        ini_set('session.use_trans_sid',0);

        //设置垃圾回收最大生存时间
        ini_set('session.gc_maxlifetime',4 * 3600);
        //设置session过期时间
        //ini_set('max_execution_time',3);
        //set_time_limit(10);
        //使用 COOKIE 保存 SESSION ID 的方式
        ini_set('session.use_cookies',1);
        ini_set('session.cookie_path','/');

        //将 session.save_handler 设置为 user，而不是默认的 files
        //session_module_name('user');

		/**
		 * 多主机共享保存 SESSION ID 的 COOKIE
		 */
		if(!empty($_GET['sessionid'])){session_id(trim($_GET['sessionid']));}
		ini_set('session.cookie_domain', '.evgo.me');
        session_start();
        return true;
    }

	function start($config = array ())
	{
		global $_SERVER;
		//设置时区
		date_default_timezone_set('Asia/Shanghai');
		//ini_set("session.cookie_domain",'hanloon.com');
		$this->initSess();
		
		
		//程序终止处理
		register_shutdown_function(array($this,'appShutdown'));

		//self::$logger->debug('启动核心');
		/* 数据过滤 */
		if (!get_magic_quotes_gpc())
		{
			$_GET = Util::addslashesDeep($_GET);
			$_POST = Util::addslashesDeep($_POST);
			$_COOKIE = Util::addslashesDeep($_COOKIE);
			$_REQUEST = Util::addslashesDeep($_REQUEST);
		}
		
		/* 请求转发 */
		$http_host = $_SERVER['HTTP_HOST'];
		if(is_file(ROOT_PATH.'/conf/config.php'))
		{
			$this->cfg = include(ROOT_PATH.'/conf/config.php');
			if(empty($this->cfg[$http_host])){	exit('no default controller config!');	}
		}
		else
		{
			exit('no controller config!');
		}
		
		$default_app = !empty($config['default_app']) ? $config['default_app'] : $this->cfg[$http_host]['default_app'];
		$default_act = !empty($config['default_act']) ? $config['default_act'] : $this->cfg[$http_host]['default_act'];

		$app = isset ($_REQUEST['app']) ? trim($_REQUEST['app']) : $default_app;
		$act = isset ($_REQUEST['act']) ? trim($_REQUEST['act']) : $default_act;

		$act = strtolower($act);
		$apps = explode('_',$app);
		foreach($apps as &$vp){	$vp = ucfirst($vp);	}
		$app = implode('_',$apps);
		
		define('APP',$app);
		define('ACT',$act);
		
		$app_class_name = ucfirst($app);
		/* 实例化控制器 */
		$app = new $app_class_name ();
		$app->doAction($act); //转发至对应的Action
	}
	
	/**
	 * 自动加载类
	 */
	private function loadClasses($class)
	{
		$classSplits = explode('_',$class);
		$flag = count($classSplits);
		if($flag > 1)
		{
			$path = '';
			for($i=1;$i<$flag;$i++)
			{
				$path .= strtolower($classSplits[$i]) . '/';
			}
			$path = ROOT_PATH . "/$path";
		}
		else
		{
			$path = ROOT_PATH . '/classes/';
		}
		
		set_include_path($path);
		set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_PATH . '/classes/libs(v1)/');
		
		spl_autoload_extensions('.php,.class.php');
		spl_autoload($classSplits[0]);
		
	}
	
	public function appShutdown()
	{
		//错误日志
		$error = error_get_last();
		if($error == null){ return; }
		$error['time'] = date('Y-m-d G:i:s');
		error_log(json_encode($error)."\r\n", 3, ROOT_PATH . '/cache/error.log');
	}
}
?>
