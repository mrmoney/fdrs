<?php
class Order_Modeller extends Money_Modeller
{
	protected $table = 'ussv_order_main';
	protected $key = 'id';

	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	/*
		主表：		订单号，姓名，手机号，下单时间，总金额，订单状态
					付款信息:{ 支付方式,付款成功时间 }
					收货信息:{ 收货人姓名,手机号,详细地址,邮政编码 }
					配送信息:{ 物流公司,物流单号,配送费用,发货人,发货时间 }

		商品清单：	商品快照,数量,单价
	 */
	public function save_order($args)
	{
		$r = false;
		$this->starttrans();

		$args_main = $args['main'];
		$order_id = $this->add($args_main);	
		$order_num = $args_main['order_num'];	
		if($order_id > 0){
			//存储商品清单
			$items = $args['items'];
			foreach ($items as $id => $item) {
				$data = null;
				$data['order_id'] = $order_id;
				$data['product_id'] = $item['snapshot']['id'];
				//$data['order_num'] = $order_num;
				$data['num'] = $item['num'];
				$data['price'] = $item['snapshot']['price1'];
				
				$product_data = json_encode($item['snapshot']);
				$product_data = addslashes($product_data);
				$data['product_data'] = $product_data;
				if(!$this->add($data,'ussv_order_item')){
					$this->MSG[] = '订单提交失败';
					$this->rollback();
					return false;
				}
			}

			$r = true;
		}else{
			$this->MSG[] = '订单提交失败';
			$this->rollback();
		}

		if($r){
			$this->commit();
			System::clearTmpInfo(CART);
		}

		return $r;
	}

	// 获取订单列表,$filter是个条件数组
	public function query_order($filter,$limit,$fields = '*')
	{
		$sql = sprintf("select %s from ussv_order_main %s
						order by id desc %s",
						$fields,$filter,$limit);
		$q = $this->query($sql);//Util::Log($q);
		return $q;
	}

	//获取订单中的清单
	public function query_items($id,$fields = '*')
	{
		$sql = sprintf("select %s from ussv_order_item where order_id=%d",
							$fields,$id);
		$q = $this->query($sql,false);//Util::Log(array($sql,$q));

		return $q;
	}

	//获取某订单中某商品的快照数据
	public function get_snapshot($id)
	{
		$product_data = null;
		$fields = 'product_data';
		$array = $this->queryFields($fields,array('id' => $id),'ussv_order_item');
		if($array){
			$product_data = json_decode($array['product_data'],true);
		}

		return $product_data;
	}

	//获取订单详情
	public function get_order($params,$fields = '*',$query_items = true)
	{
		$r = null;
		//$sql = sprintf("select %s from ussv_order_main where id = %d",
		//						$fields,$id);
		//$q = $this->getAll($sql);//Util::Log($q);
		$q = $this->queryFields($fields,$params);
		if($q){ 
			// $main = $q[0];
			$main = $q;
			$id = $q['id'];
			//付款状态
			$pay_status_txt = Config_Modeller::pay_status_text($main);
			$main['pay_status_txt'] = $pay_status_txt;

			//物流信息
			$transport_data = json_decode($main['transport_data'],true);
			//$main['transport_data'] = $transport_data;
			if(is_array($transport_data)){
				$ary_ts = null;
				$express_types = Config_Modeller::express_types();
				if($transport_data['ts_type'] != ''){
					$ary_ts[] = $express_types[$transport_data['ts_type']]['text'];
				}else{
					$ary_ts[] = '未指定物流公司';
				}
				if($transport_data['ts_num'] != ''){
					$ary_ts[] = '单号(' . $transport_data['ts_num'] . ')';
				}
				if($transport_data['ts_fee'] != ''){
					$ary_ts[] = '￥' . $transport_data['ts_fee'];
				}
				if($transport_data['ts_sender'] != ''){
					$ary_ts[] = '发货人(' . $transport_data['ts_sender'] . ')';
				}
				if($transport_data['ts_date'] != ''){
					$ary_ts[] = '发货时间(' . $transport_data['ts_date'] . ')';
				}
				if($ary_ts != null){
					$main['express_desc'] = join('，',$ary_ts);
				}
				$main = array_merge($main,$transport_data);
			}else{
				$main['express_desc'] = '还未填写物流配送信息 ..';
			}
			
			//收货人信息
			$recever_data = json_decode($main['recever_data'],true);
			//$main['recever_data'] = $recever_data;
			if(is_array($recever_data)){
				$ary_recever = null;
				if($recever_data['r_name'] != ''){
					$ary_recever[] = $recever_data['r_name'];
				}
				if($recever_data['r_phone'] != ''){
					$ary_recever[] = $recever_data['r_phone'];
				}
				if($recever_data['r_addr'] != ''){
					$ary_recever[] = $recever_data['r_addr'];
				}
				if($recever_data['r_post'] != ''){
					$ary_recever[] = '邮编(' . $recever_data['r_post'] . ')';
				}
				if($ary_recever != null){
					$main['recever_desc'] = join('，',$ary_recever);
				}
				$main = array_merge($main,$recever_data);
			}else{
				$main['recever_desc'] = '还未填写收件人信息';
			}

			$r['main'] = $main;

			//如果还要求返回清单
			if($query_items){
				//再去获取清单
				$q_items = $this->query_items($id);
				//Util::Log($q_items);
				if(is_array($q_items)){
					$items = null;
					foreach ($q_items as $array) {
						$item = null;
						$item['id'] = $array['id'];
						$item['num'] = $array['num'];
						$item['price'] = sprintf('%01.2f',$array['price']);
						$product_data = json_decode($array['product_data'],true);
						$item['product_data'] = $product_data;

						$items[] = $item;
					}
					$r['items'] = $items;
				}
			}
		}

		return $r;
	}

