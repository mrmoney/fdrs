<?php
//购物车
class Cart_Modeller extends Product_Modeller
{
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}

	//根据手机号查询其历史记录
	public function query_customer($phone_num)
	{
		$fields = 'realname,recever_data';
		$sql = sprintf('select %s from ussv_order_main where phone_num=\'%s\'',
							$fields,$phone_num);
		$q = $this->query($sql);
		
		//基本信息
		$r['basic']['phone_num'] = $phone_num;
		$r['basic']['realname'] = '';
		
		//收货人信息
		$recever['r_name'] = '';
		$recever['r_phone'] = '';
		$recever['r_addr'] = '';
		$recever['r_post'] = '';
		$r['recever'] = $recever;

		if($q){
			foreach ($q as $array) {
				$recever_data = json_decode($array['recever_data'],true);
				$r['basic']['realname'] = $array['realname'];
				if(is_array($recever_data)){
					//姓名、电话、地址、邮编
					foreach ($recever_data as $key => $value) {
						if($value != ''){
							$recever[$key] = $value;
						}
					}
				}
			}

			$r['recever'] = $recever;
		}

		return $r;
	}

	//放入购物车
	public function push($id)
	{
		$array = $this->get_product($id);
		if(!is_array($array)){
			$this->MSG[] = '该装备不存在或以下架';
			return false;
		}

		if((int)$array['isdeleted'] > 0 || (int)$array['enabled'] < 1){
			$this->MSG[] = '该装备不存在或以下架';
			return false;
		}

		$photos = json_decode($array['photos'],true);
		unset($array['photos']);
		$array['photos'] = $photos;

		$cart_data = System::getTmpInfo(CART);
		$cart_data[$id]['snapshot'] = $array;

		$num = (int)$cart_data[$id]['num'];
		$cart_data[$id]['num'] = $num + 1;
		System::setTmpInfo(CART,$cart_data);

		return true;
	}

}
?>