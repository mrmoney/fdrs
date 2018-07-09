<?php
//error_reporting(0);
abstract class System
{
	private   	$connid;
	public 		$force_index = null;
	const 		cachetime = 1200;//seconds
	public 	$MSG;
	public 	$return_data;//返回执行结果数据
	
	//仅获取第一个字母
	public static function getfirstchar($s0)
	{   
		$fchar = ord($s0{0});
		if($fchar >= ord('A') and $fchar <= ord('z') )return strtoupper($s0{0});
		$s1 = iconv('UTF-8','GBK', $s0);
		$s2 = iconv('GBK','UTF-8', $s1);
		if($s2 == $s0){$s = $s1;}else{$s = $s0;}
		$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
		if($asc >= -20319 and $asc <= -20284) return 'A';
		if($asc >= -20283 and $asc <= -19776) return 'B';
		if($asc >= -19775 and $asc <= -19219) return 'C';
		if($asc >= -19218 and $asc <= -18711) return 'D';
		if($asc >= -18710 and $asc <= -18527) return 'E';
		if($asc >= -18526 and $asc <= -18240) return 'F';
		if($asc >= -18239 and $asc <= -17923) return 'G';
		if($asc >= -17922 and $asc <= -17418) return 'H';
		//if($asc >= -17922 and $asc <= -17418) return 'I';
		if($asc >= -17417 and $asc <= -16475) return 'J';
		if($asc >= -16474 and $asc <= -16213) return 'K';
		if($asc >= -16212 and $asc <= -15641) return 'L';
		if($asc >= -15640 and $asc <= -15166) return 'M';
		if($asc >= -15165 and $asc <= -14923) return 'N';
		if($asc >= -14922 and $asc <= -14915) return 'O';
		if($asc >= -14914 and $asc <= -14631) return 'P';
		if($asc >= -14630 and $asc <= -14150) return 'Q';
		if($asc >= -14149 and $asc <= -14091) return 'R';
		if($asc >= -14090 and $asc <= -13319) return 'S';
		if($asc >= -13318 and $asc <= -12839) return 'T';
		if($asc >= -12838 and $asc <= -12557) return 'W';
		if($asc >= -12556 and $asc <= -11848) return 'X';
		if($asc >= -11847 and $asc <= -11056) return 'Y';
		if($asc >= -11055 and $asc <= -10247) return 'Z';
		return null;
	}

	public static function remove_space($content)
	{
		$content = preg_replace("'([\r\n])[\s]+'", '', $content);//去除回车换行符
		$content = preg_replace("/[\s]{2,}/",'',$content); //去除连续空白
		$content = preg_replace("/[\n]{1,}/",'',$content); //去除回车换行符
		$content = preg_replace("/[\r]{1,}/",'',$content); //去除回车换行符
		return $content;
	}
	
