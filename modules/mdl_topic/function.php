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
		//$limit = " LIMIT " . $curRow . "," . $maxRows1 . " ";
		$query = "SELECT COUNT(*) total FROM e4_linhvuc WHERE status='active'";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
        
		$count = $totalRows['total'];


        $query = "SELECT nam FROM `e4_linhvuc` GROUP BY nam ORDER BY nam DESC;";
        $database->setQuery($query);
        $nam = $database->loadObjectList();

		$query = "SELECT * FROM e4_linhvuc 
			
			WHERE status = 'active' and time_end < ".time()." 
			order by id asc ";
		$database->setQuery($query);
		$news = $database->loadObjectList();
		View::news_list($news, $nam,$count,$maxRows1);
	}
	public static function news_taxonomy()
	{
		global $ariacms;
		global $database;

		$task = $ariacms->getParam("task");
	//	echo "xxxxxxxx".$task ;
		/** Get category information */
		$query = "SELECT a.*  FROM e4_linhvuc a 
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
		$query = "SELECT * FROM `e4_tapchi` WHERE type = 'tapchi' AND id_linhvuc = ". $category['id'] ."  AND post_status = 'active' order by id asc ";
		//echo $query;
		$database->setQuery($query);
		$news = $database->loadObjectList();

        $query = "SELECT * FROM `e4_linhvuc` WHERE id = ". $category['id'] ;
        //echo $query;
        $database->setQuery($query);
        $detail = $database->loadRow();
		
		View::news_taxonomy($news,$detail, $category,$count,$maxRows1 );
	}
}
