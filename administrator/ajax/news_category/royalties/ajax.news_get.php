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

$query = "SELECT * FROM e4_posts_meta WHERE post_id = $id";
$database->setQuery($query);
$term_metas = $database->loadObjectList();

foreach ($term_metas as $term_meta) {
	$news_detail['meta']->{$term_meta->meta_key} = $term_meta->meta_value;
}

$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
	LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
	GROUP BY a.id ORDER BY a.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();

$term_taxonomy_id_list = explode(",", $news_detail['term_taxonomy_id_list']);
$array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');
$array_location = array(2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong', 0=>'Tin thường');
?>
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=news&task=news_edit&id=<?php echo $id ?>" name="news_edit" id="news_edit" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body modal-scroll">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a aria-expanded="true" href="#info_general" data-toggle="tab">Thông tin chung <font class="text-red">*</font></a></li>
						<li><a aria-expanded="false" href="#info_document" data-toggle="tab">Thông tin tài liệu</a></li>
						<li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin SEO</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="info_general">
							<div class="form-group">
								<label for="title_vi" class="col-sm-6 col-md-6 col-lg-6">Tiêu đề Tiếng Việt <span class="text-red">*</span></label>
								<label for="title_en" class="col-sm-6 col-md-6 col-lg-6">Tiêu đề Tiếng Anh</label>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<input class="form-control" name="title_vi" id="title_vi" type="text" required value="<?=$news_detail['title_vi']?>" />
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<input class="form-control" name="title_en" id="title_en" type="text" value="<?=$news_detail['title_en']?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="brief_vi" class="col-sm-6 col-md-6 col-lg-6">Giới thiệu Tiếng Việt</label>
								<label for="brief_en" class="col-sm-6 col-md-6 col-lg-6">Giới thiệu Tiếng Anh</label>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<textarea class="form-control" rows="3" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..."><?=$news_detail['brief_vi']?></textarea>
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<textarea class="form-control" rows="3" name="brief_en" id="brief_en" placeholder="Tóm tắt giới thiệu bản tin..."><?=$news_detail['brief_en']?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="content_vi" class="col-sm-12 col-md-12 col-lg-12">Nội dung Tiếng Việt</label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<textarea class="form-control" name="content_vi" id="content_vi"><?=$news_detail['content_vi']?></textarea>
								</div>
								<script type="text/javascript">
									CKEDITOR.replace('content_vi', {
										// Reset toolbar settings, so full toolbar will be generated automatically.
										toolbarGroups: [{
												name: 'insert'
											},
											{
												name: 'others'
											},
											{
												name: 'paragraph',
												groups: ['align']
											},
											{
												name: 'basicstyles',
												groups: ['basicstyles']
											},
											{
												name: 'document',
												groups: ['mode', 'document', 'doctools']
											},
											{
												name: 'styles'
											}
										],
										removeButtons: null,
										height: 300,
										entities: false,
										fullPage: true,
										// Image browser
										filebrowserImageBrowseUrl: filemanageUrl,
										filebrowserImageUploadUrl: filemanageUrl,
										// allow style and css
										allowedContent: true,
										// auto wrap content in p tag
										autoParagraph: false
									});
								</script>
							</div>
							<div class="form-group">
								<label for="content_en" class="col-sm-12 col-md-12 col-lg-12">Nội dung Tiếng Anh</label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<textarea class="form-control" name="content_en" id="content_en"><?=$news_detail['content_en']?></textarea>
								</div>
								<script type="text/javascript">
									CKEDITOR.replace('content_en', {
										// Reset toolbar settings, so full toolbar will be generated automatically.
										toolbarGroups: [{
												name: 'insert'
											},
											{
												name: 'others'
											},
											{
												name: 'paragraph',
												groups: ['align']
											},
											{
												name: 'basicstyles',
												groups: ['basicstyles']
											},
											{
												name: 'document',
												groups: ['mode', 'document', 'doctools']
											},
											{
												name: 'styles'
											}
										],
										removeButtons: null,
										height: 300,
										entities: false,
										fullPage: true,
										// Image browser
										filebrowserImageBrowseUrl: filemanageUrl,
										filebrowserImageUploadUrl: filemanageUrl,
										// allow style and css
										allowedContent: true,
										// auto wrap content in p tag
										autoParagraph: false
									});
								</script>
							</div>
						</div>

						<div class=" tab-pane" id="info_document">
							<div class="form-group">
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label for="image">Ảnh đại diện:</label>
									<input class="btn btn-info margin" id="newImg" txthide="image" class="choiceFile cursor margin" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để chọn ảnh trên hệ thống" type="button" value="Chọn ảnh" />
									<input class="form-control " id="image" name="image" type="text" placeholder="Đường dẫn ảnh..." value="<?=$news_detail['image']?>" />
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label for="image_thumb">Ảnh thumb thu nhỏ:</label>
									<input class="btn btn-info margin" id="newImgThumb" txthide="image_thumb" class="choiceFile cursor margin" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để chọn ảnh trên hệ thống" type="button" value="Chọn ảnh" />
									<input class="form-control " id="image_thumb" name="image_thumb" type="text" placeholder="Đường dẫn ảnh..." value="<?=$news_detail['image_thumb']?>" />
								</div>
							</div>
							<div class="form-group">
								
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label for="post_status">Trạng thái và hiển thị:</label>
									<select id="post_status" name="post_status" class="form-control" disabled>
										<option value="<?php echo $news_detail['post_status'] ?>"><?php echo $array_status[$news_detail['post_status']] ?></option>
									</select>
								</div>
								
								<div class="col-sm-6 col-md-6 col-lg-6">
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
								<div class="col-sm-6 col-md-6 col-lg-6">
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
								
								<div class="col-sm-6 col-md-6 col-lg-6">
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
							<div class="form-group">
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label >Quản lý hiển thị</label>
									<select id="news_position" name="news_position" class="form-control">
										<option value="">- Chọn -</option>
										<?php foreach($array_location as $key2 => $location){ ?>
											<option <?=($news_detail['news_position'] == $key2)? 'selected' : '';?> value="<?=$key2?>"><?=$location?></option>
										<?php } ?>
									</select>
								</div>
							</div>

						</div>

						<div class="tab-pane" id="info_other">
							<p id="error_url_part" class="col-sm-9 col-md-9 col-lg-9 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 text-danger"></p>
							<div class="form-group">
								<label for="url_part" class="col-sm-3 col-md-3 col-lg-3 control-label">Đường dẫn URL:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="url_part" id="url_part" type="text" onblur="check_value_exist('<?=$news_detail['url_part']?>', '#url_part', 'e4_posts', 'url_part', '#error_url_part', 'Đường dẫn URL');" value="<?=$news_detail['url_part']?>" />
								</div>

							</div>

							<div class="form-group">
								<label for="meta_title_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Title Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_title_vi" id="meta_title_vi" type="text" value="<?=$news_detail['meta']->meta_title_vi?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_title_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Title Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_title_en" id="meta_title_en" type="text" value="<?=$news_detail['meta']->meta_title_en?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_keyword_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Keyword Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_keyword_vi" id="meta_keyword_vi" type="text" value="<?=$news_detail['meta']->meta_keyword_vi?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_keyword_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Keyword Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_keyword_en" id="meta_keyword_en" type="text" value="<?=$news_detail['meta']->meta_keyword_en?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_description_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Description Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_description_vi" id="meta_description_vi" type="text" value="<?=$news_detail['meta']->meta_description_vi?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_description_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Description Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_description_en" id="meta_description_en" type="text" value="<?=$news_detail['meta']->meta_description_en?>" />
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