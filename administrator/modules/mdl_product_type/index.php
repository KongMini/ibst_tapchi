<?php
View::showProductTypeManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "product_type_add":
		Model::product_type_add();
		break;
	case "product_type_edit":
		Model::product_type_edit();
		break;
	case "product_type_delete":
		Model::product_type_delete();
		break;
	default:
		Model::product_type_view();
		break;
}
