<?php
class Admin_Modeller extends Base_Modeller
{
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}
	
	//单独修改纸样编号
	public function update_zybh($strfilter,$zybh)
	{
		$ary_zybh = explode('-',$zybh);
		$zybh_1 = $ary_zybh[0];//前缀
		$zybh_2 = $ary_zybh[1];//序号
		$sql = "select orderId,mainparams,version from _orderxfmain {$strfilter} ";	
		$q = $this->getAll($sql);
		if($q == null){ return; }

		$array = $q[0];
		$orderId = $array['orderId'];
		$version = $array['version'];
		$str_mainparams = $array['mainparams'];
		$ary_params = Util::mb_unserialize($str_mainparams);
		
		if($version == 2)
		{
			$obj_basic = $ary_params['basic'];
			$obj_basic['zybh'] = $zybh_1 . '-' . $zybh_2;
			$ary_params['basic'] = $obj_basic;
		}
		else
		{
			$ary_params['zybh'] = $zybh_1 . '-' . $zybh_2;
		}
		
		$mainparams = serialize($ary_params);
		$sql = sprintf("update _orderxfmain set zybh=%d,zybh_1='%s',zybh_2='%s',mainparams='%s'
						 where orderId=%d",$zybh_2,$zybh_1,$zybh_2 . '-' . $zybh_1,$mainparams,$orderId);
		$this->execute($sql);				 
	}
	
	//单独修改原单号
	public function update_lastordernum($strfilter,$lastordernum,$order_type)
	{
		switch($order_type)
		{
			case 'coat':
				$sql = "select orderId,mainparams,version from _orderxfmain {$strfilter} ";	
				$q = $this->getAll($sql);
				if($q == null){ return; }
				$ary_updates = null;
				$array = $q[0];
		
				$orderId = $array['orderId'];
				$version = $array['version'];
				$str_mainparams = $array['mainparams'];
				$ary_params = Util::mb_unserialize($str_mainparams);
				
				if($version == 2)
				{
					$obj_basic = $ary_params['basic'];
					$obj_basic['lastordernum'] = $lastordernum;
					$ary_params['basic'] = $obj_basic;
				}
				else
				{
					$ary_params['lastordernum'] = $lastordernum;
				}
				
				$mainparams = serialize($ary_params);
				$sql = sprintf("update _orderxfmain set lastordernum='%s',mainparams='%s'
								 	where orderId=%d",$lastordernum,$mainparams,$orderId);
				$this->execute($sql);	
				break;
			case 'shirt':
				$sql = "select orderId,mainparams,version from _ordercsmain {$strfilter} ";	
				$q = $this->getAll($sql);
				if($q == null){ return; }
				$ary_updates = null;
				$array = $q[0];
		
				$orderId = $array['orderId'];
				$version = $array['version'];
				$str_mainparams = $array['mainparams'];
				$ary_params = Util::mb_unserialize($str_mainparams);
				
				if($version == 2)
				{
					$obj_basic = $ary_params['basic'];
					$obj_basic['lastordernum'] = $lastordernum;
					$ary_params['basic'] = $obj_basic;
				}
				else
				{
					$ary_params['lastordernum'] = $lastordernum;
				}
				
				$mainparams = serialize($ary_params);
				$sql = sprintf("update _ordercsmain set lastordernum='%s',mainparams='%s'
								 	where orderId=%d",$lastordernum,$mainparams,$orderId);
				$this->execute($sql);	
				break;
			case 'dress':
				$sql = "select orderId,mainparams from _ordernzmain {$strfilter} ";	
				$q = $this->getAll($sql);
				if($q == null){ return; }
				$ary_updates = null;
				$array = $q[0];
		
				$orderId = $array['orderId'];
				$str_mainparams = $array['mainparams'];
				$ary_params = Util::mb_unserialize($str_mainparams);
				
				$ary_params['lastordernum'] = $lastordernum;
				
				$mainparams = serialize($ary_params);
				$sql = sprintf("update _ordernzmain set lastordernum='%s',mainparams='%s'
								 	where orderId=%d",$lastordernum,$mainparams,$orderId);
				$this->execute($sql);	
				break;
		}
	}
	
	//保存敏感客户信息
	public function save_sensitive($args)
	{
		$userId = (int)$args['Id'];	
		if($userId <= 0)
		{
			$userId = $this->add($args,'sys_sensitive_customer');	
			if($userId <= 0)
			{
				$this->MSG[] = '添加失败：' . $this->DBERROR();
				return false;
			}
		}
		else
		{
			unset($args['Id']);
			if(!$this->updateByParams($args,array('Id' => $userId),'sys_sensitive_customer'))
			{
				$this->MSG[] = '修改失败：' . $this->DBERROR();
				return false;
			}
		}
		
		return true;
	}
	
	//查询敏感客户
	public function query_sensitive($filter = null,$limit = null)
	{
		$sql = "select * from sys_sensitive_customer {$filter} order by Id desc {$limit}";
		$q = $this->getAll($sql);
		
		return $q;
	}
	
	//删除敏感客户
	public function delete_sensitive($ids)
	{
		$sql = sprintf("delete from sys_sensitive_customer where Id in (%s)",$ids);
		$this->execute($sql);
		
		return true;
	}
	
	//导入敏感客户资料
	public function import_sensitive()
	{
		$sql="insert ignore into sys_sensitive_customer (realname,maskname,mainphone) 
				select realname,realname,mainphone from allnamephone where 
					parentid = 1 and mainphone!='' and mainphone!='0'";
		$this->execute($sql);
	}
}
?>