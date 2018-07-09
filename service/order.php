<?php
class Order_Service extends Base_Service
{
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	//查询物流
	public function query_express($order_num)
	{
		$o = Order_Modeller::getInstance();
		$fields = 'transport_data';
		$array = $o->queryFields($fields,array('order_num' => $order_num),
										'ussv_order_main');

		$transport_data = json_decode($array['transport_data'],true);
		if(is_array($transport_data)){
			$ary_ts = null;
			$express_types = Config_Modeller::express_types();
			if($transport_data['ts_type'] != ''){
				$ary_ts[] = $express_types[$transport_data['ts_type']]['text'];
			}else{
				$this->MSG[] = '未指定物流公司';
				return false;
			}

			if($transport_data['ts_num'] != ''){
				$ary_ts[] = '单号(' . $transport_data['ts_num'] . ')';
			}else{
				$this->MSG[] = '未指定物流单号';
				return false;
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
				$array['express_desc'] = join('，',$ary_ts);
			}

			//开始尝试从第三方查询接口获取物流信息
			$ex_ordernum = $transport_data['ts_num'];
			$ex_type = $transport_data['ts_type'];
			$r = Util::query_kuaidi($ex_ordernum,$ex_type);
			if(!is_array($r)){
				$this->MSG[] = '没有跟踪到物流数据';
				return false;
			}else{
				$array['express_num'] = $r['order'];
				$array['items'] = $r['data'];
				return $array;
			}
		}else{
			$this->MSG[] = '未填写物流信息';
			return false;
		}
	}
}
?>