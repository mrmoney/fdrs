<?php
header('Content-Type:text/html; charset=utf-8');
define('__dat_db__' , ROOT . '/resource/gps-maps/offset.dat' );// DAT数据文件
define('datmax' , 9813675 );// 数据条数-结束记录

class GpsOffset
{
	static $instance;
	
	static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	
	//经度到像素X值
	private function lngToPixel($lng,$zoom) {
		return ($lng + 180) * (256 << $zoom) / 360;
	}
	
	//像素X到经度
	private function pixelToLng($pixelX,$zoom){
		return $pixelX * 360 / (256 << $zoom) - 180;
	}
	
	//纬度到像素Y
	private function latToPixel($lat, $zoom) {
		$siny = sin($lat * pi() / 180);
		$y = log((1 + $siny) / (1 - $siny));
		return (128 << $zoom) * (1 - $y / (2 * pi()));
	}
	//像素Y到纬度
	private function pixelToLat($pixelY, $zoom) {
		$y = 2 * pi() * (1 - $pixelY / (128 << $zoom));
		$z = pow(M_E, $y);
		$siny = ($z -1) / ($z + 1);
		return asin($siny) * 180 / pi();
	}
	 
	private function xy_fk( $number )
	{
		$fp = fopen(__dat_db__,'rb'); //■1■.将 r 改为 rb
		$myxy = $number;//#"112262582";
		$left = 0;//开始记录
		$right = datmax;//结束记录
	
		//采用用二分法来查找查数据
		while($left <= $right)
		{
			$recordCount =(floor(($left + $right) / 2)) * 8; //取半
			@fseek ( $fp, $recordCount , SEEK_SET ); //设置游标
			$c = fread($fp,8); //读8字节
			$lon = unpack('s',substr($c,0,2));
			$lat = unpack('s',substr($c,2,2));
			$x = unpack('s',substr($c,4,2));
			$y = unpack('s',substr($c,6,2));
			$jwd = $lon[1] . $lat[1];
	
			if ($jwd == $myxy){
			   fclose($fp);
			   return $x[1] . '|' . $y[1];
			   break;
			}else if($jwd < $myxy){
			   $left = ($recordCount / 8) + 1;
			}else if($jwd > $myxy){
			   $right = ($recordCount / 8) - 1;
			}
		}
		
		fclose($fp);
	}
	
	// 转换经纬度到,lat->纬度,lng->经度
    public function geoLatLng($lat,$lng)
	{
		//$lat = '36.678527';
		//$lon = '117.136745';
		$tmplng = intval($lng * 100);
		$tmplat = intval($lat * 100);
		$offset = $this->xy_fk($tmplng . $tmplat);
		$off = explode('|',$offset);
		$lngPixel = $this->lngToPixel($lng,18) + $off[0];
		$latPixel = $this->latToPixel($lat,18) + $off[1];
		
		$mixLat = $this->pixelToLat($latPixel,18);
		$mixLng = $this->pixelToLng($lngPixel,18);

		$ary_result = array('lat' => $mixLat , 'lng' => $mixLng);

        return $ary_result;
    }
}
?>