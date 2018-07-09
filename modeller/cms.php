<?php
class Cms_Modeller extends Base_Modeller
{
	public $table = 'fdrs_cms_content';
	public $key = 'id';

	static $instance;

	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}

	//存储cms内容
	public function save_content($args)
	{
		$id = (int)$args['id'];
		if($id <= 0){
			if($this->add($args)){
				$this->update_ownernum();
				return true;
			}else{
				//Util::Log($this->DBERROR());
				$this->MSG[] = '存储失败';
				return false;
			}
		}else{
			unset($args['id']);
			if($this->updateByParams($args,array('id' => $id))){
				$this->update_ownernum();
				return true;
			}
			else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}
	}

	public function save_type($args)
	{
		//名称不能重复
		$id = (int)$args['id'];
		if($id <= 0){
			if($this->add($args,'fdrs_cms_type')){
				return true;
			}else{
				Util::Log($this->DBERROR());
				$this->MSG[] = '存储失败';
				return false;
			}
		}else{
			unset($args['id']);
			if($this->updateByParams($args,array('id' => $id),'fdrs_cms_type')){
				return true;
			}
			else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}
	}

	//根据分类更新其名下拥有几条cms内容
	private function update_ownernum()
	{
		return;//不使用分类表
		$sql = "UPDATE fdrs_cms_type a set a.ownernum = (select count(*)
						from fdrs_cms_content b where b.type_id = a.id);";
		$this->execute($sql);
	}

	//删除分类
	public function delete_type($ids)
	{
		if($ids == ''){
			$this->MSG[] = '未指定要删除的分类';
			return false;
		}

		$sql = "UPDATE fdrs_cms_type set isdeleted = '1' where id in ({$ids})";
		if($this->execute($sql)){
			return true;
		}else{
			$this->MSG[] = '删除失败[' . $this->DBERROR() . ']';
			return false;
		}
	}

	public function query_cms($filter,$limit,$more_fields = null)
	{
		$fields[] = 'id,type_id,topic,sectopic,order_id,is_subject,
						photos,enabled,publisher,publishtime';
		if($more_fields != null){ $fields[] = $more_fields; }
		$str_fields = join(',',$fields);

		$sql = sprintf("select %s from fdrs_cms_content %s
						order by order_id desc %s",
						$str_fields,$filter,$limit);
		$q = $this->query($sql,false);// Util::Log($sql);

		return $q;
	}

	public function get_cms($id,$fields = '*')
	{
		$array = null;
		$sql = sprintf("select %s from fdrs_cms_content where id = %d",
								$fields,$id);
		$q = $this->getAll($sql);
		if($q){ $array = $q[0]; }

		return $array;
	}

	public function query_type($filter,$limit,$fields = '*')
	{
		$sql = sprintf("select %s from fdrs_cms_type %s
						order by order_id desc %s",
						$fields,$filter,$limit);
		$q = $this->getAll($sql);

		return $q;
	}

	//查询我名下都有哪些分类
	public function return_my_types($pId)
	{
		$cms_types = Config_Modeller::cms_types();
		$cms_types = array_values($cms_types);
		$types[] = $pId;
		foreach ($cms_types as $array) {
			if($pId == (int)$array['pid']){
				$types[] = $array['id'];
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

	//删除内容
	public function delete_content($ids)
	{
		if($ids == ''){
			$this->MSG[] = '未指定要删除的内容';
			return false;
		}

		$sql = "UPDATE {$this->table} set isdeleted = 1 where id in ({$ids})";
		if($this->execute($sql)){
			$this->update_ownernum();
			return true;
		}else{
			$this->MSG[] = '删除失败[' . $this->DBERROR() . ']';
			return false;
		}
	}

	// 删除某张照片
	public function delete_photo($id,$indexes = null)
	{
		$q = $this->get_cms($id,'photos');
		$str_photos = $q['photos'];
		if($str_photos != null){
			$photos = json_decode($str_photos,true);

			if($indexes != null){
				// 删除指定
				$photo = $photos[$indexes];
				if(is_array($photo)){
					System::deletefile($photo['s_path']);
					System::deletefile($photo['b_path']);
					unset($photos[$index]);
					$photos = array($photos);
					$str_photos = json_encode($photos);

					$args['id'] = $id;
					$args['photos'] = $str_photos;
					if(!$this->save_content($args)){
						return false;
					}
				}
			}else{
				// 删除所有
				if(is_array($photos)){
					foreach ($photos as $photo) {
						System::deletefile($photo['s_path']);
						System::deletefile($photo['b_path']);
					}

					$args['id'] = $id;
					$args['photos'] = '';
					if(!$this->save_content($args)){
						return false;
					}
				}
			}
			
		}

		return true;
	}
}
?>