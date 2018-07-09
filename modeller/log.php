<?php
class Log_Modeller extends Base_Modeller 
{
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
	
	public function save_log($args)
	{
		$args['saver'] = self::getUserInfo('username');
		$args['save_time'] = date('Y-m-d G:i:s');
		
		$this->add($args,'action_log');
	}
	
	public function query_log($log_type,$table_id,$limit = ' limit 0,100')
	{
		$filter = " where log_type = `{$log_type}` and table_id = `{$table_id}`";
		$sql = "select * from action_log {$filter} order by id desc {$limit}";
		$q = $this->getAll($sql);
		
		return $q;
	}
}
?>
