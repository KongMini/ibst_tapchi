<?php
class Model
{
	static function news_view_link($row)
	{
		$str = '';
		if($_SESSION['user']['role_type'] == "ADMIN" || $_SESSION['user']['role_type'] == "CHECK"){
			$str .= '<input type="checkbox" class="vitri" name="vitri[]" id="vitri_'. $row->id.'" value="'.$row->id .'"/>&nbsp;&nbsp;&nbsp;&nbsp;';
			/*$str .= '<a style="padding-left:10px;cursor:pointer" href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/crawl_news/ajax.crawl_news_review.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Sửa thông tin"></i></a>&nbsp;&nbsp;';
			$str .= '<a style="padding-left:10px;cursor:pointer" href ="?module=crawl_news&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;&nbsp;';*/
			$str .= '<a  style="padding-left:10px;cursor:pointer" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/crawl_news/ajax.crawl_news_review.php\')"><i class="fa fa-plus" data-toggle="tooltip"  title="Duyệt"></i></a>';		
		}
		return $str;
	}
	
	static function news_view_link2($row)
	{
		$str = '';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news/ajax.news_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=news&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		
		if($_SESSION['user']['role_type'] == "ADMIN"){
			if($row->post_status == 'active'){
				$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',1)"><i class="fa fa-ban" title="Gỡ bài" aria-hidden="true"></i></a>';
			}else {
				$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',0)"><i class="fa fa-thumbs-up" title="Xuất bản" aria-hidden="true"></i></a>';
			}
		}
		
		return $str;
	}
	

