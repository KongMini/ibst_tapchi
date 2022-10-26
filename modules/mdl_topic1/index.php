<?php
global $ariacms;
switch (true) {
	case ($ariacms->getParam("task") != ''):
		Model::news_taxonomy();
		break;
	default:
		Model::news_list();
		break;
}