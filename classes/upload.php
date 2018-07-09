<?php
define('UPLOADDIR',$_SERVER['DOCUMENT_ROOT']);

class Upload 
{
	private $saveDir/*存放目录,必须以"/"开头*/;
	private $extName/*当前被处理的文件后缀名*/;
	private $bfileInfo/*大文件信息数组*/,$sfileInfo/*小文件信息数组*/,$ofileInfo/*原始文件信息数组*/;
	private $bfilePath/*大文件完整路径*/,$sfilePath/*小文件的完整路径*/,$ofilePath/*原始文件的完整路径*/;
	private $bfilePaths/*系列大文件完整路径*/,$sfilePaths/*系列小文件的完整路径*/,$ofilePaths/*系列原始文件的完整路径*/;
	private $bfileSize/*大文件的大小*/,$sfileSize/*缩略图文件的大小*/,$ofileSize/*原始文件的大小*/;
	private $bfileWidth=800/*大文件的宽*/,$sfileWidth=300/*小文件的宽*/,$ofileWidth=300/*原始文件的宽*/;
	private $bfileHeight=800/*大文件的高*/,$sfileHeight=300/*小文件的高*/,$ofileHeight=300/*原始文件的高*/;
	private $bfileNameOnly/*大文件的仅文件名*/,$sfileNameOnly/*小文件的仅文件名*/,$ofileNameOnly/*原始文件的仅文件名*/;
	private $filekey;//原始字段的名字
	private $srcfilename;//原始文件的名字
	private $boolCreateThumbnail=false/*是否生产缩略图*/;
	private $boolforceResize=false;
	private $boolrename=true;
	private $resetkey=false;
	private $boolsavesrcfile=false;//是否保留原始文件
	private $allowedFileExtention=array('gif','jpg','jpeg','png','plt')/*允许上传的文件的类型*/;
	private $allowedSize=5120000;
	private $forcelimitsize=true;
	private $fileType/*被上传的文件类型*/;
	//水印信息----
	private $boolWaterMark=false;
	private $waterType=1;//水印类型,1为图片水印,2为文字水印,目前仅仅支持图片水印
	private $waterImagePath = '/images/logoforwater.gif';//需要水印的图片的路径 
	private $waterImageInfo;//水印图片的信息 
	private $waterImageMinWidth=100;//需要加水印图片的最小宽度 
	private $waterImageMinHeight=30;//最小高度 
	private $waterImageBorder=10;//水印边距 
	private $waterImageTrans=80;//水印透明度 
	private $waterImagePosition=0;//水印位置 0：随即 1：左上 2：右上 3：中间 4：左下 5：右下 
	//水印信息结束----------
	private $error_code,$MSG;
	
	public function __get($property_name)
	{
		if(isset($this->$property_name))
			return $this->$property_name;
		else
			return NULL;
	}
	
	public function __set($property_name,$value)
	{
		if(array_key_exists($property_name,get_object_vars($this)))
			$this->$property_name=$value;
	}
	
	public function __construct()
	{		
		$this->saveDir = '/resource/uploads/' . date('Ymd');
		if(!is_dir(UPLOADDIR . $this->saveDir))
			@mkdir(UPLOADDIR . $this->saveDir,'0777',true);//建立多级目录
	}
	
	private function isImage($ext_name)
	{
		$ary_ext_names=array('gif','jpg','jpeg','png','bmp');
		return in_array(strtolower($ext_name),$ary_ext_names);
	}
	
	public function __destruct()
	{
		//to destroy object
	}
	
	/**
	*	多文件上传
	* 	@param $uploadedFiles $_FILES
	* 	@return true/false
	* */
	public function runs($uploadedFiles=null)
	{
		//多文件上传-------
		$result=false;
		$filekeys=array_keys($uploadedFiles);
		foreach ($filekeys as $filekey)
		{
			if($uploadedFiles[$filekey]['name']!='')
			{
				if($this->run($uploadedFiles[$filekey]))
				{
					$tmpkey=$filekey;
					if($this->resetkey){$tmpkey=$filekey.$this->randStr(12);}
					$this->bfilePaths[$tmpkey]=$this->bfilePath;
					if($this->boolCreateThumbnail)
					{
						$this->sfilePaths[$tmpkey]=$this->sfilePath;
					}
					$this->bfileNameOnly=$this->sfileNameOnly='';
					$result=true;
				}
				elseif($this->error_code!='001') 
				{
					//删除已经上传的文件
					$this->deletefiles($this->bfilePaths);
					$this->deletefiles($this->sfilePaths);
					$result=false;
					break;
				}
			}
		}
		return $result;
	}
	