	static function news_view()
	{
		global $database;
		global $ariacms;
		//echo $_SESSION['user']['id'];die;
		$post_type = $_REQUEST['post_type'];
		//echo $post_type;
		$keysearch = $_REQUEST['keysearch'];
		$where3 = $where2 = '';
		if($keysearch !=''){
			$where3 = " and a.title_vi like '%".$keysearch."%'" ;
		}
		
		$order = ' order by a.aproved_date desc';

		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		
		if($post_type == "all" or $post_type == ""){
			$where7 = $where=" ";$where1 = " ";
		}else{
			$where = " and a.post_type = '".$post_type."'" ;
			$where1 = " and a.post_type = '".$post_type."'" ;
		}
		if($_REQUEST['category']){
			$category = $_REQUEST['category'];
			if($category > 0){
				$where2 = " and c.category_id = '$category'";
			}
		}	
		if($_REQUEST['tab'] == 'menu1'){
			$trangthai = " and a.post_status = 'active'";
		}elseif($_REQUEST['tab'] == 'menu2'){
			$trangthai = " and a.post_status = 'deactive'";
		}elseif($_REQUEST['tab'] == 'menu3'){
			$trangthai = " and a.post_status = 'lock'";
		}elseif($_REQUEST['tab'] == 'home'){
			$where7 = "and a.post_status = 'active'";
		}elseif($_REQUEST['tab'] == 'menu5'){
			$_REQUEST['tab'] = 'menu5';
			$where7 = "and a.post_status != 'active'";
		}else{
			$_REQUEST['tab'] = 'menu4';
			$trangthai = " and a.post_status = 'waiting'";
		}
		$where4 = $where5 = '';
		// điều kiện 5: trạng thái 
		if($_REQUEST['date_post']){	
			$date_post1 = $_REQUEST['date_post'];
			if($date_post1 != ""){
				$date_post = strtotime(str_replace('/','-',$date_post1 .' 00:00:00'));
				$date_post2 = strtotime(str_replace('/','-',$date_post1.' 23:59:59'));
				$where5 = " and a.post_created >= ".$date_post." and a.post_created <=".$date_post2;
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
		
		if(!isset($_REQUEST['tab']) || $_REQUEST['tab'] == 'home' || $_REQUEST['tab'] == 'menu5'){
			
			$query = "SELECT *,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved FROM e4_post_crawler a where 1=1 ".$where.$where7.$where3.$order . $limit;
			$database->setQuery($query);
			$news = $database->loadObjectList();

			$query1 = "SELECT COUNT(*) total FROM e4_post_crawler a where 1=1 ".$where.$where7.$where3;
			$database->setQuery($query1);
			$totalRows = $database->loadRow();

		}else{
			
			$query = "SELECT a.*, b.fullname, c.category,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
			FROM e4_posts a
				LEFT JOIN e4_users b ON a.user_created = b.id 
				LEFT JOIN ( 
					SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category, t2.id as category_id
					FROM e4_term_relationships t1 
					LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'category' GROUP BY t1.object_id
					) c ON a.id = c.object_id
			WHERE post_type != 'post' " . $where1. $trangthai.$where5.$where4.$where3.$where2. $order . $limit;
			$database->setQuery($query);
			$news = $database->loadObjectList();
			
			$query = "SELECT COUNT(*) total FROM e4_posts a WHERE a.post_type != 'post'".$trangthai.$where5.$where4.$where3;
			$database->setQuery($query);
			$totalRows = $database->loadRow();
			
		}
		
		$users = $ariacms->selectAll('e4_users', '', '');
		View::news_view($news, $totalRows['total'], $maxRows, $curPg, $users);
	}

	static function news_add()
	{
		global $database;
		global $ariacms;
		
		if($_SESSION['user']['role_type'] != "ADMIN" && $_SESSION['user']['role_type'] != "CHECK"){
			$ariacms->redirect("Bạn không có quyền thao tác dữ liệu.", "index.php?module=crawl_news");
		}
		// sau khi duyệt thành công tin thì xóa luôn tin ở bên này
		$id =  $_GET['id'];
		$query = "select * from e4_post_crawler where id =".$id;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		if ($_REQUEST["submit"] == "tuchoi") {
			
			$taxonomy = $_REQUEST["taxonomy"];
			
			unset($_REQUEST["taxonomy"]);
			$row = new stdClass;
			//echo $_GET['id'];die;
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
			//$row->relative =  $relative;
			//$row->post_status = "deactive";
			
			if ($database->updateObject('e4_post_crawler', $row, 'id')) {
				
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
					if($value > 0){
						$object->object_id = $_REQUEST["id"];
						$object->term_taxonomy_id = $value;
						$object->object_type = 'post';
						$object->term_order = $key;
						$database->insertObject("e4_term_relationships", $object, "object_id");

						$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
						WHERE term_taxonomy_id = " . $value . " AND object_type = 'post') WHERE id = " . $value;
						$database->setQuery($query);
						$database->query();
					}
				}
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} if ($_POST["submit"] == "news_add" || $_POST["submit"] == "xuatban") {
			$taxonomy = $_REQUEST["taxonomy"];	
			$relation = $_REQUEST["relation"];
			$relation = implode(',', $relation);
			
			unset($_REQUEST["taxonomy"]);unset($_REQUEST["relation"]);
			
			$row = new stdClass;
			
			$row->id 		= NULL;
			$row->post_created = time();
			$row->user_created = $_SESSION["user"]['id'];
			$row->post_modified = time();
			$row->user_modified = $_SESSION["user"]['id'];
			
			$row_history = new stdClass;
			$row_history->id 		= NULL;
			$row_history->post_created = time();
			$row_history->user_created = $_SESSION["user"]['id'];
			$row_history->post_modified = time();
			$row_history->user_modified = $_SESSION["user"]['id'];
			
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && strlen(strstr($key, 'meta_')) == 0) {
					if ($key != 'url_part') {
						$row->$key = $value;
						$row_history->$key = $value;
					} else {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
						$row_history->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			
			$row->post_type =  $news[0]->post_type;
			$row->relation =  $relation;
			$row_history->post_type =  $news[0]->post_type;
			
			if($_SESSION['user']['role_type'] == "ADMIN"){
				if($_POST["submit"] == "xuatban"){
					$row->post_status = 'active';
					$row->user_aproved = $_SESSION['user']['id'];
					$row_history->post_status = 'active';
					$row_history->user_aproved = $_SESSION['user']['id'];
				}else{
					$row->post_status = 'waiting';
				}
			}else{
				$row->post_status = 'waiting';
			}
			
			if($row->post_status == 'active'){ $row->user_aproved = $_SESSION['user']['id']; }
			
			if($_POST["submit"] == "xuatban"){
				if($row->aproved_date !=''){
					$row->aproved_date = strtotime($row->aproved_date);
				}else{
					$row->aproved_date = time();
				}
			}else{
				$row->aproved_date = 0;
			}
			
			if ($post_id = $database->insertObject('e4_posts', $row, 'id')) {

				$row_history->id_post = $post_id;
				$row_history->action = 'add';
				$database->insertObject('e4_posts_history', $row_history, 'id');
				
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
					if($value > 0){
						$object->object_id = $post_id;
						$object->term_taxonomy_id = $value;
						$object->object_type = 'post';
						$object->term_order = $key;
						$database->insertObject("e4_term_relationships", $object, "object_id");
						
						/** Update count for term_taxonomy when post created */
						
						$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
						WHERE term_taxonomy_id = " . $value . " AND object_type = 'post') WHERE id = " . $value;
						$database->setQuery($query);
						$database->query();
					}
				}
				// xóa luôn bản ghi 
				
				$ariacms->delete('e4_post_crawler', 'id=' . $id);
				
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
		if ($_REQUEST["submit"] == "tuchoi") {
			
			$taxonomy = $_REQUEST["taxonomy"];
			
			unset($_REQUEST["taxonomy"]);
			$row = new stdClass;
			echo $_GET['id'];die;
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
			$row->post_status = "deactive";
			if ($database->updateObject('e4_post_crawler', $row, 'id')) {
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
					if($value > 0){
						$object->object_id = $_REQUEST["id"];
						$object->term_taxonomy_id = $value;
						$object->object_type = 'post';
						$object->term_order = $key;
						$database->insertObject("e4_term_relationships", $object, "object_id");

						$query = "UPDATE e4_term_taxonomy SET COUNT = (SELECT COUNT(*) total FROM e4_term_relationships 
						WHERE term_taxonomy_id = " . $value . " AND object_type = 'post') WHERE id = " . $value;
						$database->setQuery($query);
						$database->query();
					}
				}
				$ariacms->redirect("", "javascript:history.back()");
			} else {
				echo $database->stderr();
			}
		} else {
			$ariacms->redirect("", "index.php?module=crawl_news");
		}
	}
	static function news_delete()
	{
		global $ariacms;
		global $database;
		
		if($_SESSION['user']['role_type'] == "ADMIN" || $_SESSION['user']['role_type'] == "CHECK"){
			$str_baiviet = implode(',',$_REQUEST["vitri"]);		
			// Lay ra tat ca cac bai viet duoc xoa
			
			$query = "SELECT content_vi FROM e4_post_crawler a WHERE a.id in (" . $str_baiviet.")";
			$database->setQuery($query);
			$posts_news = $database->loadObjectList();
			//echo count($posts_news);die;
			
			//$search = ['https://taichinhso.net.vn/','http://taichinhso.net.vn/'];
			$search = ['https://taichinhso.newwaytech.vn/','http://taichinhso.newwaytech.vn/'];
			$srcimg_array = array();
			$match_img = '';
			foreach($posts_news as $posts){
				$html = $posts->content_vi;
				preg_match_all('@src="([^"]+)"@', $html , $match_img);  //tìm src="X" or src='X'
				$srcimg = array_pop($match_img);// chuyên danh sách hình sang dạng chuỗi
				for($i=0;$i<count($srcimg);$i++){
				   if($srcimg[$i]!=''){
					   $duongdan_file = str_replace($search, '', $srcimg[$i]);
					   unlink("../".$duongdan_file);
				   }
				}
			}
			$ariacms->delete('e4_post_crawler', "id in (" . $str_baiviet.")");
			$ariacms->redirect("Xóa dữ liệu thành công", "index.php?module=crawl_news&tab=".$_REQUEST['tab']);		
		}else{
			$ariacms->redirect("Bạn không có quyền thao tác dữ liệu này.", "index.php?module=crawl_news".$_REQUEST['tab']);
		}
	}
	
