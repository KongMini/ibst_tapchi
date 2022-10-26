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
<div class="modal-editor">
	<form method="POST" action="?module=web_image&task=web_image_add" name="web_image_add" id="web_image_add" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết <small class="text-orange"><em>(Vui lòng nhập đầy đủ thông tin trường có dấu <font class="text-red">*</font>.)</em></small></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="title_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Tên Tiếng Việt <span class="text-red">*</span> :</label>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<input class="form-control" name="title_vi" id="title_vi" type="text" required value="" />
					</div>
					<label for="title_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Tên Tiếng Anh :</label>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<input class="form-control" name="title_en" id="title_en" type="text" value="" />
					</div>
				</div>
				<div class="form-group">
					<label for="image" class="col-sm-2 col-md-2 col-lg-2 control-label">Ảnh <span class="text-red">*</span> :</label>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<img style="height:75px;" id="newImg" onclick="openPopupImg('Img')" class="choiceImg cursor " src="templates/aptcms/dist/img/noimage.png" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để chọn ảnh trên hệ thống" />
					</div>
					<script>
						function openPopupImg(id) {
							CKFinder.popup( {
								chooseFiles: true,
								onInit: function( finder ) {
									finder.on( 'files:choose', function( evt ) {
										var file = evt.data.files.first();
										document.getElementById( id ).value = file.getUrl();
										document.getElementById( "new" + id ).src = file.getUrl();
									} );
									finder.on( 'file:choose:resizedImage', function( evt ) {
										document.getElementById( id ).value = evt.data.resizedUrl;
										
									} );
								}
							} );
						}
					
					</script>
					<label for="position" class="col-sm-2 col-md-2 col-lg-2 control-label">Vị trí :</label>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<select class="form-control " id="position" name="position" required >
							<option value="">Chọn</option>
							<option value="icon">icon</option>
							<option value="logo"  >logo</option>
							<option value="banner">banner</option>
							<option value="advertisement" >Quảng cáo bên phải</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="image" class="col-sm-2 col-md-2 col-lg-2 control-label">Link ảnh <span class="text-red">*</span> :</label>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<input class="form-control " id="Img" name="image" type="text" placeholder="Dán đường dẫn ảnh..." value="" required />
					</div>
					<label for="link" class="col-sm-2 col-md-2 col-lg-2 control-label">Địa chỉ liên kết (URL) :</label>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<input class="form-control " id="link" name="link" type="text" placeholder="Đặt link cho ảnh..." value="" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="web_image_add">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->