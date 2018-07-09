<?php
class View_Controller_Www extends Data_Controller_Www
{
	// 在首页读取最新的研究课题
	private function index_subject($o)
	{
		$types = Config_Modeller::cms_types();
		$type_id = 1;
		$num = 20;
		$rows = $this->query_top_cms($o,$types,$type_id,$num,'detail');

		// 获得研究课题
		$subject_items = null;
		if($rows){
			foreach($rows as $row){
				$photo_path = null;
				$photos = $row['photos'][0];
				if(is_array($photos)){
					$photo_path = $photos['s_path'];
				}else{
					$photos = Util::get_images($row['detail']);
					if(is_array($photos)){
						$photo_path = $photos[0];
					}else{
						continue;
					}
				}
				$row['photo_path'] = $photo_path;
				$detail = System::substrcn($row['detail'],126);
				$row['detail'] = $detail;

				unset($row['photos']);
				$subject_items[] = $row;
			}
		}

		// 根据符合条件的课题获取相关文章
		if($subject_items != null){
			$items = null;
			foreach($subject_items as $subject_item){
				$type_id = $subject_item['id'];
				$rows = $this->query_top_cms($o,$types,$type_id,4);
				$subject_item['items'] = $rows;
				$items[] = $subject_item;
			}
		}

		// Util::Log($items);
		$this->assign('subjects',$items);

		// 课题 数量
		$this->assign_items_num($items,'subject');
	}

	private function index_members($type_id = 0)
	{
		$o = Member_Modeller::getInstance();
		$ary_filter = null;
		if($type_id > 0){
			$ary_filter[] = " type_id = '{$type_id}' ";
		}
		
		$ary_filter[] = "isdeleted = 0";
		if($ary_filter != null){ $strfilter = ' where ' . join(' and ',$ary_filter); }

		$rows = $o->get_members($strfilter,'limit 0,40');

		$members = null;
		if($rows){
			$total = count($rows);
			$page_size = 6;
			$page_count = ceil($total / $page_size);
			for ($i = 1; $i <= $page_count; $i ++) { 
				for ($j = ($i - 1) * $page_size; $j < $i * $page_size; $j ++) { 
					$row = $rows[$j];
					if(!is_array($row)){ continue; }
					$members[($i - 1)][] = $row;
				}
			}
			// Util::Logs($total,$page_count,$members);
		}

		$this->assign('members',$members);

		// 课题 数量
		$this->assign_items_num($members,'members');
	}

	private function assign_items_num($items,$key)
	{
		$num = 0;
		if($items != null){ $num = count($items); }
		$this->assign($key . '_num',$num);
	}

	//默认首页
	public function index()
	{
		$o = Cms_Modeller::getInstance();
		$types = Config_Modeller::cms_types();

		$this->index_subject($o);

		$num = 6;
		// 金融聚焦
		$type_id = 2;
		$rows = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$this->assign('jrjj',$rows);
		$this->assign_items_num($rows,'jrjj');

		// 研究会动态
		$type_id = 3;
		$rows = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$this->assign('yjhdt',$rows);
		$this->assign_items_num($rows,'yjhdt');

		// 会员动态
		$type_id = 4;
		$rows = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$this->assign('hydt',$rows);
		$this->assign_items_num($rows,'hydt');

		// 政策法规
		$type_id = 5;
		$rows = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$this->assign('zcfg',$rows);
		$this->assign_items_num($rows,'zcfg');

		// 活动公告
		$type_id = 6;
		$rows = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$this->assign('hdgg',$rows);
		$this->assign_items_num($rows,'hdgg');

		// 顶部导航菜单
		$this->head_menus($cat_id = 0);

		$this->assign_photos('1-1','photos_focus');

		// 加载会员logo
		$this->index_members();

		$this->display('index-2.html');
	}

