<?php
class Model
{
	static function detail()
	{
		global $ariacms;
		global $database;
		global $params;
		$task = $ariacms->getParam("task");
		/** Get detail information in e4_posts table */
		$query = "SELECT a.*,b.fullname, d.image, d.{$params->title} as linhvuc, d.nam FROM e4_tapchi a 
			 left	JOIN e4_users b ON a.user_created = b.id 
			 left	JOIN e4_chude c ON a.id_chude = c.id
			 left	JOIN e4_linhvuc d ON d.id = a.id_linhvuc
			WHERE a.url_part = '$task'  
			limit 0,1 "; //echo $query;
		$database->setQuery($query);
		$detail = $database->loadRow();
		
		// tăng views
		
		$row = new stdClass();
		$mydate=getdate(date("U"));
		//print_r($mydate);
		$where = " number_view = number_view + 1,";
		//$where .= 
		$where .= "  view_ngay = view_ngay + 1, ";
		$where .= "  view_tuan = view_tuan + 1, ";
		$where .= "  view_thang = view_thang + 1 ";
		
		 $query = "UPDATE e4_tapchi SET ".$where." WHERE url_part = '$task'";
		//echo $query;
		$database->setQuery($query);
		  if ($database->query()) {
			 // echo "tăng 1";
		  }else{
			 // echo "tăng 2";
		  }
		
		
		$_SESSION['categoryid']= $detail["categoryid"];

        if($detail['type'] == "tapchi") {

            


            // bài liên quan
            $query = "SELECT * From e4_tapchi
			WHERE type = 'tapchi' AND id_linhvuc = ". $detail['id_linhvuc'] ." AND id != ". $detail['id'] ."  
			limit 0,8 "; //echo $query;
            $database->setQuery($query);
            $news = $database->loadObjectList();



            View::detail_news($detail, $news);
        }
        else if($detail['type'] == "post") View::detail_prodcut($detail);
		
	}
}
