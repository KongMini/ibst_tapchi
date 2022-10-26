 <?php
 
 
 date_default_timezone_set('Asia/Ho_Chi_Minh');
 session_start();
 error_reporting(0);
ini_set('display_errors', 0); //echo "dddd";
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
$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
GROUP BY a.id ORDER BY a.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();

$query1 = "SELECT a.id, a.title_vi FROM e4_posts a ORDER BY a.id DESC";
$database->setQuery($query1);
$postnews = $database->loadObjectList();

$array_location = array(1=> 'Tin Top',2=> 'Tin tâm điểm', 0=>'Tin thường');
$array_status = array('waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt');
?>
<div class="modal-dialog modal-full">
	<form method="POST" action="?module=news&task=news_add" name="news_add" id="news_add" class="form-horizontal" enctype="multipart/form-data" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Thêm mới bài viết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a aria-expanded="true" href="#info_general" data-toggle="tab">Thông tin chung <font class="text-red">*</font></a></li>
						<li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin SEO</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="info_general">
							<div class="row">
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="content_vi" class="col-sm-12 col-md-12 col-lg-12">Nội dung</label>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<textarea class="form-control" name="content_vi" id="content_vi" rows="43"></textarea>
										</div>

											<script type="text/javascript">
												// CKEDITOR.replace('content_vi', {
												// // Reset toolbar settings, so full toolbar will be generated automatically.
												// toolbarGroups: [
												// { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
												// { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
												// { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },

													// //{ name: 'forms' },
													// { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
													// { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
													// { name: 'links' },
													// { name: 'insert' },
													// //{ name: 'styles' },
													// { name: 'colors' },
													// { name: 'tools' },
													// //{ name: 'others' },
													// //{ name: 'about' }
													// ],
													// removeButtons: null,
													// height: 430,
													// entities: false,
													// fullPage: true,
												// // Image browser
												// filebrowserImageBrowseUrl: filemanageUrl,
												// filebrowserImageUploadUrl: filemanageUrl,
												// // allow style and css
												// allowedContent: true,
												// // auto wrap content in p tag
												// autoParagraph: false
											// });
										</script>
								</div>
							</div>
							
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<div class="col-xs-12">
										<label >Tiêu đề<span class="text-red">*</span></label>
										<input class="form-control" name="title_vi" id="title_vi" placeholder="Tiêu đề..." type="text" required value="" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<label>Giới thiệu</label>
										<textarea class="form-control" rows="3" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..."></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12 col-md-6">
										<label>Danh mục - Category</label>
										<select class="form-control select2" id="category_id" name="taxonomy[]" data-placeholder="Chọn danh mục..." style="width: 100%;" multiple="multiple">
											<?php
											foreach ($taxonomies as $taxonomy) {
												if ($taxonomy->taxonomy == 'category' && $taxonomy->parent == 0) {
													$selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
													echo '<option '. $selected .' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';
													if ($taxonomy->sub > 0) {
														foreach ($taxonomies as $taxonomy_sub) {
															if ($taxonomy->id == $taxonomy_sub->parent) {
																$selected = (in_array($taxonomy_sub->id, $term_taxonomy_id_list)) ? 'selected' : '';
																echo '<option '. $selected .' value="' . $taxonomy_sub->id . '">- - ' . $taxonomy_sub->title_vi . '</option>';
															}
														}
													}
												}
											}
											?>
										</select>
									</div>
									<div class="col-xs-12 col-md-6">
										<label>Quản lý chuyên đề - topic</label>
										<select class="form-control " id="topic" name="taxonomy[]"  data-placeholder="Chọn chuyên đề..." >
											<?php
											foreach ($taxonomies as $taxonomy) {
												if ($taxonomy->taxonomy == 'topic' && $taxonomy->parent == 0) {
													$selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
													echo '<option '. $selected .' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';
													
												}
											}
											?>
										</select>
									</div>
									
								</div>
								<div class="form-group">
									
									<div class="col-xs-12 col-md-6">
										<label>Gắn thẻ - tags</label>
										<select class="form-control select2" id="post_tags" multiple="multiple" name="taxonomy[]"  data-placeholder="Chọn danh mục..." style="width: 100%;">
											<?php
											foreach ($taxonomies as $taxonomy) {
												if ($taxonomy->taxonomy == 'post_tags' && $taxonomy->parent == 0) {
													$selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
													echo '<option '. $selected .' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';
													if ($taxonomy->sub > 0) {
														foreach ($taxonomies as $taxonomy_sub) {
															if ($taxonomy->id == $taxonomy_sub->parent) {
																$selected = (in_array($taxonomy_sub->id, $term_taxonomy_id_list)) ? 'selected' : '';
																echo '<option '. $selected .' value="' . $taxonomy_sub->id . '">- - ' . $taxonomy_sub->title_vi . '</option>';
															}
														}
													}
												}
											}
											?>
										</select>
									</div>
									
									<div class="col-xs-12 col-md-6">
										<label >Quản lý hiển thị</label>
										<select id="news_position" name="news_position" class="form-control">
											<option value="">- Chọn -</option>
											<?php foreach($array_location as $key2 => $location){ ?>
												<option value="<?=$key2?>"><?=$location?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group hidden">
									<div class="col-xs-12 col-md-6">
										<label for="post_status">Trạng thái và hiển thị:</label>
										<select id="post_status" name="post_status" class="form-control">
											<?php foreach($array_status as $key => $trangthai){ ?>
												<option value="<?=$key?>"><?=$trangthai?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<div class="col-xs-12 col-md-3">
										<label >Tác giả <span class="text-red"></span></label>
										<input class="form-control" name="author" id="author" placeholder="Tác giả" type="text" value="" />
									</div>
									
									<div class="col-xs-12 col-md-3">
										<label >Nguồn tham khảo <span class="text-red"></span></label>
										<input class="form-control" name="post_type" id="post_type" type="text" value="" />
									</div>
									<div class="col-xs-12 col-md-3">
										<label >Đường dẫn <span class="text-red"></span></label>
										<!-- LongPH sửa -->
										<input class="form-control" name="url_coppy" placeholder="Đường dẫn tham khảo" id="url_coppy" type="text" value="" onblur="getContent();" />
									</div>
									<div class="col-xs-12 col-md-3">
										<label >Thời gian XB<span class="text-red"></span></label>
										<input class="form-control" name="aproved_date" id="aproved_date" type="datetime-local" value="<?php echo date('Y-m-d\TH:i') ?>" />
									</div>
								</div>
								
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-4 col-xs-12 col-form-label">Ảnh đại diện:<?php
									$image_avatar = '/upload/noimage.png';
									?>
									<img style="height:60px;" id="newImg" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="chooseImg()" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
									<input type="file" name="hinhanh" id="img" style="display:none" onchange="readURL(this)" accept="image/png, image/jpeg">

									<div class="col-sm-8 col-xs-12">
										<!--input class="form-control" id="image" name="image" type="text" placeholder="Đường dẫn ảnh..." value="" /-->
									</div>

									<script>
										
										</script>
									</div>
									<div class="form-group hidden">
										<div class="col-xs-12">
											<label for="image_thumb">Chọn ảnh thumb thu nhỏ:</label>
											<?php 
											$image_thumb = '/upload/noimage.png'; ?>
											<img style="height:60px;" id="image_thumb" txthide="image_thumb" class="choiceImg cursor " src="<?=$image_thumb?>" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống">
											<input class="form-control " id="image_thumb" name="image_thumb" type="text" placeholder="Đường dẫn ảnh..." value="" />
										</div>
									</div>

									<div class="form-group hidden">
										<label for="meta_description_vi" class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Đường dẫn:</label>
										<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">
											<input class="form-control" name="url_part" id="url_part" type="text" placeholder="Đường dẫn URL" onblur="check_value_exist('', '#url_part', 'e4_posts', 'url_part', '#error_url_part', 'Đường dẫn URL');" value="" />
										</div>

									</div>
									<div class="form-group">
										<div class="col-xs-12 col-md-12">
											<label>Tin liên quan</label>
											<select class="form-control select2" id="category_id" name="relation[]" data-placeholder="Chọn tin liên quan..." style="width: 100%;" multiple="multiple">
												<?php
												foreach ($postnews as $postnew) {
													$selected = '';
													echo '<option '. $selected .' value="' . $postnew->id . '">' . $postnew->title_vi . '</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
											<input class="form-control" name="meta_keyword" placeholder="SEO: Từ khóa" id="meta_keyword" type="text" value="" />
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
											<textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="SEO: Mô tả..."></textarea>
										</div>
									</div>

								</div>
							</div>
							
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary" name="submit" value="news_add">Cập nhật</button>
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->
<script src="<?=$ariacms->actual_link ?>plugins/editor/ckeditor5/build/ckeditor.js"></script>
<script src="<?=$ariacms->actual_link ?>plugins/editor/ckfinder/ckfinder.js"></script>
<script>
	ClassicEditor
		.create( document.querySelector( '#content_vi' ), {
			
			toolbar: {
				items: [
					'CKFinder',"|",
					'heading',
					'bold',
					'link',
					'italic',
					'|',
					'blockQuote',
					'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
					'insertTable',
					'undo',
					'redo',
					
					'bulletedList',
					'numberedList',
					'mediaEmbed',
					'fontBackgroundColor',
					'fontColor',
					'fontSize',
					'fontFamily'
				]
			},
			language: 'vi',
			image: {
				toolbar: [
					'imageTextAlternative',
					'imageStyle:full',
					'imageStyle:side'
				]
			},
			table: {
				contentToolbar: [
					'tableColumn',
					'tableRow',
					'mergeTableCells'
				]
			},
			licenseKey: '',
			
			
		} )
		.then( editor => {
			window.editor = editor;
			
		} )
		.catch( error => {
			console.error( 'Oops, something went wrong!' );
			console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
			console.warn( 'Build id: v10wxmoi2tig-mwzdvmyjd96s' );
			console.error( error );
		} );
</script>
<script>
	
	// ClassicEditor
	// .create( document.querySelector( '#content_vi' ), {
			
		// ckfinder: {
			// uploadUrl: 'https://demo.economic247.vn/upload',
		// },
		// toolbar: [ 'ckfinder', 'imageUpload', '|', 'heading','link', '|', 'bold', 'italic', '|', 'undo', 'redo' ]
	// } )
	// .catch( error => {
		// console.error( error );
	// } );
		


	$(".select2").select2();
	
</script>