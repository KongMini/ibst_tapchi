<?php
class Model
{
	static function module_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_modules\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa module"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_modules\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để mở module"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href ="?module=module&task=module_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip" title="Xóa"></i></a>&nbsp;&nbsp;';

		echo $str;
	}

	static function module_view()
	{
		global $database;
		$query = "SELECT a.*
			FROM e4_modules a 
			ORDER BY a.type desc, a.id desc ";
		$database->setQuery($query);
		$modules = $database->loadObjectList();
		View::module_view($modules);
	}
	static function module_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "module_add") {
			$row = new stdClass;
			$row->id = null;
			foreach ($_POST as $key => $value) {
				if ($key != "submit")
					$row->$key = $value;
			}
			$row->status 	= 'active';
			if ($database->insertObject('e4_modules', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		}
	}

	static function module_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "module_edit") {
			$row = new stdClass;
			$row->id = $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != "submit")
					$row->$key = $value;
			}
			if ($database->updateObject('e4_modules', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		}
	}
	static function module_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_modules', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
