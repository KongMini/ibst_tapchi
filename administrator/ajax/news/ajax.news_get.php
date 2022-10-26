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
$id = $_REQUEST['id'];
$query = "SELECT a.*, b.term_taxonomy_id_list FROM e4_posts a 
		LEFT JOIN ( 
				SELECT t1.object_id, GROUP_CONCAT(t1.term_taxonomy_id) AS term_taxonomy_id_list
				FROM e4_term_relationships t1 
				LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id GROUP BY t1.object_id
				) b ON a.id = b.object_id
	WHERE a.id = $id";
$database->setQuery($query);
$news_detail = $database->loadRow();

$query = "SELECT * FROM e4_posts_meta WHERE post_id = '$id'";
$database->setQuery($query);
$term_metas = $database->loadObjectList();
foreach ($term_metas as $term_meta) {
	$news_detail['meta']->{$term_meta->meta_key} = $term_meta->meta_value;
}
//print_r($news_detail['meta']);
$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
	LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
	GROUP BY a.id ORDER BY a.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();

$query1 = "SELECT a.id, a.title_vi FROM e4_posts a ORDER BY a.id DESC";
$database->setQuery($query1);
$postnews = $database->loadObjectList();

$term_taxonomy_id_list = explode(",", $news_detail['term_taxonomy_id_list']);

$relation_id_list = explode(",", $news_detail['relation']);

$array_status = array('waiting'=>'Chờ duyệt','active'=>'Đã xuất bản','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');

