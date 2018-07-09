<?php
class Cms_Controller_Fdrs extends Base_Controller_Fdrs
{
	protected function assign_cms_types($show_all_item = false)
	{
		$types = Config_Modeller::cms_types($show_all_item,true);
		$types = json_encode($types);
		$this->assign('cms_types',$types);
	}

	public function index()
	{
		$this->assign_cms_types(true);
		$this->display('cms/index.html');
	}

	public function select_content()
	{
		$this->assign_cms_types(true);
		$this->display('cms/select.html');
	}

	public function select_subject()
	{
		// $this->assign_cms_types(true);
		$this->display('subject/select.html');
	}
	
	//录入、编辑内容
	public function input()
	{
		$type = (int)$_GET['type'];
		$id = (int)$_GET['id'];
		
		$this->assign_cms_types();
		$this->assign('id', $id);
		$this->assign('type', $type);
		$this->display('cms/input-v2.html');
	}

	public function preview()
	{
		$id = (int)$_GET['id'];
		$o = Cms_Modeller::getInstance();
		$array = $o->get_cms($id);
		if(is_array($array)){
			
			$array['publishtime'] = date('Y-m-d',strtotime($array['publishtime']));
			$photos = json_decode($array['photos'],true);

			unset($array['photos']);
			$data['frm'] = $array;
			$data['photos'] = $photos;
			
			$this->assign('data', $data);
			$this->assign('id', $id);
			$this->display('cms/detail.html');
		}else{
			$this->error_res(null,'不存在该内容');
		}

	}
	
	public function query_content()
	{
		$id = (int)$_GET['id'];
		if($id > 0)
		{
			$o = Cms_Modeller::getInstance();
			$array = $o->get_cms($id);
			if(is_array($array)){
				$array['publishtime'] = date('Y-m-d',strtotime($array['publishtime']));
				//组织图片
				$photos = null;
				$saved_photos = json_decode($array['photos'],true);
				if(is_array($saved_photos) && count($saved_photos) > 0){
					$i = 1;
					foreach ($saved_photos as $item) {

						$row = null;
						$row['name'] = '图片' . $i;
						$row['size'] = Util::getsize($item['b_path'],'kb') . 'KB';

						$type = Util::fileExt($item['b_path']);
						$row['type'] = '.' . $type;

						$row['status'] = 1;
						$row['complete'] = 100;
						$row['srv_data'] = $item;

						$i++;

						$photos[] = $row;
					}
				}

				unset($array['photos']);
				$data['frm'] = $array;
				$data['photos'] = $photos;
				
				$this->json(null,1,$data);
			}
			$this->json('不存在该内容',0);
		}

		$this->json('参数错误',0);
	}

	public function query_contents()
	{
		$type_id = (int)$_POST['type_id'];
		$kword = System::removebadstring($_POST['fieldvalue']);
		
		$o = Cms_Modeller::getInstance();
		$ary_filter = null;
		if($type_id > 0)
		{
			$types = $o->return_my_types($type_id);
		}else{
			// 获取除研究课题外的所有内容
			$types = Config_Modeller::cms_common_ids();
		}
		$ary_filter[] = " type_id in({$types}) ";

		$ary_filter[] = "isdeleted = 0";
		if($kword != ''){ $ary_filter[] = "  topic like '%{$kword}%' "; }
		
		if($ary_filter != null){ $strfilter = ' where ' . join(' and ',$ary_filter); }

		$pageSize = (int)$_POST['pageSize'];
		$p = new showpage('pageIndex');
		$total = $o->ReturnTotal($strfilter,'fdrs_cms_content');
		$p->set($pageSize,$total);

		$r['total'] = $total;
		$data = null;

		if($total > 0){
			$q = $o->query_cms($strfilter,$p->limit());
			if($q != null)
			{
				$types = Config_Modeller::cms_types();
				foreach($q as $array)
				{
					$array['publishtime'] = date('Y-m-d',strtotime($array['publishtime']));
					$typename = $types[$array['type_id']]['text'];
					$array['typename'] = System::returnText($typename,'未分类');
					$data[] = $array;
				}	
				
			}
		}
		
		$r['data'] = $data;
		$this->json_list($r);
	}

	public function delete_cms()
	{
		$ids = System::removebadstring($_POST['Ids']);
		if($ids == ''){
			$this->json('参数不足',0);
		}
		$o = Cms_Modeller::getInstance();
		if($o->delete_content($ids)){
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
		$o = Cms_Modeller::getInstance();
		$o->update_enabled($ids,$status);
		$this->json('保存成功');
	}
	
	//转移分类
	public function reset_type()
	{
		$type_id = (int)$_POST['type_id'];
		$ids = System::removebadstring($_POST['Ids']);
		if($ids == ''){
			$this->json('参数不足',0);
		}
		$o = Cms_Modeller::getInstance();
		$o->update_typeid($ids,$type_id);
		$this->json('保存成功');
	}
		
	public function save_cms()
	{
		$data = json_decode(stripslashes($_POST['data']),true);
		$id = (int)$data['id'];
		$type_id = (int)$data['type_id'];
		$order_id = (int)$data['order_id'];

		$topic = System::removebadstring($data['topic']);
		$sectopic = System::removebadstring($data['sectopic']);

		if(strlen($topic) <= 5){
			$this->json('参数不足 -> 未输入主标题',0);
		}

		if($type_id <= 0){
			$this->json('参数不足 -> 未选择所在分类',0);
		}
		
		$detail = System::removebadstring($data['detail'],false);
		$note = System::removebadstring($data['note']);
		if($note == ''){
			//从详情中截取
			$note = System::substrcn($detail,300,false);
		}

		//图片
		$photos = null;
		$ary_photos = $data['photos'];
		if(is_array($ary_photos) && count($ary_photos) > 0){
			foreach ($ary_photos as $row) {
				if(file_exists(ROOT . $row['srv_data']['b_path'])){
					$photos[] = array(
									's_path' => $row['srv_data']['s_path'],
									'b_path' => $row['srv_data']['b_path'],
								);
				}
			}
		}

		$is_home_focus = (int)$data['is_home_focus'];
		if($is_home_focus > 0 && $photos == null){
			$this->json('显示到首页焦点图片区域的文章需要上传至少一张图片',0);
		}

		//发布日期
		$publishtime = System::removebadstring($data['publishtime']);
		
		$args['id'] = $id;
		$args['type_id'] = $type_id;
		$args['order_id'] = $order_id;
		$args['topic'] = $topic;
		$args['sectopic'] = $sectopic;
		$args['detail'] = $detail;
		$args['note'] = $note;
		$args['photos'] = json_encode($photos);
		$args['is_home_focus'] = $is_home_focus;

		if($id <= 0){
			$args['publisher'] = session('realname');
			if($publishtime == ''){
				$publishtime = date('Y-m-d');
			}
		}
			
		if($publishtime != ''){
			$args['publishtime'] = $publishtime;
		}
		
		$o = Cms_Modeller::getInstance();
		if($o->save_content($args)){
			$this->json('保存成功');
		}else{
			$this->json(System::toString($o->MSG,'<br/>'),0);
		}
	}

	//来自新闻活动的文件上传
	public function upload_photo()
	{
		$this->upload_photo_common('cms');
	}
}
?>
