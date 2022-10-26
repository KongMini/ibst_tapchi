<?php
View::showNewsManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "menu_admin_add":
		Model::menu_admin_add();
		break;
	case "menu_admin_edit":
		Model::menu_admin_edit();
		break;
	case "menu_admin_delete":
		Model::menu_admin_delete();
		break;
	default:
		Model::menu_admin_view();
		break;
}
