<?php
class Member_Controller_Fdrs extends Base_Controller_Fdrs
{
	private function assign_member_types($show_all_item = false)
	{
		$types = Config_Modeller::member_types($show_all_item,true);
		$types = json_encode($types);
		$this->assign('member_types',$types);
	}

	public function index()
	{
		$this->assign_member_types(true);
		$this->display('member/index.html');
	}

	//录入、编辑
	public function input()
	{
		$id = (int)$_GET['id'];

		$data = 'null';
		if($id > 0){
			$o = Member_Modeller::getInstance();
			$array = $o->get_member(array('id' => $id));

			unset($array['isdeleted']);
			unset($array['enabled']);
			$data = json_encode($array);
		}
		$this->assign('data', $data);

		$this->assign_member_types();
		$this->assign('id', $id);
		$this->display('member/input.html');
	}

	public function get_members()
	{
		$type_id = (int)$_POST['type_id'];
		
		$o = Member_Modeller::getInstance();
		$ary_filter = null;
		if($type_id > 0){
			$ary_filter[] = " type_id = '{$type_id}' ";
		}
		
		$ary_filter[] = "isdeleted = 0";
		if($ary_filter != null){ $strfilter = ' where ' . join(' and ',$ary_filter); }

		$pageSize = (int)$_POST['pageSize'];
		$p = new showpage('pageIndex');
		$total = $o->ReturnTotal($strfilter,'fdrs_member');
		$p->set($pageSize,$total);

		$r['total'] = $total;
		$data = null;

		if($total > 0){
			$q = $o->get_members($strfilter,$p->limit());
			if($q != null)
			{
				$types = Config_Modeller::member_types();
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
	public function upload_logo()
	{
		$this->upload_photo_common('member');
	}

	public function save_member()
	{
		$id = (int)$_POST['id'];
		$title = System::removebadstring($_POST['title']);
		$type_id = System::removebadstring($_POST['type_id']);
		$note = System::removebadstring($_POST['note']);
		$site_url = System::removebadstring($_POST['site_url']);

		$types = Config_Modeller::member_types();

		if(!in_array($type_id,array_keys($types))){
			$this->json('您没有选择所在分类',0);
		}

		$photos = $this->upload_photo_common('member',true);
		if($id <= 0 && $photos == null){
			$this->json('您没有上传图片',0);
		}

		$args = null;
		if($id > 0){ $args['id'] = $id; }
		$args['title'] = $title;
		$args['type_id'] = $type_id;
		$args['note'] = $note;
		$args['site_url'] = $site_url;

		if($photos != null){
			$args['logo_path'] = $photos['s_path'];
		}

		$o = Member_Modeller::getInstance();
		if($o->save($args)){
			$this->json('保存成功',1);
		}else{
			if($photos != null){
				System::deletefile($photos['s_path']);
				// System::deletefile($photos['b_path']);
			}
			$this->json(System::toString($o->MSG,'<br/>'),0);
		}
	}

	public function delete_member()
	{
		Util::Log($_POST);
		$this->json('..',0);
		$ids = System::removebadstring($_POST['Ids']);
		if($ids == ''){
			$this->json('参数不足',0);
		}
		$o = Member_Modeller::getInstance();
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
		$o = Member_Modeller::getInstance();
		$o->update_enabled($ids,$status);
		$this->json('保存成功');
	}
}
?>