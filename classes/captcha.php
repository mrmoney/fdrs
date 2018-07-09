<?php
/**

简单用法
include_once(ROOT_PATH.'/includes/cls.captcha.new.php');
$seccode = 'asdf';
$code = new Captcha();
$code->code = $seccode;
$code->display();
 */

class Captcha{

    private $code;            //a-z 范围内随机
    private $width     = 80;        //宽度
    private $height     = 30;        //高度
    private $font = '';
    
	/**
	 * <code>
	 * 四位验证码
	 * $captchaCls = new Captcha_cls(4);
	 * $_SESSION['checkcode'] = $captchaCls->getCode();
	 * $captchaCls->display();
	 * </code>
	 */
    public function __construct($codeLen){
    	$this->code = $this->createCode($codeLen);
    	$this->font = ROOT_PATH.'/includes/cls/arial.ttf';
    }

    public function display(){
       	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	    $im=ImageCreateTrueColor($this->width,$this->height);
	    $white=ImageColorAllocate($im,140,184,63);
	    $blue=ImageColorAllocate($im,255,255,255);
	    imagefill($im,0,0,$blue);
	    // imageline($im,0,$this->lineLefHeight,$this->width,$this->lineRightHeight,0);
	    for($num=0; $num<strlen($this->code); $num++){
			imagettftext($im, rand(12,16), (rand(0,60)+330)%360, 5+15*$num+rand(0,4), 18+rand(0,4),$white, $this->font, $this->code[$num]);
		}
	    //imagestring($im,5,$this->width/4,$this->height/4,$this->code,$white);
	   	header('Content-type:image/gif');
	   	imagegif($im);
	    //ImagePng($im);
	    imageDestroy($im);
    }


	 /**
	 * 生成随机串
	 *
	 * @param   int     $len
	 * @return  string
	 */
	public function createCode($len = 4){
	    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    for ($i = 0, $count = strlen($chars); $i < $count; $i++){
	        $arr[$i] = $chars[$i];
	    }
	    mt_srand((double) microtime() * 1000000);
	    shuffle($arr);
	
	    $code = substr(implode('', $arr), 5, $len);
	    return $code;
	}
	
	public function getCode(){
		return $this->code;
	}
	
	public function setHeight($height){
		$this->height = $height;
	}
	
	public function setWidth($width){
		$this->width = $width;
	}

}

?>