<?php
class Cart_Service extends Base_Service
{
	//获取购物车中的商品总金额
	public static function get_total_amount()
	{
		$cart_data = System::getTmpInfo(CART);
		$total_amount = 0;
		if(is_array($cart_data)){
			$total = count($cart_data);
			foreach ($cart_data as $id => $array) {
				$p = $array['snapshot'];
				$price = sprintf('%01.2f',$p['price1']);
				$num = (int)$array['num'];

				$total_amount += sprintf('%01.2f',$num * $price);
			}
		}

		return $total_amount;
	}
}
?>