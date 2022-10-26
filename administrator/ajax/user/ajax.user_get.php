<?php
session_start();
if (file_exists("../../../configuration.php")) {
	require_once("../../../configuration.php");
} else {
	echo "Missing Configuration File";
	exit();
}
//Include Database Controller
if (file_exists("../../../include/database.php")) {
	require_once("../../../include/database.php");
} else {
	echo "Missing Database File";
	exit();
}
//Include System File
if (file_exists("../../../include/ariacms.php")) {
	require_once("../../../include/ariacms.php");
} else {
	echo "Missing System File";
	exit();
}
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$id = $_REQUEST['id'];
$query = "SELECT * FROM e4_users WHERE id = '$id'";
$database->setQuery($query);
$user = $database->loadRow();

$query = "SELECT * FROM e4_roles WHERE status = '1' ";
$database->setQuery($query);
$roles = $database->loadObjectList();
?>
<script language="javascript">
	function checkInput() {
		if ((document.form_user_edit.newPassword.value) != (document.form_user_edit.confirmPassword.value)) {
			alert("Mật khẩu không trùng khớp!");
			document.form_user_edit.confirmPassword.focus();
			return false;
		}
		return true;
	}
</script>
<div class="modal-dialog modal-lg">
	<form method="POST" action="?module=user&task=user_edit&id=<?php echo $id ?>" name="form_user_edit" id="form_user_edit" onSubmit="return checkInput();">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="box-body">
				<div class=" col-md-6">
					<div class="form-group">
						<label>User Type <font class="text-red">*</font></label>
						<select class="form-control" name="user_type" id="user_type" required>
							<option value="">Vui lòng chọn</option>
							<option value='admin' <?php echo ($user["user_type"] == 'admin') ? 'selected' : "" ?>>Admin Web</option>
							<option value='public' <?php echo ($user["user_type"] == 'public') ? 'selected' : "" ?>>Public Web</option>
						</select>
					</div>
					<div class="form-group">
						<label>Tên đầy đủ <font class="text-red">*</font></label>
						<input class="form-control" name="fullname" type="text" value="<?php echo  $user["fullname"] ?>" required />
					</div>
					<div class="form-group">
						<label>Email <font class="text-red">*</font> <em class="text-red" id="result_email"></em></label>
						<input class="form-control" type="text" name="email" id="email" value="<?php echo  $user["email"] ?>" required onblur="check_value_exist('<?php echo  $user["email"] ?>', '#email', 'e4_users', 'email', '#result_email', 'Email');" />
					</div>
					<div class="form-group">
						<label>Mật khẩu</label>
						<input class="form-control" type="password" value="" name="password" id="newPassword" placeholder="Để trống nếu không muốn thay đổi mật khẩu cũ..." />
					</div>
					<div class="form-group">
						<label>Nhập lại mật khẩu</label>
						<input class="form-control" type="password" value="" id="confirmPassword" placeholder="Để trống nếu không muốn thay đổi mật khẩu cũ..." />
					</div>
					<div class="form-group">
						<label>Nhóm quyền</label>
						<select class="form-control" name="permission" id="permission">
							<option value="">Vui lòng chọn</option>
							<?php
							foreach ($roles as $role) {
								if ($role->id == $user["permission"]) $sl = 'selected="selected"';
								else $sl = '';
								echo '<option value=' . $role->id . ' ' . $sl . '>- - ' . $role->role_code . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class=" col-md-6">
					<div class="form-group">
						<label>Homephone</label>
						<input class="form-control" type="text" name="homephone" value="<?php echo  $user["homephone"] ?>" />
					</div>
					<div class="form-group">
						<label>Mobifone</label>
						<input class="form-control" type="text" name="mobifone" value="<?php echo  $user["mobifone"] ?>" />
					</div>
					<div class="form-group">
						<label>Facebook</label>
						<input class="form-control" type="text" name="facebook" value="<?php echo  $user["facebook"] ?>" />
					</div>
					<div class="form-group">
						<label>Yahoo</label>
						<input class="form-control" type="text" name="yahoo" value="<?php echo  $user["yahoo"] ?>" />
					</div>
					<div class="form-group">
						<label>Skype</label>
						<input class="form-control" type="text" name="skype" value="<?php echo  $user["skype"] ?>" />
					</div>
					
					<!--div class="form-group">
						<label>Vai trò</label>
						<select class="form-control"  required name="menu_privilege" id="menu_privilege">
							<option value="">Vui lòng chọn</option>
							<option value="MAKER">Biên tập nội dung</option>
							<option value="CHECKER">Kiểm duyệt nội dung</option>
							
						</select>
					</div-->
				</div>
				
			</div>
			<div class="modal-footer">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="user_edit">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>

			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->