	public function saveArrayFile($arrayFiles)
	{
		//数组文件上传
		$result=true;
		for ($i=0; $i<count($arrayFiles); $i++)
		{
			$this->extName=substr(strrchr($arrayFiles['name'][$i], '.'), 1);
			if(!in_array(strtolower($this->extName),$this->allowedFileExtention))
			{
				continue;
			}
			else
			{
				if(class_exists(Guid))
				{
					$guid=new Guid();
					$this->bfileNameOnly=strtolower($guid->toString(false)) . '.' . $this->extName;
				}else{
					$this->bfileNameOnly=strtolower(
													$this->randStr(8) . 
													/*'-' . */$this->randStr(4) . 
													/*'-' . */$this->randStr(4) . 
													/*'-' . */$this->randStr(4) .
													/*'-' . */$this->randStr(12)
													) . '.' . $this->extName;
				}
				$this->bfilePath=$this->saveDir . '/' . $this->bfileNameOnly;
				if(!move_uploaded_file($arrayFiles['tmp_name'][$i],UPLOADDIR . $this->bfilePath))
				{
					continue;
				}
				else
				{
					$this->bfilePaths[$i]=$this->bfilePath;
					if(!$this->isImage($this->extName))
					{
						//若不是图片文件...
						$this->sfilePaths[$i]=$this->sfilePath;
						continue;
					}
					chmod(UPLOADDIR . $this->bfilePath,0755);
					$this->bfileInfo=$this->getImageInfo(UPLOADDIR . $this->bfilePath);
					if(is_array($this->bfileInfo)){$this->fileType=$this->bfileInfo['mime'];}
					if($this->gdInstalled())
					{
						//thumbnail picture now---
						if($this->boolCreateThumbnail && $this->bfileInfo['width'] <= $this->bfileWidth)
						{
							//it will get sfileNameOnly and sfilePath
							$this->Thumbnail($this->fileType,UPLOADDIR . $this->bfilePath);
						}
						else
						{
							//否则只是不让图片大到一定程度
							$this->sfileNameOnly=$this->bfileNameOnly;
							$this->sfilePath=$this->bfilePath;
						}
						if($this->boolCreateThumbnail || $this->boolforceResize)
						{
							$image=$this->createImage($this->fileType,
								UPLOADDIR . $this->bfilePath);
							if($image)
							{
								$this->ResizeImage($image,$this->bfileWidth,$this->bfileHeight,
									UPLOADDIR . $this->bfilePath);
								imagedestroy($image);
							}
						}
						if($this->boolWaterMark)
						{
							$this->markImage(UPLOADDIR . 
													  $this->waterImagePath,UPLOADDIR . $this->bfilePath);
						}
						//end thumbnail----------
					}
					else
					{
						//$this->MSG='本文件处理程序要求GD库的支持,否则不能生产缩略图!';
						$this->sfileNameOnly=$this->bfileNameOnly;
						$this->sfilePath=$this->bfilePath;
					}
					$this->sfilePaths[$i]=$this->sfilePath;
				}
				if(isset($guid)){unset($guid);}
			}
			$this->bfileNameOnly=$this->sfileNameOnly='';
		}
		return $result;
	}
	