	//修改订单
	public function update_order($args,$ary_filter,$save_from_sys = false)
	{
		if(!$save_from_sys && array_key_exists('pay_status',$args)){
			//来自人工修改
			//要判断付款状态是否可改变
			$fields = 'pay_status,pay_type,pay_time,paid_amount,refund_amount';
			$array = $this->queryFields($fields,$ary_filter);
			if(!$array){
				$this->MSG[] = '不存在此订单';
				return false;
			}else{
				if(Config_Modeller::is_online_pay($array['pay_type'])){
					//$pay_types = Config_Modeller::pay_types();
					$pre_pay_status = $array['pay_status'];
					if($pre_pay_status > 0){
						$pay_statuses = Config_Modeller::pay_status();
						$now_pay_status_text = $pay_statuses[$pre_pay_status]['text'];
						$now_pay_status_text = '当前付款状态为 [' . 
													$now_pay_status_text . ']';
						//判断付款状态
						if($pre_pay_status != $args['pay_status']){
							$this->MSG[] = $now_pay_status_text . ',不能修改了';
							return false;
						}

						//判断应付金额
						$pre_paid_amount = $array['paid_amount'];
						if($pre_paid_amount != $args['paid_amount']
							&& array_key_exists('paid_amount',$args)){
							$this->MSG[] = $now_pay_status_text . ',不能修改实付金额';
							return false;
						}

						$pre_pay_type = $array['pay_type'];
						//判断付款方式
						if($pre_pay_type != $args['pay_type']
							&& array_key_exists('pay_type',$args)){
							$this->MSG[] = $now_pay_status_text . ',不能修改付款方式';
							return false;
						}

						$pre_pay_time = $array['pay_time'];
						//判断付款时间
						if($pre_pay_time != $args['pay_time']
							&&	array_key_exists('pay_time',$args)){
							$this->MSG[] = $now_pay_status_text . ',不能修改付款时间';
							return false;
						}
					}
				}
			}
		}

		if(!$this->updateByParams($args,$ary_filter)){
			$this->MSG[] = '修改失败：' . $this->DBERROR();
			return false;
		}else{
			return true;
		}
	}

	public function delete_order($id)
	{
		$fields = 'order_time,order_status,pay_status,pay_time,refund_amount';
		$array = $this->queryFields($fields,array('id' => $id));
		if(!$array){
			$this->MSG[] = '不存在此订单';
			return false;
		}else{
			if($array['order_status'] > 0
				|| $array['pay_status'] > 0
				|| $array['pay_time'] != ''
				|| $array['refund_amount'] > 0){
				$this->MSG[] = '该订单已有付款信息,不能删除';
				return false;
			}else{
				//判断下单时间
				$order_time = strtotime($array['order_time']);
				$time_diff = abs(NOW - $order_time);
				if($time_diff <= 60 * 60 * 24){
					$this->MSG[] = '该订单距离下单时间未超过24小时,不能删除';
					return false;
				}

				$this->starttrans();
				if($this->delete(array('id' => $id))){
					if(!$this->delete(array('order_id' => $id),'ussv_order_item')){
						$this->rollback();
						$this->MSG[] = '订单中的商品清单删除失败';
						return false;
					}
					$this->commit();
					return true;
				}else{
					$this->MSG[] = '订单删除失败：' . $this->DBERROR();
					return false;
				}
			}
		}
	}

	public function close_order($id)
	{
		$fields = 'order_num,pay_status,pay_type,pay_time,refund_amount';
		$array = $this->queryFields($fields,array('id' => $id));
		if(!$array){
			$this->MSG[] = '不存在此订单';
			return false;
		}else{
			if($array['pay_status'] > 0
				|| $array['pay_time'] != ''
				|| $array['refund_amount'] > 0){
				$this->MSG[] = '该订单已有付款信息,不能关闭';
				return false;
			}

			if(Config_Modeller::is_online_pay($array['pay_type'])){
				switch ($array['pay_type']) {
					case 1:
						wxpay_core_api();
						$input = new WxPayRefundQuery();
						$input->SetOut_trade_no($array['order_num']);
						$req_r = WxPayApi::closeOrder($input);
						Util::Log($req_r);
						if(array_key_exists("return_code", $req_r)
							&& array_key_exists("result_code", $req_r)
							&& $req_r["return_code"] == "SUCCESS"
							&& $req_r["result_code"] == "SUCCESS"){
							
							$args['order_status'] = -1;
							$this->updateByParams($args,array('id' => $id));
							return true;
						}else{
							$this->MSG[] = $req_r["return_msg"];
							return false;
						}
						break;
					default:
						$this->MSG[] = '此付款方式不支持关闭订单';
						return false;
						break;
				}
			}else{
				$this->MSG[] = '此付款方式不支持关闭订单';
				return false;
			}
		}
	}
}
?>