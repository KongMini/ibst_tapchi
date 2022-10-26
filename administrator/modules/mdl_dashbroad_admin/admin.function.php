<?php
class Model
{
	static function index()
	{
		global $database;
		global $ariacms;
		
		
		$time = time() - 2*60;
		// Danh sach dang online
		$query = "SELECT fullname,user_type from e4_users where time >= '$time' order by time desc";
		$database->setQuery($query);
		$useronline = $database->loadObjectList();
		
		$query = "SELECT state,COUNT(id)  as sum FROM `e4_post_comment` GROUP BY state";
		$database->setQuery($query);
		$comment = $database->loadObjectList();
		//print_r($comment);
		
		$query = "SELECT * from e4_views ";
		$database->setQuery($query);
		$row = $database->loadObjectList();
		
		//print_r($_SESSION);
		$user_id = $_SESSION["user"]["id"];
		// top view
			$trangthai = $where = "";
		if($_REQUEST['tab'] == 'menu1'){
			//$trangthai = " and a.state = 0 ";
			$where = " and a.user_created = '$user_id' ";
			$order = ' order by a.view_ngay desc';
		}elseif($_REQUEST['tab'] == 'menu2'){
			//$trangthai = " and a.state = 1 ";
			//$where = " and a.user_created = '$user_id' ";
			$order = ' order by a.view_ngay desc';
		}elseif($_REQUEST['tab'] == 'menu3'){
			$order = ' order by a.view_tuan desc';
			//$trangthai = " and a.state = 2 ";
		}elseif($_REQUEST['tab'] == 'menu4'){
			//$trangthai = " and a.state = 2 ";
			$order = ' order by a.view_thang desc';
		}
		else{
			$_REQUEST['tab'] = 'menu1';
			$trangthai = " and a.state = 0 ";
		}
		
		
		$where = " WHERE a.post_status = 'active'   ".$where;


		
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . ",".$maxRows . " ";
	
	 	$query = "SELECT a.title_vi,a.view_ngay,a.view_tuan,a.view_thang ,c.fullname 
					FROM e4_posts a 
						LEFT JOIN e4_users c On c.id = a.user_created " .$where . $order." limit 10";
			
			
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		
		View::index($useronline,$row,$comment,$news);
	}
}
