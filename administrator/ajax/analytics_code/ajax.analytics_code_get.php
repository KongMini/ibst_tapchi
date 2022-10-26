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
$ariacms = new ariacms();
$id = $_REQUEST['id'];
$query = "SELECT * FROM e4_analytics_code WHERE id = $id";
$database->setQuery($query);
$analytics_code_detail = $database->loadRow();
?>
<div class="modal-dialog modal-lg">
	<form method="POST" action="?module=analytics_code&task=analytics_code_edit&id=<?php echo $id ?>" name="analytics_code_edit" id="analytics_code_edit">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>

				<div class="form-group ">
					<label for="title_vn">Tên mã nhúng <span class="text-red">*</span></label>
					<input class="form-control" name="title_vn" id="title_vn" value="<?php echo $analytics_code_detail['title_vn'] ?>" type="text" required />
				</div>
				<div class="form-group ">
					<label for="description_vn">Mô tả ngắn</label>
					<input class="form-control" name="description_vn" id="description_vn" value="<?php echo $analytics_code_detail['description_vn'] ?>" type="text" />
				</div>
				<div class="form-group ">
					<label for="code">Nội dung mã nhúng</label>
					<textarea class="form-control" rows="15" name="code" id="code" placeholder="Nội dung thẻ nhúng..."><?php echo $analytics_code_detail['code'] ?></textarea>
				</div>
				<div class="form-group ">
					<label for="position">Vị trí hiển thị</label>
					<select class="form-control" name="position" id="position">
						<option value="header" <?php echo ($analytics_code_detail['position'] == 'header') ? 'selected="selected"' : '' ?>>Đầu trang</option>
						<option value="footer" <?php echo ($analytics_code_detail['position'] == 'footer') ? 'selected="selected"' : '' ?>>Cuối trang</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="analytics_code_edit">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->