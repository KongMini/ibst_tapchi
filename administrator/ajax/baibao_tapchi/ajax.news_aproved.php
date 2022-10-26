<?php
session_start();
if (file_exists("../../../configuration.php")) {
	require_once("../../../configuration.php");
} else {
	echo "Missing Configuration File";
	exit();
}
//Include Database Controller
if (file_exists("../../../include/database.php")) {
	require_once("../../../include/database.php");
} else {
	echo "Missing Database File";
	exit();
}
//Include System File
if (file_exists("../../../include/ariacms.php")) {
	require_once("../../../include/ariacms.php");
} else {
	echo "Missing System File";
	exit();
}
if($_SESSION['user']['role_type'] == 'ADMIN' || $_SESSION['user']['role_type'] == 'CHECK'){
	$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
	$ariacms = new ariacms();

	if($_REQUEST['status'] == 1){ // Trạng thái xuất bản
		$post_status = "lock"; 
	}else{ 
		$post_status = "active";
	}
	
	$query = "SELECT * FROM e4_tapchi a WHERE a.id =".$_REQUEST['news_id'];
	$database->setQuery($query);
	$PostRows = $database->loadRow();

	$row_history = new stdClass;
	$row_history->action = 'edit';
	$row_history->id_post = $_REQUEST['news_id'];
	
	foreach($PostRows as $key2 => $value2){
		if(!is_numeric($key2)){
			$row_history->$key2 = $value2;
		}
	}
	
	$row_history->post_status = $post_status;
	$row_history->user_modified = $_SESSION["user"]['id'];
	$row_history->id = NULL;
	$database->insertObject('e4_posts_history', $row_history, 'id'); // Thêm vào bảng lịch sử thao tác
	
	$query = "update e4_tapchi set post_status= '".$post_status."' , user_edited=".$_SESSION["user"]['id'].", time_edited = ".time()." where id= ".$_REQUEST['news_id'];
	$database->setQuery($query);
	$database->query();
	echo $query;
}
?>