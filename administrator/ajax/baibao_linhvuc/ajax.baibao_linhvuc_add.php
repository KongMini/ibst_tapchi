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
	<form method="POST" action="?module=linhvuc&task=baibao_linhvuc_add" name="baibao_linhvuc_add" id="baibao_linhvuc_add" class="form-horizontal">
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
                                <label for="title_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Thời gian bắt đầu<span class="text-red">*</span> :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="time_start" id="time_start" type="date" required />
                                </div>
                                <label for="title_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Thời gian kể thúc</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="time_end" id="time_end" type="date" required />
                                </div>
                            </div>
							<div class="form-group">
								<label for="url_part" class="col-sm-2 col-md-2 col-lg-2 control-label">Đường dẫn URL:</label>
								<div class="col-sm-10 col-md-10 col-lg-10">
									<input class="form-control" name="url_part" id="url_part" type="text" onblur="check_value_exist('', '#url_part', 'e4_term_taxonomy', 'url_part', '#error_url_part', 'Đường dẫn URL');" />
									<input type="hidden" name="status" value="active">
								</div>
							</div>
							<div class="form-group">
                                <label for="staticEmail" class="col-sm-2 col-md-2 col-lg-2 control-label">Ảnh đại diện<?php
                                $image_avatar = '/upload/noimage.png';
                                ?>
                                <img style="height:60px;" id="newImg" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="openPopupImg('Img')" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
                                <div class="col-sm-8 col-xs-12">
                                    <input  name="image" class="form-control" id="Img" onclick="openPopupImg('Img')" accept="image/png, image/jpeg" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="staticEmail" class="col-sm-2 col-md-2 col-lg-2 control-label">Ảnh bìa 1<?php
                                            $image_avatar = '/upload/noimage.png';
                                            ?>
                                <img style="height:60px;" id="newImg1" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="openPopupImg('Img1')" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
                                <div class="col-sm-8 col-xs-12">
                                    <input  name="image1" class="form-control" id="Img1" onclick="openPopupImg('Img1')" accept="image/png, image/jpeg" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="staticEmail" class="col-sm-2 col-md-2 col-lg-2 control-label">Ảnh bìa 2<?php
                                            $image_avatar = '/upload/noimage.png';
                                            ?>
                                <img style="height:60px;" id="newImg2" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="openPopupImg('Img2')" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
                                <div class="col-sm-8 col-xs-12">
                                    <input  name="image2" class="form-control" id="Img2" onclick="openPopupImg('Img2')" accept="image/png, image/jpeg" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="staticEmail" class="col-sm-2 col-md-2 col-lg-2 control-label">Ảnh bìa 3<?php
                                            $image_avatar = '/upload/noimage.png';
                                            ?>
                                <img style="height:60px;" id="newImg3" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="openPopupImg('Img3')" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
                                <div class="col-sm-8 col-xs-12">
                                    <input  name="image3" class="form-control" id="Img3" onclick="openPopupImg('Img3')" accept="image/png, image/jpeg" >
                                </div>
                            </div>


	                        <div class="form-group">
                                <label for="staticEmail" class="ol-sm-2 col-md-2 col-lg-2 control-label">Năm<span class="text-red">*</span></label>
                                <div class="col-sm-8 col-xs-12">
                                    <input type="text" name="nam" class="form-control" value="<?= date('Y') ?>" required>
                                </div>
                            </div>

							<p id="error_url_part" class="col-sm-10 col-md-10 col-lg-10 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 text-danger"></p>

							<div class="form-group hidden">
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
						<button type="submit" class="btn btn-primary" name="submit" value="baibao_linhvuc_add">Cập nhật</button>
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->
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
															function openPopup(id) {
																CKFinder.popup( {
																	chooseFiles: true,
																	onInit: function( finder ) {
																		finder.on( 'files:choose', function( evt ) {
																			var file = evt.data.files.first();
																			document.getElementById( id ).value = file.getUrl();
																		} );
																		finder.on( 'file:choose:resizedImage', function( evt ) {
																			document.getElementById( id ).value = evt.data.resizedUrl;
																			
																		} );
																	}
																} );
															}
														</script>

														<script>
															function chooseImg(){
																$("#img").click();
															}
															
															function readURL(input) {
																if (input.files && input.files[0]) {
																	var reader = new FileReader();

																	reader.onload = function (e) {
																		$('#newImg')
																			.attr('src', e.target.result)
																			.height(60);
																		//$("#image").val() = e.target.result;
																	};

																	reader.readAsDataURL(input.files[0]);
																}
															}
														</script>	