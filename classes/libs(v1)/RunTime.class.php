<?php
class RunTime
{ 
    private $StartTime = 0; 
    private $StopTime = 0; 
	
	static $instance;
	static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
	
    public function get_microtime() 
    { 
        list($usec, $sec) = explode(' ', microtime()); 
        return ((float)$usec + (float)$sec); 
    } 
 
    public function start() 
    { 
        $this->StartTime = $this->get_microtime(); 
    } 
 
    public function stop() 
    { 
        $this->StopTime = $this->get_microtime(); 
    } 
 
    public function spent() 
    { 
        return round(($this->StopTime - $this->StartTime) * 1000, 1); 
    } 
}
//龙
?>