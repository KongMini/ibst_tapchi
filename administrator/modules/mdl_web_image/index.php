<?php
View::webImageFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
		// For web_image
	case "web_image_add":
		Model::web_image_add();
		break;
	case "web_image_edit":
		Model::web_image_edit();
		break;
	case "web_image_delete":
		Model::web_image_delete();
		break;
	default:
		Model::web_image_view();
		break;
}
