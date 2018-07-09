<?php
class Cron extends System
{
	static $instance;
	
	protected function __construct()
	{
		if(!$this->Conn())
			self::Alert($this->DBERROR());
	}
	
	static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
}
?>