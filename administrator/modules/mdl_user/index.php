<?php
View::userManagerFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "user_add":
		Model::user_add();
		break;
	case "user_edit":
		Model::user_edit();
		break;
	case "user_delete":
		Model::user_delete();
		break;
	case "user_publish":
		Model::user_publish();
		break;
	case "user_unpublish":
		Model::user_unpublish();
		break;
	case "user_public":
		Model::user_public();
	default:
		Model::user_view();
		break;
}
