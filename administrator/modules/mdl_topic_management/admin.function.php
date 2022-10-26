<?php
class Model
{
	static function news_view_link($row)
	{
		$str = '';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news/ajax.news_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=news&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.')"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>&nbsp;&nbsp;';
		
		return $str;
	}
    static function news_view(){
	global $database;
	global $ariacms;
	
	// xử lý form tìm kiếm
	//=================BEGIN====================
	
	$where = $where1 = $where2 = $where3 = $where4 = $where5 = $where6= $where7 = "";
	
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
			$where1 = " and a.user_aproved=".$user_review;
		}	
	}
	// điều kiện 2:  danh mục
	if($_REQUEST['category']){
		$category = $_REQUEST['category'];
		if($category > 0 and $category != "home"){
			//$where2 = " and c.category like '%$category%'";
			$where2 = " and c.category_id='$category'";
			$order = ' order by a.aproved_date desc';
		}else {
			$where2 = " and a.news_position=2 or a.news_position=1 ";
			$order = ' order by a.iorder asc';
		}
	} else {
		$where2 = " and a.news_position=2 or a.news_position=1 ";
		$order = ' order by a.iorder asc';
	}
	// điều kiện 3: keysearch:
	if($_REQUEST['keysearch']){
		$keysearch = $_REQUEST['keysearch'];
		if($keysearch != ""){
			$where3 = " and  a.title_vi like  '%$keysearch%'";
		}	
	}

	// điều kiện 4: loại tin
	if($_REQUEST['post_type']){	
		$post_type = $_REQUEST['post_type'];
		if($post_type != ""){
			$where4 = " and a.post_type = '".$post_type."'";
		}
	}
	
	// điều kiện 6: người tạo
	if($_REQUEST['user_created']){
		$user_created = $_REQUEST['user_created'];
		if($user_created != ""){
			$where6 = " and a.user_created = ".$user_created;
		}	
	}
	
	$where = " WHERE a.post_status = 'active' ".$where1.$where2.$where3.$where4.$where5.$where6.$where7;
	//===================END====================
	

	$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
	$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : 50;
	$curRow = ($curPg - 1) * $maxRows;
	$limit = " LIMIT " . $curRow . "," . $maxRows . " ";

	$query = "SELECT a.*, b.fullname, c.category, d.tags,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
		FROM e4_posts a
			LEFT JOIN e4_users b ON a.user_created = b.id 
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category, t2.id AS category_id
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'category' GROUP BY t1.object_id
				) c ON a.id = c.object_id
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS tags, t2.id AS tags_id
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'post_tags' GROUP BY t1.object_id
				) d ON a.id = d.object_id
		" . $where . $order . $limit;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		
	$query1 = "SELECT COUNT(*) total,a.id, b.fullname, c.category, d.tags,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
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
		" . $where . $order;
		//$query = "SELECT COUNT(*) total FROM e4_posts a ". $where;
		$database->setQuery($query1);
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
	
	// Remove 
	
	static function remove()
	{
		global $database;
		global $ariacms;
		
		$category2 = $_REQUEST["category2"];
		$array_vitri = $_REQUEST["vitri"];
		
		$str_vitri = implode(',',$array_vitri);
		$query = "UPDATE e4_posts SET news_position = 0 WHERE id in(".$str_vitri.")";
		$database->setQuery($query);
		$database->query();
		
		$ariacms->redirect("Gỡ tin nổi bật bật thành công", "index.php?module=topic_manage");
		
	}
	
	
	static function news_hot()
	{
		global $database;
		global $ariacms;
		
		$category2 = $_REQUEST["category2"];
		$array_vitri = $_REQUEST["vitri"];
		if($_POST["tin_top"]){
			$str_vitri = implode(',',$array_vitri);
			
			$query = "UPDATE e4_posts SET news_position = 2 WHERE id in(".$str_vitri.")";
			
			$database->setQuery($query);
			$database->query();
			
			$ariacms->redirect("Thêm mới tin nổi bật thành công", "index.php?module=topic_manage");
		}

		if($_POST["tin_phai"]){
			$str_vitri = implode(',',$array_vitri);
			
			$query = "UPDATE e4_posts SET news_position = 1 WHERE id in(".$str_vitri.")";
			
			$database->setQuery($query);
			$database->query();
			
			$ariacms->redirect("Thêm mới tin bên phải thành công", "index.php?module=topic_manage");
		}
		
	}
	
	// Cập nhật vị trí tin
	static function news_update()
	{
		
		global $database;
		global $ariacms;
		
		$array_iorder = $_REQUEST["iorder"];
		$remove=$_REQUEST["hid_remove"];
		if($remove=="1"){			
			$array_vitri = $_REQUEST["vitri"];			
			$str_vitri = implode(',',$array_vitri);
			$query = "UPDATE e4_posts SET news_position = 0 WHERE id in(".$str_vitri.")";
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("Gỡ nổi bật thành công", "index.php?module=topic_manage");
		}
		
		//print_r($array_iorder);die;
		//$i = (-1)*count($array_iorder);
		$i = 0;
		foreach($array_iorder as $id_post => $position){
			$i++;
			$query = "UPDATE e4_posts SET iorder = ".$i." WHERE id = ".$id_post;
			$database->setQuery($query);
			$database->query();
		}
		
		$ariacms->redirect("Cập nhật vị trí thành công", "index.php?module=topic_manage");
	}
	
	
	static function news_edit()
	{
		global $database;
		global $ariacms;
		
			//echo $_REQUEST['id'];
			$query = "UPDATE e4_posts SET news_position = 0 WHERE id = ".$_REQUEST['id'];
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("", "index.php?module=topic_manage");
		
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
