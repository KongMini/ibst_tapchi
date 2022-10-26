<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Include Configuration File
if (file_exists("configuration.php")) {
  require_once("configuration.php");
} else {
  echo "Missing Configuration File";
  exit();
}
// Include Language File
if (file_exists("languages/lang." . $ariaConfig_language . ".php")) {
  require_once("languages/lang." . $ariaConfig_language . ".php");
} else {
  echo "Missing Language File";
  exit();
}
// Include Params File
if (file_exists("params/params." . $ariaConfig_language . ".php")) {
  require_once("params/params." . $ariaConfig_language . ".php");
} else {
  echo "Missing Params File";
  exit();
}
// Include Database Controller
if (file_exists("include/database.php")) {
  require_once("include/database.php");
} else {
  echo "Missing Database File";
  exit();
}
// Include System File
if (file_exists("include/ariacms.php")) {
  require_once("include/ariacms.php");
} else {
  echo "Missing System File";
  exit();
}
// Set file sendmail
if (file_exists("plugins/phpmailer/class.phpmailer.php")) {
  require_once("plugins/phpmailer/class.phpmailer.php");
} else {
  echo "Missing Mailer File";
  exit();
}
/** Setup Global variables */
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();
$params = new params();
/** Get web menu  */
$query = "SELECT a.*, count(b.parent) submenu 
	FROM e4_web_menu a 
		LEFT JOIN (SELECT parent FROM e4_web_menu) b ON a.id = b.parent
	WHERE a.status = 'active' 
	GROUP BY a.id
	ORDER BY a.order ";
$database->setQuery($query);
$web_menus = $database->loadObjectList();
/** Get all e4_analytics_code */
$query = "SELECT * FROM e4_analytics_code WHERE status = 'active' ORDER BY position, region ";
$database->setQuery($query);
$analytics_code = $database->loadObjectList();
/** Print site content */
$ariacms->getBodyContent();
