<?php
View::showProductGroupManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "product_group_add":
		Model::product_group_add();
		break;
	case "product_group_edit":
		Model::product_group_edit();
		break;
	case "product_group_delete":
		Model::product_group_delete();
		break;
	default:
		Model::product_group_view();
		break;
}
