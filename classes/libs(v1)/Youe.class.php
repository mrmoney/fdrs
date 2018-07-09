<?php
/********************************************************************
 接口提交响应用值说明(响应值类型：字符串)：
 * 0发送成功!
 * 2余额不足!
 * 1用户名或密码错误!
 * 3超过发送最大量100条!  或: 3超过发送最大量1000条!
 * 4此用户不允许发送!
 * 5手机号或发送信息不能为空!
 * 7超过xx个字,请修改后发送!
 * 8用户已冻结，请联系客服人员！
 * 150:当前账户无可获取的用户上行信息
 * 160:当前账户无可获取的状态报告
 ********************************************************************/

/**
 *调用通用短信平台接口方法
 */ 
//echo postSendMessage();
class Youe
{
	private $uid = 'mrmoney';
	private $pwd = 'hanloon654321';
	private $sign = '恒龙云定制';
	
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}

	public function __construct()
	{

	}
	
	//点点通方式个性化发送,建议不要用于验证码群发
	public function postSendDdtMessage($args,$msg = null)
	{ 
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send_ddt/";   //通用短信平台点点通(个性化)接口地址
	
		//$msg = "{value0},您本次的注册验证码{value1}，在{value2}分钟内输入有效。POST提交。【{value3}】";  //要发送的短信内容模板，必须要加签名，签名格式：【签名内容】
		$msg = mb_convert_encoding($msg,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
		
		$ary_params = null;
		foreach($args as $arg)
		{
			$ary_params[] = $arg['values'] . ',' . $this->sign;
		}
		$params = join(';',$ary_params);//"13732288448,123456,10,恒龙定制;13710111151,4567,20,恒龙定制"; 	
		$params = mb_convert_encoding($params,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312

		//参数列表，多条记录之间用英文下的分号(;)间隔,最多不能超过1000条记录。
	
		$msg = urlencode($msg);
		$params = urlencode($params);
	
		$data = array(
			'uid' => $this->uid,
			'pwd' => md5($this->pwd),
			'params' => $params,
			'msg' => $msg,
			'dtime' => '',   //为空，表示立即发送短信;写入时间即为定时发送短信时间，时间格式：0000-00-00 00:00:00
			'linkid' => ''   //为空，表示没有流水号;写入流水号,获取状态报告和短信回复时返回流水号,流水号格式要求:最大长度不能超过32位，数字、字母、数字字母组合的字符串
		);
	
		$results = $this->posttohosts($url,$data);
	
		return $results;
	
		/* 提交成功返回值格式：0发送成功! */
	}
	
	 
	
	/**
	 * 通用短信平台HTTP接口POST方式发送短信实例
	 * 返回字符串
	 * 一般情况下调用此方法
	 */
	public function postSendMessage()
	{ 
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send/";   //通用短信平台接口地址
	
		$msg = "您本次的注册验证码678123，在30分钟内输入有效。POST提交。【通用短信平台】";         //要发送的短信内容，必须要加签名，签名格式：【签名内容】
		$msg = mb_convert_encoding($msg,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
	
		$mobile = "13732288448;13710111151";      //接收短信的手机号码，多个手机号码用英文下的分号(;)间隔,最多不能超过1000个手机号码。
	
		$data = array(
			'uid' => $this->uid,
			'pwd' => $this->pwd,
			'mobile' => $mobile,
			'msg' => $msg,
			'dtime' => '',   //为空，表示立即发送短信;写入时间即为定时发送短信时间，时间格式：0000-00-00 00:00:00
			'linkid' => ''   //为空，表示没有流水号;写入流水号,获取状态报告和短信回复时返回流水号,流水号格式要求:最大长度不能超过32位，数字、字母、数字字母组合的字符串
		);
	
		$results = $this->posttohosts($url,$data);
	
		return $results;
	}
	
	
	
	/**
	 * 通用短信平台HTTP接口POST_urldecode方式发送短信实例
	 * 返回字符串
	 * 短信内容中带有空格、换行等特殊字符时调用此方法
	 */
	public function postSendUrldecodeMessage()
	{
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send_urldecode/";   //通用短信平台接口地址
	
		$msg = "您本次的注册验证码678123，在30分钟内输入有效。POST_URLDECODE提交。【通用短信平台】";         //要发送的短信内容，必须要加签名，签名格式：【签名内容】
		$msg = mb_convert_encoding($msg,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
	
		$mobile = "13732288448;13710111151";      //接收短信的手机号码，多个手机号码用英文下的分号(;)间隔,最多不能超过1000个手机号码。
	
		$uid = urlencode($uid);
		$msg = urlencode($msg);
	
		$data = array(
			'uid' => $this->uid,
			'pwd' => $this->pwd,
			'mobile' => $mobile,
			'msg' => $msg,
			'dtime' => '',   //为空，表示立即发送短信;写入时间即为定时发送短信时间，时间格式：0000-00-00 00:00:00
			'linkid' => ''   //为空，表示没有流水号;写入流水号,获取状态报告和短信回复时返回流水号,流水号格式要求:最大长度不能超过32位，数字、字母、数字字母组合的字符串
		);
	
		$results = $this->posttohosts($url,$data);
	
		return $results;
	}
	
	
	
	/**
	 * 通用短信平台HTTP接口POST_MD5方式发送短信实例
	 * 返回字符串
	 * 用户密码需要加密时,请使用此方法
	 */
	public function postSendMd5Message($mobile,$msg)
	{
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/post_send_md5/";   //通用短信平台接口地址
		
		$msg = '【' . $this->sign . '】' . $msg;
		//$msg = "您本次的注册验证码678123，在30分钟内输入有效。POST_MD5方式提交。【{$this->sign}】";         //要发送的短信内容，必须要加签名，签名格式：【签名内容】
		$msg = mb_convert_encoding($msg,'GBK','UTF-8'); //内容为UTF-8时转码成GB2312
	
		//$mobile = "13732288448;13710111151";      //接收短信的手机号码，多个手机号码用英文下的分号(;)间隔,最多不能超过1000个手机号码。
	
		$data = array(
			'uid' => $this->uid,
			'pwd' => md5($this->pwd),
			'mobile' => $mobile,
			'msg' => $msg,
			'dtime' => '',   //为空，表示立即发送短信;写入时间即为定时发送短信时间，时间格式：0000-00-00 00:00:00
			'linkid' => ''   //为空，表示没有流水号;写入流水号,获取状态报告和短信回复时返回流水号,流水号格式要求:最大长度不能超过32位，数字、字母、数字字母组合的字符串
		);
	
		$results = $this->posttohosts($url,$data);
		$results = mb_convert_encoding($results,'UTF-8','GBK');
	
		return $results;
	}
	
	/**
	 * 通用短信平台HTTP接口GET_MGZ_MD5方式查询敏感字实例
	 * 用fopen时，注意短信内容中不能含有空格
	 * 返回字符串
	 * 检测短信内容中是否含有敏感字时调用此方法
	 */
	public function getMgzMD5()
	{
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/";  //通用短信平台接口地址
		$uid = $this->uid;                         //您在通用短信平台上注册的用户ID
		//$uid=mb_convert_encoding($uid,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
	
		$pwd = md5($this->pwd);                        //对用户密码进行MD5加密码，32位加密算法
	
		$msg = "您本次的注册验证码678123,在30分钟内输入有效,助考,三打哈,金花,不延时,游行。GET_MGZ提交查询。";//要检测的短信内容
		$msg = urlencode($msg);
		
		$results = get_url($url."mgz/?uid=$uid&pwd=$pwd&msg=$msg");    //向远程服务器提交请求
	
		return $results;
	}
	
	
	
	
	
	/**
	 * 通用短信平台HTTP接口GET方式查询余额实例
	 * 返回字符串
	 * 返回值为两行，第一行为用户ID信息，第二行为用户ID余额，单位:条
	 */
	public function getBalance()
	{
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/";  //通用短信平台接口地址
		$uid = $this->uid;                         //您在通用短信平台上注册的用户ID
		//$uid=mb_convert_encoding($uid,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
	
		$pwd = $this->pwd;                    //用户密码
	
		$results = get_url($url."user_info/?uid=$uid&pwd=$pwd");    //向远程服务器提交请求
	
		return $results;
	
		/* 查询成功返回值格式：
	
		用户ID=爱短信
	
		剩余资费=91 */
	
	}
	
	/**
	 * 通用短信平台HTTP接口GET方式获取短信回复实例
	 * 每次获取回复最多可获取20条，超过20条回复分多次轮询获取，每次软询间隔5秒
	 * 每条回复记录为一行，换行符为"\n"
	 * 每行记录包括的字段序列为：手机号码/回复时间/流水号/回复内容/子码  
	 * 每行的每个字段间的分隔符为"/";如果提交短信时linkid为空,则短信回复中流水号字段为系统默认随机值("空"或"0"或"1")
	 * 通过接口只能获取当月回复记录,回复记录不可重复获取
	 */
	public function getRevert()
	{
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/";  //通用短信平台接口地址
		$uid = $this->uid;                         //您在通用短信平台上注册的用户ID
		//$uid=mb_convert_encoding($uid,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
	
		$pwd = $this->pwd;                    //用户密码
	
		$results = get_url($url."reve/?uid=$uid&pwd=$pwd");    //向远程服务器提交请求
	
		//return $results;
	
		/* 成功获取到短信回复格式如下：
		13761836811/2014-10-11 18:39:24//收到/56666
		13761836811/2014-10-11 18:39:36//还可以/56666 */
	
		
	
		//没有可获取的回复记录,返回值为：150
		if($results != 150)
		{
			$returnResponseArr=explode("\n",$results);
			foreach($returnResponseArr as $key => $valueRecord)
			{
				if($valueRecord)
				{
					$fieldArr=explode("/",$valueRecord);
					if($fieldArr[3] != "")
					{
						$smsReplyContentString .= '$mobile' . '=' . $fieldArr[0 ]. '<br>' . 
								'$smsReplyTime' . '=' . $fieldArr[1] . '<br>' . '$lindid' . '='.$fieldArr[2] . 
								'<br>' . '$smsReplyContent' . '=' . $fieldArr[3] . '<br>' . 
								'$extensionCode' . '=' . $fieldArr[4] . '<br>' . 
								'---------------------------------------------'.'<br>';
					}
	
				}
	
			}
	
			return $smsReplyContentString;
	
		}
		else
		{
			return "没有可获取的短信回复记录!";
		}
	}
	
	
	/**
	 * 通用短信平台HTTP接口GET方式获取短信状态报告实例
	 * 每次获取状态报告最多可获取20条，超过20条状态报告记录请分多次轮询获取，每次软询间隔5秒
	 * 每条状态报告记录为一行，换行符为"\n"
	 * 每行记录包括的字段序列为：手机号码/状态报告时间/流水号/状态值/子码  
	 * 每行的每个字段间的分隔符为"/";如果提交短信时linkid为空,则短信状态报告记录中流水号字段为系统默认随机值("空"或"0"或"1")
	 * 通过接口只能获取当月状态报告记录,状态报告记录不可重复获取
	 */
	public function getReport()
	{
		$url = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/";  //通用短信平台接口地址
		$uid = $this->uid;                         //您在通用短信平台上注册的用户ID
		//$uid=mb_convert_encoding($uid,'GB2312','UTF-8'); //内容为UTF-8时转码成GB2312
	
		$pwd = $this->pwd;                    //用户密码
	
		$results = get_url($url."report/?uid=$uid&pwd=$pwd");    //向远程服务器提交请求
	
		//return $results;
	
		/* 成功获取到状态报告格式如下：
		13761836811/2014-10-11 10:22:13//DELIVRD/56666
		13761836811/2014-10-11 12:59:34//DTBLACK/56666
		13761836811/2014-10-11 15:47:12//UNDELIV/56666 */
	
		
	
		//没有可获取的状态报告记录,返回值为：160
		if($results != 160)
		{
			$returnReportArr=explode("\n",$results);
			foreach($returnReportArr as $key => $valueRecord)
			{
				if($valueRecord)
				{
					$faildArr=explode("/",$valueRecord);
					if($faildArr[3] != "")
					{
						$smsReportString .= '$mobile' . '=' . $faildArr[0] . '<br>' . 
								'$smsReportTime' . '=' . $faildArr[1] . '<br>' . 
								'$lindid' . '=' . $faildArr[2] . '<br>' . 
								'$smsReportContent' . '=' . $faildArr[3] . '<br>' . 
								'$userExtensionId' . '=' . $faildArr[4] . '<br>' . 
								'-------------------------------------------' . '<br>';
					}
				}
			}
	
			return $smsReportString;
	
		}
		else
		{
			return "没有可获取的短信状态报告记录!";
		}
	}
	
	/**
	 * 通过POST方式提交
	 */
	private function posttohosts($url, $data)
	{
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_POST, 1);  
		curl_setopt($ch, CURLOPT_URL,$url);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  //连接超时时间
		$result=curl_exec($ch);
		$curl_errno = curl_errno($ch);  
		$curl_error = curl_error($ch); 
		$info  = curl_getinfo($ch);
		curl_close($ch);
		//$log = json_encode($info);
		//putLog($log);
		if($curl_errno >0){  
			return "CURL Error:".$curl_error."(".$curl_errno.")";  
		}
		return $result;
	}
	
	
	
	/**
	 * 通过GET方式提交
	 */
	private function get_url($url)
	{
		$reg = '/^http:\/\/[^\/].+$/';
		if (!preg_match($reg, $url)) die($url ." invalid");
	
		$fp = fopen($url, "r") or die("Open url: ". $url ." failed.");
	
		while($fc = fread($fp, 8192))
		{
			$content .= $fc;
		}
	
		fclose($fp);
	
		if (empty($content))
		{
			$content = "Get url: ". $url ." content failed.";
		}
	
		return $content;
	}
}
?>