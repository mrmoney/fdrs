<?php
class Money_Modeller extends Message_Modeller
{
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
}
?>