	static function delete_all()
	{
		global $ariacms;
		global $database;
		
		//echo $_SESSION['user']['role_type'];die;
		
		if($_SESSION['user']['role_type'] == "ADMIN"){
			
			$query = "SELECT content_vi FROM e4_post_crawler a";
			$database->setQuery($query);
			$posts_news = $database->loadObjectList();
			//echo count($posts_news);die;
			
			//$search = ['https://taichinhso.net.vn/','http://taichinhso.net.vn/'];
			$search = ['https://taichinhso.newwaytech.vn/','http://taichinhso.newwaytech.vn/'];
			$srcimg_array = array();
			foreach($posts_news as $posts){
				$html = $posts->content_vi;
				preg_match_all('@src="([^"]+)"@', $html , $match_img);  //tìm src="X" or src='X'
				$srcimg = array_pop($match_img);// chuyên list hình sang dạng chuỗi
				for($i=0;$i<count($srcimg);$i++){
				   if($srcimg[$i]!=''){
					   $duongdan_file = str_replace($search, '', $srcimg[$i]);
					   unlink("../".$duongdan_file);
				   }
				}
			}
			$ariacms->delete('e4_post_crawler', "post_status = 'active'");
			$ariacms->redirect("Xóa dữ liệu thành công", "index.php?module=crawl_news&tab=".$_REQUEST['tab']);		
		}else{
			$ariacms->redirect("Bạn không có quyền thao tác dữ liệu này.", "index.php?module=crawl_news".$_REQUEST['tab']);
		}
	}
}
