<?php
View::showNewsManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_add":
		Model::news_add();
		break;
	case "news_edit":
		Model::news_edit();
		break;
	case "news_delete":
		Model::news_delete();
		break;
	default:
		Model::news_view();
		break;
}
