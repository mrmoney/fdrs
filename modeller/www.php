<?php
class Www_Modeller extends Base_Modeller
{
	protected $table = 'fdrs_testreq';
	protected $key = 'id';

	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	//存储预约试驾请求
	public function save_testreq($args)
	{
		$q = $this->queryFields('save_time',array('phone' => $args['phone']),
									'','order by id desc');
		if($q){
			$save_time = strtotime($q['save_time']);
			$time_diff = NOW - $save_time;
			if($time_diff <= (60 * 60 * 24)){
				$this->MSG[] = '您好，我们今天已收到过您的预约请求了，谢谢';
				return false;
			}
		}

		if($this->add($args)){
			return true;
		}else{
			$this->MSG[] = '存储失败';
			//$this->MSG[] = $this->DBERROR();
			return false;
		}
	}
	
	//查询预约记录
	public function query_testreq($filter,$limit,$fields = '*')
	{
		$sql = sprintf("select %s from fdrs_testreq %s
						order by id desc %s",
						$fields,$filter,$limit);
		$q = $this->query($sql,false);//Util::Log($q);
		return $q;
	}

	//修改预约状态
	public function update_status($ids,$status)
	{
		$sql = sprintf("update fdrs_testreq set status=%d where id in (%s)",
							$status,$ids);
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '修改失败';
			return false;
		}
	}

	// 删除预约情况
	public function delete_testreq($ids)
	{
		$sql = sprintf("delete from fdrs_testreq where id in (%s)",$ids);
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '删除失败';
			return false;
		}
	}
}
?>