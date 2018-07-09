<?php
class Config extends System
{
	static $instance;
	
	private function __construct() { }
	
	static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	/**
	* 返回用户角色
	* */
	public static $ary_user_roles = array( '市场部', '人事部','行政部', '财务部' );
	
	/**
	 * 短信发送参数
	 * */
	public static $mobileAccount = array(
										   'HL' => array('hzhlfs','woyaofa'),
										   'SG' => array('hzacfs','woyaofa'),
										   'HLPOOR' => array('hzhpfs','woyaofa'),
									   );
	
	/**
	 * 短信发送参数,广州短信易
	 * */
	public static $mobileAccount_GZ = array(
										   'HL' => array('admin','263656','300183'),
										   'SG' => array('admin','155012','300186'),
										   'HLPOOR' => array('admin','212213','300187'),
									   );
	
	/**据店名重组短信发送账户*/
	public static function rebuild_sms_account()
	{
		$mobileAccount = null;
		//读取发送账户密码,因为不同品牌的短信签名不一样...
		$sysBrands = self::$sysBrands;
		foreach($sysBrands as $key => $value)
		{
			foreach($value[1] as $v)
			{
				$mobileAccount[$v]=$key;
			}
		}	
		
		return $mobileAccount;
	}
	
	/**
	* 返回性别中文名
	* */
	public static $genderName = array('male' => '男','female' => '女');
	
	/**超级管理员*/
	public static $superManager = array('mrmoney');
}
?>