<?php
/**
 * 工具类
 */
class Util
{
	/**
	 * 危险 HTML代码过滤器,object|meta|
	 * @param   string  $html   需要过滤的html代码
	 * @return  string
	 * @author qidi
	 */
	public static function htmlFilter($html){
		$filter = array (
			"/\s/",
			"/<(\/?)(script|i?frame|style|html|body|title|link|\?|\%)([^>]*?)>/isU",
			"/(<[^>]*)on[a-zA-Z]\s*=([^>]*>)/isU",
		);
	
		$replace = array (" ","&lt;\\1\\2\\3&gt;","\\1\\2",);
		return preg_replace($filter, $replace, $html);
	}
	
	/**
	 * 删除目录,不支持目录中带 ..
	 *
	 * @param string $dir
	 * @return boolen
	 * @author qidi
	 */
	public static function deleteDir($dir) {
		$dir = str_replace(array ('..',"\n","\r"), array ('','',''), $dir);
		$flag = false;
		if (is_dir($dir)) {
			$d = @ dir($dir);
			if ($d) {
				while (false !== ($entry = $d->read())) {
					if ($entry != '.' && $entry != '..') {
						$entry = $dir . '/' . $entry;
						if (is_dir($entry)) {
							self::deleteDir($entry);
						} else {
							@ unlink($entry);
						}
					}
				}
				$d->close();
				$flag = rmdir($dir);
			}
		} else {
			$flag = unlink($dir);
		}
		return $flag;
	}
	
	/**
	 * 创建目录（如果该目录的上级目录不存在，会先创建上级目录）
	 * 依赖于 ROOT_PATH 常量，且只能创建 ROOT_PATH 目录下的目录
	 * 目录分隔符必须是 / 不能是 \
	 *
	 * @param   string  $absolute_path  绝对路径
	 * @param   int     $mode           目录权限
	 * @return  bool
	 * @author qidi
	 */
	public static function createDir($absolutePath, $mode = 0777) {
		if (is_dir($absolutePath)) {
			return true;
		}
		$relativePath = str_replace(ROOT_PATH, '', $absolutePath);
		$eachPath = explode('/', $relativePath);
		$curPath = ROOT_PATH;
		foreach ($eachPath as $path) {
			if ($path) {
				$curPath = $curPath . '/' . $path;
				if (!is_dir($curPath) && !mkdir($curPath, $mode)) {
					return false;
				}
			}
		}
		return true;
	}
	
