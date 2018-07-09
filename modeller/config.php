<?php
class Config_Modeller extends Base_Modeller {

	public $table = 'fdrs_config';
	public $key = 'id';

	static $instance;

	public static function getInstance()
	{
		self::$instance || self::$instance = new self();
		return self::$instance;
	}
	
	//常用弱口令
	public static $bad_pwds = array(
									'000000','111111','11111111','112233','123123','123321',
									'123456','12345678','654321','666666','888888',
									'abcdef','abcabc','abc123','a1b2c3','aaa111','123qwe',
									'qwerty','qweasd','admin','password','p@ssword','passwd',
									'iloveyou','5201314'
								);

	//内容分类
	public static function cms_types($show_all_item = false,
										$return_values = false,
										$exclude_ids = array(1))
	{
		//指定键值的目的是方便获取某id下的分类名称
		if($show_all_item){
			$types[0] = array( 'text' => '所有内容');	
		}

		// 研究课题作为单独一个栏目进行管理，旗下有自定义的课题
		$types[1] = array( 'text' => '研究课题');	
		$types[2] = array( 'text' => '金融聚焦');	

		$types[3] = array( 'text' => '研究会动态');	
		$types[4] = array( 'text' => '会员动态');	

		$types[5] = array( 'text' => '政策法规');	
		$types[6] = array( 'text' => '活动公告');	
		$types[7] = array( 'text' => '其他内容');	
		
		$new_types = null;
		foreach ($types as $key => $array) {
			if(in_array($key,$exclude_ids)){ continue; }
			$array['id'] = $key;
			$tag = System::getfirstchars($array['text']);
			$array['tag'] = $tag;
			$new_types[$key] = $array;
		}

		if($return_values){ $new_types = array_values($new_types); }

		return $new_types;
	} 

	// 获取常规分类
	public static function cms_common_ids()
	{
		$types = self::cms_types();
		$ids = array_keys($types);
		$str_ids = join(',',$ids);
		return $str_ids;
	}

	//静态内容分类
	public static function config_types($return_values = false)
	{
		$types['1-1'] = array( 'text' => '关于我们','expanded' => true);	
		$types['1-2'] = array( 'text' => '研究会简介','pid' => '1-1');	
		$types['1-3'] = array( 'text' => '研究会章程','pid' => '1-1');	

		$types['2-1'] = array( 'text' => '研究会成员','expanded' => true);	
		$types['2-2'] = array( 'text' => '组织架构','pid' => '2-1');	
		$types['2-3'] = array( 'text' => '学术委员会','pid' => '2-1');	
		$types['2-4'] = array( 'text' => '专家委员会','pid' => '2-1');	
		$types['2-5'] = array( 'text' => '(副)会长/秘书长','pid' => '2-1');	
		$types['2-6'] = array( 'text' => '监事会','pid' => '2-1');	
		$types['2-7'] = array( 'text' => '理事会','pid' => '2-1');	

		$new_types = null;
		foreach ($types as $key => $array) {
			if(in_array($key,$exclude_ids)){ continue; }
			$array['id'] = $key;
			$tag = System::getfirstchars($array['text']);
			$array['tag'] = $tag;
			$new_types[$key] = $array;
		}

		if($return_values){ $new_types = array_values($new_types); }

		return $new_types;
	} 

	// 图片分类
	public static function photo_types($show_all_item = false,
										$return_values = false)
	{
		if($show_all_item){
			$types[0] = array( 'text' => '所有照片');	
		}
		$types['1-1'] = array( 'text' => '首页切换图','w' => 775,'h' => 370);	


		foreach ($types as $key => $array) {
			$array['id'] = $key;
			$tag = System::getfirstchars($array['text']);
			$array['tag'] = $tag;

			$text_more = $array['text'];
			if((int)$array['w'] > 0){
				$text_more = $text_more . '(' . $array['w'] . ' * ' . 
								$array['h'] . ')';
			}
			$array['text_more'] = $text_more;

			$types[$key] = $array;
		}

		if($return_values){ $types = array_values($types); }

		return $types;
	} 

	// 会员类型
	public static function member_types($show_all_item = false,
										$return_values = false)
	{
		if($show_all_item){
			$types[-1] = array( 'text' => '所有会员');	
		}

		$types[0] = array( 'text' => '普通会员');	

		$new_types = null;
		foreach ($types as $key => $array) {
			if(in_array($key,$exclude_ids)){ continue; }
			$array['id'] = $key;
			$tag = System::getfirstchars($array['text']);
			$array['tag'] = $tag;
			$new_types[$key] = $array;
		}

		if($return_values){ $new_types = array_values($new_types); }

		return $new_types;
	} 

	//后台管理账户状态
	public static function sysuser_status($return_values = false)
	{
		$types[1] = array( 'text' => '正常');	
		$types[0] = array( 'text' => '禁用');	
		$types[-1] = array( 'text' => '离职');	

		foreach ($types as $key => $array) {
			$array['id'] = $key;
			$types[$key] = $array;
		}

		if($return_values){ $types = array_values($types); }

		return $types;
	} 

	// 存储配置信息,包括静态内容
	public function save_config($args)
	{
		$type_id = $args['type_id'];
		$filter = "where type_id = '{$type_id}'";
		$is_exists = $this->checkExists($filter,$this->table);
		if(!$is_exists){
			if($this->add($args)){
				return true;
			}else{
				// Util::Log($this->DBERROR());
				$this->MSG[] = '存储失败';
				return false;
			}
		}else{
			unset($args['type_id']);
			if($this->updateByParams($args,array('type_id' => $type_id))){
				return true;
			}
			else{
				$this->MSG[] = '保存失败[' . $this->DBERROR() . ']';
				return false;
			}
		}
	}

	// 获取存储信息
	public function get_config($type_id)
	{
		$q = $this->queryFields('type_id,detail,photos',
								array('type_id' => $type_id));
		return $q;
	}
}
?>
