<?php
class Model
{
	static function news_view_link($row)
	{
		$str = '';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news/ajax.news_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=news&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		if($row->post_status == 'active'){
			$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',1)"><i class="fa fa-ban" title="Gỡ bài" aria-hidden="true"></i></a>&nbsp;&nbsp;';
		}else {
			$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',0)"><i class="fa fa-thumbs-up" title="Xuất bản" aria-hidden="true"></i></a>&nbsp;&nbsp;';
		}
		return $str;
	}

	static function news_view()
	{
		global $database;
		global $ariacms;
		
		// xử lý form tìm kiếm
		//=================BEGIN====================
		
		$where = $where1 = $where2 = $where3 = $where4 = $where5 = $where6 = $trangthai = "";
	
		$keysearch = $_REQUEST['keysearch'];
		$user_review = $_REQUEST['user_review'];
		$category = $_REQUEST['category'];
		$post_status = $_REQUEST['post_status'];
		$post_type = $_REQUEST['post_type'];
		
		$query_status = " a.post_status = '".$post_status."' ";
		// điều kiện 1:  người duyệt
		if($_REQUEST['user_review']){
			$user_review = $_REQUEST['user_review'];
			if($user_review != ""){
				$where1 = "and a.user_aproved = ".$user_review;
			}	
		}
		// điều kiện 2:  danh mục
		if($_REQUEST['category']){
			$category = $_REQUEST['category'];
			if($category != ""){
				$where2 = " and c.category like '%$category%'";
			}	
		}	
		// điều kiện 3: keysearch:
		if($_REQUEST['keysearch']){
			$keysearch = $_REQUEST['keysearch'];
			if($keysearch != ""){
				$where3 = " and a.title_vi like  '%$keysearch%'";
			}	
		}

		// điều kiện 4: Vị trí tin
		if(isset($_REQUEST['vitri'])){
			$vitri = $_REQUEST['vitri'];
			if($vitri !== ""){
				//echo $vitri; die;
				$where4 = " and a.news_position =".$vitri;
			}
		}
		
		// điều kiện 5: trạng thái 
		if($_REQUEST['date_post']){	
			$date_post1 = $_REQUEST['date_post'];
			if($date_post1 != ""){
				$date_post = strtotime(str_replace('/','-',$date_post1 .' 00:00:00'));
				$date_post2 = strtotime(str_replace('/','-',$date_post1.' 23:59:59'));
				$where5 = " and a.post_created >= ".$date_post." and a.post_created <=".$date_post2;
			}
		}
		// điều kiện 6: người tạo
		if($_REQUEST['user_created']){
			$user_created = $_REQUEST['user_created'];
			if($user_created != ""){
				$where6 = " and a.user_created = ".$user_created;
			}	
		}
		
		if($_REQUEST['tab'] == 'home'){
			$trangthai = " and a.post_status = 'waiting'";
		}elseif($_REQUEST['tab'] == 'menu1'){
			$trangthai = " and a.post_status = 'active'";
		}elseif($_REQUEST['tab'] == 'menu2'){
			$trangthai = " and a.post_status = 'deactive'";
		}elseif($_REQUEST['tab'] == 'menu3'){
			$trangthai = " and a.post_status = 'lock'";
		}else{
			$_REQUEST['tab'] = 'home';
			$trangthai = " and a.post_status = 'waiting'";
		}
	
		$where = $trangthai.$where1.$where2.$where3.$where4.$where5.$where6 ;
		//===================END====================
		$order = ' order by a.id desc';

		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";

		$query = "SELECT a.*, b.fullname, c.category, d.tags,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
		FROM e4_posts a
			LEFT JOIN e4_users b ON a.user_created = b.id 
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'category' GROUP BY t1.object_id
				) c ON a.id = c.object_id
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS tags
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'post_tags' GROUP BY t1.object_id
				) d ON a.id = d.object_id
		WHERE post_type = 'post' " . $where . $order . $limit;
		
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		$query = "SELECT COUNT(*) total FROM e4_posts a WHERE a.post_type = 'post'".$where;
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		
		$users = $ariacms->selectAll('e4_users', '', '');
		View::news_view($news, $totalRows['total'], $maxRows, $curPg, $users,$taxonomies);
	}

	static function news_add()
	{
		global $database;
		global $ariacms;
		
		if ($_POST["submit"] == "news_add") {
			$taxonomy = $_REQUEST["taxonomy"];	
			unset($_REQUEST["taxonomy"]);
			$row = new stdClass;
			$row->id 		= NULL;
			$row->post_created = time();
			$row->user_created = $_SESSION["user"]['id'];
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
			
			if ($post_id = $database->insertObject('e4_posts', $row, 'id')) {
				
				
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
				
				
				$object = new stdClass;
				foreach ($taxonomy as $key => $value) {
					$object->object_id = $post_id;
					$object->term_taxonomy_id = $value;
					$object->object_type = 'post';
					$database->insertObject("e4_term_relationships", $object, "object_id");
					
					/** Update count for term_taxonomy when post created */
					
					$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
					WHERE term_taxonomy_id = " . $value . " AND object_type = 'post') WHERE id = " . $value;
					$database->setQuery($query);
					$database->query();
				}
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function news_edit()
	{
		global $database;
		global $ariacms;
		
		//echo $_REQUEST["submit"]; die;
		
		if ($_REQUEST["submit"] != "") { // Cập nhật bài viết
			
			$taxonomy = $_REQUEST["taxonomy"];
			unset($_REQUEST["taxonomy"]);
			
			$row = new stdClass;
			$row->id 		= $_GET['id'];
			$row->post_modified = time();
			$row->aproved_date = time();
			$row->user_aproved =$_SESSION["user"]['id'];
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
			
			if ($_REQUEST["submit"] == "gobaidang") { // Gỡ bài đăng
				$row->post_status = 'lock';
			}else if ($_REQUEST["submit"] == "xuatban") { // Xuất bản
				$row->post_status = 'active';
			}else if ($_REQUEST["submit"] == "choxuly") { // Chờ xử lý
				$row->post_status = 'waiting';
			}else if ($_REQUEST["submit"] == "tuchoi") { // Từ chối đăng
				$row->post_status = 'deactive';
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
				$ariacms->delete('e4_term_relationships', 'object_id=' . $_REQUEST["id"] . ' AND object_type = "post" ');
				$object = new stdClass;
				foreach ($taxonomy as $key => $value) {
					$object->object_id = $_REQUEST["id"];
					$object->term_taxonomy_id = $value;
					$object->object_type = 'post';
					$database->insertObject("e4_term_relationships", $object, "object_id");

					$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
					WHERE term_taxonomy_id = " . $value . " AND object_type = 'post') WHERE id = " . $value;
					$database->setQuery($query);
					$database->query();
				}
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function news_delete()
	{
		global $ariacms;
		global $database;
		$id	= $_REQUEST["id"];
		$ariacms->delete('e4_posts', 'id=' . $id);
		$ariacms->delete('e4_posts_meta', 'post_id=' . $id);
		$taxonomies = $ariacms->selectAll('e4_term_relationships', 'object_id=' . $id . ' AND object_type="post" ', '');
		foreach ($taxonomies as $taxonomy) {
			$query = "UPDATE e4_term_taxonomy SET count = (SELECT COUNT(*) total FROM e4_term_relationships 
			WHERE term_taxonomy_id = " . $taxonomy->term_taxonomy_id . " AND object_type = 'post') WHERE id = " . $taxonomy->term_taxonomy_id;
			$database->setQuery($query);
			$database->query();
		}
		$ariacms->delete('e4_term_relationships', 'object_id=' . $id . ' AND object_type="post" ');
		$ariacms->redirect("", "javascript:history.back()");
	}
}
