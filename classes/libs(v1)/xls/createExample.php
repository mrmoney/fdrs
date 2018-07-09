<?php
class Report extends Money
{
	static $instance;
	
	public static function getInstance()
	{
		self::$instance || self::$instance=new self();
		return self::$instance;
	}
	
	public function __get($property_name)
	{
		if(isset($this->$property_name))
			return $this->$property_name;
		else
			return NULL;
	}
	
	public function __set($property_name,$value)
	{
		if(array_key_exists($property_name,get_object_vars($this)))
			$this->$property_name=$value;
	}
	
	public function __construct()
	{
		parent::__construct();
	}
	
	//恒龙服饰公司及各定制店本年度和上一年度年零售衬衣对比统计(1-12月)
	public function ls_cs_income_contrast()
	{
		require_once ROOT . '/SysCLS/xls/PHPExcel.php';
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		//设置当前的sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		//设置sheet的name
		$objPHPExcel->getActiveSheet()->setTitle('hello');
		
		//设置单元格的值
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'string');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 2);
		$objPHPExcel->getActiveSheet()->setCellValue('A3', true);
		
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 5);
		$objPHPExcel->getActiveSheet()->setCellValue('C4', 5);
		$objPHPExcel->getActiveSheet()->setCellValue('C5', '=SUM(C2:C4)');
		
		$objPHPExcel->getActiveSheet()->setCellValue('B8', '=MIN(B2:C5)');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 20);
		//$objPHPExcel->getActiveSheet()->setCellValue('C5', 50);
		
		//合并单元格
		$objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
		
		//设置列宽
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		//设置行高
		$objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(40);
		
		//设置粗体
		$objPHPExcel->getActiveSheet()->getStyle('A1:C8')->getFont()->setBold(true);
		
		//设置单元格边框
		$styleThinBlackBorderOutline = array(
				   'borders' => array (
						 'outline' => array (
							   'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
							   'color' => array ('argb' => 'FF000000'),          //设置border颜色
						),
				  ),
			);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleThinBlackBorderOutline);
		$objStyleA1 = $objPHPExcel->getActiveSheet()->getStyle('A1'); 
		$objPHPExcel->getActiveSheet()->duplicateStyle($objStyleA1, 'A1:C8'); 

		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$filename=ROOT . '/attachement/reports/1.xls';
		$objWriter->save($filename);


		exit;
		
		
		
		// Add some data
		$year_now=date('Y');
		$year_last=$year_now-1;
		$A1='恒龙服饰公司及各定制店' . $year_now . '年、' . $year_last . '年衬衣收入对比统计(1-12月)';
	}
	
}
?>