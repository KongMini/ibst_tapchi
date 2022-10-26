<?php
View::showProductCategoryManager();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "product_category_add":
		Model::product_category_add();
		break;
	case "product_category_edit":
		Model::product_category_edit();
		break;
	case "product_category_delete":
		Model::product_category_delete();
		break;
	default:
		Model::product_category_view();
		break;
}
