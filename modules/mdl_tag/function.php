<?php
class Model
{

	public static function news_list()
	{
		global $database;
		$query = "SELECT a.*, b.fullname FROM e4_posts a 
				JOIN e4_users b ON a.user_created = b.id
			WHERE a.post_type = 'post' AND a.post_status = 'active'
			order by a.id desc ";
		$database->setQuery($query);
		$news = $database->loadObjectList();
		View::news_list($news);
	}
	public static function news_taxonomy()
	{
		global $ariacms;
		global $database;

		$task = $ariacms->getParam("task");
		$maxRows = $ariacms->web_information->posts_per_page; //echo $maxRows;
		
		
		//echo "xxxxxxxx".$task."AAAAAAAAa" ;
		//die;
		/** Get category information */
		$query = "SELECT a.*, GROUP_CONCAT('',b.id) submenu  FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT id, parent FROM e4_term_taxonomy) b ON a.id = b.parent OR a.id = b.id
		WHERE a.url_part = '" . $task . "' AND a.status = 'active' 
		GROUP BY a.id";// echo $query."<br>";
		$database->setQuery($query);
		$category = $database->loadRow();
		/** Get all product with condition filter and store in category */
		
		$news_head = array();
		
		$curRow = ($curPg-1) * $maxRows;
		if($curRow < 0) $curRow = 0;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		
		$query = "SELECT a.*  FROM e4_posts a where a.id in  
			 (SELECT b.object_id FROM e4_term_relationships b
				where term_taxonomy_id IN (" . $category['submenu'] . ") and  b.object_type = 'post')
			and a.post_status = 'active' and a.aproved_date <".time()." order by a.aproved_date desc ".$limit;
		
		//echo $query;
		$database->setQuery($query);
		$news = $database->loadObjectList();
		
		View::news_taxonomy($news, $category,$news_head );
	}
}