	public function run($uploadedFile=null)
	{
		if((int)$uploadedFile['size']<=0){
			$this->error_code='001';
			$this->MSG='没有指定要上传的文件!';
			return false;
		}else{
			if(empty($this->saveDir)){
				$this->error_code='002';
				$this->MSG='没有指定文件保存路径!';
				return false;
			}else{
				if(!is_dir(UPLOADDIR . $this->saveDir))
				{
					//尝试建立
					if(!@mkdir(UPLOADDIR . $this->saveDir,'0777',true))
					{
						$this->error_code='003';
						$this->MSG='保存文件的路径[' . $this->saveDir . ']不存在!';
						return false;
					}
				}
			}
			$this->bfileSize=$uploadedFile['size'];
			$this->fileType=$uploadedFile['type'];
			
			
			if($this->bfileSize>$this->allowedSize&&$this->forcelimitsize){
				$this->error_code='004';
				$this->MSG='该文件太大[' . sprintf("%01.2f",$this->bfileSize/1024) . 'K],
							已经超过限制的大小:' . sprintf("%01.2f",$this->allowedSize/1024). 'K!';
				return false;
			}
			
			$this->extName=substr(strrchr($uploadedFile['name'], '.'), 1);
			$this->srcfilename=rtrim($uploadedFile['name'],"." . $this->extName);
			
			if($this->allowedFileExtention!='*')
			{
				if(!in_array(strtolower($this->extName),$this->allowedFileExtention))
				{
					$this->error_code='005';
					$this->MSG='该类型的文件不允许上传[' . $this->extName . ']!';
					return false;
				}
			}
			
			if($this->boolrename||$this->boolCreateThumbnail)
			{
				if($this->bfileNameOnly==''){
					//发生这个可能的一般情况是在新增文件时--
					if(class_exists('Guid')){						
						$guid=new Guid();
						$this->bfileNameOnly=strtolower($guid->toString(false)) . '.' . 
										$this->extName;						
					}else{
						$this->bfileNameOnly=strtolower(
														$this->randStr(8) . 
														/*'-' . */$this->randStr(4) . 
														/*'-' . */$this->randStr(4) . 
														/*'-' . */$this->randStr(4) .
														/*'-' . */$this->randStr(12)
														) . '.' . $this->extName;
					}
					
					//如果要保留原始文件--
					if($this->boolsavesrcfile){
						if(class_exists(Guid)){
							$guid=new Guid();							
							$this->ofileNameOnly=strtolower($guid->toString(false)) . '.' . $this->extName;
						}else{
							$this->ofileNameOnly=strtolower(
															$this->randStr(8) . 
															/*'-' . */$this->randStr(4) . 
															/*'-' . */$this->randStr(4) . 
															/*'-' . */$this->randStr(4) .
															/*'-' . */$this->randStr(12)
															) . '.' . $this->extName;
						}
					}
				}else{
					//请在外部指定原始文件的名字---
					//这个可能一般是在覆盖文件的时候-------------
				}
			}
			else
			{
				//不对原文件进行重命名
				$this->bfileNameOnly=$uploadedFile['name'];
				if($this->boolsavesrcfile){
					$this->ofileNameOnly="src_" . $this->bfileNameOnly;
				}
			}
			$this->bfilePath=$this->saveDir . '/' . $this->bfileNameOnly;
			if($this->boolsavesrcfile){
				$this->ofilePath=$this->saveDir . '/' . $this->ofileNameOnly;
			}
			if(!move_uploaded_file($uploadedFile["tmp_name"],UPLOADDIR . $this->bfilePath))
			{
				$this->error_code='006';
				$this->MSG='文件上传失败!';
			}
			else
			{
				chmod(UPLOADDIR . $this->bfilePath,0755);
				$this->bfileInfo=$this->getImageInfo(UPLOADDIR . $this->bfilePath);
				if(is_array($this->bfileInfo)){$this->fileType=$this->bfileInfo['mime'];}
				if($this->boolsavesrcfile){
					//拷贝一份已经上传的图片称为原始文件--
					@copy(UPLOADDIR . $this->bfilePath,UPLOADDIR . $this->ofilePath);
				}
			}
			if(isset($guid)){unset($guid);}
			
			if(!$this->isImage($this->extName))
			{
				//若非图片文件..
				$this->sfileNameOnly=$this->bfileNameOnly;
				$this->sfilePath=$this->bfilePath;
				return true;
			}
			
			if($this->gdInstalled())
			{
				//thumbnail picture now---
				if($this->boolCreateThumbnail && $this->bfileInfo['width'] > $this->sfileWidth)
				{
					//it will get sfileNameOnly and sfilePath
					$this->Thumbnail($this->fileType,UPLOADDIR . $this->bfilePath);
				}
				else
				{
					//否则只是不让图片大到一定程度
					$this->sfileNameOnly=$this->bfileNameOnly;
					$this->sfilePath=$this->bfilePath;
				}
				if(/*$this->boolCreateThumbnail || */$this->boolforceResize)
				{
					$image=$this->createImage($this->fileType,UPLOADDIR . $this->bfilePath);
					if($image){
						$this->ResizeImage($image,$this->bfileWidth,$this->bfileHeight,
										   UPLOADDIR . $this->bfilePath);
						imagedestroy($image);
					}
				}
				if($this->boolWaterMark){
					$this->markImage(UPLOADDIR . $this->waterImagePath,
									 UPLOADDIR . $this->bfilePath);
				}
				//end thumbnail----------
			}else{
				//$this->MSG='本文件处理程序要求GD库的支持,否则不能生产缩略图!';
				$this->sfileNameOnly=$this->bfileNameOnly;
				$this->sfilePath=$this->bfilePath;
			}
			return true;
		}
	}
	
