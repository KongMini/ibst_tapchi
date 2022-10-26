<?php
class Model
{
	static function menu_admin_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_leftmenu\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_leftmenu\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để kích hoạt"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		if ($row->toolbar == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_leftmenu\', \'toolbar\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để xóa khỏi toolbar"><i class="fa fa-cogs"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_leftmenu\', \'toolbar\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để thêm vào toolbar"><i class="fa fa-cogs text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/menu_admin/ajax.menu_admin_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		if ($row->submenu > 0) {
			$str .= '<a data-toggle="tooltip" href="javascript:void(0);" title="Không thể xóa menu khi có chứa menu con"><i class="fa fa-trash text-black"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a href ="?module=menu_admin&task=menu_admin_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		}

		return $str;
	}

	static function menu_admin_view()
	{
		global $database;
		$query = "SELECT a.*, count(b.id) submenu 
			FROM e4_leftmenu a 
				LEFT JOIN (SELECT id, parent_id FROM e4_leftmenu WHERE level = 2) b ON a.id = b.parent_id
			WHERE a.level = 1 
			GROUP BY a.id
			ORDER BY a.region ";
		$database->setQuery($query);
		$menu_admins = $database->loadObjectList();

		foreach ($menu_admins as $menu_admin) {
			$query = "SELECT a.*, count(b.id) submenu 
			FROM e4_leftmenu a 
				LEFT JOIN (SELECT id, parent_id FROM e4_leftmenu WHERE level = 3) b ON a.id = b.parent_id
			WHERE a.level = 2 AND a.parent_id = " . $menu_admin->id . "
			GROUP BY a.id
			ORDER BY a.region ";
			$database->setQuery($query);
			$menu_admin->menu_sub = $database->loadObjectList();
		}
		View::menu_admin_view($menu_admins);
	}

	static function menu_admin_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "menu_admin_add") {
			$row = new stdClass;
			$row->id 		= null;
			foreach ($_POST as $key => $value) {
				if ($key != "submit") {
					$row->$key = $value;
				}
			}
			$query = "select level from e4_leftmenu where id = $row->parent_id";
			$database->setQuery($query);
			$level = $database->loadRow();
			($level['level'] != '') ? ($row->level = $level['level'] + 1) : $row->level = 1;
			$row->status 	= 'active';
			$row->user_created	= $_SESSION["user"]['id'];
			$row->date_created 	= time();
			if ($database->insertObject('e4_leftmenu', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		}
	}

	static function menu_admin_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "menu_admin_edit") {
			$row = new stdClass;
			$row->id = $_REQUEST['id'];
			foreach ($_POST as $key => $value) {
				if ($key != "submit") {
					$row->$key = $value;
				}
			}
			$query = "select level from e4_leftmenu where id = $row->parent_id";
			$database->setQuery($query);
			$level = $database->loadRow();
			($level['level'] != '') ? ($row->level = $level['level'] + 1) : $row->level = 1;
			if ($database->updateObject('e4_leftmenu', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		}
	}
	static function menu_admin_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_leftmenu', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
