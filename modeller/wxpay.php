<?php
class Wxpay_Modeller extends Base_Modeller
{
	public $table,$key;
	
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}

	//微信预支付信息存储
	public function save_wxpay_prepare($args)
	{
		$r = $this->add($args,'ussv_wxpay_prepare');	
		if($r){
			return true;
		}else{
			$this->MSG[] = '预支付数据存储失败[' . $this->DBERROR() . ']';
			return false;
		}
	}

	//专门用于做接收支付成功通知
	public function save_wxpay_notify($args)
	{
		$filter = array('out_trade_no' => $args['out_trade_no']);
		//查询有没有更新过
		$q = $this->queryFields('*',$filter,'ussv_wxpay_prepare');
		if(!$q){
			$this->MSG[] = '不存在此交易';
			return false;
		}

		if($q['trade_state'] == 'SUCCESS'){ 
			//之前已经更新过数据库
			return true;
		}

		//开始组织需要更新到数据库中的数据
		$array_updating['openid'] = $args['openid'];
		$array_updating['trade_state'] = 'SUCCESS';
		$array_updating['time_end'] = $args['time_end'];
		$array_updating['transaction_id'] = $args['transaction_id'];
		$array_updating['notify_data'] = json_encode($args);

		if($this->updateByParams($array_updating,$filter,
				'ussv_wxpay_prepare')){
			//$this->starttrans();
			$num = sprintf('%01.2f',(int)$q['total_fee'] / 100);
			$paytype = (int)$q['paytype'];
			switch ($paytype) {
				default:
					$time_end = date('Y-m-d',strtotime($args['time_end']));
					$args_order['ac_date'] = $time_end;
					$args_order['money_now'] = $num;
					if(!$this->savepay_to_order($args_order,$paytype)){
						$this->MSG[] = '付款信息存储失败';
						return false;
					}
					break;
			}
		}
		else
		{
			$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
			return false;
		}
		
		return true;
	}

	//保存支付信息到订单表
	private function savepay_to_order($args,$paytype)
	{
		$
		$ary_paytype[] = 8;//固定微信支付
		$ary_inorout[] = 2;//入款
		//$ary_danhao[] = strtoupper($dingzhi_danhao);
		$ary_ac_date[] = $args['ac_date'];
		$ary_money[] = $args['money_now'];

		$classes = array(2 => 'OrderXF',3 => 'OrderCS');
		$o = new $classes[$paytype]();
		$o->__set('orderId',$args['orderId']);
		$o->__set('shopname',$args['shopname']);
		$o->__set('ordernumnow',$args['shopname'] . '-' .$args['ordernumnow']);
		$o->__set('yukuan_from',$ary_paytype);
		$o->__set('inorout',$ary_inorout);
		//$o->__set('dingzhi_danhao',$ary_danhao);
		$o->__set('yukuan_date',$ary_ac_date);
		$o->__set('yukuan',$ary_money);

		if($o->updateLeftPay())
		{
			//发送手机短信
			/*if($o->sms_user_id > 0)
			{
				Message_Controller_Customer::wallet(array('userId' => $o->sms_user_id));
			}*/
			return true;
		}

		Util::Log($o->__get('MSG'));
		
		return false;
	}

	public function clothes_num($userId)
	{
		$array = array('xf_num' => null,'cs_num' => null,'nz_num' => null);
		//西装
		$sql = "select COALESCE(SUM(total_y),0) as total_y,
						COALESCE(SUM(total_k),0) as total_k,
						COALESCE(SUM(total_m),0) as total_m 
				from _orderxfmain where userId = {$userId}";
		$q = $this->query($sql);
		if($q){
			$array['xf_num'] = $q[0];
		}

		//女装
		$sql = "select COALESCE(SUM(total_y),0) as total_y,
						COALESCE(SUM(total_k),0) as total_k,
						COALESCE(SUM(total_m),0) as total_m ,
						COALESCE(SUM(total_q),0) as total_q 
				from _ordernzmain where userId = {$userId}";
		$q = $this->query($sql);
		if($q){
			$array['nz_num'] = $q[0];
		}

		//衬衫
		$sql = "select COALESCE(SUM(total_jianshu),0) as total_y
				from _ordercsmain where userId = {$userId}";
		$q = $this->query($sql);
		if($q){
			$array['cs_num'] = $q[0];
		}

		return $array;
	}
	
	//删除西装中某件衣服
	//已弃用 ...
	public function remove_coat_item($orderId,$delete_id,$shops,$args)
	{
		$q = $this->queryFields('shopname,jingshou,orderstatus,mainparams',
						array('orderId' => $orderId,'version' => 2),'_orderxfmain');			
		if(!$q)
		{
			$this->MSG[] = '不允许删除此衣服';
			return false;
		}
		
		//只能删除自己所在门店的尺寸单
		if(is_array($shops)){
			if(!in_array($q['shopname'],$shops))
			{
				$this->MSG[] = '您无权删除此衣服';
				return false;
			}	
		}
		else
		{
			if($q['shopname'] != $shops){
				$this->MSG[] = '您无权删除此衣服';
				return false;
			}
		}
		
		if((int)$q['orderstatus'] >=12 )
		{
			$this->MSG[] = '该订单已结束,不能删除';
			return false;
		}
		
		$this->starttrans();
		if($delete_id > 0){
			//读取所有的子表
			$sql = sprintf("select isshenhe from perxzclothinfo 
								where Id = %d",$delete_id);
			$q = $this->query($sql);
			if(!$q){
				$this->MSG[] = '您要删除的衣服不存在';
				$this->rollback();
				return false;
			}else{
				$isshenhe = (int)$q[0]['isshenhe'];
				if($isshenhe > 1)
				{
					$this->MSG[] = '不允许删除已审核过的衣服';
					$this->rollback();
					return false;
				}
				
				$sql = "delete from perxzclothinfo where Id = {$delete_id}";
				if(!$this->execute($sql))
				{
					$this->MSG[] = '删除失败';
					$this->rollback();
					return false;
				}
			}
		}
		
		//重新计算衣服数量
		$total_y = 0;
		$total_k = 0;
		$total_m = 0;
		$ary_items = $args['items'];
		$obj_price = $args['price'];
		foreach($ary_items as $k => $item)
		{
			$total_y += (int)$item['yi'];	
			$total_k += (int)$item['ku'];	
			$total_m += (int)$item['majia'];	
		}

		$new_mainparams = serialize($args);
		$sql = sprintf("update _orderxfmain set 
							mainparams='%s',total_y=%d,total_k=%d,total_m=%d,
							oprice='%s',kl='%s',totalprice='%s'
						 where orderId=%d",$new_mainparams,$total_y,$total_k,$total_m,
						 $obj_price['oprice'], $obj_price['kl'], $obj_price['totalprice'],
						 $orderId);
		if(!$this->execute($sql))
		{
			$this->MSG[] = '删除失败';
			$this->rollback();
			return false;
		}
		
		$this->commit();
		return true;
	}

	public function check_mobile($phone_number,$realname = null)
	{
		$ary_filter[] = sprintf("mainphone = '%s'",$phone_number);
		if($realname != null){ $ary_filter[] = sprintf("realname = '%s'",$realname); }
		$filter = "where " . join(' and ',$ary_filter);
		return $this->checkExists($filter,'allnamephone');
	}

	public function save_reg($args)
	{
		$args['sms_enabled'] = 2;
		$args['save_from'] = 'mobile';
		//检查有没有重名的手机号和姓名

		$params['mainphone'] = $args['mainphone'];
		$params['realname'] = $args['realname'];
		$params['isdeleted'] = 1;
		$q = $this->queryFields("Id,userpwd",$params,'allnamephone');
		if($q){
			$userpwd = $q['userpwd'];
			$userId = $q['Id'];
			//if(strlen($userpwd) != 32){
				//应该是老顾客在注册,只需要为其设置密码即可
				$sql = "update allnamephone set userpwd='{$args['userpwd']}' where Id=$userId";
				if ($this->execute($sql)) {
					return true;
				}else{
					$this->MSG[] = '注册失败,请稍候再试';
					return false;
				}
			//}else{
			//	$this->MSG[] = '请不要重复注册';
			//	return false;
			//}
		}else{
			if ($this->add($args,'allnamephone')) {
				return true;
			}else{
				$this->MSG[] = '注册失败,请稍候再试';
				return false;
			}
		}
	}

	public function save_newpwd($args)
	{
		$params['mainphone'] = $args['mainphone'];
		$params['isdeleted'] = 1;
		$params['save_from'] = 'mobile';
		$q = $this->queryFields("Id,userpwd",$params,'allnamephone');
		if($q){
			$userpwd = $q['userpwd'];
			$userId = $q['Id'];
			if(strlen($userpwd) == 32){
				//应该是老顾客在注册,只需要为其设置密码即可
				$sql = "update allnamephone set userpwd='{$args['userpwd']}' where Id=$userId";
				if ($this->execute($sql)) {
					return true;
				}else{
					$this->MSG[] = '新密码保存失败,请稍候再试';
					return false;
				}
			}else{
				$this->MSG[] = '找不到您的注册资料';
				return false;
			}
		}else{
			$this->MSG[] = '找不到您的注册资料';
			return false;
		}
	}

	public function mobile_user_login($phone_number,$password)
	{
		$sql = sprintf("select * from allnamephone where mainphone='%s' 
					and userpwd='%s'",$phone_number,$password);
		$q = $this->query($sql);
		if(!$q){
			$this->MSG[] = '您输入的账户或者密码不正确';
			return false;
		}

		$array = $q[0];
		switch((int)$array['user_status'])
		{
			case 1:
				//查询他最后一次消费所在门店
				$ary_roles = array('门店服务员');
				$default_shop = 'WLDZ';
				$ary_multishops[] = array('value' => 'WLDZ',text => '网络定制店');
				$ary_shops = array('WLDZ');
				$userInfo = array(
									'realname' => $array['realname'],
									'username' => $array['mainphone'],
									'roles' => $ary_roles,//角色
									'shopname' => $default_shop,
									'userId' => $array['Id'],
									'viewphone' => false,

									'is_manager' => false,
									'is_only_shop_user' => true,
									'is_only_service_user' => false,
									'is_only_service_and_shop_user' => false,
									'is_shop_user' => true,//是否门店用户,包括服务员和门店师傅
									'is_only_worker' => false,
									'is_dress_master' => false,//是否女装师傅
									'shopnames' => $ary_multishops,
									'shops' => $ary_shops,
									'phone' => $array['mainphone'],//我的手机号码
									'zybh' => '',//西装纸样编号
								);

				//查询下单配置信息
				//1、我的纸样编号
				$sql = sprintf("select zybh_2 as zybh from _orderxfmain where userId=%d order by orderId desc limit 1",$array['userId']);
				$q = $this->query($sql);
				if($q){
					$userInfo['zybh'] = $q[0]['zybh'];
				}

				$userkey = md5($array['Id'] . NOW . '-user-self');
				$userInfo['userkey'] = $userkey;

				Util::pushCache($userkey,$userInfo);
				return $userInfo;
				break;
			default:
				$this->MSG[] = '未知的错误!';
				break;
		}
	}

	//存储来自app端的注册信息,主要是苹果审核需要
	//审核完毕后可以关闭此功能
	public function save_app_user($args)
	{
		$strfilter = sprintf(" where username='%s' ",$args['username']);
		if($this->checkExists($strfilter))
		{
			$this->MSG[] = $args['username'] . '已经存在';
			return false;
		}

		$args['userpwd'] = md5($args['userpwd']);
		if($this->add($args,'sysusers'))
		{
			return true;
		}
		else
		{
			$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
			return false;	
		}
	}
}
?>