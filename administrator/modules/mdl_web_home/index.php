<?php
View::webHomeFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "web_home_add":
		Model::web_home_add();
		break;
	case "web_home_edit":
		Model::web_home_edit();
		break;
	case "web_home_delete":
		Model::web_home_delete();
		break;
	default:
		Model::web_home_view();
		break;
}
