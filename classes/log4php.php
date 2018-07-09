<?php
require_once('log4php/Logger.php');
class Log4php{
	public static function getLogger($name){
		Logger::configure(ROOT_PATH.'/conf/log4php.php');
		return Logger::getLogger($name);
	}//龙
}
?>
