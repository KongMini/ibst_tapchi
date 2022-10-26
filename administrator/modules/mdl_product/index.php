<?php
View::showProductManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "product_add":
		Model::product_add();
		break;
	case "product_edit":
		Model::product_edit();
		break;
	case "product_delete":
		Model::product_delete();
		break;
	default:
		Model::product_view();
		break;
}
