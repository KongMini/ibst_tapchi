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
	<form method="POST" action="?module=product_group&task=product_group_add" name="product_group_add" id="product_group_add" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a aria-expanded="true" href="#info_general" data-toggle="tab">Thông tin chung <font class="text-red">*</font></a></li>
						<li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin mở rộng SEO</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="info_general">
							<div class="form-group">
								<label for="parent" class="col-sm-2 col-md-2 col-lg-2 control-label">Thuộc danh mục cha:</label>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<select name="parent" id="parent" class="form-control">
										<option value="0">Vui lòng chọn</option>
										<?= $ariacms->printMenuOption('e4_term_taxonomy', 'id', 'title_vi', '', '', '', 'product_group'); ?>
									</select>
								</div>
								<label for="position" class="col-sm-2 col-md-2 col-lg-2 control-label">Vị trí hiển thị :</label>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<select name="position" id="position" class="form-control">
										<option value="">Chọn vị trí</option>
										<option value="header">Đầu trang</option>
										<option value="home">Trang chủ</option>
										<option value="left">Menu trái</option>
										<option value="right">Menu phải</option>
										<option value="footer">Cuối trang</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="title_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Tên Tiếng Việt <span class="text-red">*</span> :</label>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<input class="form-control" name="title_vi" id="title_vi" type="text" required onkeyup="" />
								</div>
								<label for="title_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Tên Tiếng Anh:</label>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<input class="form-control" name="title_en" id="title_en" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="url_part" class="col-sm-2 col-md-2 col-lg-2 control-label">Đường dẫn URL:</label>
								<div class="col-sm-10 col-md-10 col-lg-10">
									<input class="form-control" name="url_part" id="url_part" type="text" onblur="check_value_exist('', '#url_part', 'e4_term_taxonomy', 'url_part', '#error_url_part', 'Đường dẫn URL');" />
								</div>
							</div>
							<p id="error_url_part" class="col-sm-10 col-md-10 col-lg-10 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 text-danger"></p>

							<div class="form-group">
								<label for="brief_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Giới thiệu Tiếng Việt:</label>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<textarea class="form-control" rows="10" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..."></textarea>
								</div>
								<label for="brief_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Giới thiệu Tiếng Anh:</label>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<textarea class="form-control" rows="10" name="brief_en" id="brief_en" placeholder="Tóm tắt giới thiệu bản tin..."></textarea>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="info_other">
							<div class="form-group">
								<label for="meta_title_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Title Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_title_vi" id="meta_title_vi" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_title_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Title Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_title_en" id="meta_title_en" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_keyword_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Keyword Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_keyword_vi" id="meta_keyword_vi" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_keyword_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Keyword Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_keyword_en" id="meta_keyword_en" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_description_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Description Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_description_vi" id="meta_description_vi" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_description_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Description Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_description_en" id="meta_description_en" type="text" />
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary" name="submit" value="product_group_add">Cập nhật</button>
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->