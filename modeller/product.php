<?php
class Product_Modeller extends Base_Modeller
{
	public $table = 'ussv_product';
	public $key = 'id';

	static $instance;

	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}

	//存储
	public function save_product($args)
	{
		$id = (int)$args['id'];
		if($id <= 0){
			if($this->add($args)){
				return true;
			}else{
				$this->MSG[] = '存储失败';
				$this->MSG[] = $this->DBERROR();
				return false;
			}
		}else{
			unset($args['id']);
			if($this->updateByParams($args,array('id' => $id))){
				return true;
			}
			else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}
	}

	public function query_product($filter,$limit,$fields = null)
	{
		if($fields == null){
			//唯独不读取详情字段
			$fields = 'id,type_id,name,order_id,price1,price2,
						photos,enabled,publisher,publishtime';
		}

		$sql = sprintf("select %s from ussv_product %s
						order by order_id desc %s",
						$fields,$filter,$limit);
		$q = $this->query($sql);//Util::Log($q);

		return $q;
	}

	public function get_product($id,$fields = '*')
	{
		$array = null;
		$sql = sprintf("select %s from ussv_product where id = %d",
								$fields,$id);
		$q = $this->getAll($sql);
		if($q){ $array = $q[0]; }

		return $array;
	}

	//查询我名下都有哪些分类
	public function return_my_types($pId)
	{
		$types = Config_Modeller::product_types();
		$types = array_values($types);
		$types[] = $pId;
		foreach ($types as $array) {
			if($pId == (int)$array['pid']){
				$types[] = $array['pid'];
			}
		}
		$pids = join(',',$types);
		
		return $pids;
	}

	//上下线
	public function update_enabled($ids,$enabled)
	{
		$sql = sprintf('UPDATE %s set enabled=%d where id in (%s)',
						$this->table,$enabled,$ids);
		$this->execute($sql);
	}

	//更换所在分类
	public function update_typeid($ids,$type_id)
	{
		$sql = sprintf('UPDATE %s set type_id=%d where id in (%s)',
						$this->table,$type_id,$ids);
		$this->execute($sql);
	}

	//删除
	public function delete_product($ids)
	{
		if($ids == ''){
			$this->MSG[] = '未指定要删除的内容';
			return false;
		}

		$sql = sprintf('UPDATE %s set isdeleted = 1 where id in (%s)',
						$this->table,$ids);
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '删除失败[' . $this->DBERROR() . ']';
			return false;
		}
	}
}
?>