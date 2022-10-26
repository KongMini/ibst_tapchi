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

$postid =  @$_REQUEST['postid'];
$userid =  $_SESSION['member']['id'];

$query = "SELECT a.id, a.number_like, b.member_id FROM e4_posts a 
LEFT JOIN e4_post_like b on b.post_id = a.id WHERE a.id=".$postid." and a.post_status = 'active' and b.member_id = ".$userid." ORDER BY a.id desc";
$database->setQuery($query);
$post = $database->loadRow();
if($post){
	
	$number_like = $post["number_like"];
	
	$row = new stdClass;
	$row->id = $postid;
	$row->number_like = $number_like - 1;
	if($database->updateObject('e4_posts', $row, 'id')){
			$query = "delete from e4_post_like where post_id = " . $postid . " and 	member_id=". $userid;
			$database->setQuery($query);
			if ($database->query()){
				?>
				<a href="javascript:;"  onclick="likepost('<?=$postid?>')"  class="items-center">
					<ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="thumbs up outline" ></ion-icon>  <?= $number_like -1  ?>
				</a>
				
				
					<?php
			}
	}
	
}else{
	
	$query = "SELECT a.id, a.number_like FROM e4_posts a where a.id=". $postid;
	$database->setQuery($query);
	$post = $database->loadRow();
	
	if($post){
		$number_like = $post['number_like'];
		$query = "update e4_posts set number_like = number_like + 1 where id = " . $postid ;
		$database->setQuery($query);
		if ($database->query()) {
			$row = new stdClass;
			$row->id = null;
			$row->post_id= $postid;
			$row->member_id= $userid;
			$row->thoigian= time();
			$idPhieu = $database->insertObject('e4_post_like', $row, 'id');
			?>
				<a href="javascript:;" onclick="likepost('<?=$postid?>')"  class="items-center">
					<ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="thumbs up outline" style="color: blue;"></ion-icon>  <?= $number_like +1 ?>
				</a>
			<?php
		}
	}
	
}
//echo $bien;
	
?>
