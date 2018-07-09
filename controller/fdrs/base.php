<?php
/**
 * 控制器基类
 */
class Base_Controller_Fdrs extends Base_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->configTemplate();
	}

	public function configTemplate()
	{
		$this->config_tpl('fdrs');
	}

	protected function checkLogin()
	{
		$this->checkLogin_common();
	}

	protected function checkPriv() { }

	protected function addLog() { }

	public function message($content,$params = array()) { }

	// 文件上传通用处理
	protected function upload_photo_common($dir,$is_return = false)
	{
		// Util::Log($_POST);
		$default_w = (int)$_POST['w']; // 默认的最大宽度
		$default_h = (int)$_POST['h']; // 默认的最大高度
		if($default_w <= 0){ 
			$default_w = $dir == 'member'?400:1000;
		}

		$f = $_FILES['Fdata'];
		$upload = new Upload();
		$saveDir = '/images/' . $dir . '/' . date('Ymd');
		$upload->__set('saveDir', $saveDir);
		$upload->__set('allowedFileExtention', array(
														'jpg','gif','png',
														// 'doc','docx',
														// 'xls','xlsx',
														// 'ppt','pptx',
														// 'zip','rar',
													));
		$upload->__set('boolforceResize', true);
		$upload->__set('bfileWidth', $default_w);
		if($default_h > 0){
			$upload->__set('bfileHeight', $default_h);
		}

		$is_to_thumb = $dir == 'member'?false:true;
		$upload->__set('boolCreateThumbnail', $is_to_thumb);
		$upload->__set('sfileWidth', 400);
		$upload->__set('sfileHeight', 400);

		if($upload->run($f)){
			$data['s_path'] = $upload->__get('sfilePath');
			$data['b_path'] = $upload->__get('bfilePath');
			if(!$is_return){
				$this->json('上传成功',1,$data);
			}else{
				return $data;
			}
		}else{
			if(!$is_return){
				$message = '文件上传失败,原因是：' . $upload->__get('MSG');
				$this->json($message,0);
			}else{
				return null;
			}
		}
	}

	//删除还未保存的
	public function remove_uploding()
	{
		$srv_data = $_POST['srv_data'];
		if(is_array($srv_data)){
			System::deletefile($srv_data['s_path']);
			System::deletefile($srv_data['b_path']);
		}
		$this->json('删除成功');
	}

}
?>