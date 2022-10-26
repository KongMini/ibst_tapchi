<?php
class Model
{

	public static function news_list()
	{
		global $database;
		global $ariacms;
		
		$maxRows1 = $ariacms->web_information->posts_per_page; 
   
		if(trim($ariacms->getParaUrl('?curPg')) != '' && trim($ariacms->getParaUrl('?curPg')) != 'undefined'){
			$page = trim($ariacms->getParaUrl('?curPg'));
		}else if($_POST["page"]){
			$page = $_POST["page"];
		}
		else{
			$page =1;
		}

		$curPg = ($page > 0) ? $page : 1;

		$curRow = ($curPg - 1) * $maxRows1;
		$limit = " LIMIT " . $curRow . "," . $maxRows1 . " ";
		$query = "SELECT COUNT(*) total FROM e4_tapchi WHERE type = 'tapchi' AND post_status='active'";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
        
		$count = $totalRows['total'];

		$query = "SELECT a.*, b.fullname FROM e4_tapchi a 
				JOIN e4_users b ON a.user_created = b.id
				JOIN e4_linhvuc c ON a.id_linhvuc=c.id 
				JOIN e4_chude d ON a.id_chude=d.id
			WHERE a.type = 'tapchi' AND a.post_status = 'active'
			order by a.visited_count desc ".$limit;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		View::news_list($news,$count,$maxRows1);
	}
	public static function news_taxonomy()
	{
		global $ariacms;
		global $database;

		$task = $ariacms->getParam("task");
	//	echo "xxxxxxxx".$task ;
		/** Get category information */
		$query = "SELECT a.*, GROUP_CONCAT('',b.id) submenu  FROM e4_chude a 
		LEFT JOIN (SELECT id FROM e4_linhvuc) b ON a.id_linhvuc = b.id 
		WHERE a.url_part = '" . $task . "' AND a.status = 'active' 
		GROUP BY a.id";// echo $query."<br>";
		$database->setQuery($query);
		$category = $database->loadRow();
		
	
	    $maxRows1 = $ariacms->web_information->posts_per_page; 
   
		if(trim($ariacms->getParaUrl('?curPg')) != '' && trim($ariacms->getParaUrl('?curPg')) != 'undefined'){
			$page = trim($ariacms->getParaUrl('?curPg'));
		}else if($_POST["page"]){
			$page = $_POST["page"];
		}
		else{
			$page =1;
		}

		$curPg = ($page > 0) ? $page : 1;

		$curRow = ($curPg - 1) * $maxRows1;
		$limit = " LIMIT " . $curRow . "," . $maxRows1 . " ";
		$query = "SELECT COUNT(*) total FROM e4_tapchi WHERE type = 'tapchi' AND id_chude=(".$category['id'].") AND post_status='active' ";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
        
		$count = $totalRows['total'];
		
		//news
		$query = "SELECT a.*, c.fullname FROM e4_tapchi a 
			JOIN e4_users c ON a.user_created = c.id
			WHERE a.type = 'tapchi' and a.post_status = 'active' and a.id_chude=(".$category['id'].")
		order by a.id desc ".$limit;
		//echo $query;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		View::news_taxonomy($news, $category,$count,$maxRows1 );
	}
}
