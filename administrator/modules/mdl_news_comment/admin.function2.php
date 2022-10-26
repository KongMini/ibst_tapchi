<?php
class Model
{
	static function news_view_link($row)
	{
		$str = '';
		
		
		$str .= '<a href ="?module=news_comment&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		if($row->state == 0)
		{
			$str .= '<a href ="?module=news_comment&task=news_remove&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-remove" data-toggle="tooltip"  title="Duyệt"></i></a>&nbsp;&nbsp;';
		}
		else if($row->state == 1 or $row->state == 2 )
		{
			$str .= '<a href ="?module=news_comment&task=news_add&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-plus" data-toggle="tooltip"  title="Duyệt"></i></a>&nbsp;&nbsp;';
		}
		

		
		
		
		return $str;
	}

	static function news_view()
	{
		global $database;
		global $ariacms;
		
		$trangthai = "";
		if($_REQUEST['tab'] == 'menu1'){
			$trangthai = " and a.state = 0 ";
		}elseif($_REQUEST['tab'] == 'menu2'){
			$trangthai = " and a.state = 1";
		}elseif($_REQUEST['tab'] == 'menu3'){
			$trangthai = " and a.state = 2";
		}
		
		
		$where = " WHERE 1 = 1  ".$trangthai;


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

		$users = $ariacms->selectAll('e4_users', '', '');
		View::news_view($news, $totalRows['total'], $maxRows, $curPg, $users);
	}

	static function news_add()
	{
		global $database;
		global $ariacms;
		
		$id = $_REQUEST["id"];
		
		$reviewer_id =  $_SESSION["user"]['id'];
		$date_riview = '"'.date('Y-m-d').'"';		
		$query = "UPDATE e4_post_comment SET state=0,
											 reviewer_id = ".$reviewer_id.
											 ",date_review = ".$date_riview.
											 " WHERE id = ".$id;
		$database->setQuery($query);
		$database->query();		
		$ariacms->redirect("", "javascript:history.back()");
	}


	static function news_remove()
	{
		global $database;
		global $ariacms;
		
		$id = $_REQUEST["id"];
		
		$reviewer_id =  $_SESSION["user"]['id'];
		$date_riview = '"'.date('Y-m-d').'"';		
		$query = "UPDATE e4_post_comment SET state=2,
											 reviewer_id = ".$reviewer_id.
											 ",date_review = ".$date_riview.
											 " WHERE id = ".$id;
		$database->setQuery($query);
		$database->query();		
		$ariacms->redirect("", "javascript:history.back()");
	}

	static function news_delete()
	{
		global $ariacms;
		global $database;
		$id	= $_REQUEST["id"];
		
		$ariacms->delete('e4_post_comment', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
