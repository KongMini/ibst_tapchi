<?php
class Model
{
	static function analytics_code_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_analytics_code\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_analytics_code\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để kích hoạt"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/analytics_code/ajax.analytics_code_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=analytics_code&task=analytics_code_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}
	static function analytics_code_view()
	{
		global $database;
		$query = "SELECT a.* FROM e4_analytics_code a ORDER BY a.region, a.id desc ";
		$database->setQuery($query);
		$analytics_codes = $database->loadObjectList();
		View::analytics_code_view($analytics_codes);
	}
	static function analytics_code_add()
	{
		global $database;
		global $ariacms;
		if ($_POST["submit"] == "analytics_code_add") {
			$row = new stdClass;
			$row->id 		= NULL;
			foreach ($_POST as $key => $value) {
				if ($key != "submit")
					$row->$key = $value;
			}
			$row->status 	= 'active';
			$row->date_created = time();
			$row->user_created 	= $_SESSION['user']['email'];
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->insertObject('e4_analytics_code', $row, 'id'))
				$ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function analytics_code_edit()
	{
		global $database;
		global $ariacms;
		if ($_POST["submit"] == "analytics_code_edit") {
			$row = new stdClass;
			$row->id 		= $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != "submit")
					$row->$key = $value;
			}
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->updateObject('e4_analytics_code', $row, 'id'))
				$ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function analytics_code_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_analytics_code', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
