<?php
class Editor_Controller_Photo extends Base_Controller_Photo
{
	//来自kindeditor的文件上传
	public function upload()
	{
		$f = $_FILES['imgFile'];
		$upload = new Upload();
		$saveDir = '/images/fromeditor/' . date('Ymd');
		$upload->__set('saveDir', $saveDir);
		$upload->__set('allowedFileExtention', array(
														'jpg','gif','png',
														'doc','docx','xls','xlsx','ppt','pptx',
														'pdf','zip','rar',
													));
		$upload->__set('boolforceResize', true);
		$upload->__set('bfileWidth', 800);

		if($upload->run($f)){
			$content = array('error' => 0,'url' => $upload->__get('bfilePath'));
		}else{
			$message = '文件上传失败,原因是：' . $upload->__get('MSG');
			$content = array('error' => 1,'message' => $message);
		}
		
		echo json_encode($content);
	}
}
?>