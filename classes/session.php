<?php
class Session
{
	//判断当前请求的来源是否为平板
	public static function is_tablet()
	{
		$detect = new MobileDetect();
		$is_tablet = false;
		$is_tablet = ($detect->isMobile() ? ($detect->isTablet() ? true : false) : false);
		return $is_tablet;
	}
	
	//查询当前请求的设备类型
	public static function get_device_type()
	{
		$detect = new MobileDetect();
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if($deviceType == 'phone')
		{
			exit('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1">
					对不起，手机版开单系统还在升级当中，暂时已被关闭 ...');
		}
		
		return $deviceType;
	}
	
	public static function is_ipad()
	{
		return self::is_tablet();
	}
	
	public static function is_chrome()
	{
		//获取USER AGENT
		$agent = self::getBrowser();
		$is_chrome = $agent == 'chrome';   
		if($is_chrome == false)
		{
			exit('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1">
					原IE浏览器已停止使用，您必须使用chrome浏览器才能继续使用OA系统，如果您还没有安装，
					<a href="/attachement/chrome41.exe">请点击这里下载并安装</a>...');
		}
	}
	
	/** 
	* 检测用户当前浏览器 
	* @return boolean 是否ie浏览器 
	*/ 
	public static function is_ie_browser()
	{ 
		$usingie = false; 
		$userbrowser = self::getBrowser(); 
		$usingie = $userbrowser == 'ie'; 
		return $usingie; 
	} 
	
	//获取浏览器类型
	public static function getBrowser()
	{
		$agent=$_SERVER['HTTP_USER_AGENT'];
		if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
			return 'ie';
		else if(strpos($agent,'Firefox')!==false)
			return 'firefox';
		else if(strpos($agent,'Chrome')!==false)
			return 'chrome';
		else if(strpos($agent,'Opera')!==false)
			return 'opera';
		else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
			return 'safari';
		else
			return 'unknown';
	}
	
	//获取浏览器版本
	public static function getBrowserVer()
	{
		if (empty($_SERVER['HTTP_USER_AGENT']))
			return 'unknow';
			
		$agent= $_SERVER['HTTP_USER_AGENT'];   
		
		if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
			return $regs[1];
		elseif ((strpos($agent,'Chrome') == false) && preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
			return $regs[1];
		else
			return 'unknow';
	}
}
?>
