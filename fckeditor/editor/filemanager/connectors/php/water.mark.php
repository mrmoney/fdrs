<?php
class WaterMark{ 
	private $gdinfo;//当前GD库的信息 
	private $picpath;//需要水印的图片的路径 
	private $picinfo;//水印图片的信息 
	private $min_width=100;//需要加水印图片的最小宽度 
	private $min_height=30;//最小高度 
	private $mark_border=10;//水印边距 
	private $mark_pct=80;//水印透明度 
	private $errormsg='';//出错信息 
	private $mark_style=0;//水印位置 0：随即 1：左上 2：右上 3：中间 4：左下 5：右下 
	private $is_output=false;//是否输出图象 
	private $image_output_method='imagejpeg';//输出图象的函数 
	
	public function __construct($picpath){ 
	  //检查是否支持GD库 
	  if(!$this->check_gd()){return false;}; 
	  $this->picinfo=$this->get_pic_info($picpath);
	  if($this->picinfo==false){return false;}
	  $this->picpath=$picpath; 
	  if($this->is_necessary()==false){return false;}//检查是否需要加水印 
	}   
	
	/** 
	 *使用图片来显示水印 
	 *@param:$picinfo 
	 *@return : 
	*/ 
	public function markpic($picpath,$newpicpath='',$style=0){ 
		if(empty($style))$style=$this->mark_style; 
		$picim=$this->image_create($this->picinfo); 
		//获取水印图片的信息 
		$waterpic=$this->get_pic_info($picpath); 
		//检查是否适合水印 
		if(($waterpic['width']+2*$this->mark_border>$this->picinfo['width'])||($waterpic['height']+2*$this->mark_border>$this->picinfo['height'])){ 
			return false; 
		} 
		$waterim=$this->image_create($waterpic); 
		//水印合并图片 
		$picim=$this->imagemerge($picim,$waterim,$waterpic['width'],$waterpic['height'],$style); 
		//输出图象 
		$this->output($picim,$newpicpath); 
	} 
	/** 
	 *使用文字来显示水印(只显示英文) 
	 *@param:$string 
	 *@return : 
	*/ 
	private function markstring_en($string,$newpicpath='',$style=0) 
	{ 
	  //todo       
	} 
	/** 
	 *设置对象的属性 
	 *@param:$key $value 
	 *@return  
	*/ 
	public function set($key,$value){ 
		if(array_key_exists($key,get_object_vars($this))){ 
			$this->$key=$value;       
		} 
		return false; 
	} 
	/** 
	 *获取出错信息 
	 *@param void 
	 *@return  
	*/ 
	public function get_error(){ 
		return $this->errormsg; 
	} 
	/*----------------------以下为私有方法-------------------------------------------------*/ 
	/** 
	 *输出图象 
	 *@param:.... 
	 *@return  
	*/ 
	private function output($picim,$newpicpath='') 
	{ 
	   $newpicpath=$this->picinfo['path']; 
	   unlink($this->picinfo['path']); 
		//写入新的文件
		echo $newpicpath;
		imagejpeg($picim,$newpicpath);
	} 
	/** 
	 *合并水印图象 
	 *@param:.... 
	 *@return  
	*/ 
	private function imagemerge($picim,$waterim,$water_width,$water_height,$style=5) 
	{ 
		switch($style) 
		{ 
		 case 0: 
			//随即 
			$position[0]=rand($this->mark_border,$this->picinfo['width']-$this->mark_border-$water_width);//x 
			$position[1]=rand($this->mark_border,$this->picinfo['height']-$this->mark_border-$water_height);//y 
			break; 
		 case 1: 
			//左上 
			$position[0]=$this->mark_border; 
			$position[1]=$this->mark_border; 
			break; 
		 case 2: 
			//右上 
			$position[0]=$this->picinfo['width']-$this->mark_border-$water_width; 
			$position[1]=$this->mark_border; 
			break;     
		 case 3: 
			//居中 
			$position[0]=round(($this->picinfo['width']-$water_width)/2); 
			$position[1]=round(($this->picinfo['height']-$water_height)/2); 
			break; 
		 case 4: 
			//左下 
			$position[0]=$this->mark_border; 
			$position[1]=$this->picinfo['height']-$this->mark_border-$water_height; 
			break; 
		 default: 
			//右下 
			$position[0]=$this->picinfo['width']-$this->mark_border-$water_width; 
			$position[1]=$this->picinfo['height']-$this->mark_border-$water_height; 
			break; 
		} 
		imagecopymerge($picim,$waterim,$position[0],$position[1],0,0,$water_width,$water_height,$this->mark_pct); 
		return $picim; 
	} 
	
	/** 
	 *检查系统环境是否支持GD库 
	 *return: 
	*/ 
	private function check_gd(){ 
		if(!extension_loaded('gd'))
			return false;
		else
			return true;
	} 
	/** 
	 *新建一个基于调色板的图像 
	 *@param:$picinfo 
	 *@return :$im 图象标识符 
	*/ 
	private function image_create($picinfo='') 
	{ 
		if(empty($picinfo))$picinfo=$this->picinfo; 
		//echo $picinfo['mime']; 
		switch(trim($picinfo['mime'])) 
		{ 
		 case 'image/gif': 
			$this->image_output_method='imagegif';//获取输出图象的方法名称 
			return imagecreatefromgif($picinfo['path']); 
			break; 
		 case 'image/jpeg': 
			$this->image_output_method='imagejpeg'; 
			return imagecreatefromjpeg($picinfo['path']); 
			break; 
		 case 'image/png': 
			$this->image_output_method='imagepng'; 
			return imagecreatefrompng($picinfo['path']); 
			break; 
		 case 'image/wbmp': 
			$this->image_output_method='imagewbmp'; 
			return imagecreatefromwbmp($picinfo['path']); 
			break; 
		default: 
			$this->error(3); 
			break; 
		} 
	} 
	/** 
	 *获取图片的信息，主要是高度，宽度、类型 
	 *@param:$path:文件路径 
	 *@return :$picinfo array 
	*/ 
	private function get_pic_info($path) 
	{ 
		if(!file_exists($path)){
			return false;
		}else{
			$info=getimagesize($path); 
			if(empty($info)){return false;}     
			$picinfo['width']=$info[0]; 
			$picinfo['height']=$info[1]; 
			$picinfo['mime']=$info['mime']; 
			$picinfo['path']=$path; 
			return $picinfo;
		}
	} 
	/** 
	 *检查图片是否需要加水印 
	 *@param $picinfo图片信息 
	 *@return boolean 
	*/ 
	private function is_necessary($picinfo=''){ 
		if(empty($picinfo))$picinfo=$this->picinfo; 
		if(!is_array($picinfo)){return false;}; 
		if(($picinfo['width']<$this->min_width)||($picinfo['height']<$this->min_height))
			return false;
		else
			return true; 
	} 
	/** 
	*出错处理 
	*/ 
	private function error($id,$other=''){ 
		switch($id){ 
		 case '0': 
			$errormsg='你的服务器不支持GD库！'; 
			break; 
		 case '1': 
			$errormsg='不是有效的图片！'; 
			break; 
		 case '2': 
			$errormsg='出错：函数is_necessary()中的参数必须是数组！'; 
			break; 
		 case '3': 
			$errormsg='出错：目前水印只支持gif,jpg,png,wbmp四种格式的图片！'; 
			break; 
		 case '4': 
			$errormsg='图片太小，不适合水印！'; 
			break; 
		 default: 
			$errormsg='出错了，原因未知！'; 
			break; 
		} 
		die($errormsg.$other); 
	} 
} 
?>