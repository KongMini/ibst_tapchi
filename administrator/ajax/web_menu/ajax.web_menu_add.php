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
?>
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=web_menu&task=web_menu_add" name="web_menu_add" id="web_menu_add" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<p class="col-md-offset-3 col-md-9 text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="parent" class="col-md-3 control-label">Thuộc danh mục</label>
					<div class="col-md-9">
						<select name="parent" id="parent" class="form-control">
							<option value="0">Chọn danh mục cha</option>
							<?php echo  $ariacms->printMenuOption('e4_web_menu', 'id', 'title_vi', '', '', '', ''); ?>
						</select>
					</div>
				</div>
				<div class="form-group ">
					<label for="title_vi" class="col-md-3 control-label">Tên Tiếng Việt <span class="text-red">*</span></label>
					<div class="col-md-9">
						<input class="form-control" name="title_vi" id="title_vi" type="text" required />
					</div>
				</div>
				<div class="form-group ">
					<label for="title_en" class="col-md-3 control-label">Tên Tiếng Anh</label>
					<div class="col-md-9">
						<input class="form-control" name="title_en" id="title_en" type="text" />
					</div>
				</div>
				<div class="form-group ">
					<label for="url_html" class="col-md-3 control-label">Đường dẫn URL</label>
					<div class="col-md-9">
						<input class="form-control" name="url_html" id="url_html" type="text" />
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary pull-left" name="submit" value="web_menu_add">Cập nhật</button>
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->