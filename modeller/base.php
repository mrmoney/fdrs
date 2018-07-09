<?php
abstract class Base_Modeller extends System
{
	protected  $table;
	protected	$key;

	public function __construct()
	{
		if(!$this->Conn()){
			die('DBERROR');
		}
	}

	/**
	 * 得到一条记录
	 */
	public function getRow($sql,$is_need_num_key = false)
	{
		$row = null;
		$q = $this->query($sql,$is_need_num_key);
		if($q){ $row = $q[0]; } 
		return $row;
	}

	/**
	 * 得到多条记录
	 */
	public function getAll($sql,$is_need_num_key = false)
	{
		return $this->query($sql,$is_need_num_key);
	}

	/**
	 * 根据KEY更新多条记录
	 * @param array $data array(key=>value,...)
	 * @param array $ids array(1,2,...)
	 * @return boolean
	 */
	public function update($data, $ids,$firstkey = '',$tbname = '')
	{
		if($firstkey != ''){
			$this->key = $firstkey;
		}

		if($tbname != ''){
			$this->table = $tbname;
		}

		$fields = array ();
		foreach ($data as $key => $value){
			if($this->key == $key && $this->key != ''){ continue; }
			$fields[] = "`{$key}`='{$value}'";
		}

		$ids = is_array($ids)?Util::toString($ids,',','\'','\''):"'{$ids}'";
		$sql = "update `{$this->table}` set " . implode(',', $fields);
		if($ids != ''){ $sql .= " where `{$this->key}` in ({$ids})"; }
		//Util::Log($sql);

		return $this->execute($sql);
	}

	/**
	 * 根据条件参数更新多条记录
	 * @param array $data array(key=>value,...)
	 * @param array $params array(key=>value,...)
	 * return boolean
	 */
	public function updateByParams($data,$params,$tbname = '')
	{
		if(empty($data) || empty($params)) {
			$this->MSG[] = '未指定修改内容';
			return false;
		}

		if($tbname != ''){ $this->table = $tbname; }

		$fields = array();
		foreach($data as $key => $value){
			if(stristr($key,'time') && $value == ''){ continue; }
			$fields[] = "`{$key}`='{$value}'";
		}

		$values = array();
		foreach($params as $k => $v) {
			if(is_array($v)) {
				$values[] = "`{$k}` in ('".implode("','",$v)."')";
			} else {
				$values[] = "`{$k}`='{$v}'";
			}
		}

		$sql = "update `{$this->table}` set " . implode(',',$fields) . 
					" where " . implode(' and ',$values);

		if($this->execute($sql)) {
			return true;
		} else {
			Util::Log(array($this->DBERROR(),$sql));
			return false;
		}
	}

	/**
	 * 根据条件参数删除多条记录
	 * @param array $params array(key=>value,...)
	 * return boolean
	 */
	public function delete($params,$tbname = '')
	{
		if(empty($params)) {
			$this->MSG[] = '未指定删除条件';
			return false;
		}

		if($tbname != ''){ $this->table = $tbname; }

		$values = array();
		foreach($params as $k => $v) {
			if(is_array($v)) {
				$values[] = "`{$k}` in ('".implode("','",$v)."')";
			} else {
				$values[] = "`{$k}`='{$v}'";
			}
		}

		$sql = "delete from `{$this->table}` " .
					" where " . implode(' and ',$values);
		//Util::Log($sql);

		if($this->execute($sql)) {
			return true;
		} else {
			Util::Log(array($this->DBERROR(),$sql));
			return false;
		}
	}

	/**
	 * 添加一条记录
	 * @param array $data array('key'=>'value',...) 键值对
	 * @return int id
	 * 
	 */
	public function add($data,$tbname = '')
	{
		if($tbname != ''){ $this->table = $tbname; }

		$fieldsKey = array ();
		$fieldsValue = array ();
		foreach ($data as $key => $value)
		{
			$fieldsKey[] = "`{$key}`";
			$fieldsValue[] = "'{$value}'";
		}

		$sql = "insert into `{$this->table}` (" . implode(',', $fieldsKey) . 
					") values(" . implode(',', $fieldsValue) . ")";
		$r = $this->execute($sql)?$this->lastid():0;
		//Util::Log(array($sql,$r));

		return $r;
	}

	/**
	 * 根据条件记录数
	 * @param string $condition "where xxx=xxx"
	 * @return int
	 */
	public function getTotal($condition = '',$tbname = '')
	{
		if($tbname == ''){ $tbname = $this->table; }
		if(stristr($condition,'ordernumnow')){
			$force_index = ' force index(ordernumnow) ';
		}elseif(stristr($condition,'orderdate')){
			$force_index = ' force index(orderdate) ';
		}else{
			$force_index = stristr($condition,'shopname')?' force index(shopname) ':'';
		}
		$sql = "select count(*) as total from `{$tbname}` {$force_index} {$condition}";
		$q = $this->query($sql,false);
		//Util::Log(array($q,$sql));
		$total = $q != null?$q[0]['total']:0;
		return $total;
	}

	/**
	 * 根据过滤条件查询对象
	 * @param array $params 过滤条件
	 */
	public function queryFields($fields,$params,$tbname = '',
									$orderby = '',$limit = '')
	{
		if($tbname == ''){ $tbname = $this->table; }
		$where = array();
		foreach($params as $key => $value){
			$where[] = "`{$key}`='{$value}'";
		}

		$where = 'where ' . implode(' and ',$where);
		$sql = "select {$fields} from `{$tbname}` {$where} {$orderby} {$limit}";
		$r = $this->getRow($sql);
		// Util::Log($sql);
		
		return $r;
	}

	//清除不需要的字段
	protected function clear_columns($args,$table_name)
	{
		if(!is_array($args)){ return $args; }
		$ary_columns = $this->query_columns($table_name);
		if(is_array($ary_columns))
		{
			foreach($args as $column_name => $column_value)
			{
				if(!in_array($column_name,$ary_columns))
				{
					unset($args[$column_name]);
				}
			}
		}

		return $args;
	}
}
?>
