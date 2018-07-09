<?php
/**
 * 控制器基类
 */
abstract class Base_Controller
{
	protected $is_abroad = false;
    private $cachedir = '';
	private $name = __CLASS__;
	protected static $logger;
	protected $view = null;
	protected $is_post = false;
	protected $is_ajax = false;
	protected $is_tablet = 1;
	protected $cfg = null;
	protected $LANG = array();
	
	public function __construct() 
	{
        $this->cachedir = ROOT_PATH . '/cache/';
		// self::$logger = Log4php::getLogger(__CLASS__);
		$this->is_post = isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
		$this->is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
							strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST';
		$this->view = new Smarty_Viewer();
		$this->view->allow_php_tag = true;
		$this->view->left_delimiter = '<!--{';
		$this->view->right_delimiter = '}-->';
		$this->view->registerPlugin('function','link_to',array($this,'linkTo'));
		if(is_file(ROOT_PATH.'/conf/config.php')){
			$this->cfg = include(ROOT_PATH.'/conf/config.php');
			$this->assign('controller',strtolower(APP));
			$this->assign('site_name',SITE_NAME);
			$this->assign('is_tablet',$this->is_tablet);
		}else{
			$this->json('no controller config!',0);
			//exit('no controller config!');
		}
	}

	public function linkTo($config,$smarty=null)
	{
		$domain = isset($config['domain']) ? trim($config['domain']) : '';
		$controller = isset($config['controller']) ? trim($config['controller']) : '';
		$action = isset($config['action']) ? trim($config['action']) : '';
		unset($config['domain']);
		unset($config['controller']);
		unset($config['action']);
		$url = '';
		if($domain != ''){
			$url = $domain;
		}else{
			$url = '/';//"{$this->cfg[$_SERVER['HTTP_HOST']]['url']}";
		}
		
		if($this->cfg[$_SERVER['HTTP_HOST']]['rewrite']){
			$url .=  "/app/{$controller}";
			if(!empty($action)){
				$url .= "/act/{$action}";
			}
			
			foreach($config as $k => $v){
				$url .= "/{$k}/{$v}";
			}
		}else{
			$url .= "/?app={$controller}";
			if(!empty($action)){
				$url .= "&act={$action}";
			}
			
			foreach($config as $k=>$v){
				$url .= "&{$k}={$v}";
			}
		}
		return $url;
	}

	public function display($tpl)
	{
		$this->view->display($tpl);
	}

	public function assign($k, $v = null)
	{
		if (is_array($k)){
			$args = func_get_args();
			foreach ($args as $arg){
				foreach ($arg as $key => $value)
					$this->view->assign($key, $value);
			}
		}else{
			$this->view->assign($k, $v);
		}
	}

	//获取通过assign分配的值
	protected function fetch_var($k)
	{
		$v = $this->view->getTemplateVars($k);
		return $v;
	}

	//获取模板解析过的内容
	protected function fetch_tpl($k)
	{
		$v = $this->view->fetch($k);
		return $v;
	}

	//是否为移动版
	protected function is_tablet()
	{
		return false;
	}

	//是否为超级管理员
	protected function is_manager()
	{
		$is_manager = false;
		if(session() != null){
			$admins = $this->cfg['admin'];
			$username = session('username');
			$is_manager = in_array($username,$admins);
		}

		return $is_manager;
	}

	//判断用户是否合法
	protected function is_valid_user($need_role = null,$is_need_all = false,
											$is_halt = true,$is_log = false)
	{
		$is_valid = false;
		$username = session('username');
		if($need_role == null){
			//如果没有指定任何角色,则只要是登录过的人都可以
			if($username != ''){ return true; }
		}else{
			if($username == ''){
				if(!$this->is_ajax){
					header('Location:/?app=default_controller_default&act=logout');
					exit;
				}
			}
		}

		$admins = $this->cfg['admin'];
		if(in_array($username,$admins)){ return true; }
		$ary_roles = session('roles');
		if(!is_array($ary_roles)){ return false; }

		if(!is_array($need_role)){
			$is_valid = in_array($need_role,$ary_roles);
		}else{
			//有可能只需要具备某部分角色即可访问某功能
			$int_same_count = 0;
			foreach($need_role as $role){
				if(in_array($role,$ary_roles)){ $int_same_count++; }
			}

			$is_valid = $is_need_all
				?	($int_same_count >= count($need_role))
				:	($int_same_count > 0);
		}

		if(!$is_valid && $is_halt){
			$is_ajax = $this->is_ajax;
			if(is_array($need_role)){ $need_role = join(' / ',$need_role); }
			$error_message = '没有相关权限，您必须属于如下角色：' . $need_role;
	 		if($is_ajax){
	 			$this->json($error_message,403);
	 		}else{
		 		$this->error_res(null,$error_message);
	 		}
		}

		return $is_valid;
	}

