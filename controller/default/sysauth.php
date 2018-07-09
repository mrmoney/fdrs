<?php
class Sysauth_Controller_Default extends Base_Controller_Default
{
	//登录界面
	public function login()
	{
		if($this->is_valid_user(null,false,false))
		{
			header('Location:/?app=default_controller_fdrs&act=index');
			exit;
		}

		$this->assign('public_key',PUBLIC_JS_KEY);

		$this->display('login.admin.html');
	}

	public function check()
	{
		if($this->is_post){
			$username = Util::paramsString('username');
			$userpwd = Util::paramsString('userpwd');


			$userpwd = Util::rsa_decode($userpwd);
			if(strlen($username) <= 3 || strlen($userpwd) <= 5){
				$this->json('账户或者密码不合法',0);
			}

			$o = InternalUser_Modeller::getInstance();
			$result = $o->authuser($username,$userpwd);
			if($result){
				$this->json('登录成功!',1,'/?app=default_controller_fdrs&act=index');
			}else{
				$this->json(join('，',$o->MSG),0);
			}
		}else{
			$this->display('login_v2018.html');
		}
	}

	public function logout()
	{
		if(isset($_SESSION[SYS_SESSION_KEY])){
			unset($_SESSION[SYS_SESSION_KEY]);
		}
		header('Location:/'/* . $this->cfg['sso_login_url']*/);
	}
}
?>