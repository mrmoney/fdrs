<?php
class Message_Modeller extends Base_Modeller
{
	public $sign = '乔治巴顿中国';
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	/**
	 * [sendByTencent 腾讯云短信入口]
	 * @param  [type]  $phoneNumber [接收号码]
	 * @param  [type]  $params      [模板中的数据,数组形式]
	 * @param  integer $templId     [内容模板id]
	 * @param  string  $session_data[用户的 session 内容，腾讯 server 回包中会原样返回]
	 * @param  [type]  $nationCode  [国家代号]
	 * @param  string  $extend      [短信码号扩展号，格式为纯数字串，默认没有开通]
	 * @return [type]               [description]
	 */
    public function sendByTencent($phoneNumber, $params = array(), $templId = 0, 
                       $session_data = '', $nationCode = '86', $extend = '')
    {
    	//API说明：https://cloud.tencent.com/document/product/382/5976
        $url = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms";
        $appid = '1400094617';//SDK appid 一般为数字  1400开头
        $appkey = '1e0477de0fb701ce58a3f9d44b3e9103'; //SDK 对应的 APP KEY
        $random = $this->getRandom();
        $curTime = time();
        $wholeUrl = $url . '?sdkappid=' . $appid . '&random=' . $random;

        // 按照协议组织 post 包体
        $data = new stdClass();
        $tel = new stdClass();
        $tel->nationcode = '' . $nationCode;
        $tel->mobile = '' . $phoneNumber;

        $data->tel = $tel;
        $data->sig = $this->calculateSigForTempl($appkey, $random, $curTime, $phoneNumber);
        $data->tpl_id = $templId;
        $data->params = $params;
        $data->sign = $this->sign;
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $session_data;

        $r = $this->sendCurlPost($wholeUrl, $data);
        $r = json_decode($r,true);

        if(is_array($r)){
            $r['result'] =  $r['result'] == '0'?true:false;
        }else{
        	$r['result'] = false;
        	$r['errmsg'] = '网络错误';
        }

        // debug模式
        // $r['result'] = true;
        
        return $r;
    }

 	private function getRandom()
    {
        return rand(100000, 999999);
    }

	private function calculateSig($appkey, $random, $curTime, $phoneNumbers)
    {
        $phoneNumbersString = $phoneNumbers[0];
        for ($i = 1; $i < count($phoneNumbers); $i++) {
            $phoneNumbersString .= (',' . $phoneNumbers[$i]);
        }

        $hash = hash('sha256', 'appkey=' . $appkey . '&random=' . $random
                	. '&time=' . $curTime . '&mobile=' . $phoneNumbersString); 
        return $hash;
    }

	private function calculateSigForTemplAndPhoneNumbers($appkey, $random, 
                                                        $curTime, $phoneNumbers)
    {
        $phoneNumbersString = $phoneNumbers[0];
        for ($i = 1; $i < count($phoneNumbers); $i++) {
            $phoneNumbersString .= (',' . $phoneNumbers[$i]);
        }

        $hash = hash('sha256', 'appkey=' . $appkey . '&random=' . $random
                	. '&time=' . $curTime . '&mobile=' . $phoneNumbersString); 
        return $hash;
    }

	private function phoneNumbersToArray($nationCode, $phoneNumbers)
    {
        $i = 0;
        $tel = array();
        do {
            $telElement = new stdClass();
            $telElement->nationcode = $nationCode;
            $telElement->mobile = $phoneNumbers[$i];
            array_push($tel, $telElement);
        } while (++$i < count($phoneNumbers));

        return $tel;
    }

	private function calculateSigForTempl($appkey, $random, $curTime, $phoneNumber)
    {
        $phoneNumbers = array($phoneNumber);
        return $this->calculateSigForTemplAndPhoneNumbers($appkey, $random, 
                                    $curTime, $phoneNumbers);
    }

	private function sendCurlPost($url, $dataObj)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($curl);
        if (false == $ret) {
            // curl_exec failed
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else {
            $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". 
                				$rsp . " " . curl_error($curl) ."\"}";
            } else {
                $result = $ret;
            }
        }
        curl_close($curl);

        return $result;
    }

    //阿里短信发送
    public function sendByAli($mobile,$signname,$smsTempl,$ParamString2)
    {
    
        $host = 'http://sms.market.alicloudapi.com';
        $path = '/singleSendSms';
        $method = 'GET';
        $appcode = '';//阿里短信  密钥  非key和secret
        $headers = array();
        array_push($headers, 'Authorization:APPCODE ' . $appcode);
        $querys = "ParamString=$ParamString2&RecNum=$mobile&SignName=$signname&TemplateCode=$smsTempl";
        $bodys = '';
        $url = $host . $path . '?' . $querys;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos('$' . $host, 'https://'))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $res = curl_exec($curl);

        return $res;
    }
}
?>