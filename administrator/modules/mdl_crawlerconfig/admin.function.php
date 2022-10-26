<?php
class Model
{
	static function block_view_link($row)
	{
		$str = '';
		if ($row->bpublish == '1') {
			$str .= '<a onclick="update_value_by_id(\'e4_crawl_config\', \'bpublish\', \'' . $row->id . '\', \'0\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để khóa block"><i class="fa fa-unlock-alt"></i></a>&nbsp;&nbsp;';
		} else {
			$str .= '<a onclick="update_value_by_id(\'e4_crawl_config\', \'bpublish\', \'' . $row->id . '\', \'1\');" data-toggle="tooltip" href="javascript:void(0);" title="Nhấn để mở block"><i class="fa fa-lock text-black"></i></a>&nbsp;&nbsp;';
		}
		$str .= '<a href ="?module=block&task=block_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip" title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}
	static function config_view()
	{
		global $database;
		$query = "SELECT * FROM e4_crawl_config WHERE 1=1 ORDER BY id desc";
		$database->setQuery($query);
		$blocks = $database->loadObjectList();
		View::block_view($blocks);
	}

	static function config_add()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"] == "block_add") {
			$config_key		= @$_REQUEST["config_key"];
			$config_name	= @$_REQUEST["config_name"];
			
			$config_value		= @$_REQUEST["config_value"];
			$is_enable	= @$_REQUEST["is_enable"];
			
			$query = "INSERT INTO e4_crawl_config(config_key ,config_name,config_value ,is_enable  ) VALUES ('$bname','$bposition','$filename','1')";
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("", "javascript:history.back()");
		}
	}

	static function config_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["submit"]) {
			$id		= @$_REQUEST["id"];
			$config_key		= @$_REQUEST["config_key"];
			$config_name	= @$_REQUEST["config_name"];
			
			$config_value		= @$_REQUEST["config_values"];
			$is_enable	= @$_REQUEST["is_enable"];

			$query = "UPDATE e4_crawl_config SET config_key='$config_key' ,config_name='$config_name' ,config_value='$config_value' ,is_enable='$is_enable'  WHERE id = $id ";
			//echo $query;
			$database->setQuery($query);
			$database->query();
			$ariacms->redirect("", "?module=crawlerconfig");
		}
	}

	static function config_delete()
	{
		global $database;
		global $ariacms;
		$id	= @$_REQUEST["id"];
		$query = "DELETE FROM e4_crawl_config WHERE id='$id'";
		$database->setQuery($query);
		$database->query();
		$ariacms->redirect("", "javascript:history.back()");
	}
}
