<?php
class Model
{
	static function web_information_view()
	{
		View::web_information_view();
	}

	static function web_information_edit()
	{
		global $database;
		global $ariacms;
		if ($_REQUEST["sb_web_information_edit"] != 'web_information_edit') {
			$ariacms->redirect("", "index.php?module=web_information");
		} else {
			$row = new stdClass();
			foreach ($_POST as $key => $value) {
				if ($key != "sb_web_information_edit") {
					$row->option_name = $key;
					$row->option_value = $value;
					$database->updateObject("e4_options", $row, "option_name");
				}
			}
			$ariacms->redirect("", "index.php?module=web_information");
		}
	}
}
