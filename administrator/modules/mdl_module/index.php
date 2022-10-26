<?php
View::moduleManagerFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "module_add":
		Model::module_add();
		break;
	case "module_edit":
		Model::module_edit();
		break;
	case "module_delete":
		Model::module_delete();
		break;
	default:
		Model::module_view();
		break;
}
