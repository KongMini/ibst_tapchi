<?php
View::showNewsTypeManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_type_add":
		Model::news_type_add();
		break;
	case "news_type_edit":
		Model::news_type_edit();
		break;
	case "news_type_delete":
		Model::news_type_delete();
		break;
	default:
		Model::news_type_view();
		break;
}
