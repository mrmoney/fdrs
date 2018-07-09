<?php
class Photo_Controller_Fdrs extends Base_Controller_Fdrs
{
	private function assign_photo_types($show_all_item = false)
	{
		$types = Config_Modeller::photo_types($show_all_item,true);
		$types = json_encode($types);
		$this->assign('photo_types',$types);
	}

	public function index()
	{
		$this->assign_photo_types(true);
		$this->display('photo/index.html');
	}

	//录入、编辑照片，详情模式
	public function input_v2()
	{
		$type = System::removebadstring($_GET['type']);
		$id = (int)$_GET['id'];

		$data = 'null';
		if($id > 0){
			$o = Photo_Modeller::getInstance();
			$array = $o->get_photo(array('id' => $id));

			// 获取软文/专题信息
			$obj_content = array('value' => 0,'text' => '');
			$content_id = (int)$array['content_id'];
			$subject_id = (int)$array['subject_id'];

			if($content_id > 0){
				$q = $o->queryFields('topic',array('id' => $content_id),
									'fdrs_cms_content');
				if($q){
					$obj_content['value'] = $content_id;
					$obj_content['text'] = $q['topic'];
				}
			}elseif($subject_id > 0){
				$q = $o->queryFields('topic',array('id' => $subject_id),
									'fdrs_cms_content');
				if($q){
					$obj_content['value'] = $subject_id;
					$obj_content['text'] = $q['topic'];
				}
			}
			$array['content'] = $obj_content;

			unset($array['isdeleted']);
			unset($array['enabled']);
			$data = json_encode($array);
		}
		$this->assign('data', $data);

		$this->assign_photo_types();
		$this->assign('id', $id);
		$this->assign('type', $type);
		$this->display('photo/input.html');
	}

	public function get_photos()
	{
		$type_id = System::removebadstring($_POST['type_id']);
		
		$o = Photo_Modeller::getInstance();
		$ary_filter = null;
		if($type_id != ''){
			$ary_filter[] = " type_id = '{$type_id}' ";
		}
		
		$ary_filter[] = "isdeleted = 0";
		if($ary_filter != null){ $strfilter = ' where ' . join(' and ',$ary_filter); }

		$pageSize = 100;//(int)$_POST['pageSize'];
		$p = new showpage('pageIndex');
		$total = $o->ReturnTotal($strfilter,'fdrs_photo');
		$p->set($pageSize,$total);

		$r['total'] = $total;
		$data = null;

		if($total > 0){
			$q = $o->get_photos($strfilter,$p->limit());
			if($q != null)
			{
				$types = Config_Modeller::photo_types();
				foreach($q as $array)
				{
					$typename = $types[$array['type_id']]['text'];
					$array['typename'] = System::returnText($typename,'未分类');
					$data[] = $array;
				}	
				
			}
		}
		
		$r['data'] = $data;
		$this->json_list($r);
	}

	//文件上传
	public function upload_photo()
	{
		$this->upload_photo_common('photo');
	}

	// 图片快速上传保存
	public function save_photos_v1()
	{
		$types = Config_Modeller::photo_types();

		$type_id = System::removebadstring($_POST['type_id']);
		$rows = $_POST['photos'];
		if(!in_array($type_id,array_keys($types))){
			$this->json('未指定当前图片所在栏目',0);
		}

		if(!is_array($rows) || count($rows) <= 0){
			$this->json('未上传图片',0);
		}

		$o = Photo_Modeller::getInstance();
		$photos = null;
		foreach($rows as $row){
			$s_path = $row['srv_data']['s_path'];
			$b_path = $row['srv_data']['b_path'];
			if($s_path == ''){ continue; }
			if($b_path == ''){ continue; }
			if(!file_exists(ROOT . $s_path)){ continue; }
			if(!file_exists(ROOT . $b_path)){ continue; }
			$args = null;
			$args = array(
					'type_id' => $type_id,
					's_path' => $s_path,
					'b_path' => $b_path,
				);

			if(!$o->save($args)){
				System::deletefile($args['s_path']);
				System::deletefile($args['b_path']);
			}
		}

		$this->json('保存成功',1);
	}

	// 完整版图片录入保存
	public function save_photos_v2()
	{
		$id = (int)$_POST['id'];
		$title = System::removebadstring($_POST['title']);
		$type_id = System::removebadstring($_POST['type_id']);
		$content_id = (int)$_POST['content_id'];
		$subject_id = (int)$_POST['subject_id'];
		$note = System::removebadstring($_POST['note']);

		$types = Config_Modeller::photo_types();

		if(!in_array($type_id,array_keys($types))){
			$this->json('您没有选择所在分类',0);
		}

		$photos = $this->upload_photo_common('photo',true);
		if($id <= 0 && $photos == null){
			$this->json('您没有上传图片',0);
		}

		if($subject_id > 0){ $content_id = 0; }

		$args = null;
		if($id > 0){ $args['id'] = $id; }
		$args['title'] = $title;
		$args['type_id'] = $type_id;
		$args['content_id'] = $content_id;
		$args['subject_id'] = $subject_id;
		$args['note'] = $note;

		if($photos != null){
			$args['s_path'] = $photos['s_path'];
			$args['b_path'] = $photos['b_path'];
		}

		$o = Photo_Modeller::getInstance();
		if($o->save($args)){
			$this->json('保存成功',1);
		}else{
			if($photos != null){
				System::deletefile($photos['s_path']);
				System::deletefile($photos['b_path']);
			}
			$this->json(System::toString($o->MSG,'<br/>'),0);
		}
	}

	public function delete_photo()
	{
		$ids = System::removebadstring($_POST['Ids']);
		if($ids == ''){
			$this->json('参数不足',0);
		}
		$o = Photo_Modeller::getInstance();
		if($o->delete($ids)){
			$this->json('删除成功');
		}else{
			$this->json(System::toString($o->MSG,'<br/>'),0);
		}
	}

	public function update_enabled()
	{
		$status = (int)$_POST['status'];
		$ids = System::removebadstring($_POST['Ids']);
		if($ids == ''){
			$this->json('参数不足',0);
		}
		$o = Photo_Modeller::getInstance();
		$o->update_enabled($ids,$status);
		$this->json('保存成功');
	}
}
?>