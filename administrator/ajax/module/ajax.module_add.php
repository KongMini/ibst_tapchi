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
?>
<div class="modal-dialog">
	<form method="POST" action="?module=module&task=module_add" name="module_add" id="module_add">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="name">Name <span class="text-red">*</span></label>
					<input class="form-control" name="name" id="name" type="text" required />
				</div>
				<div class="form-group ">
					<label for="title">Title</label>
					<input class="form-control" name="title" id="title" type="text" />
				</div>
				<div class="form-group ">
					<label for="folder">Folder <span class="text-red">*</span></label>
					<input class="form-control" name="folder" id="folder" type="text" required />
				</div>
				<div class="form-group ">
					<label for="type">Type <span class="text-red">*</span></label>
					<select name="type" id="type" class="form-control" required>
						<option value="">Chọn loại module</option>
						<option value="admin">Admin</option>
						<option value="public">Public</option>
					</select>
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="module_add">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>

			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->