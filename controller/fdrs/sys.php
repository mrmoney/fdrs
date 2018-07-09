<?php
class Sys_Controller_Fdrs extends Base_Controller_Fdrs
{
	//受保护的企业号账户
	private $ary_protected_users = array('mrmoney','13710111151');
	
	public function index()
	{
		$ary_status = Config_Modeller::testreq_status(true);
	 	$this->assign('ary_status',json_encode($ary_status));
		
		$this->display('user/sys.html');
	}
	
	public function input()
	{
		$Id = (int)$_GET['id'];
		$data = null;
		$o = InternalUser_Modeller::getInstance();

		if($Id > 0)
		{
			$ary_filter['Id'] = $Id;
			$q = $o->queryFields('*',$ary_filter,'sysusers');
			if($q == null){ $this->not_found(); }
			$q['userpwd'] = '';
			$data = $q;
		}

		$ary_status = Config_Modeller::sysuser_status(true);
	 	$this->assign('ary_status',json_encode($ary_status));
		
		//用户角色
		$ary_user_roles = Config::$ary_user_roles;
		$ary_roles = null;
		foreach($ary_user_roles as $k => $ary_user_role)
		{
			if(!is_array($ary_user_role))
			{
				$ary_roles[] = array('id' => $ary_user_role);	
			}
			else
			{
				$ary_roles[] = array('id' => $k);	
				foreach($ary_user_role as $v)	
				{
					$ary_roles[] = array('id' => $v,'pid' => $k);	
				}
			}
		}
	 	$this->assign('ary_user_roles',json_encode($ary_roles));
		
		$data = $data == null?'null':json_encode($data);
	 	$this->assign('data',$data);
		
	 	$this->assign('Id',$Id);
		$this->assign('public_key',PUBLIC_JS_KEY);
		
		$this->display('user/input.html');
	}
	
	public function users()
	{
		$ary_filter = null;
		
		$usertype = System::removebadstring($_POST['usertype']);
		$userstatus = System::removebadstring($_POST['ustatus']);
		$realname = System::removebadstring($_POST['fieldvalue']);
		$departmentId = System::removebadstring($_POST['departmentId']);
		$strfilter = '';
		
		$o = InternalUser_Modeller::getInstance();
		$p = new showpage('pageIndex');
		if($userstatus != ''){ $ary_filter[] = "ustatus in ({$userstatus}) "; }

		if(strlen($realname) >= 2){ $ary_filter[] = "realname like '%$realname%'"; }
		if($ary_filter != null){ $strfilter = 'where ' . join(' and ',$ary_filter); }
		
		$page_size = (int)$_POST['pageSize'];
		
		$total = $o->getTotal($strfilter,'sysusers');
		$p->set($page_size,$total);
		
		if($total > 0){
			$q = $o->queryuser($strfilter,$p->limit());
		}
		
		$resultData = array('total' => $total,'data' => $q);
		$this->json_list($resultData);
	}
	
	public function save_user()
	{
		$Id = (int)$_POST['Id'];
		$tel = System::removebadstring($_POST['tel']);
		if(!Util::checkMobile($tel))
		{
			$this->json('手机号码格式不正确',0);
		}
		
		$userpwd = System::removebadstring($_POST['userpwd']);
		$userpwd = Util::rsa_decode($userpwd);
		if($userpwd == ''){ 
			$userpwd = '没有改变密码';
		}else{
			if(in_array($userpwd,Config_Modeller::$bad_pwds)){
				$this->json('您输入的登录密码过于简单',0);
			}

			if(strlen($userpwd) <= 5){
				$this->json('密码长度不能少于五位',0);
			}
		}

		$username = System::removebadstring($_POST['username']);
		$realname = System::removebadstring($_POST['realname']);
		$sex = System::removebadstring($_POST['sex']);
		$ustatus = (int)$_POST['ustatus'];
		$roles = System::removebadstring($_POST['roles']);
		$shopname = System::removebadstring($_POST['shopname']);
		$note = System::removebadstring($_POST['note']);
		

		$args = array(
					'Id' => $Id,
					'username' => $username,
					'userpwd' => $userpwd,
					'realname' => $realname,
					'sex' => $sex,
					'ustatus' => $ustatus,
					'roles' => $roles,
					'tel' => $tel,
					'note' => $note,
				);

		$o = InternalUser_Modeller::getInstance();
		if($o->saveuser($args))
		{
			if($userpwd != '没有改变密码')
			{
				// 发送短信通知其账户和密码
				$o = Message_Modeller::getInstance();
	        	$params = array($username,$userpwd);
	        	$r = $o->sendByTencent($tel,$params,'133630');
			}
			$this->json('保存成功');
		}
		else
		{
			$error_text = System::toString($o->MSG,'<br/>');
			$this->json($error_text,0);
		}
		
	}
	
	//修改用户的状态
	public function update_status()
	{
		$status = (int)$_POST['status'];	
		$rows = $_POST['rows'];
		
		if(is_array($rows)){
			$o = InternalUser_Modeller::getInstance();
			$ary_ids = null;
			foreach($rows as $row){
				$ary_ids[] = $row['Id'];
			}
			
			$ids = join(',',$ary_ids);
			if($o->update_status($status,$ids)){
				$this->json('保存成功');
			}else{
				$error_text = System::toString($o->MSG,'<br/>');
				$this->json($error_text,0);
			}
		}else{
			$this->json('没有要修改的用户',0);
		}
	}
	
	//删除禁用的、离职的、非管理员账户
	public function delete()
	{
		$rows = $_POST['rows'];
		if(is_array($rows)){
			$o = InternalUser_Modeller::getInstance();
			$ary_ids = null;
			foreach($rows as $row){
				$ary_ids[] = $row['Id'];
			}
			
			$ids = join(',',$ary_ids);
			if($o->deleteuser($ids)){
				$this->json('删除成功');
			}else{
				$error_text = System::toString($o->MSG,'<br/>');
				$this->json($error_text,0);
			}
		}else{
			$this->json('没有要删除的用户',0);
		}
		
		$this->json($content);
	}
}
?>