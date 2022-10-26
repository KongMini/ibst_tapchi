<?php
class Model
{
	static function contact_view_link($row)
	{
		$str = '';
		$str .= '<a href ="?module=contact&task=contact_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}
	static function contact_view()
	{
		global $database;
		global $ariacms;
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";

		$query = "SELECT a.* FROM e4_contacts a WHERE a.type = 'contact' ORDER BY a.id desc " . $limit;
		$database->setQuery($query);
		$contacts = $database->loadObjectList();

		$query = "SELECT COUNT(*) total FROM e4_contacts a WHERE a.type = 'contact' ";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		View::contact_view($contacts, $totalRows['total'], $maxRows, $curPg);
	}
	static function contact_newsletter()
	{
		global $database;
		global $ariacms;
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";

		$query = "SELECT a.* FROM e4_contacts a WHERE a.type = 'newsletter' GROUP BY a.email ORDER BY a.id desc " . $limit;
		$database->setQuery($query);
		$contacts = $database->loadObjectList();

		$query = "SELECT COUNT(*) total FROM e4_contacts a WHERE a.type = 'newsletter' GROUP BY a.email ";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		View::contact_newsletter($contacts, $totalRows['total'], $maxRows, $curPg);
	}
	static function contact_edit()
	{
		global $database;
		global $ariacms;
		if ($_POST["submit"] == "contact_edit") {
			$row = new stdClass;
			$row->id 		= $_REQUEST["id"];
			foreach ($_POST as $key => $value) {
				if ($key != "submit")
					$row->$key = $value;
			}
			$row->date_updated = time();
			$row->user_updated 	= $_SESSION['user']['email'];
			if ($database->updateObject('e4_contacts', $row, 'id'))
				$ariacms->redirect("", "javascript:history.back()");
			else echo $database->stderr();
		} else {
			$ariacms->redirect("", "javascript:history.back()");
		}
	}
	static function contact_delete()
	{
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$ariacms->delete('e4_contacts', 'id=' . $id);
		$ariacms->redirect("", "javascript:history.back()");
	}
}
