<?php
class Subject_Controller_Fdrs extends Cms_Controller_Fdrs
{
	public function index()
	{
		// $this->assign_cms_types(true);
		$this->display('subject/index.html');
	}

	//录入、编辑课题
	public function input_subject()
	{
		$id = (int)$_GET['id'];
		
		$this->assign('id', $id);
		$this->display('subject/input_subject.html');
	}

	//录入、编辑某课题下的内容
	public function input_item()
	{
		// 查询已录入的课题
		$o = Cms_Modeller::getInstance();
		$filter = 'where type_id = 1';
		$q = $o->query_cms($filter,'');
		if(!$q){
			$this->error_res(null,'您还未录入课题名称');
		}

		$subjects = null;
		foreach($q as $array){
			$row = null;
			$row['id'] = $array['id'];
			$row['text'] = $array['topic'];
			$subjects[] = $row;
		}

		$id = (int)$_GET['id'];
		
		$this->assign('id', $id);
		$this->assign('subjects', json_encode($subjects));
		$this->display('subject/input_item.html');
	}

	public function save_subject()
	{
		$id = (int)$_POST['id'];
		$type_id = (int)$_POST['type_id'];

		if($type_id <= 0){
			$this->json('未选择所在分类',0);
		}

		$del_sign = System::removebadstring($_POST['del_sign']);
		$del_sign = $del_sign == 'true'?true:false;

		$topic = System::removebadstring($_POST['topic']);
		$detail = stripslashes(System::removebadstring($_POST['detail'],false));
		$note = System::substrcn($detail,300,false);

		$args = null;

		// 之前上传的照片
		$now_photos = null;
		$pre_photos = null;

		if(!$del_sign){
			$now_photos = $this->upload_photo_common('cms',true);
			if($now_photos != null){
				$args['photos'] = json_encode(array($now_photos));
			}
		}else{
			// 删除之前的照片
			$args['photos'] = '';
		}

		if($id > 0){ 
			$args['id'] = $id;
		}else{
			$args['publisher'] = session('realname');
			$args['order_id'] = 1;

			$publishtime = date('Y-m-d');
			$args['publishtime'] = $publishtime;
		}

		$args['type_id'] = $type_id;
		$args['topic'] = $topic;
		$args['detail'] = $detail;
		$args['note'] = $note;
		$args['is_subject'] = 1;

		$o = Cms_Modeller::getInstance();
		if($id > 0 && ($now_photos != null || $del_sign)){
			// 查询之前的照片
			$q = $o->get_cms($id,'photos');
			$str_photos = $q['photos'];
			if($str_photos != null){
				$pre_photos = json_decode($str_photos,true);
				$pre_photos = $pre_photos[0];
			}
		}

		if($o->save_content($args)){
			if(($now_photos != null && $pre_photos != null) || $del_sign){
				System::deletefile($pre_photos['s_path']);
				System::deletefile($pre_photos['b_path']);
			}
			$this->json('保存成功',1);
		}else{
			if($now_photos != null){
				System::deletefile($now_photos['s_path']);
				System::deletefile($now_photos['b_path']);
			}
			$this->json(System::toString($o->MSG,'<br/>'),0);
		}
	}
}
?>