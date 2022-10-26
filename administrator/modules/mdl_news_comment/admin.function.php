<?php
class Model
{
	static function news_view_link($row)
	{
		$str .= '<input type="checkbox" class="vitri" name="vitri[]" id="vitri_'. $row->id.'" value="'.$row->id .'"/>&nbsp;&nbsp;';
		return $str;
	}

	static function news_view()
	{
		global $database;
		global $ariacms;
		
		$trangthai = $where3 = $where1 = "";
		if($_REQUEST['tab'] == 'menu1'){
			$trangthai = " and a.state = 0 ";
		}elseif($_REQUEST['tab'] == 'menu2'){
			$trangthai = " and a.state = 1 ";
		}elseif($_REQUEST['tab'] == 'menu3'){
			$trangthai = " and a.state = 2 ";
		}
		else{
			$_REQUEST['tab'] = 'menu1';
			$trangthai = " and a.state = 0 ";
		}
		
		// điều kiện 1:  người duyệt
		if($_REQUEST['user_created']){
			$user_created = $_REQUEST['user_created'];
			if($user_created != ""){
				$where1 = " and a.user_cmt = '".$user_created."'";
			}	
		}		
		// điều kiện 3: keysearch:
		if($_REQUEST['keysearch']){
			$keysearch = $_REQUEST['keysearch'];
			if($keysearch != ""){
				$where3 = " and b.title_vi like  '%$keysearch%'";
			}	
		}
		$where = " WHERE b.post_status = 'active'   ".$trangthai.$where3.$where1;


		$order = ' order by a.id desc';
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . ",".$maxRows . " ";
	
		$query = "SELECT a.* , b.title_vi,c.fullname
		FROM e4_post_comment a
			LEFT JOIN e4_posts b ON b.id = a.post_id
			LEFT JOIN e4_users c On c.id = a.reviewer_id " .$where . $order;
			
			
		$database->setQuery($query);
		$news = $database->loadObjectList();

		$query = "SELECT COUNT(*) total FROM e4_post_comment a ".$where;
		$database->setQuery($query);
		$totalRows = $database->loadRow();

		$query = "SELECT user_cmt FROM e4_post_comment GROUP by user_cmt";
		$database->setQuery($query);
		$users = $database->loadObjectList();
		
		View::news_view($news, $totalRows['total'], $maxRows, $curPg, $users);
	}

	static function news_add()
	{
		global $database;
		global $ariacms;
		
		$vitri = implode(',',$_REQUEST["vitri"]);
		$reviewer_id =  $_SESSION["user"]['id'];
		$date_riview = time();		
		$query = "UPDATE e4_post_comment SET state=0,
											 reviewer_id = ".$reviewer_id.
											 ",date_review = ".$date_riview.
											 " WHERE id in (".$vitri.")";
		$database->setQuery($query);
		$database->query();		
		
				
		$query = "UPDATE e4_posts a SET 
									a.number_comment = (SELECT COUNT(b.id) FROM e4_post_comment b 
										WHERE b.state = 0 and a.id = b.post_id and b.id in (".$vitri."))" ;
		$database->setQuery($query);
		$database->query();	
		//echo $query; die;
		$ariacms->redirect("", "javascript:history.back()");
	}


	static function news_edit()
	{
		global $database;
		global $ariacms;
		// lấy cái bài viết đã được check
		$vitri = implode(',',$_REQUEST["vitri"]);
		$reviewer_id =  $_SESSION["user"]['id'];
		$date_riview = time();		
		$query = "UPDATE e4_post_comment SET state=2,
											 reviewer_id = ".$reviewer_id.
											 ",date_review = ".$date_riview.
											 " WHERE id in (".$vitri.")";
		$database->setQuery($query);
		$database->query();		
		
		
		$query = "UPDATE e4_posts a SET 
									a.number_comment = (SELECT COUNT(b.id) FROM e4_post_comment b 
										WHERE b.state = 0 and a.id = b.post_id and b.id in (".$vitri."))" ;
									;
		$database->setQuery($query);
		$database->query();	
		//xecho $query; die;
		
		$ariacms->redirect("", "javascript:history.back()");
	}

	static function news_delete()
	{
		global $ariacms;
		global $database;
		$vitri = implode(',',$_REQUEST["vitri"]);
		$ariacms->delete('e4_post_comment', 'id in (' . $vitri . ')');
		$query = "UPDATE e4_posts a SET 
									a.number_comment = (SELECT COUNT(b.id) FROM e4_post_comment b 
										WHERE b.state = 0 and a.id = b.post_id and b.id in (".$vitri."))" ;
		$database->setQuery($query);
		$database->query();	
		$database->query();	
		$ariacms->redirect("", "javascript:history.back()");
	}
}
