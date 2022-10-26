<?php
class Model
{
	static function roles_view_link($row)
	{
		$str = '';
		if ($row->status == '1') {
			$str .= '<a onclick="update_value_by_id(\'e4_roles\', \'status\', \'' . $row->id . '\', \'0\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_roles\', \'status\', \'' . $row->id . '\', \'1\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để kích hoạt"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a data-toggle="tooltip" href="?module=roles&task=roles_module_action&id=' . $row->id . '" title="Các chức năng được thao tác"><i class="fa fa-list-alt"></i></a>&nbsp;&nbsp;';
		$str .= '<a data-toggle="tooltip" href="?module=roles&task=roles_menu_access&id=' . $row->id . '" title="Các menu được truy cập"><i class="fa fa-list"></i></a>&nbsp;&nbsp;';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/roles/ajax.roles_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=roles&task=roles_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		echo $str;
	}
	static function roles_view()
	{
		global $database;
		$query = "SELECT * FROM e4_roles ";
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		View::roles_view($rows);
	}
	static function roles_menu_access()
	{
		global $database;
		global $ariacms;
		if (!$_REQUEST["submit"]) {
			$id = @$_REQUEST["id"];
			$row = $ariacms->selectOne('e4_roles', 'id', '=', $id);
			$items_one = $ariacms->selectAll('e4_leftmenu', 'level = 1 and status = "active"', 'order by region, id');
			$items_two = $ariacms->selectAll('e4_leftmenu', 'level = 2 and status = "active"', 'order by region, id');
			View::roles_menu_access($row, $items_one, $items_two);
		} else {
			$id = @$_REQUEST["id"];
			$menu_id_list = @$_REQUEST["menu_id_list"];
			// Insert vào CSDL
			$row = new stdClass;
			$row->id = $id;
			$row->menu_id = $menu_id_list;
			if ($database->updateObject('e4_roles', $row, 'id')) $ariacms->redirect("Cập nhật thành công!", "index.php?module=roles");
			else echo $database->stderr();
		}
	}
	static function roles_module_action()
	{
		global $database;
		global $ariacms;
		if (!$_REQUEST["submit"]) {
			$id = @$_REQUEST["id"];
			$row = $ariacms->selectOne('e4_roles', 'id', '=', $id);
			$query = "SELECT a.*, count(b.id) task 
				FROM e4_modules a 
					LEFT JOIN e4_functions b ON a.id = b.module_id
				WHERE a.status = 'active' 
				GROUP BY a.id
				ORDER BY a.type desc, id desc ";
			$database->setQuery($query);
			$modules = $database->loadObjectList();

			foreach ($modules as $module) {
				$query = "SELECT a.*
					FROM e4_functions a 
					WHERE a.module_id = " . $module->id . " and a.status = 'active'
					ORDER BY a.function_code ";
				$database->setQuery($query);
				$module->list_task = $database->loadObjectList();
			}
			View::roles_module_action($row, $modules);
		} else {
			$id 			= @$_REQUEST["id"];
			$module_name_list	= @$_REQUEST["module_name_list"];
			$function_code_list	= @$_REQUEST["function_code_list"];
			// Insert vào CSDL
			$row = new stdClass;
			$row->id = $id;
			$row->module_name_list = $module_name_list;
			$row->function_code_list = $function_code_list;
			if ($database->updateObject('e4_roles', $row, 'id')) $ariacms->redirect("Cập nhật thành công!", "index.php?module=roles");
			else echo $database->stderr();
		}
	}

	static function roles_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] != 'roles_add') {
			$ariacms->redirect("", "javascript:history.back()");
		} else {
			$role_code	= @$_REQUEST["role_code"];
			$role_desc	= @$_REQUEST["role_desc"];
			// Insert vào CSDL
			$row = new stdClass;
			$row->id = null;
			$row->role_code = $role_code;
			$row->role_desc = $role_desc;
			$row->status = '1';
			if ($id = $database->insertObject('e4_roles', $row, 'id')) $ariacms->redirect("Cập nhật thành công!", "index.php?&module=roles&task=roles_menu_access&id=" . $id);
			else echo $database->stderr();
		}
	}

	static function roles_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] != 'roles_edit') {
			$ariacms->redirect("", "javascript:history.back()");
		} else {
			$id = @$_REQUEST["id"];
			$role_code	= @$_REQUEST["role_code"];
			$role_desc	= @$_REQUEST["role_desc"];
			// Insert vào CSDL
			$row = new stdClass;
			$row->id = $id;
			$row->role_code = $role_code;
			$row->role_desc = $role_desc;

			if ($database->updateObject('e4_roles', $row, 'id')) $ariacms->redirect("Cập nhật thành công!", "index.php?&module=roles");
			else echo $database->stderr();
		}
	}
	static function roles_delete()
	{
		global $ariacms;
		$id = @$_REQUEST["id"];
		$ariacms->delete('e4_roles', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
