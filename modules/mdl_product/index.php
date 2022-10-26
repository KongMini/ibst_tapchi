<?php
global $ariacms;
switch (true) {
	case ($ariacms->getParam("task") != ''):
		Model::product_taxonomy();
		break;
	default:
		Model::product_list();
		break;
}
