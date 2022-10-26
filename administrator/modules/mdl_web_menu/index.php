<?php
View::webMenuFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "web_menu_add":
		Model::web_menu_add();
		break;
	case "web_menu_edit":
		Model::web_menu_edit();
		break;
	case "web_menu_delete":
		Model::web_menu_delete();
		break;
	default:
		Model::web_menu_view();
		break;
}
