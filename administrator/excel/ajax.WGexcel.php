<?php
session_start();

if (file_exists("../../configuration.php")) {
	require_once("../../configuration.php");
} else {
	echo "Missing Configuration File";
	exit();
}
//Include Database Controller
if (file_exists("../../include/database.php")) {
	require_once("../../include/database.php");
} else {
	echo "Missing Database File";
	exit();
}
//Include System File
if (file_exists("../../include/ariacms.php")) {
	require_once("../../include/ariacms.php");
} else {
	echo "Missing System File";
	exit();
}

$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();


$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$sql = "";

if($from != ''){
	$sttFrom = strtotime($from);
}else{
	$from = date("Y-m")."-01";
	$sttFrom = strtotime($from);
}

if($to != ''){
	$sttTo = strtotime($to. ' 23:59:59');
}else{
	$sttTo = strtotime(date("Y-m-d")." 23:59:59");
}

$sql = " WHERE a.date_created >= ".$sttFrom." and a.date_created <= ".$sttTo;
$order = ' order by a.id desc';
$query = "SELECT a.*, b.title_vi ,c.fullname 
	FROM e4_royalties a 
	LEFT JOIN e4_posts b ON b.id = a.post_id 
	LEFT JOIN e4_users c On c.id = a.user_id " .$sql . $order;
				
$database->setQuery($query);
$rows = $database->loadObjectList();
/**/
//echo count($rows);exit();
require_once '../phpexcel/Classes/PHPExcel.php';
define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
require_once "../phpexcel/Classes/PHPExcel/IOFactory.php";

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("../phpexcel/Template/dsnhuanbut.xls");

$title = "Danh sách nhuận bút từ ngày ".date("d/m/Y",strtotime($from))." đến ngày ".date("d/m/Y",strtotime($to));

$objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
$array_status = array(1=> 'Đã thanh toán', 0=>'Chờ thanh toán');
// bắt đầu ghi từ dòng 3
$baseRow = 4;
$stt = 1;
foreach ($rows as $r => $row) {
	$styleArray = array(
        'borders' => array(
            'left' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'right' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE,
            )
        )
    );
	// ghi dữ liệu vào file excel
    $roww = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($roww, 1);
	$objPHPExcel->getActiveSheet()
			->setCellValue('A' . $roww, $stt)
            ->setCellValue('B' . $roww, $row->title_vi)
            ->setCellValue('C' . $roww, $row->fullname)
            ->setCellValue('D' . $roww, $row->price)
            ->setCellValue('E' . $roww, $array_status[$row->status])
            ->setCellValue('F' . $roww, date("d-m-Y",$row->date_created))
            ->setCellValue('G' . $roww, $row->notice);
	$stt++;
	
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(date('YmdHi')."NhuanBut.xls");
echo date('YmdHi')."NhuanBut.xls";

?>