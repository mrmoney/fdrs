<?php
ini_set('date.timezone','PRC');
ini_set('expose_php','Off');//隐藏版本信息
define('SAVE_LOG', true);
define('MAX_SLEEP_TIME', 120);
define('NOW', time());
define('ROOT_PATH', 'E:\\mrmoney\\baoxiang\\fdrs\\');
define('ONLINE_ROOT_PATH', 'E:\\mrmoney\\baoxiang\\fdrs\\');

define('SITE_NAME','广东省金融发展研究会');
define('ROOT',ROOT_PATH);
//将html,image转换成PDF或者JPG的第三方应用所在目录
define('WK_HTML_TO_DIR','D:\\wkhtmltopdf\\');
define('HOST',get_host());

define('HTTP_REFERER',get_referer());
define('REQUEST_URI',get_uri());
define('PHP_SELF',get_url());
define('IS_MASK_NAME', false);

define('CART','cart');
define('SYS_SESSION_KEY','system');
define('USER_SESSION_KEY','user');

define('API_KEY_1','!@#$%^QSDRwww123800');
define('API_KEY_2','clothes-diy.luxh');

define('SESSION_TYPE','SESSION');
define('CACHE_SRV','127.0.0.1');
define('CACHE_PORT',11211);

define('MEMCACHE_TIME',60 * 60 * 24 * 7);//memcahe缓存时间

//安全公钥和私钥
define('PRIVATE_KEY','-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCq38pvqT//Luuuw105mQ5sDDIV13rgdQzTr8Ccik1YqpuaJE0K
59dOcl2KdAd7e50O1TZlh9bwOp9MPpVvIDzdlGsQEDRV7kxgsxTpF4dqI4SYUBYg
6B31Wh0TpYAEG95FIweF9P/7Q9fH2oSpveL0jPYyhvPvzXtq5K8qj6cL3QIDAQAB
AoGAM99B/gm8MsRUqbYG+/A5z5UYM0c5tx/xZ+XHq/3UIyGPoQh6FuBwnRDc0qYM
i3DoKdOR8tp85mp1Z1jsVlLMBtzsqUIxv5uqj8kDwBdZnNunZ8dvC1TU3UUwPaYJ
xcDd9tMTm7KisDAZ7bOJc2aCuhtQ1D0EYPXSZT+KcGDW/IECQQDZnzJgUUBQmAxs
zCGoH8DxznxyYjQjJxtKbToMVMoP0VZfXIPd3UfjL5AIrhI1InS/kSxRlcNI5gay
kNUkyLw9AkEAyQIc/ALr2wDVeGI3gqIDOZvQmxOwMMdrshGh9JZgp4UbUvszoJg8
Nr74bZkZQ+9DzOTEJf7+LePohsqAqWZoIQJAMyP3Ka1OaOIiYVrjOegkZm64zgSH
7g7dmfLrJkSyq17tZkGOd4/tudTOi0uk2bm8J9yMxqtkFfiAcGwauqc1nQJBAKN0
aXdxNLQxeGXdkIBVGMRG9Zq1pufzsprqBcYsZsqyzeZrya7FPOnT35bYEZiRv5Ol
T/AJ7E4K7/J0R635TaECQQCxSiG5stx4f+Oev2tPXvuyoGLD9Up7c8TNSpKM0MK4
OIKoNavobvk1sLTugzenVuPH3KjbyFzO++vvlYTHp2cn
-----END RSA PRIVATE KEY-----
');

define('PUBLIC_SRV_KEY','-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCq38pvqT//Luuuw105mQ5sDDIV
13rgdQzTr8Ccik1YqpuaJE0K59dOcl2KdAd7e50O1TZlh9bwOp9MPpVvIDzdlGsQ
EDRV7kxgsxTpF4dqI4SYUBYg6B31Wh0TpYAEG95FIweF9P/7Q9fH2oSpveL0jPYy
hvPvzXtq5K8qj6cL3QIDAQAB
-----END PUBLIC KEY-----
');

//用于JS端的公钥
define('PUBLIC_JS_KEY','-----BEGIN PUBLIC KEY----- MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCq38pvqT//Luuuw105mQ5sDDIV 13rgdQzTr8Ccik1YqpuaJE0K59dOcl2KdAd7e50O1TZlh9bwOp9MPpVvIDzdlGsQ EDRV7kxgsxTpF4dqI4SYUBYg6B31Wh0TpYAEG95FIweF9P/7Q9fH2oSpveL0jPYy hvPvzXtq5K8qj6cL3QIDAQAB -----END PUBLIC KEY-----');

function get_url()
{
	$url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
	$int_pos = stripos($url, '?');
	if($int_pos){ $url = substr($url,0,$int_pos);	}
	return $url;
}

function session($data_key = null,$session_key = SYS_SESSION_KEY)
{
	$session_data = null;
	if(isset($_SESSION[$session_key])){
		$session_data = $_SESSION[$session_key];
	}else{
		return null;
	}
	
	if($data_key != null){
		return $session_data[$data_key];
	}else{
		return $session_data;
	}
}

//获取具体的主机地址
function get_host()
{ 
	$protocol_name = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
		?'https://':'http://';
	$host_name = $_SERVER['SERVER_NAME'];
	$port = $_SERVER['SERVER_PORT'];
	$port = in_array($port,array(80,443))?'':':' . $port;
	
	$host = $protocol_name . $host_name . $port . '/';
	return $host;
}

function get_referer(){ 
	$referer = 	isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
	return $referer;
}

function get_uri(){ 
	$uri = 	isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:''; 
	return $uri;
}

//配置文件中的通用信息
function common_config($host_url)
{
	return array (
		'url' => 'http://' . $host_url,
		'default_app' => 'view_controller_www',
		'default_act' => 'index',
		// 'default_app' => 'sysauth_controller_default',
		// 'default_act' => 'login',
		'db_host' => 'localhost',
		'db_port' => 3316,
		'db_name' => 'bx_fdrs',
		'db_username' => 'gd_baoxiang_tz',
		'db_password' => 'gd_baoxiang_tz@1981',
		'rewrite' => false,
		'uncheck' => array (
			'default_controller_default&index',//登录界面
			'default_controller_default&check',//登录界面
			'default_controller_default&logout',//登录界面
			'default_controller_default&authcode',//验证码
			
			//'help_controller_default',//来自微信端的照片上传
			'service_controller_wechat',//微信云定制服务号
			'default_controller_wechat&act=erp',//微信企业号
			'wechat_controller_pay&act=notify',//微信支付成功回调通知
			
			//乔治巴顿版
			'sysauth_controller_default&login',//登录界面
			'sysauth_controller_default&check',//验证登录
			'sysauth_controller_default&logout',//注销登录
		),
	);
}

//载入微信支付核心接口
function wxpay_core_api()
{
	require_once ROOT . "/classes/wxpay(web)/WxPay.Api.php";
}

//载入微信支付接口
function wxpay_pay_api()
{
	wxpay_core_api();
	require_once ROOT . "/classes/wxpay(web)/WxPay.NativePay.php";
}

//载入微信回调接口
function wxpay_notify_api()
{
	wxpay_core_api();
	require_once ROOT . "/classes/wxpay(web)/WxPay.Notify.php";
}
?>