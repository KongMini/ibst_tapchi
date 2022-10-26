<?php
View::showBaiBaoLinhVuc();
global $ariacms;

switch ($ariacms->getParam("task")) {
	case "baibao_linhvuc_add":
		Model::baibao_linhvuc_add();
		break;
	case "baibao_linhvuc_edit":
		Model::baibao_linhvuc_edit();
		break;
	case "baibao_linhvuc_delete":
		Model::baibao_linhvuc_delete();
		break;
	default:
		Model::baibao_linhvuc_view();
		break;
}
