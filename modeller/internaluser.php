<?php
class InternalUser_Modeller extends Base_Modeller
{
	public $table = 'sysusers';
	public $key = 'Id';

	static $instance;

	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	//保存登录账户资料
	public function saveuser($args)
	{
		$userId = (int)$args['Id'];
		if($userId <= 0){
			$strfilter = sprintf(" where username='%s' ",$args['username']);
			if($this->checkExists($strfilter)){
				$this->MSG[] = $args['username'] . '已经存在';
				return false;
			}

			$args['userpwd'] = md5($args['userpwd']);
			if($this->add($args)){
				return true;
			}else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}else{
			if($args['userpwd'] == '没有改变密码'){
				unset($args['userpwd']);
			}else{
				$args['userpwd'] = md5($args['userpwd']);
			}

			unset($args['Id']);
			if($this->update($args,$userId)){
				return true;
			}else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}
	}

	//查询用户
	public function queryuser($strfilter,$limit = '')
	{
		$sql = sprintf("select * from sysusers %s order by
							Id desc %s",$strfilter,$limit);
		$q = $this->getAll($sql);
		return $q;
	}

	//删除用户
	public function deleteuser($ids)
	{
		$sql=sprintf("delete from sysusers where ustatus in (0,2)
						and Id in (%s) and Id > 1 ",$ids);
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '删除失败[' . $this->DBERROR() . ']';
			return false;
		}
	}

	//更改用户的使用状态
	public function update_status($new_status,$ids)
	{
		$sql=sprintf("update sysusers set ustatus = %d
						where Id in (%s) and Id > 1 ",
						$new_status,$ids);
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '保存失败[' . $sql . ']';
			return false;
		}
	}

	//检查当前账户是否因为登录错误次数过多而临时锁定
	protected function check_islocked($username)
	{
		$key = md5($username . '-err-times');
		$r = (int)Util::pullCache($key);
		if($r >= 5){
			$this->MSG[] = '密码错误次数过多,请稍后再试';
		}
		return $r;
	}

	//通过输入账户和密码验证登录账户
	public function authuser($username,$userpwd)
	{
		$err_times = $this->check_islocked($username);
		if($err_times >= 5){ return false; }
		$result = false;

		//username和tel都是唯一的
		$sql = Util::isMobile($username)
			?	sprintf("SELECT * FROM sysusers WHERE (tel = '%s')",$username)
			:	sprintf("SELECT * FROM sysusers WHERE (username = '%s')",$username);
		$qs = $this->getAll($sql,false);//Util::Log($sql);
		if(!$qs){
			$this->MSG[] = '您输入的账户或者密码不正确';
			return false;
		}else{
			$q = $qs[0];
			$input_pwd = md5($userpwd);
			$saved_pwd = $q['userpwd'];
			if($input_pwd != $saved_pwd){
				$key = md5($username . '-err-times');
				$err_times ++;
				Util::pushCache($key,$err_times,60);

				$this->MSG[] = '您输入的账户或者密码不正确';
				return false;
			}else{
				$result = $this->check_common($qs);
				return $result;
			}
		}
	}

	private function check_common($q)
	{
		$result = false;
		if($q != null){
			$array = $q[0];
			switch((int)$array['ustatus'])
			{
				case 0:
					$this->MSG[] = '该帐户已经被锁定!';
					break;
				case 1:
					$cfg = include(ROOT_PATH.'/conf/config.php');
					$admins = $cfg['admin'];
					$is_manager = in_array($array['username'],$admins);
					$roles = $array['roles'];
					$ary_roles = array();
					if($roles != ''){ $ary_roles = explode(',', $roles); }

					$userInfo = array(
										'username' => $array['username'],
										'realname' => $array['realname'],
										'roles' => $ary_roles,//角色
										'userId' => $array['Id'],

										'is_manager' => $is_manager,
										'phone' => $array['tel'],//我的手机号码
									);

					$_SESSION[SYS_SESSION_KEY] = $userInfo;
					$result = true;
					break;
				case 2:
					$this->MSG[] = '当前员工已经离职!';
					break;
				default:
					$this->MSG[] = '未知的错误!';
					break;
			}
		}else{
			$this->MSG[] = '用户名或者密码错误!';
		}

		return $result;
	}

	//修改密码
	public function update_password($args)
	{
		$userId = session('userId');
		//先校验当前登录的密码是否正确
		$filter = sprintf("where Id=%d and userpwd='%s'",$userId,$args['pre_userpwd']);
		if(!$this->checkExists($filter,'sysusers')){
			$this->MSG[] = '修改失败，您输入的原密码不正确!';
			return false;
		}

		$filter = sprintf("where userId=%d and usertype=1 and password='%s'",
								$userId,$args['new_userpwd']);
		if($this->checkExists($filter,'pwd_history')){
			$this->MSG[] = '您曾使用过该密码，为了安全，请更换一个!';
			return false;
		}

		$sql = sprintf("update sysusers set userpwd='%s' where Id=%d",
							$args['new_userpwd'],$userId);
		if($this->execute($sql)){
			//将此密码列入历史密码
			$username = session('username');
			$new_args['userId'] = $userId;
			$new_args['username'] = $username;
			$new_args['usertype'] = 1;
			$new_args['savetime'] = time();
			$new_args['password'] = $args['new_userpwd'];
			$this->add($new_args,'pwd_history');

			return true;
		}else{
			$this->MSG[] = '修改失败[' . $this->DBERROR() . ']';
			return false;
		}
	}

}
?>