	//文章列表
	public function contents()
	{
		$type_id = (int)$_GET['type_id'];
		$types = Config_Modeller::cms_types();
		if(!in_array($type_id,array_keys($types))){
			$this->not_found(null,'此栏目不存在');
		}

		$o = Cms_Modeller::getInstance();

		// 默认只加载最新的100篇
		$num = 100;
		$q = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$items = null;
		if($q){
			foreach($q as $array){
				$detail = System::substrcn($array['detail'],300,false);
				$array['detail'] = $detail;
				$items[] = $array;
			}
		}

		// Util::Logs($items,$q);
		$this->assign('items',$items);

		// 分类名称
		$typename = $types[$type_id]['text'];
		$this->assign('typename',$typename);

		$cats = array(
						2 => 2,// 金融聚焦
						6 => 4,// 活动公告
					);
		$cat_id = (int)$cats[$type_id];
		$this->head_menus($cat_id);

		$this->display('cms/list.html');
	}

	// 新闻类内容详情
	public function cms_detail()
	{
		$id = (int)$_GET['id'];
		if($id <= 0){
			$this->error_res(null,'参数错误');
		}

		$o = Cms_Modeller::getInstance();
		$array = $o->get_cms($id);
		if(is_array($array)){
			if((int)$array['isdeleted'] > 0 || (int)$array['enabled'] < 1){
				$this->error_res(null,'该内容已下架或已删除');
			}

			// 是否为研究课题
			$is_subject = $array['is_subject'] == '1';

			$types = Config_Modeller::cms_types();
			if($is_subject){
				// 查询该课题的相关信息
				$obj_subject = $o->get_cms($array['type_id']);
				$array['subject'] = $obj_subject;
				$array['typename'] = System::returnText($obj_subject['topic'],'未知课题');
			}else{
				// 当前内容分类名称
				$typename = $types[$array['type_id']]['text'];
				$array['typename'] = System::returnText($typename,'未分类');
			}

			// 当前分类下的其他文章
			$rows = null;
			if($array['type_id'] > 0){
				$num = 5;
				$type_id = $array['type_id'];
				$rows = $this->query_top_cms($o,$types,$type_id,$num);
			}
			$this->assign('r_rows',$rows);

			$array['publishtime'] = date('Y-m-d',strtotime($array['publishtime']));
			$photos = json_decode($array['photos'],true);

			unset($array['photos']);
			$data['frm'] = $array;
			$data['photos'] = $photos;
			
			// Util::Log($data);
			$this->assign('data', $data);
			$this->assign('id', $id);
			$this->assign('is_subject', $is_subject);
			
			if($is_subject){
				// 研究课题
				$cat_id = 3;
			}else{
				switch($array['type_id']){
					case 2:$cat_id = 2;break;// 金融聚焦
					case 6:$cat_id = 4;break;// 活动公告
					default:$cat_id = 0;break;
				}
			}
			$this->head_menus($cat_id);
			$this->display('cms/detail.html');
		}else{
			$this->error_res(null,'不存在该内容');
		}
	}

	// 研究课题类内容详情
	public function subject_detail()
	{
		$id = (int)$_GET['id'];
		if($id <= 0){
			$this->error_res(null,'参数错误');
		}

		$o = Cms_Modeller::getInstance();
		$array = $o->get_cms($id);
		if(is_array($array)){
			if((int)$array['isdeleted'] > 0 || (int)$array['enabled'] < 1){
				$this->error_res(null,'该内容已下架或已删除');
			}

			$types = Config_Modeller::cms_types();

			// 查询旗下都有哪些文章
			$items = null;
			$num = 100;
			$q = $this->query_top_cms($o,$types,$array['id'],$num,'detail');
			if($q){
				foreach($q as $item){
					$detail = System::substrcn($item['detail'],300,false);
					$item['detail'] = $detail;
					$items[] = $item;
				}
			}
			$this->assign('items',$items);
			

			// 当前分类下的其他文章
			$rows = null;
			if($array['type_id'] > 0){
				$num = 5;
				$type_id = $array['type_id'];
				$rows = $this->query_top_cms($o,$types,$type_id,$num);
			}
			$this->assign('r_rows',$rows);

			$array['publishtime'] = date('Y-m-d',strtotime($array['publishtime']));
			$photos = json_decode($array['photos'],true);

			unset($array['photos']);
			$data['frm'] = $array;
			$data['photos'] = $photos;
			
			// Util::Log($data);
			$this->assign('data', $data);
			$this->assign('id', $id);
			
			$this->head_menus($cat_id = 3);
			$this->display('subject/detail.html');
		}else{
			$this->error_res(null,'不存在该内容');
		}
	}

