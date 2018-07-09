<?php
abstract class Data_Controller_Www extends Base_Controller_Www
{
	protected function query_top_cms($o,$types,$type_id,$limit = 10,$fields = null)
	{
		$ary_filter = null;
		if(!is_array($type_id)){
			$type_ids = $o->return_my_types($type_id);
		}else{
			$type_ids = join(',',$type_id);
		}

		$ary_filter[] = " type_id in({$type_ids}) ";
		$ary_filter[] = " isdeleted = 0 and enabled = 1 ";
		$strfilter = ' where ' . join(' and ',$ary_filter);
		$q = $o->query_cms($strfilter,'limit 0,' . $limit,$fields);
		$rows = null;
		if($q != null)
		{
			foreach($q as $array)
			{
				$array['publishtime'] = date('Y-m-d',strtotime($array['publishtime']));
				$typename = $types[$array['type_id']]['text'];
				$array['typename'] = System::returnText($typename,'未分类');

				// 照片
				$photos = json_decode($array['photos'],true);
				$array['photos'] = $photos;

				$detail = System::substrcn($array['detail'],140);
				$array['detail'] = $detail;

				$rows[] = $array;
			}	
			// Util::Log($rows);
		}

		return $rows;
	}

	// 获取静态内容
	protected function get_config($type_id,$o = null)
	{
		if(!$o){ $o = Config_Modeller::getInstance(); }
		$array = $o->get_config($type_id);
		return $array;
	}

	// 加载切换图
	protected function assign_photos($type_id,$key = 'photos')
	{
		$o = Photo_Modeller::getInstance();
		$strfilter = "where type_id = '{$type_id}' and isdeleted = 0 and enabled = 1";
		$photos = $o->get_photos($strfilter,'limit 0,15');
		// Util::Log($photos);
		if(!$photos){
			switch ($type_id) {
				case '1-1':
					break;
			}
		}
		$this->assign($key,$photos);
	}
}
?>