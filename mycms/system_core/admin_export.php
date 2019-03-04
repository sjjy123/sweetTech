<?php
session_start();
header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n");
header("Content-Type: text/html; charset=uft-8");
define('INIT_XMALL',true);
define('INIT_ROOT','../');
include_once(INIT_ROOT."system_include/conn2.php"); 
//include_once(INIT_ROOT."system_include/check_purview.php");
include_once(INIT_ROOT."system_include/reader.php");
include_once(INIT_ROOT."system_include/phpexcel/PHPExcel.php");
include_once(INIT_ROOT."system_include/phpexcel/PHPExcel/Worksheet.php");
include_once(INIT_ROOT."system_include/phpexcel/PHPExcel/Writer/Excel2007.php");

$action = $_GET['action'];
if ($action == 'import') { //导入XLS
	$tmp = $_FILES['file']['tmp_name'];
	if (empty ($tmp)) {
		echo '请选择要导入的Excel文件！';
		exit;
	}
	
	$save_path = INIT_ROOT."xls/";
	$file_name = $save_path.date('Ymdhis') . ".xls";
	if (copy($tmp, $file_name)) {
		$xls = new Spreadsheet_Excel_Reader();
		$xls->setOutputEncoding('utf-8');
		$xls->read($file_name);
		$date_time 	= date("Y-m-d H:i:s",time());
		for ($i=2; $i<=$xls->sheets[0]['numRows']; $i++) {
			$user_name = $xls->sheets[0]['cells'][$i][1];
			$mobile = $xls->sheets[0]['cells'][$i][2];
			$source = $xls->sheets[0]['cells'][$i][3];
			$id = $xls->sheets[0]['cells'][$i][4];
			$data_values .= "('$id','$source','$mobile','$user_name','$date_time'),";
		}
		$data_values = substr($data_values,0,-1); //去掉最后一个逗号

		$query = mysql_query("insert into ".$tablepre."mhouses_bm (id,source,mobile,user_name,datetime) values $data_values");//批量插入数据表中
	  if($query){
		    echo '导入成功！';
	  }else{
		    echo '导入失败！';
	  }
	}
} elseif ($action=='exportconsult') { //导出咨询XLS
	$sname = $_POST['szx'];
	$sql = "select * from ".$tablepre."mhconsult order by houseid asc,datetime desc";
	if(!empty($sname)){
		$sql = "select * from ".$tablepre."mhconsult where title like '%".$sname."%' order by houseid asc,datetime desc";
	}
    $result = mysql_query($sql);
    $str = "";
    
    while($row=mysql_fetch_array($result)){
        $title = iconv('gb2312','utf-8',$row['title']);
    		$str .= $row['id']."\t".$row['title']."\t"."`".$row['mobile']."\t".$row['datetime']."\t\n";
    }
    $filename = date('Ymd').'zixun.xls';
    exportExcel($filename,$str);
} elseif ($action=='exporthuodong') { //导出活动XLS skf
		$sname = $_POST['skf'];

		$objPHPExcel = new PHPExcel();
//保存excel—2007格式
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//或者$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 非2007格式
$objWriter->save("xxx.xlsx");
//直接输出到浏览器
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
header("Pragma: public");
header("Expires: 0");
//header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type:application/vnd.ms-execl");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");;
header('Content-Disposition:attachment;filename="resume.xls"');
header("Content-Transfer-Encoding:binary");
$objWriter->save('php://output');

		// $objPHPExcel = new PHPExcel();
  //  		$objPHPExcel->getProperties()->setCreator("JHM")
  //           ->setLastModifiedBy("JHM")
  //           ->setTitle("Office 2007 XLSX Test Document")
  //           ->setSubject("Office 2007 XLSX Test Document")
  //           ->setDescription("Office 2007 XLSX.")
  //           ->setKeywords("office 2007 openxml php")
  //           ->setCategory("JHM system export file");

  //       $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);

   //      $objPHPExcel->setActiveSheetIndex(0)
			// ->setCellValue('A1', '序号11')
   //          ->setCellValue('B1', '楼盘名称22')
   //          ->setCellValue('C1', '联系人')
   //          ->setCellValue('D1', '手机号码')
   //          ->setCellValue('E1', '时间');
//echo "hi,444555";
  //   	$sql ="select * from ".$tablepre."mhapply order by houseid asc,datetime desc";
  //   	if(!empty($sname)){
		// 	$sql = "select * from ".$tablepre."mhapply where title like '%".$sname."%' order by houseid asc,datetime desc";
		// }
  //   	$result = mysql_query($sql);
  //   	$k=1;
  //   	while($row=mysql_fetch_array($result)){
  //   		$title = iconv('utf-8','gb2312',$row['title']);
  //       	$contact = iconv('utf-8','gb2312',$row['contact']);

  //       	$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($k + 1), $row['id']);
		// 	$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($k + 7), $title);
		// 	$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($k + 1), $contact);
		// 	$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($k + 1), $row['mobile']);
		// 	$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($k + 1), $row['datetime']);

		// 	$objPHPExcel->getActiveSheet()->getRowDimension($k + 7)->setRowHeight(16);
		// 	$k++;
  //       	//$str .= $row['id']."\t".$title."\t".$contact."\t"."`".$row['mobile']."\t".$row['datetime']."\t\n";
  //   	}

    	// $objPHPExcel->setActiveSheetIndex(0);
	    // // 输出
	    // header('Content-Type: application/vnd.ms-excel');
	    // header('Content-Disposition: attachment;filename="' . date('Ymd') . 'hd.xls"');
	    // header('Cache-Control: max-age=0');

	    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    // $objWriter->save('php://output');

	    // 内容
	   //  foreach($detalis_list as $k=>$v){
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($k + 7), $k+1);
			 // $objPHPExcel->getActiveSheet(0)->setCellValueExplicit('B' . ($k + 7), $v['batch_ask_code'],PHPExcel_Cell_DataType::TYPE_STRING);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($k + 7), $v['goods_storage_name']);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($k + 7), $v['spec_name']);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($k + 7), $v['goods_unit']);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($k + 7), $v['real_num']);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($k + 7), $v['remark']);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($k + 7), $v['wh_name']);
			 // $objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($k + 7), $v['wh_loc_name']);

			 // $objPHPExcel->getActiveSheet()->getRowDimension($k + 7)->setRowHeight(16);
	   //  }
	    // Rename sheet
	    //$objPHPExcel->getActiveSheet()->setTitle('盘点明细');

	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
	    // $objPHPExcel->setActiveSheetIndex(0);
	    // // 输出
	    // header('Content-Type: application/vnd.ms-excel');
	    // header('Content-Disposition: attachment;filename="' . $billcode . '.xls"');
	    // header('Cache-Control: max-age=0');

	    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    // $objWriter->save('php://output');

	// $sname = $_POST['skf'];
 //    $sql ="select * from ".$tablepre."mhapply order by houseid asc,datetime desc";
 //    if(!empty($sname)){
	// 	$sql = "select * from ".$tablepre."mhapply where title like '%".$sname."%' order by houseid asc,datetime desc";
	// }
 //    $str = "aa\t"."bb\t"."\n";
 //    $result = mysql_query($sql);
 //    while($row=mysql_fetch_array($result)){
 //    	$title = iconv('utf-8','gb2312',$row['title']);
 //        $contact = iconv('utf-8','gb2312',$row['contact']);
 //        $str .= $row['id']."\t".$title."\t".$contact."\t"."`".$row['mobile']."\t".$row['datetime']."\t\n";
 //    }
 //    $filename = date('Ymd').'huodong.xls';
 //    exportExcel($filename,$str);
}


