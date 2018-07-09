<?php
class Report_Modeller extends Base_Modeller
{
	protected $table = 'ussv_order_main';
	protected $key = 'id';

	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	public function query_sum($s_date,$e_date)
	{
		$datas = null;
		$xAxisData = null;//x轴数据
		$seriesData1 = null;//实收总额数组
		$seriesData2 = null;//退款总额数组

		$total_amount = 0;
		$refund_amount = 0;

		//根据下单日期计算总收入
		$fields = 'order_time,total_amount,paid_amount,refund_amount';
		$filter = "where order_time >= '{$s_date} 00:00:00' 
							and order_time <= '{$e_date} 23:59:59' 
							and order_status >= 0";
		$sql = sprintf("select %s from %s %s",$fields,$this->table,$filter);
		$q = $this->query($sql,false);
		if($q){
			$seriesData1 = null;
			foreach ($q as $array) {
				$row = null;
				$order_time = date('Y-m-d',strtotime($array['order_time']));

				//$now_amount = sprintf('%01.2f',($array['paid_amount'] - $array['refund_amount']));
				$now_amount = sprintf('%01.2f',$array['paid_amount']);
				$pre_amount = sprintf('%01.2f',$seriesData1[$order_time]);
				$amount = sprintf('%01.2f',$pre_amount + $now_amount);

				$seriesData1[$order_time] = $amount;
				$xAxisData[$order_time] = $order_time;
			}
		}

		//根据退款时间统计总退款
		$fields = 'submit_time,refund_fee,refund_status,refund_time';
		$filter = "where submit_time >= '{$s_date} 00:00:00' 
							and submit_time <= '{$e_date} 23:59:59' 
							and refund_status >= 0";
		$sql = sprintf("select %s from ussv_order_refund %s",$fields,$filter);
		$q = $this->query($sql,false);//Util::Log($sql);
		if($q){
			$seriesData2 = null;
			foreach ($q as $array) {
				$row = null;
				$order_time = date('Y-m-d',strtotime($array['submit_time']));

				$now_amount = sprintf('%01.2f',$array['refund_fee']);
				$pre_amount = sprintf('%01.2f',$seriesData2[$order_time]);
				$amount = sprintf('%01.2f',$pre_amount + $now_amount);

				$seriesData2[$order_time] = $amount;
				$xAxisData[$order_time] = $order_time;
			}

		}

		if($xAxisData != null){
			natcasesort($xAxisData);//进行自然排序,让日期从小到大排列
			$xAxisData = array_keys($xAxisData);
			//为了在相同的x坐标上显示正确的数据,需要进行校正
			$series1 = null;
			$series2 = null;
			foreach ($xAxisData as $date) {
				$series1[$date] = sprintf('%01.2f',$seriesData1[$date]);
				$series2[$date] = sprintf('%01.2f',$seriesData2[$date]);
			}

			$seriesData1 = $series1;
			$seriesData2 = $series2;

			if($seriesData1 != null){
				$seriesData1 = array_values($seriesData1);
				$total_amount = sprintf('%01.2f',array_sum($seriesData1));
			}

			if($seriesData2 != null){
				$seriesData2 = array_values($seriesData2);
				$refund_amount = sprintf('%01.2f',array_sum($seriesData2));
			}
		}

		$datas['xAxisData'] = $xAxisData;
		$datas['seriesData1'] = $seriesData1;
		$datas['seriesData2'] = $seriesData2;

		$datas['total_amount'] = $total_amount;
		$datas['refund_amount'] = $refund_amount;

		//Util::Log($datas);

		return $datas;
	}
}
?>