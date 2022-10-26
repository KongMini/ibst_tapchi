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
$id = $_REQUEST['id'];
?>
<div class="modal-dialog">
	<form method="POST" action="?module=task&task=task_add&id=<?php echo $id ?>" name="task_add" id="task_add">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="function_name">FunctionName <span class="text-red">*</span></label>
					<input class="form-control" name="function_name" id="function_name" type="text" required />
				</div>
				<div class="form-group ">
					<label for="function_code">Function Code <span class="text-red">*</span></label>
					<input class="form-control" name="function_code" id="function_code" type="text" required />
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="task_add">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>

			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->