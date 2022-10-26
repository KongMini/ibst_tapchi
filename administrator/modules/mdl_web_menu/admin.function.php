<?php
class Model
{
	static function web_menu_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_web_menu\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để ẩn"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_web_menu\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để hiển thị"><i class="fa fa-eye-slash text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/web_menu/ajax.web_menu_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		if ($row->submenu > 0) {
			$str .= '<a data-toggle="tooltip" href="javascript:void(0);" title="Không thể xóa menu khi có chứa menu con"><i class="fa fa-trash text-black"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a href ="?module=web_menu&task=web_menu_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		}
		return $str;
	}

	static function web_menu_view()
	{
		View::web_menu_view();
	}

	static function web_menu_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "web_menu_add") {
			$row = new stdClass;
			$row->id 		= NULL;
			foreach ($_POST as $key => $value) {
				if ($key != 'submit')
					$row->$key = $value;
			}
			$row->status 	= 'active';
			$row->date_created = time();
			$row->user_created 	= $_SESSION['user']['email'];
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->insertObject('e4_web_menu', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function web_menu_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "web_menu_edit") {
			$row = new stdClass;
			$row->id = $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != 'submit')
					$row->$key = $value;
			}
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->updateObject('e4_web_menu', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function web_menu_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_web_menu', 'id =' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
	static function PrintMenuAction($table, $parent_id, $str)
	{
		global $database;
		$str .= "- - ";
		$where = " WHERE a.parent = " . $parent_id;
		$group = " GROUP BY a.id ";
		$order = " ORDER BY a.order ";
		$query = "
				SELECT a.*, count(b.parent) submenu 
				FROM " . $table . " a 
					LEFT JOIN (SELECT parent FROM " . $table . ") b ON a.id = b.parent
				" . $where . $group . $order;
		$database->setQuery($query);
		$web_menus = $database->loadObjectList();
		foreach ($web_menus as $web_menu) {
			if ($web_menu->submenu > 0) {
?>
				<tr class="<?=($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $str . $web_menu->title_vi ?></td>
					<td><?php echo $str . $web_menu->title_en ?></td>
					<td><?php echo $web_menu->url_html ?></td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $web_menu->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $web_menu->id ?>', this.value);" />
					</td>
					<td><?php echo  Model::web_menu_view_link($web_menu) ?></td>
				</tr>
			<?php
				Model::PrintMenuAction($table, $web_menu->id, $str);
			} else {
			?>
				<tr class="<?php echo ($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $str . $web_menu->title_vi ?></td>
					<td><?php echo $str . $web_menu->title_en ?></td>
					<td><?php echo $web_menu->url_html ?></td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $web_menu->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $web_menu->id ?>', this.value);" />
					</td>
					<td><?php echo  Model::web_menu_view_link($web_menu) ?></td>
				</tr>
<?php
			}
		}
	}
}
?>