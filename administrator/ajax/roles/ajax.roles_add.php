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
			<form method="POST" action="?module=roles&task=roles_add" name="roles_add" id="roles_add">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
				</div>
				<div class="modal-body">
					<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
					<div class="form-group ">
						<label for="role_code" >Mã quyền <span class="text-red">*</span></label>
						<input class="form-control" name="role_code" id="role_code" type="text" required />
					</div>
					<div class="form-group ">
						<label for="role_desc" >Mô tả quyền</label>
						<input class="form-control" name="role_desc" id="role_desc" type="text" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-left" name="submit" value="roles_add" >Cập nhật</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
					
				</div>
			</div><!-- /.modal-content -->
			</form>
		</div><!-- /.modal-dialog -->