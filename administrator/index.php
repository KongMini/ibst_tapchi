<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
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
//Set file sendmail
if (file_exists("../plugins/phpmailer/class.phpmailer.php")) {
	require_once("../plugins/phpmailer/class.phpmailer.php");
} else {
	echo "Missing Mailer File";
	exit();
}
// Setup Global variables
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();
$params = new params();

if (!$ariacms->checkLoginAdmin()) {
	require_once("login.php");
	exit();
}

//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
//die;
//echo $_COOKIE["ip_login"];
if (file_exists("templates/aptcms/index.php")) {
	require_once("templates/aptcms/index.php");
} else {
	echo "Missing Template.";
	exit();
}
