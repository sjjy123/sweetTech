<?php
session_start();
header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n");
header("Content-Type: text/html; charset=uft-8");
define('INIT_XMALL',true);
define('INIT_ROOT','../');
include_once(INIT_ROOT."system_include/conn.php"); 
include_once(INIT_ROOT."system_include/check_purview.php");
include_once(INIT_ROOT."system_include/reader.php");
//include_once("D:/wamp/www/20160424_efang/mycms/system_include/phpexcel/PHPExcel.php");
//include_once("D:/wamp/www/20160424_efang/mycms/system_include/phpexcel/PHPExcel/Writer/Excel2007.php");
	//include('../editor/fckeditor.php');
/////////////////////////////////////////////////////////////////////////////

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body>
<?php
/**
 * @
 * @Description:
 * @Copyright (C) 2011 helloweba.com,All Rights Reserved.
 * -----------------------------------------------------------------------------
 * @author: Liurenfei (lrfbeyond@163.com)
 * @Create: 2012-5-1
 * @Modify:
*/

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
			$title = $xls->sheets[0]['cells'][$i][2];
			$mobile = $xls->sheets[0]['cells'][$i][3];
			$source = $xls->sheets[0]['cells'][$i][4];
			$id = $xls->sheets[0]['cells'][$i][5];
			if(!empty($mobile)){
				$data_values .= "('$id','$source','$title','$mobile','$user_name','$date_time'),";
			}
		}
		$data_values = substr($data_values,0,-1); //去掉最后一个逗号

		$query = mysql_query("insert into ".$tablepre."mhouses_bm (sequence,source,title,mobile,user_name,datetime) values $data_values");//批量插入数据表中
	  if($query){
		    echo '导入成功！';
	  }else{
		    echo '导入失败！';
	  }
	}
} elseif ($action=='exportconsult') { //导出咨询XLS
//			$objPHPExcel = new PHPExcel();
//   		$objPHPExcel->getProperties()->setCreator("JHM")
//            ->setLastModifiedBy("JHM")
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Office 2007 XLSX.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("JHM system export file");
//      $objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('A1', '序号')
//            ->setCellValue('B1', '楼盘')
//            ->setCellValue('C1', '电话号码')
//            ->setCellValue('D1', '咨询时间');
//            
//      $filename = date('Ymd').'zixun.xls';   
//      // 内容
//      $result = mysql_query("select * from ".$tablepre."mhconsult");
//      while($row=mysql_fetch_array($result)){
//      	$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($k + 1), $row['id']);
//			 	$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($k + 1), $row['title']);
//			 	$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($k + 1), $row['mobile']);
//			 	$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($k + 1), $row['datetime']);
//      }
//	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
//	    $objPHPExcel->setActiveSheetIndex(0);
//	    // 输出
//	    header('Content-Type: application/vnd.ms-excel');
//	    header('Content-Disposition: attachment;filename="' . $filename . '"');
//	    header('Cache-Control: max-age=0');
//
//	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//	    $objWriter->save('php://output');   
            
//    $result = mysql_query("select * from ".$tablepre."mhconsult");
//    $str = "序号\t楼盘\t电话号码\t咨询时间\t\n";
//    $str = iconv('utf-8','gb2312',$str);
//    
//    while($row=mysql_fetch_array($result)){
//        $title = iconv('gb2312','utf-8',$row['title']);
//    		$str .= $row['id']."\t".$row['mobile']."\t".$row['datetime']."\t\n";
//    }
//    $filename = date('Ymd').'zixun.xls';
//    exportExcel($filename,$str);
} elseif ($action=='exporthuodong') { //导出活动XLS
    $result = mysql_query("select * from student");
    $str = "姓名\t性别\t年龄\t\n";
    $str = iconv('utf-8','gb2312',$str);
    while($row=mysql_fetch_array($result)){
        $name = iconv('utf-8','gb2312',$row['name']);
        $sex = iconv('utf-8','gb2312',$row['sex']);
    	$str .= $name."\t".$sex."\t".$row['age']."\t\n";
    }
    $filename = date('Ymd').'.xls';
    exportExcel($filename,$str);
}


function exportExcel($filename,$content){
 	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/vnd.ms-execl");
	header("Content-Type: application/force-download");
	header("Content-Type: application/download");
  header("Content-Disposition: attachment; filename=".$filename);
  header("Content-Transfer-Encoding: binary");
  header("Pragma: no-cache");
  header("Expires: 0");


echo "111\t2222\t";
  //echo $content;
}
?>
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="2">导入导出</th>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet1">导入客户</u>：</td>
	<td class="tablerow1">
		<form id="addform" action="?action=import" method="post" enctype="multipart/form-data">
			<input type="file" name="file"> <input type="submit" class="btn" value="导入XLS">
    </form>
	</td>
</tr>
<form name="searchzx" method="post" action="/export2.php">
<tr>
	<td width="35%" align="right" class="tablerow2"><u title="MainDomain">导出咨询</u>：</td>
	<td width="65%" class="tablerow2">
		<input type="text" name="szx" value="" style="width:150px;" placeholder="请输入楼盘名称">&nbsp;
		<input type="submit" class="btn" id="exportCSV" value="导出XLS" >
	</td>
</tr>
</form>
<form name="searchzx" method="post" action="/export1.php">
<tr>
	<td class="tablerow1" align="right"><u title="MainSet1">导出看房活动</u>：</td>
	<td class="tablerow1">
		<input type="text" name="skf" value="" style="width:150px;" placeholder="请输入楼盘名称">&nbsp;
		<input type="submit" class="btn" id="exportCSV2" value="导出XLS">
	</td>
</tr>
</form>
</table>
</body>
</html>