<?php
class Model
{
	static function task_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_functions\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_functions\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để kích hoạt"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href ="?module=task&task=task_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}

	static function module_view_link($row)
	{
		$str = '';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/task/ajax.module_function_add.php\')"><i class="fa fa-cogs" data-toggle="tooltip" title="Thêm function cho module"></i></a>&nbsp;&nbsp;';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_modules\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa module"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_modules\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để mở module"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}

		$str .= '<a href ="?module=module&task=module_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip" title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}
	static function task_view()
	{
		global $database;
		$query = "SELECT a.*, count(b.id) task 
			FROM e4_modules a 
				LEFT JOIN e4_functions b ON a.id = b.module_id
			WHERE 1 = 1 
			GROUP BY a.id
			ORDER BY a.type desc, a.id desc ";
		$database->setQuery($query);
		$modules = $database->loadObjectList();
		foreach ($modules as $module) {
			$query = "SELECT a.*
				FROM e4_functions a 
				WHERE a.module_id = " . $module->id . "
				ORDER BY a.function_code ";
			$database->setQuery($query);
			$module->list_task = $database->loadObjectList();
		}
		View::task_view($modules);
	}

	static function task_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "task_add") {
			$row = new stdClass;
			$row->id 		= null;
			$row->function_code 	= $_REQUEST["function_code"];
			$row->function_name 	= $_REQUEST["function_name"];
			$row->module_id 		= $_REQUEST["id"];
			$row->user_created	= $_SESSION["user"]['id'];
			$row->date_created 	= time();
			$row->status 		= 'active';
			if ($database->insertObject('e4_functions', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		}
	}

	static function task_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "task_edit") {
			$row = new stdClass;
			$row->id 		= $_REQUEST["id"];
			$row->function_code 	= $_REQUEST["function_code"];
			$row->function_name 	= $_REQUEST["function_name"];
			$row->module_id 		= $_REQUEST["id_module"];
			if ($database->updateObject('e4_functions', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		}
	}
	static function task_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_functions', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
