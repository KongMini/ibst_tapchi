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
$id			= @$_REQUEST["i"];
$table		= @$_REQUEST["t"];
$colummn	= @$_REQUEST["c"];
$value		= @$_REQUEST["v"];

$row = new stdClass;
$row->id = $id;
$row->$colummn = $value;
$database->updateObject($table, $row, 'id');
