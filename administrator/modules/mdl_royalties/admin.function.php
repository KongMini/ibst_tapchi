<?php
class Model
{
	static function news_view_link($row)
	{
		$str = '';

		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/royalties/ajax.news_get.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=royalties&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		return $str;
	}

	static function news_view()
	{
		global $database;
		global $ariacms;
		
		$trangthai = $where3 = $where1 = "";
		
		if($_REQUEST['from'] != ''){
			$sttFrom = strtotime($_REQUEST['from']);
		}else{
			$_REQUEST['from'] = date("Y-m")."-01";
			$sttFrom = strtotime($_REQUEST['from']);
		}
		
		if($_REQUEST['to'] != ''){
			$sttTo = strtotime($_REQUEST['to']. '23:59:59');
		}else{
			$_REQUEST['to'] = date("Y-m-d");
			$sttTo = strtotime($_REQUEST['to']. '23:59:59');
		}
		
		$where = " WHERE a.date_created >= ".$sttFrom." and a.date_created <= ".$sttTo;
		
		$order = ' order by a.id desc';
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . ",".$maxRows . " ";
		
		
		// lấy tất cả các bản ghi 
		$query = "SELECT a.*, b.title_vi ,c.fullname 
			FROM e4_royalties a 
				LEFT JOIN e4_posts b ON b.id = a.post_id 
				LEFT JOIN e4_users c On c.id = a.user_id " .$where . $order;	
		
		$database->setQuery($query);
		$news = $database->loadObjectList();

		// lấy tống sổ dòng
		$query = "SELECT COUNT(*) total FROM e4_royalties a ".$where;
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		
		// lấy những người dùng
		$query = "SELECT fullname FROM e4_users ";
		$database->setQuery($query);
		$users = $database->loadObjectList();
		
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


	static function news_edit()
	{
		global $database;
		global $ariacms;
		
		$id = $_REQUEST["id"];
		
		$price = $_REQUEST["price"];
		$status = $_REQUEST["status"];
		$notice = " ";
		if($_REQUEST["notice"] != "")
			echo $notice = " ,notice = '".$_REQUEST["notice"]."'";
		
		
		echo $query = "UPDATE e4_royalties
		SET 
			
			price = ".$price.$notice."
			 ,status = ".$status. 
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
		
		$ariacms->delete('e4_royalties', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
