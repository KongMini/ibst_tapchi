<?php
View::showNewsTagsManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_tags_add":
		Model::news_tags_add();
		break;
	case "news_tags_edit":
		Model::news_tags_edit();
		break;
	case "news_tags_delete":
		Model::news_tags_delete();
		break;
	default:
		Model::news_tags_view();
		break;
}
