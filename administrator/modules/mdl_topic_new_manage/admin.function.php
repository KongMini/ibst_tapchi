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
		
		$where = $where2 = $where3 = "";
		
		$keysearch = $_REQUEST['keysearch'];
		
		$category = $_REQUEST['category'];
		
		// điều kiện 3: keysearch:
		if($_REQUEST['keysearch']){
			$keysearch = $_REQUEST['keysearch'];
			if($keysearch != ""){
				$where3 = " and  a.title_vi like  '%$keysearch%'";
			}	
		}

		$where = " WHERE a.post_status = 'active' ".$where3;
		//===================END====================
		$order = ' order by a.iorder asc,a.id desc';

		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		
		$query = "SELECT a.*, c.fullname,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved FROM e4_posts a 
		JOIN e4_users c ON a.user_created = c.id
		JOIN e4_term_relationships d ON d.object_id = a.id ".$where ." and d.term_taxonomy_id = ".$category." GROUP BY a.id  order by a.aproved_date DESC".$limit;
		//echo $query;
		
		$database->setQuery($query);
		$news = $database->loadObjectList();

		$query = "SELECT COUNT(*) total FROM e4_posts a JOIN e4_term_relationships d ON d.object_id = a.id WHERE a.post_status = 'active' and d.term_taxonomy_id = ".$category."";
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
	
	static function news_hot()
	{
		global $database;
		global $ariacms;
		
		$id_topic = $_REQUEST["topic"]; // ID topic duoc chon
		$array_baiviet = $_REQUEST["vitri"]; // Id bai viet
		$txt_topicid = $_REQUEST["txt_topicid"]; // Chuoi id topic
		
		$str_baiviet = implode(',',$array_baiviet);
		/*
		$query = "UPDATE e4_term_relationships SET object_type = 'topic' where term_taxonomy_id in (".$txt_topicid.")";
		$database->setQuery($query);
		$database->query();
		*/
		// Xóa tất cả chủ đề của bài viết hiện tại
		$ariacms->delete('e4_term_relationships', "object_id in (".$str_baiviet.") and term_taxonomy_id in (".$txt_topicid.")");
		
		// Thêm mới vào
		if($id_topic > 0){
			foreach($array_baiviet as $baiviet){
				$object = new stdClass;
				$object->object_id = $baiviet;
				$object->term_taxonomy_id = $id_topic;
				$object->object_type = 'topic';
				$object->term_order = 2;
				$database->insertObject("e4_term_relationships", $object, "object_id");
			}
		}
		
		$ariacms->redirect("Cập nhật chủ đề bài viết thành công", "index.php?module=topic_news");
		
	}
	
	// Cập nhật vị trí tin
	static function news_update()
	{
		
		global $database;
		global $ariacms;
		
		$array_iorder = $_REQUEST["iorder"];
		$category = $_REQUEST["keyword"];
		//print_r($array_iorder);die;
		
		$remove = $_REQUEST["hid_remove"];
		$topic_id = $_REQUEST["topic_id"];
		if($remove == "1" && $topic_id > 0){
			$array_vitri = $_REQUEST["vitri"];			
			$str_vitri = implode(',',$array_vitri);
			$ariacms->delete('e4_term_relationships', "object_id in (".$str_vitri.") and term_taxonomy_id =".$topic_id);
			
			$ariacms->redirect("Gỡ tin theo chủ đề thành công", "index.php?module=topic_news&task=news_view&category=".$category);
		}
		
		$i=0;
		foreach($array_iorder as $id_post => $position){
			$i++;
			$query = "UPDATE e4_posts SET torder = ".$i." WHERE id = ".$id_post;
			$database->setQuery($query);
			$database->query();
		}
		
		$ariacms->redirect("Cập nhật vị trí thành công", "index.php?module=topic_news&task=news_view&category=".$category);
	}
	
	
	static function news_edit()
	{
		global $database;
		global $ariacms;
		
			//echo $_REQUEST['id'];
			$query = "UPDATE e4_posts SET news_position = 0 WHERE id = ".$_REQUEST['id'];
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("", "index.php?module=topic_news");
		
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
