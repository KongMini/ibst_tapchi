<?php
class Model
{
	static function news_group_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_term_taxonomy\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để ẩn"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_term_taxonomy\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để hiển thị"><i class="fa fa-eye-slash text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news_group/ajax.news_group_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		if ($row->submenu > 0) {
			$str .= '<a data-toggle="tooltip" href="javascript:void(0);" title="Không thể xóa menu khi có chứa menu con"><i class="fa fa-trash text-black"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a href ="?module=news_group&task=news_group_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		}

		return $str;
	}

	static function news_group_view()
	{
		View::news_group_view();
	}

	static function news_group_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "news_group_add") {
			$row = new stdClass;
			$row->id 		= NULL;
			$row->taxonomy = 'group';
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			if ($term_id = $database->insertObject('e4_term_taxonomy', $row, 'id')) {
				$meta = new stdClass;
				foreach ($_POST as $key => $value) {
					if (strlen(strstr($key, 'meta_')) > 0 && $value != '') {
						$meta->meta_id = NULL;
						$meta->term_id = $term_id;
						$meta->meta_key = $key;
						$meta->meta_value = $value;
						$database->insertObject("e4_term_meta", $meta, "meta_id");
					}
				}
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function news_group_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "news_group_edit") {
			$row = new stdClass;
			$row->id 		= $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			if ($database->updateObject('e4_term_taxonomy', $row, 'id')) {
				$ariacms->delete('e4_term_meta', 'term_id=' . $_REQUEST["id"]);
				$meta = new stdClass;
				foreach ($_POST as $key => $value) {
					if (strlen(strstr($key, 'meta_')) > 0 && $value != '') {
						$meta->meta_id = NULL;
						$meta->term_id = $_REQUEST["id"];
						$meta->meta_key = $key;
						$meta->meta_value = $value;
						$database->insertObject("e4_term_meta", $meta, "meta_id");
					}
				}
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function news_group_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_term_taxonomy', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}

	static function printMenuAction($table, $parent_id, $str, $taxonomy)
	{
		global $database;
		$str .= "- - ";
		$parent_id != '' ? $parent_id = $parent_id : $parent_id = 0;
		$where = " WHERE a.parent = " . $parent_id . " AND taxonomy = '" . $taxonomy . "'";
		$group = " GROUP BY a.id ";
		$order = " ORDER BY a.order ";
		$parent_id != '' ? $where .= " AND a.parent = " . $parent_id : '';
		$query = "SELECT a.*, count(b.parent) submenu FROM " . $table . " a 
			LEFT JOIN (SELECT parent FROM " . $table . " WHERE taxonomy = '" . $taxonomy . "' ) b ON a.id = b.parent
				" . $where . $group . $order;
		$database->setQuery($query);
		$term_taxonomy = $database->loadObjectList();
		foreach ($term_taxonomy as $news_group) {
			if ($news_group->submenu > 0) {
?>
				<tr class="<?php echo ($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $str . $news_group->title_vi ?></td>
					<td><?php echo $str . $news_group->title_en ?></td>
					<td><?php echo $news_group->url_part ?></td>
					<td><?php echo $news_group->count ?></td>
					<td>
						<select class="form-control" name="position" id="position" onchange="update_value_by_id('<?php echo $table ?>', 'position', '<?php echo $news_group->id ?>', this.value);">
							<option value="">Chọn vị trí</option>
							<option value="header" <?php echo ($news_group->position == 'header') ? 'selected="selected"' : '' ?>>Đầu trang</option>
							<option value="home" <?php echo ($news_group->position == 'home') ? 'selected="selected"' : '' ?>>Trang chủ</option>
							<option value="left" <?php echo ($news_group->position == 'left') ? 'selected="selected"' : '' ?>>Menu trái</option>
							<option value="right" <?php echo ($news_group->position == 'right') ? 'selected="selected"' : '' ?>>Menu phải</option>
							<option value="footer" <?php echo ($news_group->position == 'footer') ? 'selected="selected"' : '' ?>>Cuối trang</option>
						</select>
					</td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $news_group->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $news_group->id ?>', this.value);" />
					</td>
					<td><?php echo  Model::news_group_view_link($news_group) ?></td>
				</tr>
			<?php
				Model::PrintMenuAction($table, $news_group->id, $str, $taxonomy);
			} else {
			?>
				<tr class="<?php echo ($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $str . $news_group->title_vi ?></td>
					<td><?php echo $str . $news_group->title_en ?></td>
					<td><?php echo $news_group->url_part ?></td>
					<td><?php echo $news_group->count ?></td>
					<td>
						<select class="form-control" name="position" id="position" onchange="update_value_by_id('<?php echo $table ?>', 'position', '<?php echo $news_group->id ?>', this.value);">
							<option value="">Chọn vị trí</option>
							<option value="header" <?php echo ($news_group->position == 'header') ? 'selected="selected"' : '' ?>>Đầu trang</option>
							<option value="home" <?php echo ($news_group->position == 'home') ? 'selected="selected"' : '' ?>>Trang chủ</option>
							<option value="left" <?php echo ($news_group->position == 'left') ? 'selected="selected"' : '' ?>>Menu trái</option>
							<option value="right" <?php echo ($news_group->position == 'right') ? 'selected="selected"' : '' ?>>Menu phải</option>
							<option value="footer" <?php echo ($news_group->position == 'footer') ? 'selected="selected"' : '' ?>>Cuối trang</option>
						</select>
					</td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $news_group->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $news_group->id ?>', this.value);" />
					</td>
					<td><?= Model::news_group_view_link($news_group) ?></td>
				</tr>
<?php
			}
		}
	}
}
?>