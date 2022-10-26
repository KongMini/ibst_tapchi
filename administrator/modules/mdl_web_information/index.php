<?php
View::webInformationFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "web_information_edit":
		Model::web_information_edit();
		break;
	default:
		Model::web_information_view();
		break;
}
