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
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=analytics_code&task=analytics_code_add" name="analytics_code_add" id="analytics_code_add" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<p class="col-md-offset-3 col-md-9 text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="title_vn" class="col-md-3 control-label">Tên mã nhúng <span class="text-red">*</span></label>
					<div class="col-md-9">
						<input class="form-control" name="title_vn" id="title_vn" type="text" required />
					</div>
				</div>
				<div class="form-group ">
					<label for="description_vn" class="col-md-3 control-label">Mô tả ngắn</label>
					<div class="col-md-9">
						<input class="form-control" name="description_vn" id="description_vn" type="text" />
					</div>
				</div>
				<div class="form-group ">
					<label for="code" class="col-md-3 control-label">Nội dung mã nhúng</label>
					<div class="col-md-9">
						<textarea class="form-control" rows="15" name="code" id="code" placeholder="Nội dung thẻ nhúng..."></textarea>
					</div>
				</div>
				<div class="form-group ">
					<label for="position" class="col-md-3 control-label">Vị trí hiển thị</label>
					<div class="col-md-9">
						<select class="form-control" name="position" id="position">
							<option value="header">Đầu trang</option>
							<option value="footer">Cuối trang</option>
						</select>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary pull-left" name="submit" value="analytics_code_add">Cập nhật</button>
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->