<?php
View::showNewsManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_add":
		Model::news_add();
		break;
	case "news_delete":
		Model::news_delete();
		break;
	case "news_remove":
		Model::news_remove();
		break;	
	default:
		Model::news_view();
		break;
}