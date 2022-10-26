<?php
session_start();
// Include Configuration File
if (file_exists("../configuration.php")) {
  require_once("../configuration.php");
} else {
  echo "Missing Configuration File";
  exit();
}
// Include Language File
if (file_exists("../languages/lang." . $ariaConfig_language . ".php")) {
  require_once("../languages/lang." . $ariaConfig_language . ".php");
} else {
  echo "Missing Language File";
  exit();
}
// Include Params File
if (file_exists("../params/params." . $ariaConfig_language . ".php")) {
  require_once("../params/params." . $ariaConfig_language . ".php");
} else {
  echo "Missing Params File";
  exit();
}
// Include Database Controller
if (file_exists("../include/database.php")) {
  require_once("../include/database.php");
} else {
  echo "Missing Database File";
  exit();
}
// Include System File
if (file_exists("../include/ariacms.php")) {
  require_once("../include/ariacms.php");
} else {
  echo "Missing System File";
  exit();
}
// Set file sendmail
if (file_exists("../plugins/phpmailer/class.phpmailer.php")) {
  require_once("../plugins/phpmailer/class.phpmailer.php");
} else {
  echo "Missing Mailer File";
  exit();
}
/* Setup Global variables */
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();
$params = new params();
//$catid =  @$_REQUEST['catid'];
//$row =  @$_REQUEST['row'];
//$allcount =  @$_REQUEST['allcount'];

if(isset($_SESSION['member']) and $_SESSION['member']['id'] > 0){

	date_default_timezone_set('Asia/Ho_Chi_Minh');
/** Lấy dữ liệu từ form  */
	$content =  @$_REQUEST['content'];
	$date_cmt = time();
	$post_id = @$_REQUEST['postid'];
	
	$row = new stdClass;
	$row->id = null;
	$row->post_id = $post_id;
	$row->member_id = $_SESSION['member']['id'];
	$row->content = $content;
	$row->user_cmt = $_SESSION['member']['fullname'];
	$row->mail_user = $_SESSION['member']['email'];
	$row->date_cmt = $date_cmt;
	$row->state = 1;
	
	// add in database
	if($database->insertObject("e4_post_comment", $row, "id")){
		echo 1;
	}else{
		echo 0;
	}
	
}else{
	echo 0;
}
?> 	