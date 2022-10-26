<?php
@session_start();
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
$input = $_REQUEST['input'];
$c = $_REQUEST['c'];
$t = $_REQUEST['t'];
$error = $_REQUEST['error'];
$value = $_REQUEST['value'];

$query = "SELECT * FROM " . $t . " WHERE " . $c . " = '" . $input . "' and " . $c . " != '" . $value . "' and " . $c . " != '' ";
$database->setQuery($query);
$checks = $database->loadObjectList();
if ($checks) echo $error . " đã tồn tại.";
else echo "";