/**
 * 	导出模板
*/
function common_export($filename='',$title_s=array(),$data_s=array(),$width_s=array()){

		$this->load->library('ifile_lib');
		$filedir=FCPATH.'uploadfile/export/create/'.date('Ym');
		$filepath=FCPATH.'uploadfile/export/create/'.date('Ym').'/'.$filename.'.xls';

		if($this->ifile_lib->is_file_exists($filepath)){//表明文件已经存在，读取
			$objReader = PHPExcel_IOFactory::createReader ( 'Excel5' );
			$objPHPExcel = $objReader->load ($filepath);
			$objActSheet = $objPHPExcel->getActiveSheet(0);
			$allRow = $objPHPExcel->getActiveSheet(0)->getHighestRow();

		}else{//不存在，新建
			$this->ifile_lib->mkdir($filedir);
			$objPHPExcel = new PHPExcel();
	   		$objPHPExcel->getProperties()->setCreator("JHM")->setLastModifiedBy("JHM")
	            ->setTitle("Office 2003 XLS Document")->setSubject("Office 2003 XLS Document")->setDescription("Office 2003 XLS.")
	            ->setKeywords("office 2003 openxml php")->setCategory("JHM system export file");

	      	$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	   	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '序号');
	   	  	if(!empty($title_s) && is_array($title_s)){
	   	  		foreach($title_s as $k=>$v){//从B开始
					$objPHPExcel->getActiveSheet(0)->setCellValue($k . '1', $v);
					if(isset($width_s[$k])){
						$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth($width_s[$k]);
					}else{
						$objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(12);
					}
				}
	   	  	}
	   	  	$objPHPExcel->getActiveSheet()->setTitle('Sheet数据表');
			$allRow = 1;
		}

		if(!empty($data_s) && is_array($data_s)){
			foreach($data_s as $k=>$v){//
				$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($allRow+$k + 1), $allRow+$k);
				foreach($v as $sk=>$sv){//从B开始
					$objPHPExcel->getActiveSheet(0)->setCellValue($sk . ($allRow+$k + 1), $v[$sk]);
				}
		    }
		}

	    $objPHPExcel->setActiveSheetIndex(0);
	    $filename=empty($filename)?date('YmdHis',time()):$filename;

	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($filepath);
}


/**
 * 组装表头，默认最大26列，可扩展
 */
function common_export_title($title_s=array()){
		$title_key=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$res=array();
		foreach($title_s as $k=>$v){
			$key=$title_key[$k];
			$res[$key]=$v;
		}
		return $res;
}


function exportExcel($filename,$content){
 	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/vnd.ms-execl;charset=utf-8");
	header("Content-Type: application/force-download");
	header("Content-Type: application/download");
  header("Content-Disposition: attachment; filename=".$filename);
  header("Content-Transfer-Encoding: binary");
  header("Pragma: no-cache");
  header("Expires: 0");


//echo "111\t2222\t";
  echo $content;
}
?>