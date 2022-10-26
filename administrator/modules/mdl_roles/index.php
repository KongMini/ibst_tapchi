<?php
View::showIntroductionManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "roles_view":
		Model::roles_view();
		break;
	case "roles_add":
		Model::roles_add();
		break;
	case "roles_edit":
		Model::roles_edit();
		break;
	case "roles_delete":
		Model::roles_delete();
		break;
	case "roles_module_action":
		Model::roles_module_action();
		break;
	case "roles_menu_access":
		Model::roles_menu_access();
		break;
	default:
		Model::roles_view();
		break;
}
