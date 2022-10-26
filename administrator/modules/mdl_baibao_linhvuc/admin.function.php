<?php
class Model
{
	static function baibao_linhvuc_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			echo '<a onclick="update_value_by_id(\'e4_linhvuc\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để ẩn"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
		} else {
			echo '<a onclick="update_value_by_id(\'e4_linhvuc\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để hiển thị"><i class="fa fa-eye-slash text-black"></i></a>&nbsp;&nbsp;';
		}
			echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/baibao_linhvuc/ajax.baibao_linhvuc_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		if ($row->submenu > 0) {
			echo '<a data-toggle="tooltip" href="javascript:void(0);" title="Không thể xóa menu khi có chứa menu con"><i class="fa fa-trash text-black"></i></a>&nbsp;&nbsp;';
		} else {
			echo '<a href ="?module=linhvuc&task=baibao_linhvuc_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		}

		return $str;
	}

	static function baibao_linhvuc_view()
	{
		View::baibao_linhvuc_view();
	}

	static function baibao_linhvuc_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "baibao_linhvuc_add") {
			$row = new stdClass;
			$row->id 		= NULL;
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if($key == 'time_start' or $key == 'time_end'){
                        $row->$key = strtotime($value);
                    }
                    else if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			if ($term_id = $database->insertObject('e4_linhvuc', $row, 'id')) {
				// $meta = new stdClass;
				// foreach ($_POST as $key => $value) {
				// 	if (strlen(strstr($key, 'meta_')) > 0 && $value != '') {
				// 		$meta->meta_id = NULL;
				// 		$meta->term_id = $term_id;
				// 		$meta->meta_key = $key;
				// 		$meta->meta_value = $value;
				// 		$database->insertObject("e4_term_meta", $meta, "meta_id");
				// 	}
				// }
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function baibao_linhvuc_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "baibao_linhvuc_edit") {
			$row = new stdClass;
			$row->id 		= $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
                    if($key == 'time_start' or $key == 'time_end'){
                        $row->$key = strtotime($value);
                    }else if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			// print_r($row);die;
			if ($database->updateObject('e4_linhvuc', $row, 'id')) {
				// $ariacms->delete('e4_term_meta', 'term_id=' . $_REQUEST["id"]);
				// $meta = new stdClass;
				// foreach ($_POST as $key => $value) {
				// 	if (strlen(strstr($key, 'meta_')) > 0 && $value != '') {
				// 		$meta->meta_id = NULL;
				// 		$meta->term_id = $_REQUEST["id"];
				// 		$meta->meta_key = $key;
				// 		$meta->meta_value = $value;
				// 		$database->insertObject("e4_term_meta", $meta, "meta_id");
				// 	}
				// }
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function baibao_linhvuc_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_linhvuc', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}

	static function printMenuAction($table, $parent_id, $str, $taxonomy)
	{
		global $database;
		// = "- - ";
		// $parent_id != '' ? $parent_id = $parent_id : $parent_id = 0;
		// $where = " WHERE a.parent = " . $parent_id . " AND taxonomy = '" . $taxonomy . "'";
		// $group = " GROUP BY a.id ";
		// $order = " ORDER BY a.order ";
		// $parent_id != '' ? $where .= " AND a.parent = " . $parent_id : '';
		$query = "SELECT * from e4_linhvuc " . $group . $order;
		$database->setQuery($query);
		$baibao_linhvucs = $database->loadObjectList();
		foreach ($baibao_linhvucs as $baibao_linhvuc) {
?>
				<tr class=" valign-middle">
					<td><?php echo  $baibao_linhvuc->title_vi ?></td>
					<td><?php echo  $baibao_linhvuc->title_en ?></td>
					<td><?php echo $baibao_linhvuc->url_part ?></td>

					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $baibao_linhvuc->nam ?>" />
					</td>
					<td><?php echo  Model::baibao_linhvuc_view_link($baibao_linhvuc) ?></td>
				</tr>
		
<?php
			
		}
	}
}
?>