<?php
class Me_Controller_Fdrs extends Base_Controller_Fdrs
{
	//检查是否为弱口令
	public function check_password()
	{
		$pwd_is_bad = (int)session('pwd_is_bad');
		$this->json($pwd_is_bad);
	}

	//自行修改密码
	public function update_mypwd()
	{
		$this->assign('public_key',PUBLIC_JS_KEY);
		$this->display('user/update-password.html');
	}

	//修改密码
	public function save_mypwd()
	{
		$pre_userpwd = $_POST['pre_userpwd'];
		$new_userpwd = $_POST['new_userpwd'];

		$pre_userpwd = Util::rsa_decode($pre_userpwd);
		$new_userpwd = Util::rsa_decode($new_userpwd);
		if(in_array($new_userpwd,Config_Modeller::$bad_pwds)){
			$this->json('您输入的密码过于简单,请重新设置一个',0);
		}

		$args['pre_userpwd'] = md5($pre_userpwd);
		$args['new_userpwd'] = md5($new_userpwd);
		$o = InternalUser_Modeller::getInstance();
		if($o->update_password($args)){
			$this->json('修改成功');
		}else{
			$this->json(join('<br/>',$o->MSG),0);
		}

	}
}
?>