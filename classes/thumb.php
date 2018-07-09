<?php


/**
 * 缩略图生成类
 */
require_once ("phpthumb/phpthumb.class.php");
class Thumb extends phpthumb {
	/** 
	 *  水印字符 
	 * @var <string> 
	 */
	private $wmtStr = 'www.uCoulor.com';
	/** 
	 *  水印字体大小 1-5 
	 * @private <int> 
	 */
	private $wmtFontSize = 5;

	/** 
	 *  允许生成的源图形mime类型 
	 * @private <array> 
	 */
	private $allowed_mime_types = array (
		'image/jpeg',
		'image/pjpeg',
		'image/gif',
		'image/png'
	);

	/** 
	 *  错误输出数组 
	 * @private <array> 
	 */
	private $errors = array ();
	/** 
	 *  phpThumb 调试信息 
	 * @private <array> 
	 */
	private $debugMsg = array ();
	/** 
	 *  图像默认宽 px 
	 * @private <int> 
	 */
	private $width = 200;

	/** 
	 *  图像默认高 px 
	 * @private <int> 
	 */
	private $height = 250;

	/** 
	 *  图像缩放 
	 * @private <float> 
	 */
	private $zoom_crop = 0;
	/** 
	 *  jpg 输出质量 
	 * @private <int> 
	 */
	public $q = 95;

	public function __construct(){
		$this->setParameter('config_allow_src_above_docroot', true);  
	    $this->setParameter('w',$this->width);  
	    $this->setParameter('h',$this->height);  
	    $this->setParameter('zc',$this->zoom_crop);  
	    $this->setParameter('q',$this->q);
	}
	/**
	 * 生成缩略图
	 * 	<code>
	  *   $this->setParameter('config_allow_src_above_docroot', true);  
	  *   $this->setParameter('w',$this->width);  
	  *   $this->setParameter('h',$this->height);  
	  *   $this->setParameter('zc',$this->zoom_crop);  
	  *   $this->setParameter('q',$this->q);
	  *  //设置水印  
	  *  $this->setParameter('fltr', "wmt|www.ucolor.com|{$this->wmtFontSize}|BR|EE3322");
	  * </code>
	  * @param string 源文件路径
	  * @param string 缩略图保存路径
	  * @return bool 如果成功true,否则false 
	 */
	public function createThumb($source_path, $to_path) {
		$this->setSourceFilename($source_path);
		return $this->GenerateThumbnail() && $this->RenderToFile($to_path);
	}
}
?>
