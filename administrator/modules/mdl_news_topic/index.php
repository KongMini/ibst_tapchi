<?php
View::showNewsTopicManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "news_topic_add":
		Model::news_topic_add();
		break;
	case "news_topic_edit":
		Model::news_topic_edit();
		break;
	case "news_topic_delete":
		Model::news_topic_delete();
		break;
	default:
		Model::news_topic_view();
		break;
}
