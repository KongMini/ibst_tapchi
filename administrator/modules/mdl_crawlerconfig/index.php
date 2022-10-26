<?php
View::blocksManagerFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "config_add":
		Model::config_add();
		break;
	case "block_edit":
		Model::config_edit();
		break;
	case "config_delete":
		Model::config_delete();
		break;
	default:
		Model::config_view();
		break;
}
