<?php
class Model
{
	static function block_view_link($row)
	{
		$str = '';
		if ($row->bpublish == '1') {
			$str .= '<a onclick="update_value_by_id(\'e4_blocks\', \'bpublish\', \'' . $row->id . '\', \'0\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa block"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_blocks\', \'bpublish\', \'' . $row->id . '\', \'1\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để mở block"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href ="?module=block&task=block_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip" title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}
	static function block_view()
	{
		global $database;
		$query = "SELECT * FROM e4_blocks WHERE 1=1 ORDER BY bpublish desc, region asc ";
		$database->setQuery($query);
		$blocks = $database->loadObjectList();
		View::block_view($blocks);
	}

	static function block_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "block_add") {
			$filename	= $_FILES["bfilename"]["name"];
			$filetmp	= $_FILES["bfilename"]["tmp_name"];
			$bname		= @$_REQUEST["bname"];
			$bposition	= @$_REQUEST["bposition"];
			$dir = "../blocks/";
			if ($filename != '') {
				copy($filetmp, $dir . $filename);
			}

			$query = "INSERT INTO e4_blocks(bname,bposition,bfilename,bpublish) VALUES ('$bname','$bposition','$filename','1')";
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function block_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "block_edit") {
			$id		= @$_REQUEST["id"];
			$bname		= @$_REQUEST["bname"];
			$bposition	= @$_REQUEST["bposition"];
			$bfilename	= @$_REQUEST["bfilename"];
			$region		= @$_REQUEST["region"];

			$query = "UPDATE e4_blocks SET bname='$bname' ,bposition='$bposition' ,bfilename='$bfilename' ,region='$region'  WHERE id = $id ";
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function block_delete()
	{
		global $database;
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$query = "SELECT * FROM e4_blocks WHERE id='$id'";
		$database->setQuery($query);
		$row = $database->loadRow();
		$file = $row["bfilename"];
		unlink("../blocks/$file");

		$query = "DELETE FROM e4_blocks WHERE id='$id'";
		$database->setQuery($query);
		$database->query();
		$ariacms->redirect("", "javascript:history.back()");
	}
}
