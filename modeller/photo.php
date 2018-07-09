<?php
class Photo_Modeller extends Base_Modeller
{
	public $table = 'fdrs_photo';
	public $key = 'id';

	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}

	//存储
	public function save($args)
	{
		$id = (int)$args['id'];
		if($id <= 0){
			if($this->add($args)){
				return true;
			}else{
				$this->MSG[] = '存储失败';
				return false;
			}
		}else{
			// 找出之前的照片
			$q_pre_photos = null;
			if($args['s_path'] != ''){
				$q_pre_photos = $this->queryFields('s_path,b_path',array('id' => $id),$this->table);
			}
			unset($args['id']);
			if($this->updateByParams($args,array('id' => $id))){
				if($q_pre_photos != null){
					System::deletefile($q_pre_photos['s_path']);
					System::deletefile($q_pre_photos['b_path']);
				}
				return true;
			}
			else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}
	}

	public function get_photos($filter,$limit = null,$fields = null)
	{
		$ary_fields[] = 'id,type_id,title,s_path,b_path,enabled,content_id,subject_id';
		if($fields != null){
			//唯独不读取详情字段
			$ary_fields[] = $fields;
		}

		$fields = join(',',$ary_fields);

		$sql = sprintf("select %s from %s %s order by id desc %s",
						$fields,$this->table,$filter,$limit);
		$q = $this->query($sql,false);// Util::Log($sql);

		return $q;
	}

	public function get_photo($params,$fields = '*')
	{
		$array = $this->queryFields($fields,$params,$this->table);
		return $array;
	}

	//上下线
	public function update_enabled($ids,$enabled)
	{
		$sql = sprintf('UPDATE %s set enabled=%d where id in (%s)',
						$this->table,$enabled,$ids);
		$this->execute($sql);
	}

	//删除
	public function delete($ids)
	{
		if($ids == ''){
			$this->MSG[] = '未指定要删除的对象';
			return false;
		}

		$sql = "UPDATE {$this->table} set isdeleted = '1' where id in ({$ids})";
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '删除失败[' . $this->DBERROR() . ']';
			return false;
		}
	}
}
?>