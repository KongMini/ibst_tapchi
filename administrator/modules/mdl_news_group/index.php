<?php
View::showNewsGroupManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_group_add":
		Model::news_group_add();
		break;
	case "news_group_edit":
		Model::news_group_edit();
		break;
	case "news_group_delete":
		Model::news_group_delete();
		break;
	default:
		Model::news_group_view();
		break;
}
