<?php
View::blocksManagerFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "block_add":
		Model::block_add();
		break;
	case "block_edit":
		Model::block_edit();
		break;
	case "block_delete":
		Model::block_delete();
		break;
	default:
		Model::block_view();
		break;
}
