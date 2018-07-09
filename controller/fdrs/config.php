<?php
class Config_Controller_Fdrs extends Base_Controller_Fdrs
{
	protected function assign_config_types($return_values = true)
	{
		$types = Config_Modeller::config_types($return_values);
		$types = json_encode($types);
		$this->assign('config_types',$types);
	}

	public function index()
	{
		$this->assign_config_types();
		$this->display('config/index.html');
	}

	public function get_config()
	{
		$type_id = $_POST['type_id'];
		$types = Config_Modeller::config_types();
		if(!in_array($type_id,array_keys($types))){
			$this->json('参数错误',0);
		}

		$o = Config_Modeller::getInstance();
		$array = $o->get_config($type_id);
		if(is_array($array)){
			// $array['detail'] = strip_tags($array['detail']);
			$photos = json_decode($array['photos'],true);
			$array['photos'] = $photos;
		}
		Util::Log($array);
		$this->json('OK',1,$array);
	}

	public function save_config()
	{
		$data = json_decode(stripslashes($_POST['data']),true);

		$type_id = $data['type_id'];
		$types = Config_Modeller::config_types();
		if(!in_array($type_id,array_keys($types))){
			$this->json('参数错误 -> 内容类型不合法',0);
		}

		// 详细内容
		$detail = System::removebadstring($data['detail'],false);

		//图片
		$photos = null;
		$ary_photos = $data['photos'];
		if(is_array($ary_photos) && count($ary_photos) > 0){
			foreach ($ary_photos as $row) {
				if(file_exists(ROOT . $row['srv_data']['b_path'])){
					$photos[] = array(
									's_path' => $row['srv_data']['s_path'],
									'b_path' => $row['srv_data']['b_path'],
								);
				}
			}
		}

		$args['type_id'] = $type_id;
		$args['detail'] = $detail;
		$args['photos'] = json_encode($photos);

		$o = Config_Modeller::getInstance();
		if($o->save_config($args)){
			$this->json('保存成功');
		}else{
			$this->json(System::toString($o->MSG,'<br/>'),0);
		}
	}

	//来自新闻活动的文件上传
	public function upload_photo()
	{
		$this->upload_photo_common('photo');
	}
}
?>