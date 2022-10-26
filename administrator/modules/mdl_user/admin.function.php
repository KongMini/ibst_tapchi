<?php
class Model
{
	static function user_view()
	{
		global $database;
		global $ariacms;



		$totalRows = 0;
		$where = "";
		$curPg		= @$_REQUEST["curPg"];
		$keyword	= @$_REQUEST["keyword"];
		$start_date	= @$_REQUEST["start_date"];
		$s_start_date = (int) $ariacms->dateToUnix($_REQUEST['start_date']) + 86400;
		$end_date	= @$_REQUEST["end_date"];
		$s_end_date = (int) $ariacms->dateToUnix($_REQUEST['end_date']) + 86400;
		$status		= @$_REQUEST["status"];
		($keyword != "") ? $where .= " and ( a.fullname like '%$keyword%' OR a.email = '$keyword' OR a.homephone = '$keyword' OR a.mobifone = '$keyword' ) " : $where .= "";

		($start_date != "") ? $where .= " and ( a.date_created >= $s_start_date ) " : $where .= "";
		($end_date != "") ? $where .= " and ( a.date_created <= $s_end_date ) " : $where .= "";
		if ($status == 1) $where .= " and ( a.publish = $status ) ";
		else if ($status == 2) $where .= " and ( a.publish = 0 ) ";

		$query = "SELECT a.*,b.role_code FROM e4_users a left join e4_roles b on a.permission = b.id where 1=1 " . $where . " ORDER BY a.user_type, a.permission asc";
		$database->setQuery($query);
		$users = $database->loadObjectList();

		$totalRows = count($users);
		$maxRows = 30;
		if ($curPg == "") $curPg = 1;
		$curRow = ($curPg - 1) * $maxRows;
		View::user_view($users, $totalRows, $curPg, $curRow, $maxRows);
	}
	static function user_public()
	{
		global $database;
		global $ariacms;
		$totalRows = 0;
		$where = "";
		$curPg		= @$_REQUEST["curPg"];
		$keyword	= @$_REQUEST["keyword"];
		$start_date	= @$_REQUEST["start_date"];
		$s_start_date = (int) $ariacms->dateToUnix($_REQUEST['start_date']) + 86400;
		$end_date	= @$_REQUEST["end_date"];
		$s_end_date = (int) $ariacms->dateToUnix($_REQUEST['end_date']) + 86400;
		$status		= @$_REQUEST["status"];
		$phanbien	= @$_REQUEST["phanbien"];
		($keyword != "") ? $where .= " and ( a.fullname like '%$keyword%' OR a.email = '$keyword' OR a.homephone = '$keyword' OR a.mobifone = '$keyword' ) " : $where .= "";

		($start_date != "") ? $where .= " and ( a.date_created >= $s_start_date ) " : $where .= "";
		($end_date != "") ? $where .= " and ( a.date_created <= $s_end_date ) " : $where .= "";
		if ($status == 1) $where .= " and ( a.publish = $status ) ";
		if ($phanbien == 1) $where .= " and ( a.phanbien = 1 ) ";
		else if ($status == 2) $where .= " and ( a.publish = 0 ) ";



		$query = "SELECT a.*,b.role_code FROM e4_users a left join e4_roles b on a.permission = b.id where user_type= 'public' " . $where . " ORDER BY a.user_type, a.permission asc";
		$database->setQuery($query);
		$users = $database->loadObjectList();

		$totalRows = count($users);
		$maxRows = 30;
		if ($curPg == "") $curPg = 1;
		$curRow = ($curPg - 1) * $maxRows;
		View::user_public($users, $totalRows, $curPg, $curRow, $maxRows);
	}

	static function user_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] != 'user_add') {
			$ariacms->redirect("", "javascript:history.back()");
		} else {
			$row = new stdClass;
			$row->id = null;
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && $key != "imgfile") {
					if ($key == "password") $row->$key = md5($value);
					else $row->$key = $value;
				} else if ($key == "imgfile") $row->image_url = $value;
			}
			$row->publish 	= 1;
			$row->menu_privilege = @$_REQUEST["menu_privilege"];
			$row->date_created = time();
			$row->user_created 	= $_SESSION['user']['email'];
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			/** Verify User information */
			$query = "SELECT * FROM e4_users WHERE email = '" . $row->email . "' ";
			$database->setQuery($query);
			$checks = $database->loadObjectList();
			if ($checks) $ariacms->redirect("Email đã tồn tại! Vui lòng kiểm tra lại thông tin.", "javascript:history.back()");
			else {
				// Insert DB
				if ($database->insertObject('e4_users', $row, 'id')) $ariacms->redirect("Thêm mới thành công!", "javascript:history.back()");
				else echo $database->stderr();
			}
		}
	}

	static function user_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] != 'user_edit') {
			$ariacms->redirect("", "javascript:history.back()");
		} else {
			$row = new stdClass;
			$row->id = $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != "submit" && $key != "imgfile") {
					if ($key == "password" && $value != "") $row->$key = md5($value);
					else $row->$key = $value;
				} else if ($key == "imgfile") $row->image_url = $value;
			}
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			$row->menu_privilege = @$_REQUEST["menu_privilege"];
			/** Verify User information */
			$query = "SELECT * FROM e4_users WHERE email = '" . $row->email . "' and id != '" . $row->id . "' ";
			$database->setQuery($query);
			$checks = $database->loadObjectList();
			if ($checks) $ariacms->redirect("Email đã tồn tại! Vui lòng kiểm tra lại thông tin.", "javascript:history.back()");
			else {
				// Insert DB
				if ($database->updateObject('e4_users', $row, 'id')) $ariacms->redirect("", "javascript:history.back()");
				else echo $database->stderr();
			}
		}
	}

	static function user_delete()
	{
		global $database;
		global $ariacms;
		$id = @$_REQUEST["id"];
		$query = "DELETE FROM e4_users WHERE id = '$id'";
		$database->setQuery($query);
		$database->query();
		$ariacms->redirect("", "javascript:history.back()");
	}
	static function user_publish()
	{
		global $database;
		global $ariacms;
		$id = @$_REQUEST["id"];
		$query = "UPDATE e4_users SET publish='1' WHERE id='$id'";
		$database->setQuery($query);
		$database->query();
		$ariacms->redirect("", "javascript:history.back()");
	}
	static function user_unpublish()
	{
		global $database;
		global $ariacms;
		$id = @$_REQUEST["id"];
		$query = "UPDATE e4_users SET publish='0' WHERE id='$id'";
		$database->setQuery($query);
		$database->query();
		$ariacms->redirect("", "javascript:history.back()");
	}
}
