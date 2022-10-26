<?php
View::showNewsCategoryManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_category_add":
		Model::news_category_add();
		break;
	case "news_category_edit":
		Model::news_category_edit();
		break;
	case "news_category_delete":
		Model::news_category_delete();
		break;
	default:
		Model::news_category_view();
		break;
}
