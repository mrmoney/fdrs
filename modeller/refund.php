<?php
class Refund_Modeller extends Order_Modeller
{
	protected $table = 'ussv_order_refund';
	protected $key = 'id';

	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	//发起新的退款请求
	public function save_refund($args)
	{
		//判断退款总金额是否超限
		$fields = 'order_num,pay_status,pay_type,paid_amount,pay_time';
		$array = $this->queryFields($fields,array('id' => $args['order_id']),
										'ussv_order_main');
		if((int)$array['pay_status'] <= 0){
			$this->MSG[] = '退款请求失败：当前订单还未支付';
			return false;
		}

		$pay_type = $array['pay_type'];
		if(!Config_Modeller::is_online_pay($pay_type)){
			$this->MSG[] = '退款请求失败：当前订单不属于第三方支付网关';
			return false;
		}

		$pay_time = $array['pay_time'];
		if($pay_time != ''){
			$pay_time = strtotime($pay_time);
			$time_diff = abs($pay_time - NOW);
			if($time_diff > 60 * 60 * 24 * 300){
				$this->MSG[] = '当前订单已过退款期限';
				return false;
			}
		}

		$order_num = $array['order_num'];
		$refund_fee = sprintf('%01.2f',$args['refund_fee']);
		//获取已经发起的退款总额
		$filter = sprintf('where order_num=\'%s\' and refund_status in (0,1)',$order_num);
		$saved_total_fee = $this->ReturnSum('refund_fee',$filter,'ussv_order_refund');
		$refunding_fee = $saved_total_fee + $refund_fee;

		if($refunding_fee > $array['paid_amount']){
			$diff_fee = abs(sprintf('%01.2f',($array['paid_amount'] - $saved_total_fee)));
			$this->MSG[] = '退款请求失败：退款总额已超限，剩余可退￥' . $diff_fee;
			return false;
		}

		//追加以下数据
		$args['order_num'] = $array['order_num'];

		$this->starttrans();
		if($this->add($args)){
			$refund_id = $this->lastid();
			switch ($pay_type) {
				case 1://微信支付
					$args_req = array(
							'order_num' => $args['order_num'],
							'refund_num' => $args['refund_num'],
							'paid_amount' => $array['paid_amount'],
							'refund_fee' => $args['refund_fee'],
						);

					$req_r = $this->submit_wechat_refund($args_req);
					if(array_key_exists("return_code", $req_r)
						&& array_key_exists("result_code", $req_r)
						&& $req_r["return_code"] == "SUCCESS"
						&& $req_r["result_code"] == "SUCCESS"){
						
						//发起成功
						//$this->query_refund($refund_id);
						$this->commit();
						return true;
					}else{
						$this->rollback();
						$msg = self::returnText($req_r['err_code_des'],$req_r['return_msg']);
						$this->MSG[] = '退款请求失败[' . $msg . ']';
						return false;
					}
					break;
				default:
					$this->commit();
					return true;
					break;
			}
		}else{
			$this->MSG[] = '退款请求失败[' . $this->DBERROR() . ']';
			return false;
		}
	}

	//向微信提交退款请求
	public function submit_wechat_refund($args)
	{
		wxpay_core_api();

		$order_num = $args['order_num'];
		$refund_num = $args['refund_num'];
		$total_fee = $args['paid_amount'] * 100;
		$refund_fee = $args["refund_fee"] * 100;

		$input = new WxPayRefund();
		$input->SetOut_trade_no($order_num);
		$input->SetTotal_fee($total_fee);
		$input->SetRefund_fee($refund_fee);
	    $input->SetOut_refund_no($refund_num);
	    $input->SetOp_user_id(WxPayConfig::MCHID);
	    $input->SetNotify_url(WxPayConfig::NOTIFY_REFUND_URL);

	    $r = WxPayApi::refund($input);
	    Util::Log($r);
	    return $r;
	}

	//更新退款结果
	public function update_refund($args,$refund_num,$order_num)
	{
		if(!$this->updateByParams($args,array('refund_num' => $refund_num))){
			$this->MSG[] = '修改失败：' . $this->DBERROR();
			return false;
		}else{
			//汇总退款总额
			$sql = "UPDATE ussv_order_main a set a.refund_amount=(select 
						COALESCE(SUM(b.refund_fee),0) from ussv_order_refund b 
						where b.order_num=a.order_num and b.refund_status = 1) 
						where a.order_num='{$order_num}';";
			$this->execute($sql);
			return true;
		}
	}

	//获取某订单的退款清单
	public function query_refunds($id)
	{
		$sql = sprintf("select * from ussv_order_refund where order_id=%d",$id);
		$q = $this->query($sql);

		return $q;
	}

	//获取某条退款请求的详细信息
	public function query_refund($id)
	{
		$sql = sprintf('SELECT a.order_num,a.refund_num,a.refund_status,b.pay_type
							FROM ussv_order_refund AS a
						INNER JOIN ussv_order_main AS b ON a.order_id = b.id
							WHERE a.id=%d',$id);
		$q = $this->query($sql,false);//Util::Log($sql);
		if(!$q){
			$this->MSG[] = '无此退款记录';
			return false;
		}

		$array = $q[0];
		$pay_type = $array['pay_type'];
		switch ($pay_type) {
			case 1:
				return $this->query_wxpay_refund($array);
				break;
			default:
				$this->MSG[] = '此付款通道暂不支持退款查询';
				return false;
				break;
		}
	}

	//微信付款渠道的退款查询
	private function query_wxpay_refund($array)
	{
		$order_num = $array['order_num'];
		$refund_num = $array['refund_num'];

		wxpay_core_api();
		$input = new WxPayRefundQuery();
		$input->SetOut_refund_no($refund_num);
		$req_r = WxPayApi::refundQuery($input);
		Util::Log($req_r);

		if(array_key_exists("return_code", $req_r)
			&& array_key_exists("result_code", $req_r)
			&& $req_r["return_code"] == "SUCCESS"
			&& $req_r["result_code"] == "SUCCESS"){
			
			$args['refund_status'] = 1;
			$args['refund_time'] = $req_r['refund_success_time_0'];
			return $this->update_refund($args,$refund_num,$order_num);
		}else{
			$this->MSG[] = $req_r["return_msg"];
			return false;
		}
	}
}
?>