<?php
class Default_Controller_Fdrs extends Base_Controller_Fdrs
{
	public function index()
	{
		$realname = session('realname');
	 	$this->assign('realname',$realname);
	 	$this->assign('sso_logout_url',$this->cfg['sso_logout_url']);
		$this->display('index.html');
	}

	public function view_testreq()
	{
		$ary_status = Config_Modeller::testreq_status(true);
	 	$this->assign('statuses',$ary_status);
	 	$this->assign('ary_status',json_encode($ary_status));

		$this->display('view_testreq.html');
	}

	// 获取预约试驾数据
	public function query_testreq()
	{
		$phone_num = System::removebadstring($_POST['phone_num']);
		$realname = System::removebadstring($_POST['realname']);

		$o = Www_Modeller::getInstance();
		$ary_filter = null;
		if(Util::isMobile($phone_num)) {
			$ary_filter[] = " phone='{$phone_num}' ";
		}

		if($realname != '') {
			$ary_filter[] = " realname='{$realname}' ";
		}
		
		$strfilter = null;
		if($ary_filter != null){ $strfilter = ' where ' . join(' and ',$ary_filter); }

		$pageSize = (int)$_POST['pageSize'];
		$p = new showpage('pageIndex');
		$total = $o->ReturnTotal($strfilter,'fdrs_testreq');
		$p->set($pageSize,$total);

		$r['total'] = $total;
		$data = null;

		if($total > 0){
			$q = $o->query_testreq($strfilter,$p->limit());
			$testreq_status = Config_Modeller::testreq_status();
			foreach($q as $array){
				$status_txt = $testreq_status[$array['status']]['text'];
				$array['status_txt'] = $status_txt;
				
				$data[] = $array;
			}
		}
		
		$r['data'] = $data;
		$this->json_list($r);
	}

	//修改预约试驾状态
	public function update_status()
	{
		$status = (int)$_POST['status'];
		$testreq_status = Config_Modeller::testreq_status();
		$ids = System::removebadstring($_POST['ids']);
		if($ids == '' || !is_array($testreq_status[$status])){
			$this->json('参数错误',0);
		}

		$o = Www_Modeller::getInstance();
		$ary_ids = explode(',',$ids);
		$new_ids = null;
		foreach($ary_ids as $id){
			$id = (int)$id;
			if($id <= 0){ continue;}
			$new_ids[] = $id;
		}

		if($new_ids != null){
			$ids = join(',',$new_ids);
			if($o->update_status($ids,$status)){
				$this->json('修改成功',1);
			}else{
				$this->json(System::toString($o->MSG,'<br/>'),0);
			}
		}else{
			$this->json('参数错误',0);
		}
	}

	//尝试删除预约试驾
	public function delete_testreq()
	{
		$ids = System::removebadstring($_POST['ids']);
		if($ids == ''){
			$this->json('参数错误',0);
		}

		$o = Www_Modeller::getInstance();
		$ary_ids = explode(',',$ids);
		$new_ids = null;
		foreach($ary_ids as $id){
			$id = (int)$id;
			if($id <= 0){ continue;}
			$new_ids[] = $id;
		}

		if($new_ids != null){
			$ids = join(',',$new_ids);
			if($o->delete_testreq($ids)){
				$this->json('删除成功',1);
			}else{
				$this->json(System::toString($o->MSG,'<br/>'),0);
			}
		}else{
			$this->json('参数错误',0);
		}
	}
}
?>