	private function markImage($waterImage,$markedImage){
		//先获取水印图片的信息
		$waterImageInfo=$this->getImageInfo($waterImage);
		$markedImageInfo=$this->getImageInfo($markedImage);
		if(is_array($waterImageInfo)){
			//检查下是否适合打水印
			if(
				($waterImageInfo['width']+2*$this->waterImageBorder  > $markedImageInfo['width'])
					||
				($waterImageInfo['height']+2*$this->waterImageBorder > $markedImageInfo['height'])
				){
				$this->error_code='008';
				$this->MSG='被打水印的图片太小!';
				return false; 
			}
			$waterImage=$this->createImage($waterImageInfo['mime'],$waterImage);
			$markedImage=$this->createImage($markedImageInfo['mime'],$markedImage);
			$picim=$this->mergeImage(
										$markedImage,
										$waterImage,
										$waterImageInfo['width'],
										$waterImageInfo['height'],
										$markedImageInfo['width'],
										$markedImageInfo['height']
										);
			imagejpeg($picim,UPLOADDIR . $this->bfilePath,100);
			imagedestroy($waterImage);
			imagedestroy($markedImage);
			return true;
		}else{
			return false;
		}
	}

	private function mergeImage($picim,$waterim,$waterwidth,$waterheight,$srcwidth,$srcheight){ 
		switch($this->waterImagePosition){ 
		 case 0: 
			//随即
			$position[0]=rand($this->waterImageBorder,$srcwidth-$this->waterImageBorder-$waterwidth);//x 
			$position[1]=rand($this->waterImageBorder,$srcheight-$this->waterImageBorder-$waterheight);//y 
			break; 
		 case 1: 
			//左上 
			$position[0]=$this->waterImageBorder; 
			$position[1]=$this->waterImageBorder; 
			break; 
		 case 2: 
			//右上 
			$position[0]=$srcwidth-$this->waterImageBorder-$waterwidth; 
			$position[1]=$this->waterImageBorder; 
			break;     
		 case 3: 
			//居中 
			$position[0]=round(($srcwidth-$waterwidth)/2); 
			$position[1]=round(($srcheight-$waterheight)/2); 
			break; 
		 case 4: 
			//左下 
			$position[0]=$this->waterImageBorder; 
			$position[1]=$srcheight-$this->waterImageBorder-$waterheight; 
			break; 
		 default: 
			//右下 
			$position[0]=$srcwidth-$this->waterImageBorder-$waterwidth; 
			$position[1]=$srcheight-$this->waterImageBorder-$waterheight; 
			break; 
		} 
		imagecopymerge($picim,$waterim,$position[0],$position[1],0,0,$waterwidth,$waterheight,$this->waterImageTrans); 
		return $picim; 
	} 
	
	private function getImageInfo($filePath){
		if(!file_exists($filePath)){
			$this->error_code='009';
			$this->MSG='文件路径不正确!';
			return false;
		}else{
			if(!$this->gdInstalled()){
				$this->error_code='010';
				$this->MSG='本文件处理程序要求GD库的支持,否则不能生产缩略图!';
				return false;
			}else{
				$info=getimagesize($filePath); 
				$picinfo['width']=$info[0]; 
				$picinfo['height']=$info[1]; 
				$picinfo['mime']=$info['mime']; 
				$picinfo['path']=$info['path']; 
				return $picinfo;
			}
		}
	}
	
	private function createImage($imgType,$file){
		if($imgType == "image/jpeg"){ 
			$image = imagecreatefromjpeg($file); 
		}elseif($imgType == "image/png"){ 
			$image = imagecreatefrompng($file); 
		}elseif($imgType == "image/gif"){ 
			$image = imagecreatefromgif($file); 
		}elseif($imgType == "image/wbmp"){
			$image = imagecreatefromwbmp($file); 
		}else{
			$image=null;
		}
		return $image;
	}
	
