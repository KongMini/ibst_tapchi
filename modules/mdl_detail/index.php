<?php
global $ariacms;
switch (true) {
	case ($ariacms->getParam("task") != ''):
		Model::detail();
		break;
	default:
		Model::detail();
		break;
}