	 /**
	 * 返回由对象属性组成的关联数组
	 *
	 * @param    obj    $obj
	 * @return   array
	 * @author qidi
	 */
	public static function getObjectVarsDeep($obj) {
		if (is_object($obj)) {
			$obj = get_object_vars($obj);
		}
		if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				$obj[$key] = self::getObjectVarsDeep($value);
			}
		}
		return $obj;
	}
	
	/**
	 * 返回文件扩展名
	 * @param string $filename 文件名
	 * @return string
	 * @author qidi
	 */
	public static function fileExt($filename) {
		return trim(substr(strrchr($filename, '.'), 1, 10));
	}

	//获得文件大小
	public static function getsize($filename, $format = 'kb') {
		$size = filesize(ROOT . $filename);
	    $p = 0;
	    if ($format == 'kb') {
	        $p = 1;
	    } elseif ($format == 'mb') {
	        $p = 2;
	    } elseif ($format == 'gb') {
	        $p = 3;
	    }
	    $size /= pow(1024, $p);
	    return number_format($size, 1);
	}
	
	/**
	 *  将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
	 *
	 * @access  public
	 * @param   string       $str         待转换字串
	 *
	 * @return  string       $str         处理后字串
	 */
	public static function fullWidth2halfAngle($str) {
		$arr = array (
			'０' => '0',
			'１' => '1',
			'２' => '2',
			'３' => '3',
			'４' => '4',
			'５' => '5',
			'６' => '6',
			'７' => '7',
			'８' => '8',
			'９' => '9',
			'Ａ' => 'A',
			'Ｂ' => 'B',
			'Ｃ' => 'C',
			'Ｄ' => 'D',
			'Ｅ' => 'E',
			'Ｆ' => 'F',
			'Ｇ' => 'G',
			'Ｈ' => 'H',
			'Ｉ' => 'I',
			'Ｊ' => 'J',
			'Ｋ' => 'K',
			'Ｌ' => 'L',
			'Ｍ' => 'M',
			'Ｎ' => 'N',
			'Ｏ' => 'O',
			'Ｐ' => 'P',
			'Ｑ' => 'Q',
			'Ｒ' => 'R',
			'Ｓ' => 'S',
			'Ｔ' => 'T',
			'Ｕ' => 'U',
			'Ｖ' => 'V',
			'Ｗ' => 'W',
			'Ｘ' => 'X',
			'Ｙ' => 'Y',
			'Ｚ' => 'Z',
			'ａ' => 'a',
			'ｂ' => 'b',
			'ｃ' => 'c',
			'ｄ' => 'd',
			'ｅ' => 'e',
			'ｆ' => 'f',
			'ｇ' => 'g',
			'ｈ' => 'h',
			'ｉ' => 'i',
			'ｊ' => 'j',
			'ｋ' => 'k',
			'ｌ' => 'l',
			'ｍ' => 'm',
			'ｎ' => 'n',
			'ｏ' => 'o',
			'ｐ' => 'p',
			'ｑ' => 'q',
			'ｒ' => 'r',
			'ｓ' => 's',
			'ｔ' => 't',
			'ｕ' => 'u',
			'ｖ' => 'v',
			'ｗ' => 'w',
			'ｘ' => 'x',
			'ｙ' => 'y',
			'ｚ' => 'z',
			'（' => '(',
			'）' => ')',
			'［' => '[',
			'］' => ']',
			'【' => '[',
			'】' => ']',
			'〖' => '[',
			'〗' => ']',
			'「' => '[',
			'」' => ']',
			'『' => '[',
			'』' => ']',
			'｛' => '{',
			'｝' => '}',
			'《' => '<',
			'》' => '>',
			'％' => '%',
			'＋' => '+',
			'—' => '-',
			'－' => '-',
			'～' => '-',
			'：' => ':',
			'。' => '.',
			'、' => ',',
			'，' => '.',
			'、' => '.',
			'；' => ',',
			'？' => '?',
			'！' => '!',
			'…' => '-',
			'‖' => '|',
			'＂' => '"',
			'＇' => '`',
			'｀' => '`',
			'｜' => '|',
			'〃' => '"',
			'　' => ' '
		);
		return strtr($str, $arr);
	}
	
	/**
	 * 递归方式的对变量中的特殊字符去除转义
	 *
	 * @access  public
	 * @param   mix     $value
	 *
	 * @return  mix
	 */
	public static function stripslashesDeep($value)
	{
		if (empty ($value)) {
			return $value;
		} else {
			return is_array($value) ? array_map(array(self,stripslashesDeep), $value) : stripslashes($value);
		}
	}
	
	/**
	 * 将对象成员变量或者数组的特殊字符进行转义
	 *
	 * @access   public
	 * @param    mix        $obj      对象或者数组
	 *
	 * @return   mix                  对象或者数组
	 */
	public static function addslashesDeepObj($obj)
	{
		if (is_object($obj) == true)
		{
			foreach ($obj as $key => $val)
			{
				if (($val) == true)
				{
					$obj-> $key = self::addslashesDeepObj($val);
				} else {
					$obj-> $key = self::addslashesDeep($val);
				}
			}
		}
		else
		{
			$obj = self::addslashesDeep($obj);
		}
		return $obj;
	}
	
	/**
	 * 递归方式的对变量中的特殊字符进行转义
	 * @param string|array 转义内容
	 * @return string|array
	 * @author qidi
	 */
	public static function addslashesDeep($value)
	{
		if (empty ($value))
		{
			return $value;
		}
		else
		{
			$v = is_array($value) ? array_map(array('Util','addslashesDeep'), $value) : addslashes($value);
			return $v;
		}
	}
	
	
	/**
	 * 验证输入的邮件地址是否合法
	 * @param string	$email	需要验证的邮件地址
	 * @return bool
	 * @author qidi
	 */
	public static function isEmail($email)
	{
		$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
		if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
			if (preg_match($chars, $email)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/*检查手机号码*/
	public static function isMobile($phone)
	{
		return self::checkMobile($phone);
	}

	//联系方式是否合法	
	public static function isValidContactInfo($info)
	{
		if(self::isMobile($info)){ return true; }	
		if(self::isEmail($info)){ return true; }	
		return false;
	}

	
	//是否中文名
	public static function is_cn_name($str)
	{
		$r = preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z]+$/u",$str);
		return $r;
	}

	//是否英文名
	public static function is_en_name($str)
	{
		$r = preg_match("/^[A-Za-z]+$/u",$str);
		return $r;
	}
	
	/**
	 * 检查是否为一个合法的时间格式
	 *
	 * @param   string  $time
	 * @return  void
	 */
	public static function isDateTime($time)
	{
		$pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';
		return preg_match($pattern, $time);
	}
	
	public static function checkMobile($phone)
	{
		$regPattern = @"/^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/";
		
		return preg_match($regPattern,$phone);
	}
	/**
	 * 是否含有中文
	 *
	 * @param String $str
	 * @return Bool
	 */
	public static function hasChinese($str)
	{
		$cns = Check::getLens($str);
		if($cns['cn'] > 0){
			return true;
		}
		return false;
	}
	/**
	 * 获得用户的真实IP地址
	 *
	 * @return  string
	 */
	public static function getClientIp() {
		static $clientIp = NULL;
	
		if ($clientIp !== NULL) {
			return $clientIp;
		}
	
		if (isset ($_SERVER)) {
			if (isset ($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				/* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
				foreach ($arr AS $ip) {
					$ip = trim($ip);
					if ($ip != 'unknown') {
						$clientIp = $ip;
						break;
					}
				}
			}
			elseif (isset ($_SERVER['HTTP_CLIENT_IP'])) {
				$clientIp = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset ($_SERVER['REMOTE_ADDR'])) {
					$clientIp = $_SERVER['REMOTE_ADDR'];
				} else {
					$clientIp = '0.0.0.0';
				}
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$clientIp = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_CLIENT_IP')) {
				$clientIp = getenv('HTTP_CLIENT_IP');
			} else {
				$clientIp = getenv('REMOTE_ADDR');
			}
		}
	
		preg_match("/[\d\.]{7,15}/", $clientIp, $onlineip);
		$clientIp = !empty ($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
	
		return $clientIp;
	}
	
	/**
	 * 截取UTF-8编码下字符串的函数
	 *
	 * @param   string      $str        被截取的字符串
	 * @param   int         $length     截取的长度
	 * @param   bool        $append     是否附加省略号
	 *
	 * @return  string
	 */
	public static function utf8Substr($string, $length = 0, $append = true) {
	
		if (strlen($string) <= $length) {
			return $string;
		}
		$string = str_replace(array ('&amp;','&quot;','&lt;','&gt;'), array ('&','"','<','>'), $string);
		$strcut = '';
	
		$n = $tn = $noc = 0;
		while ($n < strlen($string)) {
			$t = ord($string[$n]);
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1;
				$n++;
				$noc++;
			}
			elseif (194 <= $t && $t <= 223) {
				$tn = 2;
				$n += 2;
				$noc += 2;
			}
			elseif (224 <= $t && $t < 239) {
				$tn = 3;
				$n += 3;
				$noc += 2;
			}
			elseif (240 <= $t && $t <= 247) {
				$tn = 4;
				$n += 4;
				$noc += 2;
			}
			elseif (248 <= $t && $t <= 251) {
				$tn = 5;
				$n += 5;
				$noc += 2;
			}
			elseif ($t == 252 || $t == 253) {
				$tn = 6;
				$n += 6;
				$noc += 2;
			} else {
				$n++;
			}

			if ($noc >= $length) {
				break;
			}

		}
		if ($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
		$strcut = str_replace(array ('&','"','<','>'), array ('&amp;','&quot;','&lt;','&gt;'), $strcut);
		if ($append && $string != $strcut) {
			$strcut .= '...';
		}
		return $strcut;
	}
	
	/**
	 * 获得当前的域名
	 *
	 * @return  string
	 */
	public static function getDomain() {
		/* 协议 */
		$protocol = (isset ($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
		/* 域名或IP地址 */
		if (isset ($_SERVER['HTTP_X_FORWARDED_HOST'])) {
			$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
		}
		elseif (isset ($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		} else {
			/* 端口 */
			if (isset ($_SERVER['SERVER_PORT'])) {
				$port = ':' . $_SERVER['SERVER_PORT'];
	
				if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol)) {
					$port = '';
				}
			} else {
				$port = '';
			}
	
			if (isset ($_SERVER['SERVER_NAME'])) {
				$host = $_SERVER['SERVER_NAME'] . $port;
			}
			elseif (isset ($_SERVER['SERVER_ADDR'])) {
				$host = $_SERVER['SERVER_ADDR'] . $port;
			}
		}
		return $protocol . $host;
	}
	
	/**
	 * 获得网站的URL地址
	 *
	 * @return  string
	 */
	public static function siteUrl() {
		$phpSelf = htmlentities(isset ($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
		return getDomain() . substr($phpSelf, 0, strrpos($phpSelf, '/'));
	}
	
	/**
	 *  模拟http请求封装函数
	 *
	 *  @param string $url
	 *  @param int    $limit
	 *  @param string $post
	 *  @param string $cookie
	 *  @param boolen $bysocket
	 *  @param string $ip
	 *  @param int    $timeout
	 *  @param boolen $block
	 *  @return responseText
	 */
	public static function httpRequest($url, $limit = 500000, $post = '', $cookie = '', 
							$bysocket = false, $ip = '', $timeout = 15, $block = true) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
		$port = !empty ($matches['port']) ? $matches['port'] : 80;
	
		if ($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			//$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= 'Content-Length: ' . strlen($post) . "\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
			$out .= $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			//$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @ fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if (!$fp) {
			return '';
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@ fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if (!$status['timed_out']) {
				while (!feof($fp)) {
					if (($header = @ fgets($fp)) && ($header == "\r\n" || $header == "\n")) {
						break;
					}
				}
	
				$stop = false;
				while (!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
					$return .= $data;
					if ($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}
			@ fclose($fp);
			return $return;
		}
	}
	
	/**
	 * 去除字符串右侧可能出现的乱码
	 *
	 * @param   string	$str	字符串
	 * @return  string
	 */
	public static function trimRight($str) {
		$len = strlen($str);
		/* 为空或单个字符直接返回 */
		if ($len == 0 || ord($str {
			$len -1 }) < 127) {
			return $str;
		}
		/* 有前导字符的直接把前导字符去掉 */
		if (ord($str {
			$len -1 }) >= 192) {
			return substr($str, 0, $len -1);
		}
		/* 有非独立的字符，先把非独立字符去掉，再验证非独立的字符是不是一个完整的字，不是连原来前导字符也截取掉 */
		$r_len = strlen(rtrim($str, "\x80..\xBF"));
		if ($r_len == 0 || ord($str {
			$r_len -1 }) < 127) {
			return sub_str($str, 0, $r_len);
		}
	
		$as_num = ord(~$str {
			$r_len -1 });
		if ($as_num > (1 << (6 + $r_len - $len))) {
			return $str;
		} else {
			return substr($str, 0, $r_len -1);
		}
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
	public static function paramsInt($key,$defaultValue=0){
		return !empty($_REQUEST[$key]) ? intval($_REQUEST[$key]) : $defaultValue;
	}
	
	public static function paramsIntNotEmpty($key,$defaultValue=''){
		if(isset($_REQUEST[$key])){
			if($_REQUEST[$key]!==""){
				return intval($_REQUEST[$key]);
			}else{
				return $defaultValue;
			}
		}else{
			return $defaultValue;
		}
	}	
	public static function defaultString($string,$default=''){
		return !empty($string) ? self::utf8_trim($string) : $default;
	}
	
	public static function paramsFloat($key,$defaultValue=0.0){
		return !empty($_REQUEST[$key]) ? floatval($_REQUEST[$key]) : $defaultValue;
	}
	
	public static function paramsString($key,$defaultValue=''){
		return !empty($_REQUEST[$key]) ? trim($_REQUEST[$key]) : $defaultValue;
	}
	
	public static function paramsArray($key,$defaultValue=array()){
		return !empty($_REQUEST[$key])&&is_array($_REQUEST[$key]) ? $_REQUEST[$key] : $defaultValue;
	}
	
	//重新格式化日期
	public static function parseDate($date,$format = 'y/m/d')
	{
		if($date != null)
		{
			$date = strtotime($date) > 0?date($format,strtotime($date)):$date;
		}
		
		return $date;	
	}
	
	public static function getMimetype($fileType){
        switch(strtolower($fileType)){
            case "js" :
                return "application/x-javascript";

            case "json" :
                return "application/json";

            case "jpg" :
            case "jpeg" :
            case "jpe" :
                return "image/jpeg";

            case "png" :
            case "gif" :
            case "bmp" :
            case "tiff" :
                return "image/".strtolower($fileType);

            case "css" :
                return "text/css";

            case "xml" :
                return "application/xml";

            case "doc" :
            case "docx" :
                return "application/msword";

            case "xls" :
            case "xlt" :
            case "xlm" :
            case "xld" :
            case "xla" :
            case "xlc" :
            case "xlw" :
            case "xll" :
                return "application/vnd.ms-excel";

            case "ppt" :
            case "pps" :
                return "application/vnd.ms-powerpoint";

            case "rtf" :
                return "application/rtf";

            case "pdf" :
                return "application/pdf";

            case "html" :
            case "htm" :
            case "php" :
                return "text/html";

            case "txt" :
                return "text/plain";

            case "mpeg" :
            case "mpg" :
            case "mpe" :
                return "video/mpeg";

            case "mp3" :
                return "audio/mpeg3";

            case "wav" :
                return "audio/wav";

            case "aiff" :
            case "aif" :
                return "audio/aiff";

            case "avi" :
                return "video/msvideo";

            case "wmv" :
                return "video/x-ms-wmv";

            case "mov" :
                return "video/quicktime";

            case "rar" :
                return "application/x-rar-compressed";

            case "zip" :
				return "application/zip";

            case "tar" :
                return "application/x-tar";

            case "swf" :
                return "application/x-shockwave-flash";

            default :
				return "unknown/" . trim($fileType);
        }
	}
	
	public static function getMimeContentType($filename)
	{
		if(!function_exists('mime_content_type')) {
			$mime_types = array(
	            'txt' => 'text/plain',
	            'htm' => 'text/html',
	            'html' => 'text/html',
	            'php' => 'text/html',
	            'css' => 'text/css',
	            'js' => 'application/javascript',
	            'json' => 'application/json',
	            'xml' => 'application/xml',
	            'swf' => 'application/x-shockwave-flash',
	            'flv' => 'video/x-flv',
	
	            // images
	            'png' => 'image/png',
	            'jpe' => 'image/jpeg',
	            'jpeg' => 'image/jpeg',
	            'jpg' => 'image/jpeg',
	            'gif' => 'image/gif',
	            'bmp' => 'image/bmp',
	            'ico' => 'image/vnd.microsoft.icon',
	            'tiff' => 'image/tiff',
	            'tif' => 'image/tiff',
	            'svg' => 'image/svg+xml',
	            'svgz' => 'image/svg+xml',
	
	            // archives
	            'zip' => 'application/zip',
	            'rar' => 'application/x-rar-compressed',
	            'exe' => 'application/x-msdownload',
	            'msi' => 'application/x-msdownload',
	            'cab' => 'application/vnd.ms-cab-compressed',
	
	            // audio/video
	            'mp3' => 'audio/mpeg',
	            'qt' => 'video/quicktime',
	            'mov' => 'video/quicktime',
	
	            // adobe
	            'pdf' => 'application/pdf',
	            'psd' => 'image/vnd.adobe.photoshop',
	            'ai' => 'application/postscript',
	            'eps' => 'application/postscript',
	            'ps' => 'application/postscript',
	
	            // ms office
	            'doc' => 'application/msword',
	            'rtf' => 'application/rtf',
	            'xls' => 'application/vnd.ms-excel',
	            'ppt' => 'application/vnd.ms-powerpoint',
	
	            // open office
	            'odt' => 'application/vnd.oasis.opendocument.text',
	            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	        );
	        $ext = strtolower(array_pop(explode('.',$filename)));
	        if (array_key_exists($ext, $mime_types)) {
	            return $mime_types[$ext];
	        }elseif (function_exists('finfo_open')) {
	            $finfo = finfo_open(FILEINFO_MIME);
	            $mimetype = finfo_file($finfo, $filename);
	            finfo_close($finfo);
	            return $mimetype;
	        }else {
	            return 'application/octet-stream';
	        }
		}
		return mime_content_type($filename);
	}
	
	public static function getRandNumber($len=4)
	{
		$number = '';
		for($i=0;$i<$len;$i++){
			$number .= rand(0,9);
		}
		return $number;
	}
	
	/**
	 * 发送Email
	 * @param dimension:消息数组维度[1,2,3...]
	 * @param sendtype:101-群发(收信人内容一样),100-每个收信人内容都不一样
	 * @return string HTTP状态码,成功返回OK
	
	 例如：
	 1、二维数组发送：
	 $args[]['13710111151']=$sms_content;
	 $args[]['13826118561']=$sms_content;
	 Util::sendMobileMessage($args,2);
	 2、单维数组发送：
	 $args['13710111151']=$sms_content;
	 $args['13826118561']=$sms_content;
	 Util::sendMobileMessage($args);
	 */
	
	
	/**
	 * 发送Email通用API
	 * @param array $addresses
	 * @param string $subject
	 * @param string $body
	 * @param array $attachments 可选
	 * 
	 * {@example sendMail(array('test@test.com'=>'测试'),'测试邮件标题','测试邮件内容',array('/home/qidi/images/test.gif'))}
	 */
	public static function sendMail($addresses,$subject,$body,$attachments=array())
	{
		require_once(ROOT_PATH.'/classes/phpMailer/class.phpmailer.php');
		$mailConfig = include(ROOT_PATH.'/conf/mail_config.php');
		
		$mail          	  = new PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->Encoding = "base64";
		$mail->Host       = $mailConfig['smtp_host']; // SMTP server
		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		$mail->IsSMTP();
		$mail->IsHTML();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = $mailConfig['smtp_port'];                    // set the SMTP port for the GMAIL server
		$mail->Username   = $mailConfig['username']; // SMTP account username
		$mail->Password   = $mailConfig['password'];        // SMTP account password
		$mail->AddReplyTo($mailConfig['username'], $mailConfig['alias']);
		$mail->SetFrom($mailConfig['username'], $mailConfig['alias']);
		foreach($addresses as $key=>$value){
			$mail->AddAddress($key, $value);
		}
		//$mail->AddCC("inpressing@qq.com","qidi");
		$mail->Subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
		$mail->MsgHTML($body);
		//添加附件
		if(!empty($attachments)){
			foreach($attachments as $attachment){
				$mail->AddAttachment($attachment);
			}
		}
		if($mail->Send()){
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			//echo "恭喜，邮件发送成功！";
			return true;			
		}else{
			//echo "发送失败：" . $mail->ErrorInfo;
			return false;
		}
	}
	
	public static function varDumpToString($var,&$output,$prefix=""){
	    foreach($var as $key=>$value){
	        if(is_array($value)){
	            $output.= $prefix.$key;
	            self::varDumpToString($value,$output,"  ".$prefix);
	        } else{
	            $output.= $prefix.$key.": ".$value.",";
	        }
	    }
	}
	
	//正则判断是否包含特殊字符
	public static function checkEnterAllError($str){
		if(is_array($str)){
			foreach ($str as $key => $value) {
				if(!self::checkEnterStr($value)){
					return false;
				}
			}
			return true;
		}else{
			if(!empty($str)){
				if(!preg_match("/^[A-Za-z0-9]/",$str)){
					if(!preg_match("/^[\x{4e00}-\x{9fa5}]/u",$str)){
						return false;
			 		}
				}
			}
			return true;
		}
	}
	
	//正则判断是否包含特殊字符
	public static function checkEnterError($str,$modelfields){
		$errorArray = array();
		foreach ($str as $key => $value) {
			if(preg_match("/['\"]/",$value)){
				if(isset($modelfields[$key])){
					//$errorArray[] = $modelfields[$key]." 中不能含有特殊字符 \" 或者 ' "; 
					$errorArray[0] = "输入框中不能含有特殊字符 \" 或者 ' ";
				}
		 	}
		}
		return $errorArray;
	}
	 	 
	 public static function checkbrowser(){
	 	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 9")){
  			return "InternetExplorer9"; 
  		} 
  		if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 8")){
  			return "InternetExplorer8"; 
  		} 
  		else if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7")){
  			return "InternetExplorer7"; 
  		}
		else if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6")){
			return "InternetExplorer6";
		} 
		else if(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox")){
			return "Firefox";
		}
		else if(strpos($_SERVER["HTTP_USER_AGENT"],"Chrome")){
			return "GoogleChrome";
		}
		else if(strpos($_SERVER["HTTP_USER_AGENT"],"Safari")){
			return "Safari";
		}
		else if(strpos($_SERVER["HTTP_USER_AGENT"],"Opera")){
			return "Opera";
		}
		else{
			return $_SERVER["HTTP_USER_AGENT"];
		} 
	 }
	
	/***
	* 人民币大写转换函数
	*/
	public static function chinese_rmb($money) {
	    $money = round($money, 2);    // 四舍五入
	    if ($money <= 0) {
	        return '零元';
	    }
	    $units = array ( '', '拾', '佰', '仟', '', '万', '亿', '兆' );
	    $amount = array( '零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖' );
	    $arr = explode('.', $money);    // 拆分小数点
	    $money = strrev($arr[0]);        // 翻转整数
	    $length = strlen($money);        // 获取数字的长度
	    for ($i = 0; $i < $length; $i++) {
	        $int[$i] = $amount[$money[$i]];    // 获取大写数字
	        if (!empty($money[$i])) {
	            $int[$i] .= $units[$i%4];    // 获取整数位
	        }
	        if ($i%4 == 0) {
	            $int[$i] .= $units[4+floor($i/4)];    // 取整
	        }
	    }
	    $con = isset($arr[1]) ? '元' . $amount[$arr[1][0]] . '角' . $amount[$arr[1][1]] . '分' : '元整';
	    return implode('', array_reverse($int)) . $con;    // 整合数组为字符串
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
		if($date==null)$date=date('Y-m-d');
		$w=date('w',strtotime($date));if($w==0)$w=7;
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
	
	/**
	* 截取指定长度的字符串
	* */
	public static function substrcn($str, $len,$showdot=true, $dot = '...')
	{
		//support utf-8
		$str = strip_tags($str); $str=str_replace('&nbsp;','',$str);
		$str=self::utf8_trim($str); //去除前后空白
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
	
	/**
	* 将某数组转换成字符串
	* */
	public static function toString($aryneedle=array(),$pattern=',',$prefix='',$suffix='')
	{
		if(is_array($aryneedle))
		{
			$string='';
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
			return $aryneedle;
	}
	
	//格式化数字
	public static function parse_number($value,$dot_len = 0)
	{
		$dot_len = (int)$dot_len;
		if($dot_len > 3){ $dot_len = 3; }
		$value = sprintf('%01.' . $dot_len . 'f',$value);
		
		//去除末尾的0
		for($i = 1;$i <= $dot_len;$i ++)
		{
			$value = rtrim($value,'0');
		}		
		$value = rtrim($value,'.');

		return $value;	
	}
	
	/**
	* 返回当前页面的路径,包括各个地址参数
	* */
	public static function GetUrl()
	{
		return str_replace('index.php','',urlencode($_SERVER['REQUEST_URI']));
	}
	
	/**
	* 读取某路径下文件的内容,该文件路径是个绝对路径
	* */
	public static function ReadStream($filepath)
	{
		if(file_exists($filepath) && is_readable($filepath))
		{
			$filedata=file_get_contents($filepath);
			return $filedata;
		}
	}
	
	/**
	* 将一字符串写入指定的文件,第一个参数必须是文件的绝对路径,第二个参数是文件的内容
	* */
	public static function WriteStream($filepath,$content)
	{
		if(is_writable(dirname($filepath))){
			$fh = fopen($filepath, "wt");
			fwrite($fh, $content);
			fclose($fh);
			return true;
		}else{
			return false;
		}
	}
	
	//删除文件,只要提供相对路径即可..
	public static function deletefile($filepath)
	{
		if($filepath!='' && is_file(ROOT . $filepath))
			@unlink(ROOT_PATH . $filepath);
	}

	// 任意数量参数日志调用
	public static function Logs()
	{
		$datas = func_get_args();
		if($datas != null && count($datas) == 1){
			self::Log($datas[0]);
		}else{
			self::Log($datas);
		}
	}
	
	//记录日志
	public static function Log($message,$log_dir = 'logs',$file_name = null,$loguser = true)
	{
		if(!SAVE_LOG){ return; }//日志写入开关
		if($message == ''){ return; }
		if(is_array($message)){ $message = print_r($message,true); }
		if(is_object($message)){ $message = print_r($message,true); }
		if($file_name == null){ $file_name = date('Ymd'); }
		if(stripos($log_dir, 'logs') !== 0){ $log_dir = 'logs/' . $log_dir; }
		$dir_name = ROOT_PATH . '/' . $log_dir;
		if(!is_dir($dir_name)){ mkdir($dir_name,'0777',true); }
		$logfilepath = $dir_name . '/' . $file_name . '.log';

		if($loguser){
			$realname = System::getUserInfo('realname');
			if($realname == ''){ $realname = '匿名'; }
			$ary_content[] = '[' . date('G:i:s') . '][' . $realname . ']';
		}else{
			$ary_content[] = '[' . date('G:i:s') . ']';
		}

		$bt = debug_backtrace();
		$ary_content[] = 'Request URL -> ' . $_SERVER['REQUEST_URI'];
		$log_position =  'Last invoke -> ' . $bt[1]['class'] . '::' . $bt[1]['function'] . ' --> Line:' . $bt[1]['line'];
		$ary_content[] = $log_position;
		$ary_content[] = "\n" . $message;
		$ary_content[] = "-----------------------------------------------------------------\n\n";
		//$message = $prefix . '[' . $_SERVER['REQUEST_URI'] . '][' . $message . ']' . $suffix;
		$message = join("\n",$ary_content);
		@error_log($message,3,$logfilepath);
	}

	/**
	* 中国56个民族
	* */
	public static $nation=array(
			1=>'汉族',2=>'蒙古族',3=>'回族',4=>'藏族',5=>'苗族',6=>'彝族',
			7=>'壮族',8=>'布依族',9=>'朝鲜族',10=>'满族',11=>'侗族',12=>'瑶族',
			13=>'白族',14=>'土家族',15=>'哈尼族',16=>'哈萨克族',17=>'傣族',
			18=>'黎族',19=>'傈僳族',20=>'佤族',21=>'畲族',22=>'高山族',
			23=>'拉祜族',24=>'水族',25=>'东乡族',26=>'纳西族',27=>'景颇族',
			28=>'柯尔克孜族',29=>'土族',30=>'达乌尔族',31=>'羌族',
			32=>'仫佬族',33=>'布朗族',34=>'撒拉族',35=>'毛难族',
			36=>'仡佬族',37=>'锡伯族',38=>'阿昌族',39=>'普米族',
			40=>'塔吉克族',41=>'怒族',42=>'乌孜别克族',43=>'俄罗斯族',
			44=>'鄂温克族',45=>'崩龙族',46=>'保安族',47=>'裕固族',
			48=>'京族',49=>'维吾尔族',50=>'塔塔尔族',51=>'独龙族',
			52=>'鄂伦春族',53=>'赫哲族',54=>'门巴族',55=>'珞巴族',
			56=>'基诺族',57=>'其他'
		);
		
	
	//提交数据
	public static function curl($url,$data,$method = 'POST')
	{
		$ch = curl_init(); 
		
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);//这个很重要,否则请求二维码会失败
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$info = curl_exec($ch);
		
		if (curl_errno($ch)) {
			self::Log( 'Errno'.curl_error($ch) );
		}
		
		curl_close($ch);
		
		return $info;
	}
	
	//查询物流快递结果
	//$ordernum：单号
	//$type：物流公司代号
	/*
	返回数据：示例：{"id":"dtwl","name":"大田物流","order":"6108241734",
					"num":107,"updateTime":"2013-02-20 12:28:16",
					"message":"","errCode":0,"status":3,
					"data":[{"time":"2012-03-21 11:41:06","content":"长沙站 XXX"},
							{"time":"2012-03-21 09:16:27","content":"到达XXX"}]} 
	*/
	public static function query_kuaidi($ordernum,$type)
	{
		$ordernum = str_replace(' ','',$ordernum);  //快递单号
		$AppKey = 'd7310d6a21da4f71a6e7dbdbd3df1e93';
		$url = 'http://www.aikuaidi.cn/rest/?key=' . $AppKey . '&order=' . 
						$ordernum . '&id=' . $type . '&ord=desc';
		$r_content = self::curl($url);
		$json_data = json_decode($r_content,true);
		//Util::Log($json_data);

		return $json_data;
	}
	
	
	/**
	 * 密码强度
	 * */
	public static function pwdStrenth($str)
	{
		$score = 0;
		if(preg_match("/[0-9]+/",$str))
		{
			$score ++;
		}
		if(preg_match("/[0-9]{3,}/",$str))
		{
			$score ++;
		}
		if(preg_match("/[a-z]+/",$str))
		{
			$score ++;
		}
		if(preg_match("/[A-Z]+/",$str))
		{
			$score ++;
		}
		if(preg_match("/[A-Z]{3,}/",$str))
		{
			$score ++;
		}
		if(strlen($str) >= 10)
		{
			$score ++;
		}
		return false;
	}

	//动态加密解密函数
	public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
	{   
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
		$ckey_length = 4;   
		// 密匙   
		$key = md5($key ? $key : $GLOBALS['discuz_auth_key']);   
		// 密匙a会参与加解密   
		$keya = md5(substr($key, 0, 16));   
		// 密匙b会用来做数据完整性验证   
		$keyb = md5(substr($key, 16, 16));   
		// 密匙c用于变化生成的密文   
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): 
								substr(md5(microtime()), -$ckey_length)) : '';   
		// 参与运算的密匙   
		$cryptkey = $keya.md5($keya.$keyc);   
		$key_length = strlen($cryptkey);   
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
		//解密时会通过这个密匙验证数据完整性   
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
		$string = $operation == 'DECODE' 
			?	base64_decode(substr($string, $ckey_length)) 
			:	sprintf('%010d', $expiry ? $expiry + time() : 0) . 
				substr(md5($string . $keyb), 0, 16) . $string;   
		$string_length = strlen($string);   
		$result = '';   
		$box = range(0, 255);   
		$rndkey = array();   
	
		// 产生密匙簿   
	
		for($i = 0; $i <= 255; $i++)
		{   
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);   
		}   
	
		// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
		for($j = $i = 0; $i < 256; $i++)
		{   
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;   
			$tmp = $box[$i];   
			$box[$i] = $box[$j];   
			$box[$j] = $tmp;   
		}   
	
		// 核心加解密部分   
		for($a = $j = $i = 0; $i < $string_length; $i++)
		{   
			$a = ($a + 1) % 256;   
			$j = ($j + $box[$a]) % 256;   
			$tmp = $box[$a];   
			$box[$a] = $box[$j];   
			$box[$j] = $tmp;   
			// 从密匙簿得出密匙进行异或，再转成字符   
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
		}   
	
		if($operation == 'DECODE')
		{  
			// 验证数据有效性，请看未加密明文的格式   
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&  
					substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
				return substr($result, 26);   
			} else {   
				return '';   
			}   
		} else {   
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
			return $keyc.str_replace('=', '', base64_encode($result));   
		}   
		
		/*
			//使用例子
			$str = 'abcdef'; 
			$key = 'www.helloweba.com'; 
			//echo authcode($str,'ENCODE',$key,0),'<br/>'; //加密 
			$str = '4d48jOhPenjLm7fCiXozG2SRAmSu0CPfea04sgtChcCpnHI'; 
			echo authcode($str,'DECODE',$key,0); //解密
		*/
	} 
	
	//默认缓存时间为一周
	public static function pushCache($key,$value,$cache_seconds = null)
	{
		$memcache = new Memcache();
		$memcache->connect(CACHE_SRV,CACHE_PORT);
		if($cache_seconds == null){ $cache_seconds = 60 * 60 * 24 * 7; }
		$memcache->set($key,$value,0,$cache_seconds);//有效时间1周
	}
	
	//获取缓存
	public static function pullCache($key)
	{
		$memcache = new Memcache();
		$memcache->connect(CACHE_SRV,CACHE_PORT);
		$o = $memcache->get($key);
		// Util::Log(array($key,$o,CACHE_SRV,CACHE_PORT));
		return $o;
	}
	
	//删除缓存
	public static function deleteCache($key,$timeout = 0)
	{
		$memcache = new Memcache();
		$memcache->connect(CACHE_SRV,CACHE_PORT);
		if(is_array($key))
		{
			foreach($key as $k){
				$memcache->delete($k,$timeout);
			}
		}
		else
		{
			$memcache->delete($key,$timeout);
		}
	}
	
	public static function mb_unserialize($serial_str) 
	{ 
		$data = unserialize($serial_str);
		if(is_array($data)){ return $data; }
		$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str ); 
		$serial_str= str_replace("\r", "", $serial_str); 
		$data = unserialize($serial_str);
		return  $data;
	} 
	
	//从新浪获取短网址
	public static function short_url($long_url)
	{
		$r = @file_get_contents($long_url);	
		if($r != '')
		{
			$array = json_decode($r,true);
			return $array[0]['url_short'];
		}
	}
	
	//用rsa加密
	public static function rsa_encode($data)
	{
		//$pi_key =  openssl_pkey_get_private(PRIVATE_KEY);
		$pu_key = openssl_pkey_get_public(PUBLIC_SRV_KEY);		
		
		if(is_array($data)){ $data = json_encode($data); }
		openssl_public_encrypt($data, $encrypted, $pu_key);//公钥加密
		$encrypted = base64_encode($encrypted);// base64传输
		//echo $encrypted,"<br/>";
		
		return $encrypted;
	}
	
	//用rsa解密
	public static function rsa_decode($encrypted)
	{
		$pi_key =  openssl_pkey_get_private(PRIVATE_KEY);
		//$pu_key = openssl_pkey_get_public(PUBLIC_SRV_KEY);		
		openssl_private_decrypt(base64_decode($encrypted), $decrypted, $pi_key);//私钥解密
		
		return $decrypted;
	}

	// 从内容详情中获取图片
	public static function get_images($content)
	{
		$r = null;
		$f = preg_match_all("/src=\"\/?(.*?)\"/", $content, $match);
		if($f > 0){
			$r = $match[1];
		}

		return $r;
	}
}
?>
