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
$query = "SELECT * FROM e4_web_menu WHERE id = $id";
$database->setQuery($query);
$web_menu_detail = $database->loadRow();
?>
<div class="modal-dialog modal-lg">
	<form method="POST" action="?module=web_menu&task=web_menu_edit&id=<?php echo $id ?>" name="web_menu_edit" id="web_menu_edit">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="parent">Thuộc danh mục</label>
					<select name="parent" id="parent" class="form-control">
						<option value="0">Chọn danh mục cha</option>
						<?php echo  $ariacms->printMenuOption('e4_web_menu', 'id', 'title_vi', '', '', $web_menu_detail['parent'], ''); ?>
					</select>
				</div>
				<div class="form-group ">
					<label for="title_vi">Tên Tiếng Việt <span class="text-red">*</span></label>
					<input class="form-control" name="title_vi" id="title_vi" value="<?php echo $web_menu_detail['title_vi'] ?>" type="text" required />
				</div>
				<div class="form-group ">
					<label for="title_en">Tên Tiếng Anh</label>
					<input class="form-control" name="title_en" id="title_en" value="<?php echo $web_menu_detail['title_en'] ?>" type="text" />
				</div>
				<div class="form-group ">
					<label for="url_html">Icon</label>
					<input class="form-control" name="icon" id="icon" type="text" value='<?php echo $web_menu_detail['icon'] ?>' />
				</div>
				<div class="form-group ">
					<label for="url_html">Đường dẫn URL</label>
					<input class="form-control" name="url_html" id="url_html" type="text" value="<?php echo $web_menu_detail['url_html'] ?>" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="web_menu_edit">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>

			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->