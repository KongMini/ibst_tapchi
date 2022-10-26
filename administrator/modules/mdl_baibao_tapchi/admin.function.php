<?php
class Model
{
	static function news_view_link($row)
	{
		global $ariacms;
		$url = $ariacms->actual_link . 'chi-tiet/' . $row->url_part . '.html';
		$str = '';
		$str .= '<a target="_blank" href="https://developers.google.com/speed/pagespeed/insights/?hl=vi&url='.$url.'&tab=mobile"><i class="fa fa-tachometer"></i></a>&nbsp;&nbsp;';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news/ajax.news_view.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		//$str .= '<a href ="?module=news&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		if($row->post_status == 'active'){
			$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',1)"><i class="fa fa-ban" title="Gỡ bài" aria-hidden="true"></i></a>';
		}else {
			$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',0)"><i class="fa fa-thumbs-up" title="Xuất bản" aria-hidden="true"></i></a>';
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
		if($_REQUEST['chude']){
			$category = $_REQUEST['chude'];
			if($category != ""){
				//$where2 = " and c.category like '%$category%'";
				$where2 = " and d.id = '$category'";
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
		if(isset($_REQUEST['linhvuc'])){
			$vitri = $_REQUEST['linhvuc'];
			if($vitri !== ""){
				//echo $vitri; die;
				$where4 = " and c.id =".$vitri;
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
		
		//echo "AAAAA".$_SESSION['user']['role_type'];
		
		if($_SESSION['user']['role_type'] != 'ADMIN' && $_SESSION['user']['role_type'] != 'CHECK'){
			$where6 = " and a.user_created = ".$_SESSION['user']['id'];
			$users = $ariacms->selectAll('e4_users', 'id='.$_SESSION['user']['id'], '');
		}else{
			$users = $ariacms->selectAll('e4_users', '', '');
		}
		
		if($_REQUEST['tab'] == 'home'){
			$trangthai = " and a.post_status = 'waiting'";
		}elseif($_REQUEST['tab'] == 'menu1'){
			$trangthai = " and a.post_status = 'active'";
		}elseif($_REQUEST['tab'] == 'menu2'){
			$trangthai = " and a.post_status = 'deactive'";
		}elseif($_REQUEST['tab'] == 'menu3'){
			$trangthai = " and a.post_status = 'lock'";
		}elseif($_REQUEST['tab'] == 'menu4'){
				$trangthai = " and a.post_status = 'choduyet'";
		}
		elseif($_REQUEST['tab'] == 'menu5'){
			$trangthai = " and a.post_status = 'tralai'";
		}
		else{
			$_REQUEST['tab'] = 'home';
			$trangthai = " and a.post_status = 'waiting'";
		}
	
		$where = $trangthai. $where1. $where2. $where3. $where4. $where5. $where6;
		//===================END====================
		$order = ' order by a.aproved_date desc';

		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		
		// if($_REQUEST['tab'] == 'menu4'){
			// $query = "SELECT a.*, b.fullname
			// FROM e4_posts a
				// LEFT JOIN e4_users b ON a.user_created = b.id
			// WHERE post_type = 'member' and post_status='waiting' " . $order . $limit;
		// }else{
		$query = "SELECT a.*, b.fullname, c.title_vi as linhvuc, c.nam, d.title_vi as chude FROM `e4_tapchi` a 
                        LEFT JOIN e4_users b ON a.user_created = b.id
                        LEFT JOIN e4_linhvuc c ON a.id_linhvuc = c.id
                        LEFT JOIN e4_chude d ON d.id = a.id_chude Where  a.type = 'tapchi' " . $where  . $limit;
		// }
		//echo $query;die;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		/**/
		$query = "SELECT a.* FROM `e4_tapchi` a  WHERE  a.type = 'tapchi' ".$where;
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		$totalNews=$totalRows['total'];
		View::news_view($news, $totalNews, $maxRows, $curPg, $users);
	}
	
	static function news_publish()
	{
		global $database;
		global $ariacms;
		
		// xử lý form tìm kiếm
		//=================BEGIN====================
		
		$where = $where1 = $where2 = $where3 = $where4 = $where5 = $where6 = $where7= $trangthai = "";
	
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
				//$where2 = " and c.category like '%$category%'";
				$where2 = " and c.category_id = '$category'";
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
		
		// điều kiện 5: ngay
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
		if($post_type == "all" or $post_type == ""){
			$where7 = "";
		}else{
			$where7 = " and a.post_type = '".$post_type."'" ;
		}
		
		if($_SESSION['user']['role_type'] != 'ADMIN' && $_SESSION['user']['role_type'] != 'CHECK'){
			$where6 = " and a.user_created = ".$_SESSION['user']['id'];
			$users = $ariacms->selectAll('e4_users', 'id='.$_SESSION['user']['id'], '');
		}else{
			$users = $ariacms->selectAll('e4_users', '', '');
		}
		
		$where = $where1.$where2.$where3.$where4.$where5.$where6.$where7 ;
		//===================END====================
		$order = ' order by a.aproved_date desc';

		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		/*
		$query = "SELECT a.*, b.fullname, c.category, d.tags,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
		FROM e4_posts a
			LEFT JOIN e4_users b ON a.user_created = b.id 
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category, t2.id as category_id
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'category' GROUP BY t1.object_id
				) c ON a.id = c.object_id
			LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS tags, t2.id as tags_id
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'post_tags' GROUP BY t1.object_id
				) d ON a.id = d.object_id
		WHERE a.post_status = 'active' " . $where . $order . $limit;
		*/
		$query = "SELECT a.*, b.fullname, c.title_vi as linhvuc, d.title_vi as chude FROM `e4_tapchi` a 
                        LEFT JOIN e4_users b ON a.user_created = b.id
                        LEFT JOIN e4_linhvuc c ON a.id_linhvuc = c.id
                        LEFT JOIN e4_chude d ON d.id = a.id_chude Where  1 = 1 " . $where . $order . $limit;
		
		//echo $query;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		/**/$query = "SELECT COUNT(a.id) total FROM e4_posts a WHERE a.post_status = 'active'".$where;
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		
		//$totalNews=count($news);
		$totalNews=$totalRows['total'];
		View::news_publish($news, $totalNews, $maxRows, $curPg, $users);
	}
	
	static function news_add()
	{
		global $database;
		global $ariacms;
		
		if ($_POST["submit"] != "") {
			$row = new stdClass;
			$row->id 		= NULL;
			$row->post_created = time();
			$row->user_created = $_SESSION["user"]['id'];
			$row->url_part =  $ariacms->utf8ToUrl($_POST['title_vi']);
			
			$row_history = new stdClass;
			$row_history->id 		= NULL;
			$row_history->post_created = time();
			$row_history->user_created = $_SESSION["user"]['id'];
			
			foreach ($_POST as $key => $value) {
				if ($key != "submit") {
					if ($key != 'url_part') {
						$row->$key = $value;
						$row_history->$key = $value;
					} 
					else if($key == "hinhanh"){
						
					}
					
					else{
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
						$row_history->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
					}
				}
			}
			$link = "index.php?module=tapchi&tab=home";
			//if($_SESSION['user']['role_type'] !="ADMIN"){
				if ($_REQUEST["submit"] == "xuatban") { // Gỡ bài đăng
					$link = "index.php?module=tapchi&tab=home";
					$row->post_status = 'waiting';
				}else if ($_REQUEST["submit"] == "choduyet") { // Chờ xử lý
					$row->post_status = 'choduyet';
					$link = "index.php?module=tapchi&tab=menu4";
				}
				//$row->post_status = 'waiting';
			//}
			//$row->meta_title = $_POST['title_vi'];
			//print_r($row);die;
			if ($post_id = $database->insertObject('e4_tapchi', $row, 'id')) {
			
				$row_history->id_post = $post_id;
				$row_history->action = 'add';
				
				//// Nhuan but
				if($_REQUEST["post_status"] == "active" and $_REQUEST["nhuanbut"] > 0){
					
					$query = "SELECT id FROM e4_royalties a WHERE a.post_id = ".$post_id;
					$database->setQuery($query);
					$totalRows = $database->loadRow();
					if(count($totalRows) == 0){
							
						// lấy nhuận bút
						$row_royalties = new stdClass;
						$row_royalties->id = NULL;
						$row_royalties->post_id = $post_id;
						$row_royalties->user_id = $_SESSION["user"]['id'];
						$row_royalties->price = $_REQUEST["nhuanbut"];
						$row_royalties->date_created = time();
					
						$database->insertObject('e4_royalties', $row_royalties, 'id');
					}
					
				}
				
				$database->insertObject('e4_posts_history', $row_history, 'id');
				
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
				$ariacms->redirect("", $link);
			} else {
				echo $database->stderr();
			}
		} else {
			//$ariacms->redirect("", "javascript:history.back()");
			View::news_add();
		}
	}


	static function move_file($file, $to){
		$path_parts = pathinfo($file);
		$newplace   = "$to/{$path_parts['basename']}";
		if(rename($file, $newplace))
			return $newplace;
		return null;
	}
	
	static function news_edit()
	{
		global $database;
		global $ariacms;
		
		$part_url = "http://127.0.0.1:8083/";
		$part_urls = "https://127.0.0.1:8083/";

		if ($_REQUEST["submit"] != "") { // Cập nhật bài viết
			
			$row = new stdClass;
			$row->id 		= $_GET['id'];
			$row->time_edited = time();

			$row->user_edited =$_SESSION["user"]['id'];
			$row_history = new stdClass;
			$row_history->id = NULL;
			$row_history->action = 'edit';
			$row_history->id_post = $_GET['id'];
			$row_history->user_created = $_SESSION["user"]['id'];
			$row_history->post_modified = time();
			$row_history->user_modified = $_SESSION["user"]['id'];
			
			foreach ($_POST as $key => $value) {
				if ($key != "submit") {
					if ($key == 'url_part') {
						$row->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
						$row_history->$key = ($value == '') ? $ariacms->utf8ToUrl($_POST['title_vi']) : $value;
						
					}else if($key == 'time_edited'){
						//echo $key . "-".$value;die;
						$row->$key = strtotime($value);
					} 
					else {
						
						$row->$key = $value;
						$row_history->$key = $value;
					}
				}
			}
			$link ="index.php?module=tapchi";
			if($_SESSION['user']['role_type'] == "ADMIN"){
				if ($_REQUEST["submit"] == "gobaidang") { // Gỡ bài đăng
					$link = "index.php?module=tapchi&tab=menu3";
					$row->post_status = 'lock';
				}else if ($_REQUEST["submit"] == "xuatban") { // Xuất bản
					$taxonomy = $_REQUEST["taxonomy"];
					$relation = $_REQUEST["relation"];
					$relation = implode(',', $relation);
					unset($_REQUEST["taxonomy"]); unset($_REQUEST["relation"]);
					$link = "index.php?module=tapchi&tab=menu1";
					$row->post_status = 'active';
				}else if ($_REQUEST["submit"] == "choxuly") { // Chờ xử lý
					$row->post_status = 'waiting';
					$link = "index.php?module=tapchi&tab=home";
				}else if ($_REQUEST["submit"] == "tuchoi") { // Từ chối đăng
					$row->post_status = 'deactive';
					$link = "index.php?module=tapchi&tab=menu2";
				}else if ($_REQUEST["submit"] == "tralai") { // Từ trả lại
					$row->post_status = 'tralai';
					$link = "index.php?module=tapchi&tab=menu5";
				}
			}else if($_SESSION['user']['role_type'] == "CHECK"){
				if ($_REQUEST["submit"] == "gobaidang") { // Gỡ bài đăng
					$row->post_status = 'lock';
					$link = "index.php?module=tapchi&tab=menu3";
				}else if ($_REQUEST["submit"] == "choxuly") { // Chờ xử lý
					$row->post_status = 'waiting';
				}else if ($_REQUEST["submit"] == "tuchoi") { // Từ chối đăng
					$row->post_status = 'deactive';
					$link = "index.php?module=tapchi&tab=menu2";
				}else if ($_REQUEST["submit"] == "tralai") { // Từ trả lại
					$row->post_status = 'tralai';
					$link = "index.php?module=tapchi&tab=menu5";
					
				}
			}
			
//			if($_POST['post_type'] == ''){
//				$row->post_type = 'post';
//			}
			
//			if($row->aproved_date !=''){
//				$row->aproved_date = strtotime($row->aproved_date);
//			}else{
//				$row->aproved_date = time();
//			}
			
			//$row->relation = implode(',',$relation);
			//print_r($row);die;
			if ($database->updateObject('e4_tapchi', $row, 'id')) {
				
				$database->insertObject('e4_posts_history', $row_history, 'id'); // Thêm vào bảng lịch sử thao tác
				
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

				// Nhuan but
				if($row->post_status == 'active' && $row->nhuanbut > 0){
					$query = "SELECT id FROM e4_royalties a WHERE a.post_id = ".$_REQUEST["id"];
					$database->setQuery($query);
					$totalRows = $database->loadRow();
					if(count($totalRows) == 0){
						$query1 = "SELECT user_created FROM e4_posts a WHERE a.id = ".$row->id;
						$database->setQuery($query1);
						$nguoitao = $database->loadRow();

						// lấy nhuận bút
						$row_royalties = new stdClass;
						$row_royalties->id = NULL;
						$row_royalties->post_id = $row->id;
						$row_royalties->user_id = $nguoitao['user_created'];
						$row_royalties->price = $row->nhuanbut;
						$row_royalties->date_created = time();

						$database->insertObject('e4_royalties', $row_royalties, 'id');
					}else{
						$query = "UPDATE e4_royalties SET price = ".$row->category_id." WHERE a.post_id = ".$_REQUEST["id"];
						$database->setQuery($query);
						$database->query();
					}
				}else{
					$ariacms->delete('e4_royalties', 'post_id=' . $_REQUEST["id"]);
				}
				
				// Coppy ảnh sang 1 thư mục khác
				$query = "SELECT image,content_vi FROM e4_posts a WHERE a.post_type='member' and a.post_status='active' and a.id =".$_GET['id'];
				$database->setQuery($query);
				$posts = $database->loadRow();
				
				if($posts){
					
					$search = [$part_url,$part_urls];
					$noidungcuoi = $html = $_POST['content_vi'];
					$image = $_POST['image'];
					$match_img = '';
					
					$duongdan_avatar = str_replace($search, '', $image);
					$avatar_new = explode('/',$duongdan_avatar);
					
					copy('../'.$duongdan_avatar, '../upload/advertisement/'.$avatar_new[count($avatar_new)-1]);
					
					preg_match_all('@src="([^"]+)"@', $html , $match_img);  //tìm src="X" or src='X'
					$srcimg = array_pop($match_img);// chuyên list hình sang dạng chuỗi
					
					for($i=0;$i<count($srcimg);$i++){
						if($srcimg[$i]!=''){
							$duongdan_file = str_replace($search, '', $srcimg[$i]);
							$file_new = explode('/',$duongdan_file);
							copy('../'.$duongdan_file, '../upload/advertisement/'.$file_new[count($file_new)-1]);
							$noidungcuoi = str_replace($duongdan_file,'upload/advertisement/'.$file_new[count($file_new)-1], $noidungcuoi);
						}
					}
					
					// Cập nhật lại đường dẫn ảnh
					$capnhatlai = new stdClass;
					$capnhatlai->id = $_GET['id'];
					$capnhatlai->image = $part_url.'upload/advertisement/'.$avatar_new[count($avatar_new)-1];
					$capnhatlai->content_vi = $noidungcuoi;
					$database->updateObject('e4_posts', $capnhatlai, 'id');
					
				}
				
				$ariacms->redirect("", $link);
			} else {
				echo $database->stderr();
			}
			
		} else {
			View::news_edit();
			//$ariacms->redirect("", "javascript:history.back()");
		}
		
	}
	
	static function news_delete()
	{
		global $ariacms;
		global $database;
		$id	= $_REQUEST["id"];
		
		$query = "SELECT * FROM e4_posts a WHERE a.id =".$id;
		$database->setQuery($query);
		$PostRows = $database->loadRow();
		
		$row_history = new stdClass;
		$row_history->action = 'delete';
		$row_history->id_post = $id;
		foreach($PostRows as $key2 => $value2){
			if(!is_numeric($key2)){
				$row_history->$key2 = $value2;
			}
		}
		
		$row_history->user_modified = $_SESSION["user"]['id'];
		$row_history->id = NULL;
		$database->insertObject('e4_posts_history', $row_history, 'id'); // Thêm vào bảng lịch sử thao tác
		
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
