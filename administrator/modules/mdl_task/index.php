<?php
View::tasksManagerFront();
global $ariacms;
switch ($ariacms->getParam("task")) {
	case "task_add":
		Model::task_add();
		break;
	case "task_edit":
		Model::task_edit();
		break;
	case "task_delete":
		Model::task_delete();
		break;
	default:
		Model::task_view();
		break;
}
