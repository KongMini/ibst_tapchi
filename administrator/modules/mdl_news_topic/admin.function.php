<?php
class Model
{
	static function news_topic_view_link($row)
	{
		$str = '';
		if ($row->status == 'active') {
			$str .= '<a onclick="update_value_by_id(\'e4_term_taxonomy\', \'status\', \'' . $row->id . '\', \'deactive\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để ẩn"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_term_taxonomy\', \'status\', \'' . $row->id . '\', \'active\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để hiển thị"><i class="fa fa-eye-slash text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news_topic/ajax.news_topic_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		if ($row->submenu > 0) {
			$str .= '<a data-toggle="tooltip" href="javascript:void(0);" title="Không thể xóa menu khi có chứa menu con"><i class="fa fa-trash text-black"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a href ="?module=news_topic&task=news_topic_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		}

		return $str;
	}

	static function news_topic_view()
	{
		View::news_topic_view();
	}

	static function news_topic_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "news_topic_add") {
			$row = new stdClass;
			$row->id 		= NULL;
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			if ($term_id = $database->insertObject('e4_chude', $row, 'id')) {
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

	static function news_topic_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "news_topic_edit") {
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
			if ($database->updateObject('e4_chude', $row, 'id')) {
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
	static function news_topic_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_chude', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}

	static function printMenuAction($table, $parent_id, $str, $taxonomy)
	{
		global $database;
		$str .= "- - ";
		//$parent_id != '' ? $parent_id = $parent_id : $parent_id = 0;
		//$where = " WHERE a.parent >= 0 AND taxonomy = '" . $taxonomy . "'";
		$group = " GROUP BY a.id ";
		$order = " ORDER BY a.id ";
		$parent_id != '' ? $where .= " AND a.parent = " . $parent_id : '';
		$query = "SELECT a.*, b.title_vi linhvuc FROM " . $table . " a 
			LEFT JOIN e4_linhvuc b ON b.id = a.id_linhvuc
				" . $order;
		$database->setQuery($query);
		$chudes = $database->loadObjectList();
		
		$arr_linhvuc = [];
		$arr_linhvuc_temp;
	
		//print_r($arr_linhvuc);
		foreach ($chudes as $news_topic) {
?>
				<tr class="<?php echo ($parent_id == 0) ? 'bg-gray-light' : ''; ?> valign-middle">
					<td><?php echo $news_topic->title_vi ?></td>
					<td><?php echo $news_topic->title_en ?></td>
					<td><?php echo $news_topic->url_part ?></td>
					<td>
						<input type="number" class="form-control" name="order" id="order" value="<?php echo  $news_topic->order ?>" onchange="update_value_by_id('<?php echo $table ?>', 'order', '<?php echo $news_topic->id ?>', this.value);" />
					</td>
					<td><?php echo  Model::news_topic_view_link($news_topic) ?></td>
				</tr>
			<?php
				//Model::PrintMenuAction($table, $news_topic->id, $str, $taxonomy);
			
		}
	}
}
?>