<?php

class ExeclController extends \BaseController 
{

	/**
	 * 设置内存大小以及运行时间
	 *
	 * @return Response
	 */
	public function __construct() 
	{
		set_time_limit(0);
		ini_set('memory_limit', '512M');
	}

	/**
	 * 读取Execl数据
	 *
	 * @param string $filename 文件名称
	 * @param int $start 起始行数
	 * @return Response
	 */
	public function reader($filename, $start = 2)
	{
		$filename = 'test.xlsx';
		$filename = sprintf('datas/%s', $filename);
		$filename = public_path($filename);
		
		if ( !is_file($filename) ) {
			return false;
		}

		$PHPReader = new PHPExcel_Reader_Excel2007();
		if ( !$PHPReader->canRead($filename) ) {
			$PHPReader = new PHPExcel_Reader_Excel5();
			if ( !$PHPReader->canRead($filename) ) {
				exit('no Execl!');
			}
		}

		# 读取工作表
		$objPHPExecl = $PHPReader->load($filename);
		$objSheet = $objPHPExecl->getSheet(0);

		$allCol = $objSheet->getHighestColumn();
		$allRow = $objSheet->getHighestRow();

		$aValue = array();
		for ($row = $start; $row <= $allRow; $row++) 
		{ 
			for ($col = 'A'; $col < $allCol; $col++) 
			{ 
				$addr = $col . $row; 
				$sValue = $objSheet->getCell($addr)->getValue();

				if ( !empty($sValue) ) 
				{
					# 中文状态不能输出， 使用转码 iconv
					$sValue = iconv( 'utf-8', 'gb2312', $sValue);

					# 富文本转换字符串
					if ( $sValue instanceof PHPExcel_RichText ) {
						$sValue = $sValue->__toString();
					}
				}
				$aValue[$row][$col] = $sValue;
			}
		}
		return $aValue;
	}


	/**
	 * 写入Execl数据
	 *
	 * @throws 开启debug模式会导致生成的Exel文件乱码
	 * @return Response
	 */
	public function writer()
	{
		$aValue = array(
			array('col1' => 'a', 'col2'=>'b', 'col3' => 'c'),
			array('col1' => 'a', 'col2'=>'b', 'col3' => 'c'),
		);


		$objPHPExecl = new PHPExcel();
		$objPHPExecl->getProperties()->setTitle('export')->setDescription('none');
		$objPHPExecl->setActiveSheetIndex(0);

		$row = 1;
		foreach ($aValue as $key => $value) 
		{
			$col = 0;
			foreach ($value as $kk => $vv) 
			{
				$objPHPExecl->getActiveSheet()->setCellValueExplicitByColumnAndRow($col, $row, $vv);
				$col = $col + 1;
			}
			$row = $row + 1;
		}

		/* 解决长数字改成科学计数法问题 */
		//$objActSheet->setCellValueExplicit('A5','8757584',PHPExcel_Cell_DataType::TYPE_STRING);
		
		$objPHPExecl->setActiveSheetIndex(0);
		$this->download($objPHPExecl);
	}


	/**
	 * 下载生成的Execl数据
	 *
	 * @param object $object PHPExecl 对象
	 * @param string $filename 下载文件名称
	 * @param string $execl Execl版本
	 * @return Response
	 */
	public function download($object, $filename = '', $execl = 'Excel2007')
	{
		# 文件名称
		if ( empty($filename) ) {
			$filename = sprintf('document%d.xls', time());
		}

		$objWrite = PHPExcel_IOFactory::createWriter($object, $execl);
		// Sending headers to force the user to download the file
		header('Content-Type: application/vnd.ms-execl');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWrite->save('php://output');
	}


}