	private function Thumbnail($imgType,$file,$forcenew=false)
	{
		$image=$this->createImage($imgType,$file);
		if($image){ 
			//如果要创建小图片			
			$this->extName=substr(strrchr($file, '.'), 1);
			if($this->sfileNameOnly==''||$forcenew){
				if(class_exists(Guid)){
					$guid=new Guid();
					$this->sfileNameOnly=strtolower($guid->toString(false)) . '.' . $this->extName;
				}else{
					$this->sfileNameOnly=strtolower(
													$this->randStr(8) . 
													/*'-' . */$this->randStr(4) . 
													/*'-' . */$this->randStr(4) . 
													/*'-' . */$this->randStr(4) .
													/*'-' . */$this->randStr(12)
													) . '.' . $this->extName;
				}
			}else{
				//请在外部指定文件名字,不带路径---
				//这个可能一般是在覆盖文件的时候--------
			}
			$this->sfilePath=$this->saveDir . '/' . $this->sfileNameOnly;
			$this->ResizeImage($image,$this->sfileWidth,$this->sfileHeight,
							   UPLOADDIR . $this->sfilePath); 
			imagedestroy($image); 
		}else{
			$this->sfileNameOnly=$this->bfileNameOnly;
			$this->sfilePath=$this->bfilePath;
		}
	}
	
	private function ResizeImage($image,$maxwidth,$maxheight,$name)
	{
		$width = imagesx($image); 
		$height = imagesy($image); 
		$extName=strtolower(substr(strrchr($name, '.'), 1));
		if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight))
		{ 
			if($maxwidth && $width > $maxwidth)
			{ 
				$widthratio = $maxwidth/$width; 
				$RESIZEWIDTH=true; 
			} 
			if($maxheight && $height > $maxheight)
			{ 
				$heightratio = $maxheight/$height; 
				$RESIZEHEIGHT=true; 
			}
		
			if($RESIZEWIDTH && $RESIZEHEIGHT){ 
				if($widthratio < $heightratio){ 
					$ratio = $widthratio; 
				}else{ 
					$ratio = $heightratio; 
				} 
			}elseif($RESIZEWIDTH){ 
				$ratio = $widthratio; 
			}elseif($RESIZEHEIGHT){ 
				$ratio = $heightratio; 
			}
			
			$newwidth = $width * $ratio; 
			$newheight = $height * $ratio; 
			


			if(function_exists('imagecopyresampled'))
			{ 
				$newim = imagecreatetruecolor($newwidth, $newheight); 
				imagealphablending($newim, false); 
				imagesavealpha($newim, true);   
				imagealphablending($image, true); 
				imagecopyresampled($newim, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
			}
			else
			{ 
				$newim = imagecreate($newwidth, $newheight); 
				imagecopyresized($newim, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
			} 
			
			switch($extName)
			{
				case "jpg":
					imagejpeg($newim,$name,100); 
					break;
				case "gif":
					imagegif($newim,$name); 
					break;
				case "png":
					imagepng($newim,$name); 
					break;
				case "bmp":
					imagewbmp($newim,$name); 
					break;
				default:
					imagejpeg($newim,$name,100); 
					break;
			}
			imagedestroy($newim); 
		}
		else
		{ 
			switch($extName)
			{
				case "jpg":
					imagejpeg($image,$name,100); 
					break;
				case "gif":
					imagegif($image,$name); 
					break;
				case "png":
					imagepng($image,$name); 
					break;
				case "bmp":
					imagewbmp($image,$name); 
					break;
				default:
					imagejpeg($image,$name,100); 
					break;
			}
		} 
	} 

	private function randStr($len){ 
		//return rnd string
		$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz'; // characters to build the password from 
		$string=''; 
		for(;$len>=1;$len--) 
		{
			$position=rand()%strlen($chars);
			$string.=substr($chars,$position,1); 
		}
		return $string; 
	}

	private function gdInstalled(){ 
		if(!extension_loaded('gd'))
			return false;
		else
			return true;
	}
	
	public function deletefile($filePath){
		if(is_file(UPLOADDIR . $filePath)){
			@unlink(UPLOADDIR . $filePath);
		}
	}
	
	public function deletefiles($filePaths){
		if(is_array($filePaths)&&$filePaths!=null)
		{
			foreach ($filePaths as $filePath)
			$this->deletefile($filePath);
		}
	}	
}
?>