	//联系我们
	public function contact()
	{
		$this->display('contact.html');
	}

	//预约试驾
	public function testreq()
	{
		$this->display('testreq.html');
	}

	//关于我们 -> 简介
	public function about_intro()
	{
		$config = $this->get_config('1-2');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 1);
		$this->display('about/intro.html');
	}

	//关于我们 -> 章程
	public function about_rules()
	{
		$config = $this->get_config('1-3');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 1);
		$this->display('about/rules.html');
	}

	// 会员申请
	public function member_join()
	{
		$this->head_menus($cat_id = 6);
		$this->display('member/join-1.html');
	}

	// 研究会成员 -> 组织架构
	public function member_org()
	{
		$config = $this->get_config('2-2');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 5);

		$this->assign('title_text','组织架构');
		$this->display('member/index.html');
	}

	// 研究会成员 -> 学术委员会
	public function member_academic()
	{
		$config = $this->get_config('2-3');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 5);

		$this->assign('title_text','学术专家委员会');
		$this->display('member/index.html');
	}

	// 研究会成员 -> 专家顾问委员会
	public function member_expert()
	{
		$config = $this->get_config('2-4');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 5);
		
		$this->assign('title_text','顾问专家委员会');
		$this->display('member/index.html');
	}

	// 研究会成员 -> 会长/副会长/秘书长/监事会/理事会
	public function member_leader1()
	{
		// 会长/副会长
		$config = $this->get_config('2-5');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 5);
		
		$this->assign('title_text','会长/副会长/秘书长');
		$this->display('member/index.html');
	}

	// 研究会成员 -> 会长/副会长/秘书长/监事会/理事会
	public function member_leader2()
	{
		// 监事会
		$config = $this->get_config('2-6');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 5);
		
		$this->assign('title_text','监事会');
		$this->display('member/index.html');
	}

	// 研究会成员 -> 会长/副会长/秘书长/监事会/理事会
	public function member_leader3()
	{
		// 理事会
		$config = $this->get_config('2-7');
		$this->assign('config',$config);

		$this->head_menus($cat_id = 5);
		
		$this->assign('title_text','理事会');
		$this->display('member/index.html');
	}

	// 会员列表
	public function member_list()
	{
		// 读取所有会员
		$o = Member_Modeller::getInstance();
		$ary_filter = null;
		if($type_id > 0){
			$ary_filter[] = " type_id = '{$type_id}' ";
		}
		
		$ary_filter[] = "isdeleted = 0";
		if($ary_filter != null){ $strfilter = ' where ' . join(' and ',$ary_filter); }

		$rows = $o->get_members($strfilter,$limit = '','note');
		$members = null;
		if($rows){
			foreach($rows as $row){
				$note = System::substrcn($row['note'],150);
				$row['note'] = $note;
				$members[] = $row;
			}
		}
		$this->assign('members',$members);
		
		$this->head_menus($cat_id = 5);
		$this->display('member/members.html');
	}

	// 查询会员详情
	public function member_detail()
	{
		$id = (int)$_GET['id'];
		if($id <= 0){
			$this->error_res(null,'参数错误');
		}

		$o = Member_Modeller::getInstance();
		$array = $o->get_member(array('id' => $id));
		if(is_array($array)){
			if((int)$array['isdeleted'] > 0 || (int)$array['enabled'] < 1){
				$this->error_res(null,'该内容已下架或已删除');
			}
		}

		// Util::Log($array);
		$this->assign('array', $array);
		$this->assign('id', $id);

		$this->display('member/detail-2.html');
	}

	// 研究课题 -> 首页
	public function subject_index()
	{
		$o = Cms_Modeller::getInstance();

		// 默认只加载最新的100篇
		$type_id = 1;// 即为课题
		$num = 100;
		$q = $this->query_top_cms($o,$types,$type_id,$num,'detail');
		$items = null;
		if($q){
			foreach($q as $array){
				$detail = System::substrcn($array['detail'],600,false);
				$array['detail'] = $detail;
				$items[] = $array;
			}
		}

		// Util::Logs($items,$q);
		$this->assign('items',$items);

		$this->head_menus($cat_id = 3);

		$this->display('subject/index.html');
	}	
}
?>
