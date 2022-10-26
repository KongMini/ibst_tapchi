<?php
View::analyticsCodeFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
		// For analytics_code
	case "analytics_code_add":
		Model::analytics_code_add();
		break;
	case "analytics_code_edit":
		Model::analytics_code_edit();
		break;
	case "analytics_code_delete":
		Model::analytics_code_delete();
		break;
	default:
		Model::analytics_code_view();
		break;
}
