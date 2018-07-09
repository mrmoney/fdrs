<?php
class Validate {
		/**
		 * 验证是否为数字，英语字母，汉字，下划线
		 * @param    string    $str    被验证的参数
		 * @return    bool
		 */
		public static function valiStrZn($str){
			if (!eregi("^[a-z0-9|_|\x80-\xff]{1,}$", $str)) {
				return true;
			}
			return false;
		}
	
		/**
		 * 验证是否为数字，英语字母，下划线
		 * @param    string    $str    被验证的参数
		 * @return    bool
		 */
		public static function valiStrNomal($str){
			if (!eregi("^[_a-z0-9]{3,16}$", $str)) {
				return true;
			}
			return false;
		}
	
		/**
		 * 验证E-mail
		 * @param    string    $str    email
		 * @return    bool
		 */
		public static function isEmail($str){
			if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z]{2,3})$/", $str)) {
				return true;
			}
			return false;
		}
		 
		/**
		 * 验证数字
		 * @param    string    $str    数字
		 * @return    bool
		 */
		public static function isNumber($str){
			if (preg_match("/^[0-9]*$/", $str)) {
				return true;
			}
			return false;
		}
	
		/**
		 * 验证字符串长度
		 * @param    string    $str    字符串
		 * @param    int        $min    最不长度
		 * @param    int        $max    最大长度
		 * @return    bool
		 */
		public static function valiLength($str, $min, $max){
			if ($min > strlen($str) || strlen($str) > $max ) {
				return true;
			}
			return false;
		}
	
		/**
		 * 验证日期
		 * @param    int    $year    年
		 * @param    int    $month    月
		 * @param    int    $day    日
		 * @return    bool
		 */
		public static function validateDate($year,$month,$day){
			if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)){
				if ($month == 2){
					if ($day > 29){
						return true;
					}
				}
			}
			if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
				if ($day > 31){
					return true;
				}
			}elseif ($month == 2){
				if ($day > 28){
					return true;
				}
			}else {
				if ($day > 30){
					return true;
				}
			}
		}
	
		/**
		 * 验证个人主页
		 * @param    string    $str    homepage
		 * @return    bool
		 */
		public static function isHomePage($str){
			if (preg_match("/^(http://)(\.\w)*\.(com|cn|com\.cn)/", $str)) {
				return true;
			}
			return false;
		}
	
		/**
		 * 判断字符串是否为空
		 *
		 * @param     string $str
		 * @return     bool
		 */
		public static function isEmpty($str){
			if (!is_string($C_char)) return false; //是否是字符串类型
			if(empty($str)){
				return true;
			}
			if($str == ''){
				return true;
			}
			return false;
		}
		 
		/**
		 * 是否含有中文
		 *
		 * @param String $str
		 * @return Bool
		 */
		public static function hasChinese($str){
			$cns = self::getLens($str);
			if($cns['cn'] > 0){
				return true;
			}
			return false;
		}
	
		/**
		 * 是否为纯中文
		 *
		 * @param String $str
		 * @return Bool
		 */
		public static function isChinese($str){
			$cns = self::getLens($str);
			if ($cns['cn'] > 0 && $cns['en'] == 0){
				return true;
			}
			return false;
		}
		 
		/**
		 * 是否是纯英文
		 *
		 * @param unknown_type $str
		 * @return unknown
		 */
		public static function isEnglish($str){
			if(preg_match("/[^a-zA-Z]/",$str)){
				return false;
			}else{
				return true;
			}
		}
		 
		/**
		 * 是否符合URL规范
		 *
		 * @param     string $url
		 * @return    bool
		 */
		public static function isURL($url){
			if(preg_match( '/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i' ,$url)){
				return true;
			}else{
				return false;
			}
		}
		 
		/**
		 * 是否是QQ号码
		 *
		 * @param unknown_type $str
		 * @return unknown
		 */
		public static function isQQ($str){
			if(is_numeric($str)){
				return true;
			}
			if(preg_match("/\d{5,12}/",$str)){
				return true;
			}
			return false;
		}
		 
		/**
		 * 是否是手机号码
		 *
		 * @param    string    $str    手机
		 * @return    bool
		 */
		public static function isMobile($str){
			if(preg_match("/^1\d{10}$/", $str)){
				return true;
			}else{
				return false;
			}
		}
		 
		/**
		 * 是否是电话号码
		 *
		 * @param    string    $str    固定电话
		 * @return    bool
		 */
		public static function isPhone($str){
			if(preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/", $str)){
				return true;
			}else{
				return false;
			}
		}
		 
		/**
		 * 是否是合法身份证
		 *
		 * @param unknown_type $str
		 * @return unknown
		 */
		public static function isCard($str){
			if(preg_match("/^\d{15}(\d{2}[xX0-9])?$/", $str)){
				return true;
			}else{
				return false;
			}
		}
		 
		/**
		 * 是否是邮编
		 *
		 * @param unknown_type $str
		 * @return unknown
		 */
		public static function isZip($str){
			if(preg_match("/^[1-9]\d{5}$/", $str)){
				return true;
			}else{
				return false;
			}
		}
	
		/**
		 * 长度范围(包括边界)
		 * @param    int        $min    最小长度
		 * @param    int        $max    最大长度
		 * @param    string    $str    字符串
		 * @return    bool
		 */
		public static function isBetween($min,$max,$str){
			$cns = self::getLens($str);
			$len = $cns['cn'] * 2 + $cns['en'];
	
			if ($len < $min || $len > $max){
				return false;
			} else {
				return true;
			}
		}
	
		/**
		 * 取长度信息
		 * @param    string    $str    字符串
		 * @return    array
		 */
		public static function getLens($str){
			$numCn = 0;
			$numEn = 0;
			for ($i=0; $i<strlen($str); $i++) {
				if (ord($str[$i]) > 127) {
					$numCn++;
					$i += 2;
				} else {
					$numEn++;
				}
			}
			return array("cn"=>$numCn,"en"=>$numEn,"all"=>($numCn*2+$numEn));
		}
	
		/**
		 * 检查ASCII字符串
		 * @param    string    $ascii    字符串
		 * @return    bool
		 */
		public static function checkAscii($ascii){
			if(!ereg("^[a-zA-Z0-9 \.\,\+\!\@\#\$\%\^\&\*\(\)\~\/\'\_\-]+$", $ascii)){
				return false;
			}else{
				return true;
			}
		}
	
	
		/**
		 * 检查主机名称是否合法
		 * @param    string    $host    主机名
		 * @return    bool
		 */
		public static function isHostName($host)
		{
			if(!ereg("^[a-zA-Z0-9\.\@\*\-]+$", $host)){
				return false;
			}else{
				return true;
			}
		}
		/**
		 * 验证身份证号
		 * @param $vStr
		 * @return bool
		 */
		public static function isCreditNo($vStr)
		{
			$vCity = array(
					'11','12','13','14','15','21','22',
					'23','31','32','33','34','35','36',
					'37','41','42','43','44','45','46',
					'50','51','52','53','54','61','62',
					'63','64','65','71','81','82','91'
			);
		
			if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
		
			if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
		
			$vStr = preg_replace('/[xX]$/i', 'a', $vStr);
			$vLength = strlen($vStr);
		
			if ($vLength == 18)
			{
				$vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
			} else {
				$vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
			}
		
			if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
			if ($vLength == 18)
			{
				$vSum = 0;
		
				for ($i = 17 ; $i >= 0 ; $i--)
				{
				$vSubStr = substr($vStr, 17 - $i, 1);
				$vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
				}
		
				if($vSum % 11 != 1) return false;
		}
		
		return true;
		}
		
		/**
		 * 检查数据是否是99999.99格式
		 * @param    string    $money    待检测的数字
		 * @return    bool
		 */
		public static function isMoney($money)
		{
			if (!preg_match("/^[0-9][.][0-9]$/", $money)) return false;
			return true;
		}
	
		/**
		 * 判断是否为合法用户名
		 * @param    string    $user_name    用户名
		 * @return    bool
		 */
		public static function checkUserName($user_name)
		{
			//宽度检验
			if (!self::valiLength($user_name,4,20)) return false;
			//特殊字符检验
			if (!preg_match("/^[_a-zA-Z0-9]*$/", $user_name)) return false;
			return true;
		}
	
		/**
		 * 判断是否为合法用户密码
		 * @param    string    $passwd    密码
		 * @return    bool
		 */
		public static function checkPassword($passwd)
		{
			if (!self::valiLength($passwd, 4, 20)) return false; //宽度检测
			if (!preg_match("/^[_a-zA-Z0-9]*$/", $passwd)) return false; //特殊字符检测
			return true;
		}
}

?>