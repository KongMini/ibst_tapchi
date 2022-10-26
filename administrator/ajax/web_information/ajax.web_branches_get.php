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
$id = @$_REQUEST["id"];
$query = "SELECT * FROM e4_web_branches WHERE id = '$id'";
$database->setQuery($query);
$branch = $database->loadRow();
?>
<div class="modal-dialog">
	<form method="POST" action="?module=web_information&task=web_branches_edit&id=<?php echo $id ?>" name="web_branches_edit" id="web_branches_edit">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi nhánh</h4>
			</div>
			<div class="modal-body">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="name_vn">Tên chi nhánh Tiếng Việt <span class="text-red">*</span></label>
					<input class="form-control" name="name_vn" id="name_vn" type="text" required placeholder="Tên chi nhánh đầy đủ Tiếng Việt" value="<?php echo $branch['name_vn'] ?>" />
				</div>
				<div class="form-group ">
					<label for="name_en">Tên chi nhánh Tiếng Anh</label>
					<input class="form-control" name="name_en" id="name_en" type="text" placeholder="Tên chi nhánh đầy đủ Tiếng Anh" value="<?php echo $branch['name_en'] ?>" />
				</div>
				<div class="form-group ">
					<label for="address_vn">Địa chi Tiếng Việt <span class="text-red">*</span></label>
					<input class="form-control" name="address_vn" id="address_vn" type="text" required placeholder="Địa chỉ chi nhánh Tiếng Việt" value="<?php echo $branch['address_vn'] ?>" />
				</div>
				<div class="form-group ">
					<label for="address_en">Tên chi nhánh Tiếng Anh</label>
					<input class="form-control" name="address_en" id="address_en" type="text" placeholder="Địa chỉ chi nhánh Tiếng Anh" value="<?php echo $branch['address_en'] ?>" />
				</div>
				<div class="form-group ">
					<label for="hotline">Hotline <span class="text-red">*</span></label>
					<input class="form-control" name="hotline" id="hotline" type="text" required placeholder="Số điện thoại hotline của chi nhánh" value="<?php echo $branch['hotline'] ?>" />
				</div>
				<div class="form-group ">
					<label for="phone">Điện thoại tổng đài</label>
					<input class="form-control" name="phone" id="phone" type="text" placeholder="Điện thoại bàn hoặc tổng đài chi nhánh" value="<?php echo $branch['phone'] ?>" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="sb_web_branches_edit" value="web_branches_edit">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->