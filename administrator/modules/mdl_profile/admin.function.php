<?php
class Model
{
	static function profile_view()
	{
		global $database;
		$query = "SELECT a.*, b.role_code, b.role_desc FROM e4_users a left join e4_roles b on a.permission = b.id where a.id = '" . $_SESSION["user"]['id'] . "' ";
		$database->setQuery($query);
		$profile = $database->loadRow();
		View::profile_view($profile);
	}
	static function profile_edit()
	{
		global $database;
		global $ariacms;
		$submit	= @$_POST["sb_profile_edit"];
		if ($submit != 'profile_edit') {
			$ariacms->redirect("", "javascript:history.back()");
		} else {
			$row = new stdClass();
			$row->id = $_SESSION["user"]['id'];
			foreach ($_POST as $key => $value) {
				if ($key != "sb_profile_edit") {
					$row->$key = $value;
				}
			}
			$row->date_updated = time();
			$row->user_updated = $_SESSION['user']['email'];
			/** Verify duplicate information user */
			$query = "SELECT * FROM e4_users WHERE email = '" . $row->email . "' and id != '" . $row->id . "' ";
			$database->setQuery($query);
			$checks = $database->loadObjectList();
			if ($checks) $ariacms->redirect("Email đã tồn tại! Vui lòng kiểm tra lại thông tin.", "index.php?module=profile");
			else {
				if ($database->updateObject('e4_users', $row, 'id')) $ariacms->redirect("Cập nhật thông tin thành công!", "index.php?module=profile");
				else echo $database->stderr();
			}
		}
	}
	static function profile_change_pass()
	{
		global $database;
		global $ariacms;
		$submit	= @$_POST["sb_profile_change_pass"];
		if ($submit != 'profile_change_pass') {
			$ariacms->redirect("", "index.php?module=profile");
		} else {
			$id 		= @$_SESSION["user"]['id'];
			$password	= @$_POST["password_new"];
			$password_old = @$_POST["password_old"];
			$query = "SELECT * FROM e4_users WHERE password = '" . md5($password_old) . "' and id = '" . $id . "' ";
			$database->setQuery($query);
			$checks = $database->loadObjectList();
			if ($checks) {
				// Insert vào CSDL
				$row = new stdClass;
				$row->id = $id;
				$row->password 	= md5($password);
				$row->date_updated = time();
				$row->user_updated 	= $_SESSION['user']['email'];
				if ($database->updateObject('e4_users', $row, 'id')) $ariacms->redirect("Đổi mật khẩu thành công!", "index.php?module=profile");
				else echo $database->stderr();
			} else $ariacms->redirect("Mật khẩu cũ không chính xác!", "index.php?module=profile");
		}
	}
}
