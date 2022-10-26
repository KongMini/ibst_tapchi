<?php
global $ariacms;
//echo "AAAAAAAAA".$ariacms->getParam("task");die;
switch (true) {
	case ($ariacms->getParam("task") == 'login'):
		Model::formlogin();
		break;
	case ($ariacms->getParam("task") == 'logout'):
		Model::checklogout();
		break;
	case ($ariacms->getParam("task") == 'register'):
		Model::formregister();
		break;
	case ($ariacms->getParam("task") == 'check-login'):
		Model::checklogin();
		break;
	case ($ariacms->getParam("task") == 'check-register'):
		Model::checkregister();
		break;
	case ($ariacms->getParam("task") != ''):
		Model::kichhoattaikhoan();
		break;
	default:
		Model::formlogin();
		break;
}