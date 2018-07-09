<?php
class Mail
{
	private $mailer;
	private $_config_=array(
							//by 163...
							//'smtp'=>'smtp.163.com','port'=>25,
							//'username'=>'aguoxinyua@163.com','password'=>'364207',
							//'smtpSecure'=>'',
							//by qqmail
							'smtp'=>'smtp.exmail.qq.com','port'=>465,
							'username'=>'shirt@hanloon.com','password'=>'chenshan@568',
							'smtpSecure'=>'ssl',
							);
	
	private $allow_retry_after_mail_failed=false;
	private $allow_retry_times=6;
	private $sleep_time_before_retry=120; //沉睡2分钟后再试
	public $Result=false;
	public $MSG;
	static $instance;
	
	static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
 
	public function Mail()
	{
		$this->mailer=new PHPMailer(true);
		$this->mailer->IsSMTP();
		$this->mailer->Host       = $this->_config_['smtp'];
		$this->mailer->SMTPAuth   = true;
		$this->mailer->Port       = $this->_config_['port'];
		$this->mailer->Username   = $this->_config_['username'];
		$this->mailer->Password   = $this->_config_['password'];
		$this->mailer->SMTPSecure = $this->_config_['smtpSecure'];
		$this->mailer->SetFrom($this->_config_['username'], System::SiteName);
		$this->mailer->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
	}
	
	//发送普通邮件
	public function send_common_mail($args,$retry_time_now=1)
	{
		try
		{
			$recevers=$args['recever'];
			if(!is_array($recevers))
				$this->mailer->AddAddress($args['recever'], $args['name']);
			else
			{
				foreach($recevers as $recever)
					$this->mailer->AddAddress($recever[0], $recever[1]);
			}
			
			//添加附件..
			$attachement=$args['files'];
			if($attachement!='')
			{
				if(is_array($attachement))
				{
					foreach ($attachement as $file)
						$this->mailer->AddAttachment($file);
				}
				else
					$this->mailer->AddAttachment($attachement);
			}
				
			$this->mailer->Subject = $args['subject'];;
			$this->mailer->MsgHTML($args['content']);
			$this->mailer->Send();
			$this->mailer->ClearAddresses();
			$this->Result=true;
			return true;
		}
		catch(Exception $e)
		{
			if($this->allow_retry_after_mail_failed)
			{
				if($retry_time_now>=$this->allow_retry_times)
					return false;
				else
				{
					@sleep($this->sleep_time_before_retry);
					$retry_time_now++;
					return $this->send_common_mail($args,$retry_time_now);
				}
			}
		}
	}
	
	//发送衬衫尺寸单到工厂
	public function send_cs_to_hongkong($args,$retry_time_now=1)
	{
		try
		{
			$recevers=$args['recever'];
			if(!is_array($recevers))
				$this->mailer->AddAddress($args['recever'], $args['name']);
			else
			{
				foreach($recevers as $recever)
					$this->mailer->AddAddress($recever[0], $recever[1]);
			}
			
			//添加附件..
			$attachement=$args['files'];
			if($attachement!='')
			{
				if(is_array($attachement))
				{
					foreach ($attachement as $file)
						$this->mailer->AddAttachment($file);
				}
				else
					$this->mailer->AddAttachment($attachement);
			}
				
			$this->mailer->Subject = $args['subject'];;
			$this->mailer->MsgHTML($args['content']);
			$this->mailer->Send();
			$this->mailer->ClearAddresses();
			$this->Result=true;
			return true;
		}
		catch(Exception $e)
		{
			System::Log($e);
			if($this->allow_retry_after_mail_failed)
			{
				if($retry_time_now>=$this->allow_retry_times)
					return false;
				else
				{
					@sleep($this->sleep_time_before_retry);
					$retry_time_now++;
					return $this->send_cs_to_hongkong($args,$retry_time_now);
				}
			}
		}
	}
}
?>