	public function doAction($action) 
	{
		if (is_string($action) && method_exists($this, $action)){
			$this->checkHost();
			if(!$this->is_manager()){
				$this->checkLogin();
				$this->checkPriv();
			}
			$this->addLog();
			$this-> $action();
		}else{
			$this->error_res(null,'action[' . $action . '] not exists');
		}
	}

	public function json($message,$code = 1,$data = null,$is_mini_list = false)
	{
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-type: text/x-json; charset=utf-8');

		$return_data = null;
		if($is_mini_list){
			$data['code'] = $code;
			$data['message'] = $message;

			// 为了兼容第三方接口,追加以下字段
			$data['msg'] = $message;
			$data['count'] = $data['total'];

			$return_data = json_encode($data);
		}else{
			$res_data = array('code' => $code,'message' => $message,'data' => $data);

			// 为了兼容第三方接口,追加以下字段
			$res_data['msg'] = $message;

			$return_data = json_encode($res_data);
		}


		exit($return_data);
	}
	
	//返回列表数据
	public function json_list($data,$code = 1)
	{
		$this->json(null,$code,$data,true);
	}

	public function json_html($data)
	{
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-type: text/html; charset=utf-8');
		echo json_encode($data);
		exit;
	}

	public function parse_html($html)
	{
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-type: text/html; charset=utf-8');
		echo $html;
		exit;
	}

	protected function not_found($title = null,$content = null,$is_miniui_style = false)
	{
		$title = $title == null?'找不到您想查看的内容':$title;
		$content = $content == null?'您要查找的资源可能已被删除。':$content;
		if($this->is_ajax){
			$this->json($content,404);
		}else{
			$this->assign('title', $title);
			$this->assign('content', $content);
			$this->assign('is_miniui_style', $is_miniui_style);
			$this->display('../404.html');
		}
		exit;
	}

	protected function error_res($title = null,$content = null,$is_miniui_style = false)
	{
		if($this->is_ajax){
			$message = $content != null?$content:'ERROR';
			$this->json($message,0);	
		}else{
			$title = $title == null?'出错啦':$title;
			$content = $content == null ?	'未知的错误' :	$content;
			$this->assign('title', $title);
			$this->assign('content', $content);
			$this->assign('is_miniui_style', $is_miniui_style);
			$this->display('../500.html');
		}
		exit;
	}

