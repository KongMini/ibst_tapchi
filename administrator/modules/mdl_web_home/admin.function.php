<?php
class Model
{
	static function web_home_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_web_home\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để ẩn"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_web_home\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để hiển thị"><i class="fa fa-eye-slash text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/web_home/ajax.web_home_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		if ($row->submenu > 0) {
			$str .= '<a data-toggle="tooltip" href="javascript:void(0);" title="Không thể xóa menu khi có chứa menu con"><i class="fa fa-trash text-black"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a href ="?module=web_home&task=web_home_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		}
		return $str;
	}

	static function web_home_view()
	{
		View::web_home_view();
	}

	static function web_home_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "web_home_add") {
			$row = new stdClass;
			$row->id 		= NULL;
			foreach ($_POST as $key => $value) {
				if ($key != 'submit') {
					if ($key == 'content_en' || $key == 'content_vn')
						$row->$key = $ariacms->ConvertEditor($value);
					else $row->$key = $value;
				}
			}
			$row->status 	= 'active';
			$row->date_created = time();
			$row->user_created 	= $_SESSION['user']['email'];
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->insertObject('e4_web_home', $row, 'id'))
				$ariacms->redirect("", "javascript:history.back()");
			else
				echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function web_home_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "web_home_edit") {
			$row = new stdClass;
			$row->id 		= $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != 'submit') {
					if ($key == 'content_en' || $key == 'content_vn')
						$row->$key = $ariacms->ConvertEditor($value);
					else $row->$key = $value;
				}
			}
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->updateObject('e4_web_home', $row, 'id'))
				$ariacms->redirect("", "javascript:history.back()");
			else
				echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function web_home_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_web_home', 'id=' . $id);
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
		$web_home_categories = $database->loadObjectList();
		foreach ($web_home_categories as $web_home) {
			if ($web_home->submenu > 0) {
?>
				<tr class="<?php echo ($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $str . $web_home->title_vi ?></td>
					<td><?php echo $str . $web_home->title_en ?></td>
					<td>
						<?php
						if ($parent_id == 0) {
						?>
							<input type="text" class="form-control" name="icon" id="icon" value="<?php echo  $web_home->icon ?>" onchange="update_value_by_id('<?php echo $table ?>', 'icon', '<?php echo $web_home->id ?>', this.value);" />
						<?php
						}
						?>
					</td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $web_home->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $web_home->id ?>', this.value);" />
					</td>
					<td><?php echo  Model::web_home_view_link($web_home) ?></td>
				</tr>
			<?php
				Model::PrintMenuAction($table, $web_home->id, $str);
			} else {
			?>
				<tr class="<?php echo ($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $str . $web_home->title_vi ?></td>
					<td><?php echo $str . $web_home->title_en ?></td>
					<td>
						<?php
						if ($parent_id == 0) {
						?>
							<input type="text" class="form-control" name="icon" id="icon" value="<?php echo  $web_home->icon ?>" onchange="update_value_by_id('<?php echo $table ?>', 'icon', '<?php echo $web_home->id ?>', this.value);" />
						<?php
						}
						?>
					</td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $web_home->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $web_home->id ?>', this.value);" />
					</td>
					<td><?php echo  Model::web_home_view_link($web_home) ?></td>
				</tr>
<?php
			}
		}
	}
}
?>