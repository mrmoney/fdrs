<?
class TimeMillis{
	public function  currentTimeMillis()
	{
		list($usec,  $sec)  =  explode("  ",microtime());
		return  $sec.substr($usec,  2,  3);
	}
}
class NetAddress{
	public $Name  =  'localhost';
	public $IP  =  '127.0.0.1';
	public function  getLocalHost()  //  static
	{
		$address  =  new  NetAddress();
		$address->Name  =  $_ENV["COMPUTERNAME"];
		$address->IP  =  $_SERVER["SERVER_ADDR"];
		return  $address;
	}
	public function  toString()
	{
		return  strtolower($this->Name.'/'.$this->IP);
	}
}
class Random{
	public function  nextLong()
	{
		$tmp  =  rand(0,1)?'-':'';
		return  $tmp.rand(1000,  9999).rand(1000,  9999).rand(1000,  9999).rand(100,  999).rand(100,  999);
	}
}

//  三段
//  一段是微秒  一段是地址  一段是随机数

class Guid{
	public $valueBeforeMD5;
	public $valueAfterMD5;
	
	public function  __construct()
	{
		$this->getGuid();
	}

	public function  getGuid()
	{
		$address  =  NetAddress::getLocalHost();
		$this->valueBeforeMD5  =  $address->toString().':'.TimeMillis::currentTimeMillis().':'.Random::nextLong();
		$this->valueAfterMD5  =  md5($this->valueBeforeMD5);
	}
	
	public function  newGuid()
	{
		$Guid  =  new  Guid();
		return  $Guid;
	}
	
	public function  toString($split = true)
	{
		$raw  =  strtoupper($this->valueAfterMD5);
		$str = substr($raw,0,8).'-'.substr($raw,8,4).'-'.substr($raw,12,4).'-'.substr($raw,16,4).'-'.substr($raw,20);
		if(!$split){ $str = str_replace('-', '', $str); }
		return  $str;
	}
}
?>