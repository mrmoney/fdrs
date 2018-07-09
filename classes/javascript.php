<?php
class Javascript{
	protected function __construct()
	{
		
	}
	/**
	 * 返回上页
	 * @param    int    $step    返回的层数 默认为1
	 */
	public static function Back($step = -1){
		$msg = "history.go(".$step.");";
		self::_Write($msg);
		self::FreeResource();
		exit;
	}

	/**
	 * 弹出警告的窗口
	 * @param    string    $step    警告信息
	 */
	public static function Alert($msg){
		$msg = "alert(\"".$msg."\");";		
		self::_Write($msg);
		self::Back();
	}

	/**
	 * 写js
	 * @param    string    $msg    警告信息
	 */
	public static function _Write($msg) {
		echo "<script language=\"javascript\">\n";
		echo $msg;
        echo "\n</SCRIPT>";
	}

	/**
	 * 刷新当前页
	 * 
	 */
	public static function Reload(){
		$msg = "location.reload();";
		self::FreeResource();
		self::_Write($msg);
		exit;
     }

     /**
      * 刷新弹出父页
      */
		public static function ReloadOpener(){
		$msg = "if (opener) opener.location.reload();";
		self::_Write($msg);
		}

	/**
	 * 跳转到url
	 * @param    string    $url    跳转url地址
	 */
	public static function Redirect($url){
	    $msg = "location.href = ‘$url’;";
		self::FreeResource();
		self::_Write($msg);
		exit;
	}
	/**
	 * 提示信息并跳转到url
	 * @param    string    $url    跳转url地址
	 */
	public static function RedirectAndAlert($url,$msg){
		$msg = "alert(\"".$msg."\");";
		$msg.= "location.href = '".$url."';";

		self::FreeResource();
		self::_Write($msg);
		exit;
	}
	/**
	 * 关闭窗口
	 */
	function Close(){
		$msg = "window.close()";
		self::FreeResource();
		self::_Write($msg);
		exit;
	}

	/**
	 * 关闭数据库连接
	 */
	function FreeResource(){
		// 数据库连接标志
		global $conn;
		if (is_resource($conn))
			@mysql_close($conn);
	}
}
?>