	//拒绝操作
	protected function deny()
	{
		if($this->is_ajax){
			$this->json('DENY',403);
		}else{
			$this->display(ROOT_PATH . '/templates/deny.html');
		}
		exit;
	}

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired 缓存秒数，如果为0则为长期缓存
     * @return boolean
     */
    protected function setCache($cachename,$value,$expired=0)
	{
        $file = $this->cachedir . $cachename . '.cache';
        $data = array(
		                'value' => $value,
		                'expired' => $expired ? time() + $expired : 0
			        );
        return file_put_contents( $file, serialize($data) ) ? true : false;
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
	{
        $file = $this->cachedir . $cachename . '.cache';
        if (!is_file($file)) {
           return false;
        }

        $data = unserialize(file_get_contents( $file ));
        if (!is_array($data) || !isset($data['value']) || (!empty($data['value']) 
				&& $data['expired']<time())) {
            @unlink($file);
            return false;
        }
        return $data['value'];
    }

	//创建pdf文件
	protected $wechat_data = null;
	protected function create_pdf_file($content,$is_output = true,
						$attache_type = 'wkhtmltopdf',$ary_options = null)
	{
		$print_file_name = sha1(time() . '-' . session_id());
		$dir_name = '/attachement/to_wechat/' . date('Ymd') . '/';
		@mkdir(ROOT . $dir_name);
		$htmlfile = ROOT . $dir_name . $print_file_name . '.html';
		System::WriteStream($htmlfile,$content);

		$to_wechat = (int)$_GET['to_wechat'];
		if($to_wechat == 1){ $attache_type = 'wkhtmltoimage'; }//如果是要发送给微信,则强制生成图片
		$dest_file_type = array('wkhtmltoimage'=>'jpg','wkhtmltopdf'=>'pdf',);
		$pdf_file_path = '/attachement/to_wechat/' . $print_file_name . '.' . $dest_file_type[$attache_type];
		$destfile = ROOT . $pdf_file_path;
		$options = '';
		if($ary_options != null){ $options = join(' ',$ary_options); }
		$exec_cmd = WK_HTML_TO_DIR . $attache_type . '.exe ' . $options . //工具路径
									' ' . $htmlfile . ' ' . //源文件路径
									$destfile; //目标文件

		shell_exec($exec_cmd);
		@unlink($htmlfile);

		if($to_wechat == 1){
			if(file_exists($destfile)){
				$image_file_path = '/resource/tmp/' . $print_file_name . '.jpg';
				copy($destfile,QIYEHAO_ROOT . $image_file_path);
				$this->wechat_data['order']['picurl'] = $image_file_path;
				$this->send_to_wechat($image_file_path);
			}
		}

		if(!$is_output){
			return $pdf_file_path;
		}else{
			echo $pdf_file_path;
			exit;
		}
	}

	//发送尺寸单处理流程通知到微信企业号
	protected function send_process_message($args)
	{
		$next_key = $args['next'];
		$ary_next_process[] ='';

		if($next_key != '' && $next_key >= count($ary_next_process)){ return; }

		$o = new Default_Controller_Wechat();
		$ary_result = $o->text(
								$args['content'],
								0/*通知公告应用编号*/,
								$args['touser'],null,
								$args['tags']
							);
		Util::Log($ary_result);
	}

	//下载导出的收款明细
	public function download_exported()
	{
		$key = $_GET['key'];
		$key = str_replace(' ','+',$key);
		$key = unserialize(Util::authcode($key,'DECODE',API_KEY_1,0));
		$filepath = ROOT . $key[0];
		System::DownLoad($filepath,$key[1]);
	}

	//unserialize增强版
	protected function mb_unserialize($serial_str)
	{
		return Util::mb_unserialize($serial_str);
	}

	/**
	 * 消息显示
	 */
	abstract function message($content,$params=array());

	/**
	 * 配置模板，子类必须实现此方法
	 */
	abstract protected function configTemplate();

	/**
	 * 权限判断，子类必须实现此方法，可以空实现，即不实现权限判断
	 */
	abstract protected function checkPriv();

	/**
	 * 检查是否已登录
	 */
	abstract protected function checkLogin();

	protected function config_tpl($tpl_dir = '')
	{
		if($tpl_dir != ''){
			$this->view->template_dir  = ROOT_PATH . '/templates/' . $tpl_dir;
			$this->view->compile_dir   = ROOT_PATH . '/cache/compiled/templates/' . $tpl_dir;
			$this->view->cache_dir      =  ROOT_PATH . '/cache/cached/templates/' . $tpl_dir;
			$this->view->assign('miniui', $this->cfg['miniui']);
			$this->view->assign('res', HOST . '/resource');
			$this->view->assign('cdn_host', 'http://cdn.hanloon.com/');
			$this->view->assign('base', '/templates/' . $tpl_dir);
			$this->view->assign('cfg', $this->cfg);
			$this->view->allow_php_tag = true;
		}
	}

	/**
	 * 检查控制器是否为当前HOST
	 */
	protected function checkHost(){}

	//获取用户信息,兼容老代码中的self::getUserInfo
	public static function getUserInfo($data_type,$group_type = 'system')
	{
		return System::getUserInfo($data_type,$group_type);
	}

	//获取用户信息,兼容老代码中的self::setUserInfo
	public static function setUserInfo($key,$value)
	{
		return System::setUserInfo($key,$value);
	}

	//判断当前app或者app下某个具体的应用是否需要登录授权才能访问
	protected function in_uncheck()
	{
	 	$req_app_act = strtolower(APP . '&' . ACT);
	 	$req_app = strtolower(APP);

	 	//不须登录验证部分
	 	$unchecks = $this->cfg[$_SERVER['HTTP_HOST']]['uncheck'];
	 	
	 	if(in_array($req_app,$unchecks)){ return true; }
	 	if(in_array($req_app_act,$unchecks)){ return true; }

		return false;
	}

	//验证是否已登录的通用方法
	protected function checkLogin_common()
	{
	 	if(!$this->in_uncheck()){
			if(session() == null){
		 		if($this->is_ajax){
		 			$this->json('会话超时',-1);
		 		}else{
			 		header('Location: /');
			 		exit;
		 		}
		 	}
	 	}
	}

	// 各种分类
	protected function assign_types($typename = 'pay_types',$is_encode = true)
	{
		$types = Config_Modeller::$typename();
		if($is_encode){
			$types = array_values($types);
			$types = json_encode($types);
		}
		$this->assign($typename,$types);
	}

}
?>