<?php
View::profileManagerFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "profile_edit":
		Model::profile_edit();
		break;
	case "profile_change_pass":
		Model::profile_change_pass();
		break;
	default:
		Model::profile_view();
		break;
}