	public function mb_unserialize($serial_str) 
	{ 
		$data = unserialize($serial_str);
		if(is_array($data)){ return $data; }
		$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str ); 
		$serial_str= str_replace("\r", "", $serial_str); 
		$data = unserialize($serial_str);
		return  $data;
	} 
	 
	 //获取所有所有字符的首字母
	public static function getfirstchars($zh)
	{
		$ret = '';
		$s1 = iconv('UTF-8','gb2312', $zh);
		$s2 = iconv('gb2312','UTF-8', $s1);
		if($s2 == $zh){$zh = $s1;}
		for($i = 0; $i < strlen($zh); $i++)
		{
			$s1 = substr($zh,$i,1);
			$p = ord($s1);
			if($p > 160)
			{
				$s2 = substr($zh,$i++,2);
				$ret .= self::getfirstchar($s2);
			}else{
				$ret .= $s1;
			}
		}
		return $ret;
	}
	
	//往外提交数据
	protected function http_post($url,$param,$post_file=false)
	{
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		}
		
		if (is_string($param) || $post_file) {
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach($param as $key=>$val){
				$aPOST[] = $key."=".urlencode($val);
			}
			$strPOST =  join("&", $aPOST);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus['http_code'])==200){
			return $sContent;
		}else{
			return false;
		}
	}

	/**
	* 连接数据库
	* */
	protected final function Conn()
	{
		$cfg = include (ROOT_PATH . '/conf/config.php');
		$host = $_SERVER['HTTP_HOST'];
		if($host == ''){ $host = 'fdrs.evgo.me'; }
		$dbConf = $cfg[$host];
		$this->connid = @mysqli_connect($dbConf['db_host'],$dbConf['db_username'],
							$dbConf['db_password'],$dbConf['db_name'],$dbConf['db_port']);
		
		$data = null;
		if($this->connid){ $data = @mysqli_query($this->connid,'set names "utf8"'); }
		
		return $data;
	}

	//获取某表的所有列
	public function query_columns($table_name)
	{
		$ary_columns = null;
		if($table_name != '')
		{
			$sql = 'SHOW COLUMNS FROM ' . $table_name;
			$q = $this->query($sql);
			if($q)
			{
				foreach($q as $array)
				{
					$ary_columns[] = $array['Field'];	
				}	
			}
		}
		
		return $ary_columns;
	}
	
	/**
	* 执行数据库IU操作
	* */
	public final function execute($sql)
	{
		//execute insert,update,delete statement--
		//return true / false
		mysqli_query($this->connid,$sql);
		$affectedrows = mysqli_affected_rows($this->connid);
		if($affectedrows < 0){
			$ary[] = $this->DBERROR();
			$ary[] = $sql;
			self::Log($ary);
			return false;
		}else{
			return true;
		}
	}
	
	/**
	* 执行数据库查询操作,如果开启了缓存,则会将查询结果放入缓存
	* */
	public function query($sql,$is_need_num_key = true)
	{
		$s_time = microtime(true);
		//execute selectstatement--
		$result = null;//self::Log($sql);
		if($this->force_index != null)
		{
			if(strstr($sql,'where')){ 
				$sql = str_replace('where',' force index(' . 
						$this->force_index . ') where ',$sql);
			}	
		}
		
		$query = mysqli_query($this->connid,$sql);
		
		$e_time = microtime(true);
		$time_diff = $e_time - $s_time;
		if($time_diff > 2){ 
			Util::Log(array($sql,$time_diff,'from system'),'logs/time');
		}
		
		if($query != null) {
			if($is_need_num_key) {
				//关键和数字都索引
				while($array = mysqli_fetch_array($query)) {
					$result[] = $array;
				}
			} else {
				//只以关键做结果索引
				while($array = mysqli_fetch_assoc($query)) {
					$result[] = $array;
				}
			}
		}
		
		return $result;
	}
	
	/**
	* 获取当前数据库错误信息
	* */
	protected final function DBERROR($other_msg='')
	{
		$strError=@mysqli_error($this->connid);
		if(stristr($strError, 'Duplicate entry'))
			$strError.="\n此错误表明以上双引号中内容已在数据库存在且他不允许重复";
		if($other_msg!='')$strError .= "\n{$other_msg}";
		return '[DB ERROR]' . $strError;
	}
	
	/**
	* 获取最新插入的记录所在的Id值
	* */
	protected final function lastid()
	{
		return mysqli_insert_id($this->connid);
	}

	protected final function killProcess()
	{
		$result = mysqli_query("SHOW PROCESSLIST");
		while ($proc = mysqli_fetch_assoc($result))
		{
			if ($proc["Command"] == "Sleep" && $proc["Time"] > MAX_SLEEP_TIME)
				@mysqli_query("KILL " . $proc["Id"]);
		}
	}
	
	protected final function stmt_init()
	{
		return mysqli_stmt_init($this->connid);
	}
	
	protected final function prepare($stmt,$sql)
	{
		return mysqli_stmt_prepare($stmt,$sql);
	}
	
	protected final function bind_param($stmt,$dataType,$value)
	{
		return mysqli_stmt_bind_param($stmt,$dataType,$value);
	}
	
	protected final function stmt_execute($stmt)
	{
		return mysqli_stmt_execute($stmt);
	}
	
	/**
	* 准备执行transaction
	* */
	public function starttrans()
	{
		return $this->execute('START TRANSACTION');
	}
	
	/**
	* 回滚刚执行完毕的所有IU操作
	* */
	public function rollback()
	{
		return $this->execute('ROLLBACK');
	}
	
	/**
	* 正式提交IU操作
	* */
	public function commit()
	{
		return $this->execute('COMMIT');
	}
	
	/**
	* 返回当前数据库里的表状态
	* */
	protected function return_db_status()
	{
		$sql="SHOW TABLE STATUS";
		$query=$this->query($sql);
		return $query;
	}
	
	/**
	* 优化数据表
	* */
	public function optimize_table()
	{
		$query_tables=$this->return_db_status();
		foreach ($query_tables as $array)
		{
			$sql="OPTIMIZE TABLE " . $array['Name'];
			if(!$this->execute($sql))
			{
				self::Alert($this->DBERROR());
				break;
			}
		}
	}	
	
	/**
	* 返回符合某条件的记录总数
	* strfilter:条件
	* tbname:查询目标表 
	* is_groupby:是否按照group by语句查询
	* str_groupby:groupby的列对象,多个列请用','分割
	* int_group_num:要求groupby出的数量大于多少才符合要求
	* */
	public final function ReturnTotal($strfilter,$tbname,$is_groupby = false,
							$groupby_fieldnames = '',$int_group_num = 1)
	{
		if(!$is_groupby){
			$sql = "select count(1) as total from {$tbname} {$force_index} {$strfilter}";
		}else{
			if($groupby_fieldnames == ''){ return 0; }
			$sql = "select count(1) as total from (select count(1) as samenum from 
						{$tbname} {$strfilter} group by {$groupby_fieldnames} 
						having count(1) > {$int_group_num}) as row_count";
		}
		
		// self::Log($sql);
		$q = $this->query($sql,false);
		$total = $q != null?$q[0]['total']:0;
		
		return $total;
	}
	
	/**
	* 返回符合某条件的记录之和
	* */
	public final function ReturnSum($fieldname,$strCondition,$tbname,$is_log = false)
	{
		$sql = "select COALESCE(SUM($fieldname),0) as sum_num from " . 
							$tbname . ' ' . $strCondition;
		$q = $this->query($sql);
		if($is_log){ Util::Log($sql); }
		if($q != null){
			return $q[0]['sum_num'];
		}else{
			return 0;
		}
	}
	
	/**
	* 检查某记录是否存在
	* */
	public function checkExists($strfilter,$tbname,$force_index = '')
	{
		$result = false;
		if($strfilter != '')
		{
			if($force_index != ''){ 
				$force_index = ' force index(' . $force_index . ') ';
			}

			$sql = "select count(1) as total from $tbname {$force_index} " . $strfilter;
			$q = $this->query($sql);
			if((int)$q[0]['total'] > 0)
			{
				$result = true;
			}
		}
		
		return $result;		
	}
	
	//将数组转换成json对象
	public static function to_json($array,$is_has_key = false)
	{
		$json_data = '[';
		$ary_data = null;
		
		if(is_array($array))
		{
			if($is_has_key)	
			{
				foreach($array as $k => $v)
				{
					$tmp = '{id:"' . $k . '",text:"' . $v . '"}';
					$ary_data[] = $tmp;
				}	
			}
			else
			{
				foreach($array as $v)
				{
					$tmp = '{id:"' . $v . '",text:"' . $v . '"}';
					$ary_data[] = $tmp;
				}	
			}
		}
		
		if($ary_data!=null)
		{
			$json_data .= join(',', $ary_data);
		}
		
		$json_data .= ']';
		
		return $json_data;
	}								
	
	/**
	* 返回指定文件的内容
	* */
	public static function getFileContent($filename)
	{
		if(is_file($filename))
		{
			ob_start();
			include $filename;
			$fileContent = ob_get_contents();
			ob_end_clean();
			return self::utf8_trim($fileContent);
		}
	}
	
	/**
	 * 递归方式的对变量中的特殊字符进行转义
	 * @param string|array 转义内容
	 * @return string|array
	 */
	public static function addslashesDeep($value) 
	{
		if (!empty ($value)) 
		{
			
			if(is_array($value))
				$value = array_map(array(self,'addslashesDeep'), $value);
			else
			{
				if(!get_magic_quotes_gpc())$value=addslashes($value);
			}
			
		}
		return $value;
	}
	
	/**
	* 删除指定字符串中的危险字符,已经包含了删除肮脏词语的功能
	* */
	public static function removebadstring($word,$strip_tags = true,$defaultVal = '')
	{
		if(is_array($word))return $word;
		if($word!='')
		{
			$word=self::utf8_trim($word,' ');
			if(!get_magic_quotes_gpc())$word=self::addslashesDeep($word);
			
			$word=$strip_tags
				?	strip_tags(self::removedirtystring($word))
				:	self::removedirtystring($word);
			
			return $word;
		}
		else
			return $defaultVal;
	} 
	
	/**
	* 删除指定字符串中的肮脏词语
	* */
	public static function removedirtystring($word)
	{
		if(is_array($word))return $word;
		$ary_words=array(
								'fuck','fuckyou','fuck you',
								'操!','操你妈','操你娘','我操',
								'他妈的','她妈的','它妈的','你娘的',
								'他娘的','她娘的','它娘的',
								'靠!','我靠',
								'法轮','大麻','海洛因','鸦片','毒品',
								'贩卖'
							);
		foreach($ary_words as $bad_word)
		{
			if(stristr($word,$bad_word))
				$word=str_replace($bad_word,'***',$word);
		}
		return $word;
	}
	
	/**
	* 返回一个日期数组,返回的数组中包括了Y,m,d
	* */
	public static function returndate($date,$separator='-')
	{
		$date=$date=='' ? $date=date('Y-m-d') : $date;
		$arydate=explode($separator,$date);
		$unixtime=mktime(0,0,0,$arydate[1],$arydate[2],$arydate[0]);
		$arytime=getdate($unixtime);
		return array(
						'y' => $arytime['year'],
						'm' => $arytime['mon'],
						'd' => $arytime['mday']
					);
	}
	
	//给定任何一个标准的日期,返回这个日期所在月份的第一天和最后最后一天
	public static function getFirstAndLastDate($date)
	{
		$firstday = date("Y-m-01",strtotime($date));
		$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
		return array($firstday,$lastday);
	}	
	
	//给定任何一个标准的日期,返回这个日期所在星期的第一天和最后最后一天
	public static function getFirstAndLastWeekDay($date=null)
	{
		if($date == null){ $date = date('Y-m-d'); }
		$w = date('w',strtotime($date));
		if($w == 0){ $w = 7; }
		$now_week_day=$w-1;
		$i=$now_week_day * 60 * 60 * 24;
		$j=time()-$i;
		$firstday = date('Y-m-d',$j);
		
		$next_week_day=7-$w;
		$i=$next_week_day * 60 * 60 * 24;
		$j=time()+$i;
		$lastday = date('Y-m-d',$j);
		return array($firstday,$lastday);
	}	
	
	//纠正日期
	public static function correcttime($time)
	{
		$arytime=explode(' ',$time);
		$date=$arytime[0];
		$arydate=explode('/',$date);
		$newdate=$arydate[2] . '-' . $arydate[1] . '-' . $arydate[0];
		$newtime=$newdate . ' ' . $arytime[1];
		if((int)strtotime($newtime)>0)
			return $newtime;
		else
			return $time;
	}
	
	
	/**
	* 获取当前浏览者的外部IP
	* */
	public static function GetIP()
	{
		//return public ip address
		static $realip;
		if (isset($_SERVER))
		{
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			else if (isset($_SERVER["HTTP_CLIENT_IP"])) 
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			else
				$realip = $_SERVER["REMOTE_ADDR"];
		}
		else
		{
			if (getenv("HTTP_X_FORWARDED_FOR"))
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			else if (getenv("HTTP_CLIENT_IP"))
				$realip = getenv("HTTP_CLIENT_IP");
			else
				$realip = getenv("REMOTE_ADDR");
		}
		return $realip;
	}
	
	/**
	* 截取指定长度的字符串
	* */
	public static function substrcn($str, $len,$showdot = true, $dot = '...')
	{
		//support utf-8
		$str = strip_tags($str); 
		$str = str_replace('&nbsp;','',$str);
		$str = self::utf8_trim($str); //去除前后空白
		$str = preg_replace('/\s(?=\s)/', '', $str); //去掉跟随别的挤在一块的空白 
		$str = preg_replace('/[\n\r\t]/', ' ', $str); //最后，去掉非space 的空白，用一个空格代替 
		$patten ='/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/';
		
		preg_match_all($patten, $str, $regs);
		$v = 0; $s = '';
		for($i=0; $i<count($regs[0]); $i++)
		{
			(ord($regs[0][$i]) > 129) ? $v += 2 : $v++;
			$s .= $regs[0][$i];
			if($v >= $len * 2)
			{
				if($showdot){
					$s .= $dot;
				}
				break;
			}
		}
		return $s;
	}
	
	//删除数组中的某值并重建索引
	public static function array_remove($array, $offset)  
	{    
		array_splice($array, $offset, 1); 
		return $array;
	}  
	
	//重建数组
	public static function rebuild_array($array)  
	{    
		if(!is_array){return $array;}
		if(count($array)>0)
		{
			$tmp=null;
			foreach($array as $value)
				$tmp[]=$value;
			$array=$tmp;	
		}
		return $array;
	}  
	
	//将数组中key为数字的键值删除
	public static function remove_num_key($array)  
	{    
		if(!is_array){return $array;}
		if(count($array)>0)
		{
			$tmp=null;
			foreach($array as $k=>$v)
			{
				if(!is_numeric($k))
					$tmp[$k]=$v;
			}
			$array=$tmp;	
		}
		return $array;
	}  
	
	/**
	* 返回指定长度的随机字符串
	* */
	public static function randStr($len)
	{ 
		$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$string = ''; 
		for(;$len >= 1;$len--) 
		{
			$position = rand() % strlen($chars);
			$string .= substr($chars,$position,1); 
		}
		return $string; 
	}
	
	/**
	* 返回指定长度的随机数字
	* */
	public static function randNum($len)
	{ 
		$chars = '0123456789';
		$string = ''; 
		for(;$len >= 1;$len--) 
		{
			$position = rand() % strlen($chars);
			$string .= substr($chars,$position,1); 
		}
		return $string; 
	}	
	
	/**
	* 将某数据(字符串或者数组)转换成数组
	* */
	public static function toArray($strneedle,$pattern=',',$fix='')
	{
		$result_array=array();
		if(is_string($strneedle))
		{
			if($strneedle!='')$result_array=explode($pattern,$strneedle);
		}
		
		if(count($result_array)>0 && $fix!='')
		{
			function set_array_value(&$v,$k,$fix='\''){$v = "{$fix}{$v}{$fix}";}
			array_walk($result_array,'set_array_value',$fix);
		}
		return $result_array;
	}
	
	/**
	* 将某数组转换成字符串
	* */
	public static function toString($aryneedle = array(),$pattern = ',',
										$prefix = '',$suffix = '')
	{
		if(is_array($aryneedle))
		{
			if(in_array($pattern,array('li','div')))
			{
				foreach($aryneedle as $str)
					$string.='<' . $pattern . '>' . $prefix . $str . 
								$suffix . '</' . $pattern . '>';
			}
			else
			{
				if($prefix!='' || $suffix!='')
				{
					foreach($aryneedle as $str)
						$string.=$prefix . $str . $suffix . $pattern;
					$string=trim($string,$pattern);					
				}
				else 
					$string=join($pattern,$aryneedle);
			}
			return $string;
		}
		else
		{
			if($prefix!='' && $suffix!=''){ $aryneedle = $prefix . $aryneedle . $suffix; }
			return $aryneedle;
		}
	}
	
	
	/**
	* 查询某数据(字符串或者数组)是否在另外一个数组中
	* */
	public static function inArray($needle,$haystack,$boolallneeded = true)
	{
		$haystack = self::toArray($haystack);
		if(is_string($needle)){
			if(in_array($needle,$haystack)){ return true; }
		}else if(is_array($needle)){
			$count = count($needle);
			$i = 0;
			foreach($needle as $value){
				if(in_array($value,$haystack))
					$i++;
			}
			
			if($boolallneeded){
				//要求数组里的每个都能被找到
				if($count == $i){ return true; }
			}else{
				//仅仅要求至少一个被找到
				if($i > 0){ return true; }
			}
		}
		
		return false;
	}
	
	/**
	* 获取当前登陆用户保存在session中的某信息
	* */
	public static function getUserInfo($data_type,$session_key = SYS_SESSION_KEY)
	{
		return session($data_type,$session_key);
	}
	
	/**
	* 设置当前登陆的用户的保存在session中的信息
	* */
	public static function setUserInfo($data_type,$value,$session_key = SYS_SESSION_KEY)
	{
		$_SESSION[$session_key][$data_type] = $value;
	}
	
	/**
	* 将某信息临时保存在session中
	* */
	public static function setTmpInfo($key,$value)
	{
		$_SESSION[$key] = $value;
	}
	
	/**
	* 将某信息临时保存在session中
	* */
	public static function clearTmpInfo($key)
	{
		if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
		}
	}
	
	/**
	* 读取保存在session中的临时数据
	* */
	public static function getTmpInfo($key)
	{
		$v = null;
		if(isset($_SESSION[$key])){ $v = $_SESSION[$key]; }
		return $v;
	}
	
	/**
	* 读取某路径下文件的内容,该文件路径是个绝对路径
	* */
	public static function ReadStream($filepath)
	{
		if(file_exists($filepath) && is_readable($filepath)) {
			$filedata = file_get_contents($filepath);
			return $filedata;
		}
	}
	
	/**
	* 将一字符串写入指定的文件,第一个参数必须是文件的绝对路径,第二个参数是文件的内容
	* */
	public static function WriteStream($filepath,$content,$write_mode = 'wt')
	{
		//use:for example,overwrite something to the special file
		if(is_writable(dirname($filepath))) {
			$fh = fopen($filepath, $write_mode);
			fwrite($fh, $content);
			fclose($fh);
		}
	}#end write text
	
	//删除文件..
	public static function deletefile($filepath)
	{
		if($filepath != '' && is_file(ROOT . $filepath)) {
			@unlink(ROOT . $filepath);
		}
	}
	
	/**
	* 删除指定的目录
	* */
	public static function deletedir($dirname,$is_delete_dir = true)
	{
		$root = $_SERVER['DOCUMENT_ROOT'];
		if($dirname == '' || $dirname == $root || $dirname == $root . '/'){ return; }
		if($dh = opendir($dirname)) {
			while(($file = readdir($dh)) != false) {
				if(($file == '.') || ($file == '..')){ continue; }
				if(is_dir($dirname . '/' . $file)) {
					self::deletedir($dirname . '/' . $file,$is_delete_dir);
				} else {
					unlink($dirname . '/' . $file);
				}
			}
			
			closedir($dh);
			
			if($is_delete_dir) {
				@rmdir($dirname);
			}
		}
	}
	
	/**
	* 返回缺省字符串
	* */
	public static function returnText($strInput,$defaulttext = '-未知-',$checkvalue='')
	{
		$strInput = $strInput == $checkvalue ? $defaulttext : $strInput;
		return $strInput;
	}
	
	public static function utf8_ltrim( $str, $charlist = FALSE ) 
	{ 
		if($charlist === FALSE) return ltrim($str); 
		$charlist = preg_replace('!([\\\\\\-\\]\\[/^])!','\\\${1}',$charlist); 
		return preg_replace('/^['.$charlist.']+/u','',$str); 
	} 
	
	public static function utf8_rtrim( $str, $charlist = FALSE ) 
	{ 
		if($charlist === FALSE) return rtrim($str); 
		$charlist = preg_replace('!([\\\\\\-\\]\\[/^])!','\\\${1}',$charlist); 
		return preg_replace('/['.$charlist.']+$/u','',$str); 
	} 
	
	public static function utf8_trim( $str, $charlist = FALSE ) 
	{ 
		if($charlist === FALSE) return trim($str); 
		return self::utf8_ltrim(self::utf8_rtrim($str, $charlist), $charlist); 
	} 
	
	public static function Log($message,$log_dir = 'logs',
								$file_name = null,$loguser = true)
	{
		Util::Log($message,$log_dir,$file_name,$loguser);
	}

	//删除或者保留汉字
	public static function is_drop_chinese($str,$is_drop = true)
	{
		$str = $is_drop
			?	preg_replace('/[\x{4e00}-\x{9fa5}]/iu','',$str)
			:	preg_replace('/[^\x{4e00}-\x{9fa5}]/iu','',$str);
		return $str;
	}
	
	/**
	* 下载任何文件
	* */
	public static function DownLoad($file,$newfilename='')
	{
		$downloaded_file = @fopen($file,"r"); // 打开文件
		if($downloaded_file)
		{
			if($file!='')
			{
				if(ini_get('zlib.output_compression')) 
					ini_set('zlib.output_compression', 'Off');
				// 输入文件标签
				//header("Content-type: application/octet-stream");
				if(stristr($file,'.xls'))
					header("Content-type:application/vnd.ms-excel;charset=utf-8");
				elseif(stristr($file,'.doc'))
					header("Content-type:application/vnd.ms-word;charset=utf-8");
				elseif(stristr($file,'.rar'))
					header("Content-type:application/x-rar-compressed;charset=utf-8");
				elseif(stristr($file,'.zip'))
					header("Content-type:application/zip;charset=utf-8");
				elseif(stristr($file,'.jpg'))
					header("Content-type:image/jpg;charset=utf-8");
				elseif(stristr($file,'.gif'))
					header("Content-type:image/gif;charset=utf-8");
				elseif(stristr($file,'.png'))
					header("Content-type:image/png;charset=utf-8");
				else
					header("Content-type:application/force-download;charset=utf-8");
					
				header("Pragma: public"); // required 
				header("Expires: 0"); 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
				header("Cache-Control: private",false); // required for certain browsers 

					
				$extName = substr(strrchr(basename($file), '.'), 1);
				if($newfilename == '')
					$filename = basename($file);
				else
				{
					$char = new Charsets();
					$converted_text = $char->convert_charset( $newfilename, 'UTF-8', 'GBK');
					$filename = $converted_text . '.' . $extName;
				}
				header("Content-Disposition: attachment; filename=" . $filename);
	
				header("Content-Transfer-Encoding: binary"); 
				//header("Accept-Ranges: bytes");
				header("Accept-Length: ".filesize($file));
				// 输出文件内容
				echo @fread($downloaded_file,filesize($file));
				@fclose($downloaded_file);
			}
			else
				echo 'no data ...';
		}
		else
			echo 'can not find the file ',@basename($file),' ...';
	}
	
	public static function mask_realname($name)
	{
		if(IS_MASK_NAME){$name='**' . mb_substr($name,-1,2,'utf-8');}
		$name = Config::replace_hidden_names($name);
		return $name;
	}
	
	//对自身进行缩略...
	public function toThumbnail($srcPath,$is_create_newThumb=true,$w=200,$h=200)
	{
		$t = new ThumbHandler();
		if($is_create_newThumb)
		{
			//生成缩略图..
			$basename=basename($srcPath);
			$savePath=str_replace($basename,'',$srcPath);
			$guid=new Guid();
			$extName=substr(strrchr($basename, '.'), 1);
			$new_file_name_s=strtolower($guid->toString()) . '.' . $extName;
			$dstPath=$savePath . $new_file_name_s;
			//再缩放大图
			$t->setSrcImg(ROOT . $srcPath); 
			$t->setDstImg(ROOT . $dstPath); 
		}
		else
		{
			$dstPath=$srcPath;
			$t->setSrcImg(ROOT . $srcPath); 
			$t->setDstImg(ROOT . $srcPath); 
		}
		$t->createImg($w,$h); 
		$t = null;
		return $dstPath;
	}
}
?>
