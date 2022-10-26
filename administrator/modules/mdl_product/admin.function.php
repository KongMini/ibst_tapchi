<?php
class Model
{
	/** Link add to product row in view list */
	static function product_view_link($row)
	{
		$str = '';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/product/ajax.product_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=product&task=product_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		return $str;
	}

	static function product_view()
	{
		global $database;
		global $ariacms;
		/** Condition */
		$where = " WHERE a.post_type = 'product' ";
		/** Order */
		$order = ' order by a.id desc';
		/** Pagination and Limit */
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		/** Merge query for selection */
		$query = "SELECT a.*, b.fullname, c.category, d.groups
		FROM e4_posts a
			LEFT JOIN e4_users b ON a.user_created = b.id 
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'product_category' GROUP BY t1.object_id
				) c ON a.id = c.object_id
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS groups
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'product_group' GROUP BY t1.object_id
				) d ON a.id = d.object_id
		" . $where . $order . $limit;
		$database->setQuery($query);
		$product = $database->loadObjectList();
		/** Total product in DB */
		$query = "SELECT COUNT(*) total FROM e4_posts WHERE post_type = 'product'";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		/** Get all user in DB */
		$users = $ariacms->selectAll('e4_users', '', '');
		/** Push data to view list product */
		View::product_view($product, $totalRows['total'], $maxRows, $curPg, $users);
	}
	/** Create product */
	static function product_add()
	{
		global $database;
		global $ariacms;
		if ($_POST["submit"] == "product_add") {
			$taxonomy = $_REQUEST["taxonomy"];
			$imagelist = $_REQUEST['imagelist'];
			unset($_REQUEST["taxonomy"]);
			unset($_REQUEST['imagelist']);
			/** Push key and value for product */
			$row = new stdClass;
			$row->id 		= NULL;
			$row->post_created = time();
			$row->user_created = $_SESSION["user"]['id'];
			$row->post_modified = time();
			$row->user_modified = $_SESSION["user"]['id'];
			$row->post_type = 'product';
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			if ($post_id = $database->insertObject('e4_posts', $row, 'id')) {
				/** Insert meta information for product */
				$meta = new stdClass;
				foreach ($_POST as $key => $value) {
					if (strlen(strstr($key, 'meta_')) > 0 && $value != '') {
						$meta->meta_id = NULL;
						$meta->post_id = $post_id;
						$meta->meta_key = $key;
						$meta->meta_value = $value;
						$database->insertObject("e4_posts_meta", $meta, "meta_id");
					}
				}
				/** Insert and update count for term relationships with product */
				$object = new stdClass;
				foreach ($taxonomy as $key => $value) {
					$object->object_id = $post_id;
					$object->term_taxonomy_id = $value;
					$object->object_type = 'product';
					$database->insertObject("e4_term_relationships", $object, "object_id");
					/** Update count for term_taxonomy when post created */
					$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
					WHERE term_taxonomy_id = " . $value . " AND object_type = 'product') WHERE id = " . $value;
					$database->setQuery($query);
					$database->query();
				}
				/** Insert related image list for product */
				for ($i = 1; $i <= count($imagelist); $i++) {
					if ($imagelist[$i]) {
						$query = "INSERT INTO `e4_posts_image`(`object_id`, `image_link`, `order`) VALUES ($post_id,'$imagelist[$i]',$i)";
						$database->setQuery($query);
						$database->query();
					}
				}
				/** Redirect back url */
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	/** Update information for product detail */
	static function product_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "product_edit") {
			$taxonomy = $_REQUEST["taxonomy"];
			$imagelist = $_REQUEST['imagelist'];
			unset($_REQUEST["taxonomy"]);
			unset($_REQUEST["imagelist"]);
			$row = new stdClass;
			$row->id 		= $_GET['id'];
			$row->post_modified = time();
			$row->user_modified = $_SESSION["user"]['id'];
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if ($key != 'url_part') {
						$row->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			if ($database->updateObject('e4_posts', $row, 'id')) {
				$ariacms->delete('e4_posts_meta', 'post_id=' . $_REQUEST["id"]);
				$meta = new stdClass;
				foreach ($_POST as $key => $value) {
					if (strlen(strstr($key, 'meta_')) > 0 && $value != '') {
						$meta->meta_id = NULL;
						$meta->post_id = $_REQUEST["id"];
						$meta->meta_key = $key;
						$meta->meta_value = $value;
						$database->insertObject("e4_posts_meta", $meta, "meta_id");
					}
				}
				$ariacms->delete('e4_term_relationships', 'object_id=' . $_REQUEST["id"] . ' AND object_type = "product" ');
				$object = new stdClass;
				foreach ($taxonomy as $key => $value) {
					$object->object_id = $_REQUEST["id"];
					$object->term_taxonomy_id = $value;
					$object->object_type = 'product';
					$database->insertObject("e4_term_relationships", $object, "object_id");

					$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
					WHERE term_taxonomy_id = " . $value . " AND object_type = 'product') WHERE id = " . $value;
					$database->setQuery($query);
					$database->query();
				}
				/** Insert related image list for product */
				$ariacms->delete('e4_posts_image', 'object_id=' . $_REQUEST["id"]);
				for ($i = 1; $i <= count($imagelist); $i++) {
					if ($imagelist[$i]) {
						$query = "INSERT INTO `e4_posts_image`(`object_id`, `image_link`, `order`) VALUES (" . $_REQUEST['id'] . ",'$imagelist[$i]',$i)";
						$database->setQuery($query);
						$database->query();
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
	/** Delete product */
	static function product_delete()
	{
		global $ariacms;
		global $database;
		$id	= $_REQUEST["id"];
		/** Delete post info */
		$ariacms->delete('e4_posts', 'id=' . $id);
		$ariacms->delete('e4_posts_meta', 'post_id=' . $id);
		$taxonomies = $ariacms->selectAll('e4_term_relationships', 'object_id=' . $id . ' AND object_type="product" ', '');
		/** Update taxonomy product related */
		foreach ($taxonomies as $taxonomy) {
			$query = "UPDATE e4_term_taxonomy SET count = (SELECT COUNT(*) total FROM e4_term_relationships 
			WHERE term_taxonomy_id = " . $taxonomy->term_taxonomy_id . " AND object_type = 'product') WHERE id = " . $taxonomy->term_taxonomy_id;
			$database->setQuery($query);
			$database->query();
		}
		$ariacms->delete('e4_term_relationships', 'object_id=' . $id . ' AND object_type="product" ');
		$ariacms->redirect("", "javascript:history.back()");
	}
}