$array_location = array(0=>'Tin thường',2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong');
?>
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=news&task=news_edit&id=<?php echo $id ?>" name="news_edit" id="news_edit" class="form-horizontal" enctype="multipart/form-data">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs hidden">
						<li class="active"><a aria-expanded="true" href="#info_general" data-toggle="tab">Thông tin chung <font class="text-red">*</font></a></li>
						<li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin SEO</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="info_general">
							<div class="row">
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="content_vi" class="col-sm-12 col-md-12 col-lg-12">Nội dung Tiếng Việt</label>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<textarea class="form-control" name="content_vi" id="content_vi" rows="43"><?=$news_detail['content_vi']?></textarea>
									</div>
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
								</div>
							</div>
							
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<div class="col-xs-12">
										<label >Tiêu đề<span class="text-red">*</span></label>
										<input class="form-control" name="title_vi" id="title_vi" type="text" required value="<?=str_replace('"','\'',$news_detail['title_vi']);?>" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<label>Giới thiệu</label>
										<textarea class="form-control" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..."><?=$news_detail['brief_vi']?></textarea>
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
											<option value="">- Chọn -</option>
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
										<label >Quản lý hiển thị</label>
										<select id="news_position" name="news_position" class="form-control">
											<?php foreach($array_location as $key2 => $location){ ?>
												<option <?=($news_detail['news_position'] == $key2)? 'selected' : '';?> value="<?=$key2?>"><?=$location?></option>
											<?php } ?>
										</select>
									</div>
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
								</div>
								<div class="form-group hidden">
									<div class="col-xs-12 col-md-6">
										<label for="post_status">Trạng thái và hiển thị:</label>
										<select id="post_status" name="post_status" class="form-control">
											<?php foreach($array_status as $key => $trangthai){ ?>
												<option <?=($news_detail['post_status'] == $key)? 'selected' : '';?> value="<?=$key?>"><?=$trangthai?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12 col-md-3">
										<label >Tác giả <span class="text-red"></span></label>
										<input class="form-control" name="author" id="author" placeholder="Tác giả" type="text" value="<?=$news_detail['author']?>" />
									</div>
									
									<div class="col-xs-12 col-md-3">
										<label >Nguồn tham khảo <span class="text-red"></span></label>
										<input class="form-control" name="post_type" id="post_type" type="text" value="" />
									</div>
									<div class="col-xs-12 col-md-3">
										<label >Đường dẫn <span class="text-red"></span></label>
										<input class="form-control" name="url_coppy" placeholder="Đường dẫn tham khảo" id="url_coppy" type="text" value="<?=$news_detail['url_coppy']?>" />
									</div>
									<div class="col-xs-12 col-md-3">
										<label >Thời gian XB<span class="text-red"></span></label>
										<?php if($news_detail['aproved_date'] > 0){ $aproved_date = date('Y-m-d\TH:i',$news_detail['aproved_date']);}else{ $aproved_date = date('Y-m-d\TH:i');} ?>
											<input class="form-control" name="aproved_date" id="aproved_date" type="datetime-local" value="<?php echo $aproved_date ?>" />
									</div>
								</div>
								
								<div class="form-group row">
									
									<?php if($_SESSION['user']['role_type'] == "ADMIN"){ ?>
									<div class="col-xs-12 col-md-6">
										<label >Tiền nhuận bút <span class="text-red"></span></label>
										<input class="form-control" name="nhuanbut" id="nhuanbut" placeholder="Nhuận bút" type="number" value="<?=$news_detail['nhuanbut']?>" />
									</div>
									<?php } ?>
									<label for="staticEmail" class="col-sm-6 col-xs-12 col-form-label">Ảnh đại diện:<?php 
										$url_image = getimagesize($news_detail['image']);
										if($news_detail['image'] != '' && is_array($url_image)){
											$image_avatar = $news_detail['image'];
										}else{
											$image_avatar = '/upload/noimage.png';
										} ?>
										<img style="height:60px;" id="newImg" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="chooseImg();" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label>
										<!--input class="form-control" id="image" name="image" type="hidden" placeholder="Đường dẫn ảnh..." value="<?=$news_detail['image']?>" /-->
										<input type="file" name="hinhanh" id="img" style="display:none" onchange="readURL(this)" accept="image/png, image/jpeg">
										
								</div>
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
								<div class="form-group hidden">
									<div class="col-xs-12">
										<label for="image_thumb">Chọn ảnh thumb thu nhỏ:</label>
										<?php 
										$url_image_thumb = getimagesize($news_detail['image_thumb']);
										if($news_detail['image_thumb'] != '' && is_array($url_image)){
											$image_thumb = $news_detail['image_thumb'];
										}else{
											$image_thumb = '/upload/noimage.png';
										} ?>
										<img style="height:60px;" id="image_thumb" txthide="image_thumb" class="choiceImg cursor " src="<?=$image_thumb?>" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống">
										<input class="form-control " id="image_thumb" name="image_thumb" type="text" placeholder="Đường dẫn ảnh..." value="<?=$news_detail['image_thumb']?>" />
									</div>
								</div>
								
								<div class="form-group hidden">
									<label for="meta_description_vi" class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Đường dẫn:</label>
									<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">
										<input class="form-control" name="url_part" id="url_part" type="text" placeholder="Đường dẫn URL" onblur="check_value_exist('<?=$news_detail['url_part']?>', '#url_part', 'e4_posts', 'url_part', '#error_url_part', 'Đường dẫn URL');" value="<?=$news_detail['url_part']?>" />
									</div>

								</div>
								<div class="form-group">
									<div class="col-xs-12 col-md-12">
										<label>Tin liên quan</label>
										<select class="form-control select2" id="category_id" name="relation[]" data-placeholder="Chọn tin liên quan..." style="width: 100%;" multiple="multiple">
											<?php
											foreach ($postnews as $postnew) {
												$selected = (in_array($postnew->id, $relation_id_list)) ? 'selected' : '';
												echo '<option '. $selected .' value="' . $postnew->id . '">' . $postnew->title_vi . '</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
										<input class="form-control" name="meta_keyword" placeholder="Từ khóa:" id="meta_keyword_vi" type="text" value="<?=$news_detail['meta_keyword']?>" />
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
										<textarea class="form-control" rows="3" name="meta_description" placeholder="Mô tả:" id="meta_description_vi" ><?=$news_detail['meta_description']?></textarea>
									</div>
								</div>
								
							</div>
							</div>
							
							<div class="form-group">
								<label for="meta_description_en" class="col-sm-12 col-md-12 col-lg-12">Góp ý bài đăng</label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<textarea class="form-control" rows="3" name="aproved_comment" id="aproved_comment" placeholder="Nội dung góp ý..."><?=$news_detail['aproved_comment']?></textarea>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary" id="capnhat" name="submit" value="news_edit">Cập nhật</button>
						<?php if($_SESSION['user']['role_type'] == 'ADMIN' && $news_detail['post_status'] != 'active'){ ?>
							<button type="submit" class="btn btn-warning" id="xuatban" name="submit" value="xuatban">Xuất bản</button>
						<?php } ?>
						<?php if($_SESSION['user']['role_type'] == 'ADMIN' || $_SESSION['user']['role_type'] == 'CHECK'){?>
							<?php if($news_detail['post_status'] == 'active'){ // Nếu đã duyệt hiển thị nút gỡ, cập nhật ?>
							<button type="submit" class="btn btn-danger" id="gobaidang" name="submit" value="gobaidang">Gỡ bài</button>
							<?php }elseif($news_detail['post_status'] == 'waiting'){ // Nếu đang chờ duyệt thì hiển thị nút đăng, hủy, cập nhật ?>
							<button type="submit" class="btn btn-danger" id="tuchoi" name="submit" value="tuchoi">Từ chối</button>
							<?php }elseif($news_detail['post_status'] == 'deactive' || $news_detail['post_status'] == 'lock'){ // Nếu từ chối hiển thị nút duyệt tin trạng thái chờ, cập nhật ?>
							<button type="submit" class="btn btn-warning" id="choxuly" name="submit" value="choxuly">Chờ xử lý</button>
							<?php } ?>
						<?php } ?>
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->
<script>
	$(".select2").select2();
</script>