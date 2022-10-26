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
$product_detail = $database->loadRow();

$query = "SELECT * FROM e4_posts_meta WHERE post_id = $id";
$database->setQuery($query);
$term_metas = $database->loadObjectList();

foreach ($term_metas as $term_meta) {
	$product_detail['meta']->{$term_meta->meta_key} = $term_meta->meta_value;
}

$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
	LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
	GROUP BY a.id ORDER BY a.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();

$term_taxonomy_id_list = explode(",", $product_detail['term_taxonomy_id_list']);

$images = $ariacms->selectAll('e4_posts_image', 'object_id=' . $id, '');
?>
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=product&task=product_edit&id=<?php echo $id ?>" name="product_edit" id="product_edit" class="form-horizontal">
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
									<input class="form-control" name="title_vi" id="title_vi" type="text" required value="<?= $product_detail['title_vi'] ?>" />
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<input class="form-control" name="title_en" id="title_en" type="text" value="<?= $product_detail['title_en'] ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="product_sale" class="col-sm-6 col-md-6 col-lg-6">Giá bán ra</label>
								<label for="product_price" class="col-sm-6 col-md-6 col-lg-6">Giá ban đầu (nếu có)</label>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<input class="form-control" name="product_sale" id="product_sale" type="number" value="<?= $product_detail['product_sale'] ?>" />
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<input class="form-control" name="product_price" id="product_price" type="number" value="<?= $product_detail['product_price'] ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="brief_vi" class="col-sm-6 col-md-6 col-lg-6">Giới thiệu Tiếng Việt</label>
								<label for="brief_en" class="col-sm-6 col-md-6 col-lg-6">Giới thiệu Tiếng Anh</label>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<textarea class="form-control" rows="3" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..."><?= $product_detail['brief_vi'] ?></textarea>
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<textarea class="form-control" rows="3" name="brief_en" id="brief_en" placeholder="Tóm tắt giới thiệu bản tin..."><?= $product_detail['brief_en'] ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="content_vi" class="col-sm-12 col-md-12 col-lg-12">Nội dung Tiếng Việt</label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<textarea class="form-control" name="content_vi" id="content_vi"><?= $product_detail['content_vi'] ?></textarea>
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
										height: 500,
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
									<textarea class="form-control" name="content_en" id="content_en"><?= $product_detail['content_en'] ?></textarea>
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
										height: 500,
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
									<label for="image">Ảnh đại diện<span class="text-red">*</span>:</label>
									<?php if ($product_detail['image'] != '') { ?>
										<img style="height:75px;" id="newImg" txthide="image" class="choiceImg cursor margin" src="<?php echo $product_detail['image'] ?>" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để đổi ảnh đại diện" />
									<?php } else { ?>
										<img style="height:75px;" id="newImg" txthide="image" class="choiceImg cursor margin" src="templates/aptcms/dist/img/noimage.png" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để chọn ảnh đại diện" />
									<?php } ?>

									<input class="form-control " id="image" name="image" type="text" placeholder="Đường dẫn ảnh..." value="<?= $product_detail['image'] ?>" required />
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label for="image_thumb">Ảnh thumb thu nhỏ:</label>
									<?php if ($product_detail['image_thumb'] != '') { ?>
										<img style="height:75px;" id="newImgThumb" txthide="image_thumb" class="choiceImg cursor margin" src="<?php echo $product_detail['image_thumb'] ?>" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để đổi ảnh đại diện" />
									<?php } else { ?>
										<img style="height:75px;" id="newImgThumb" txthide="image_thumb" class="choiceImg cursor margin" src="templates/aptcms/dist/img/noimage.png" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để chọn ảnh đại diện" />
									<?php } ?>

									<input class="form-control " id="image_thumb" name="image_thumb" type="text" placeholder="Đường dẫn ảnh..." value="<?= $product_detail['image_thumb'] ?>" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label>Danh mục - Category</label>
									<select class="form-control select2" id="product_category" name="taxonomy[]" multiple="multiple" data-placeholder="Chọn danh mục..." style="width: 100%;">
										<?php
										foreach ($taxonomies as $taxonomy) {
											if ($taxonomy->taxonomy == 'product_category' && $taxonomy->parent == 0) {
												$selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
												echo '<option ' . $selected . ' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';
												if ($taxonomy->sub > 0) {
													foreach ($taxonomies as $taxonomy_sub) {
														if ($taxonomy->id == $taxonomy_sub->parent) {
															$selected = (in_array($taxonomy_sub->id, $term_taxonomy_id_list)) ? 'selected' : '';
															echo '<option ' . $selected . ' value="' . $taxonomy_sub->id . '">- - ' . $taxonomy_sub->title_vi . '</option>';
														}
													}
												}
											}
										}
										?>
									</select>
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label>Nhóm sp - Group</label>
									<select class="form-control select2" id="product_group" name="taxonomy[]" multiple="multiple" data-placeholder="Chọn nhóm..." style="width: 100%;">
										<?php
										foreach ($taxonomies as $taxonomy) {
											if ($taxonomy->taxonomy == 'product_group' && $taxonomy->parent == 0) {
												$selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
												echo '<option ' . $selected . ' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';
												if ($taxonomy->sub > 0) {
													foreach ($taxonomies as $taxonomy_sub) {
														if ($taxonomy->id == $taxonomy_sub->parent) {
															$selected = (in_array($taxonomy_sub->id, $term_taxonomy_id_list)) ? 'selected' : '';
															echo '<option ' . $selected . ' value="' . $taxonomy_sub->id . '">- - ' . $taxonomy_sub->title_vi . '</option>';
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
									<label>Phân loại - Type</label>
									<select class="form-control select2" id="product_type" name="taxonomy[]" multiple="multiple" data-placeholder="Chọn thuộc tính..." style="width: 100%;">
										<?php
										foreach ($taxonomies as $taxonomy) {
											if ($taxonomy->taxonomy == 'product_type' && $taxonomy->parent == 0) {
												$selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
												echo '<option ' . $selected . ' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';
												if ($taxonomy->sub > 0) {
													foreach ($taxonomies as $taxonomy_sub) {
														if ($taxonomy->id == $taxonomy_sub->parent) {
															$selected = (in_array($taxonomy_sub->id, $term_taxonomy_id_list)) ? 'selected' : '';
															echo '<option ' . $selected . ' value="' . $taxonomy_sub->id . '">- - ' . $taxonomy_sub->title_vi . '</option>';
														}
													}
												}
											}
										}
										?>
									</select>
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label for="post_status">Trạng thái và hiển thị:</label>
									<select id="post_status" name="post_status" class="form-control">
										<option value="">- Chọn -</option>
										<option <?= ($product_detail['post_status'] == 'active') ? 'selected' : ''; ?> value="active">Đã xuất bản</option>
										<option <?= ($product_detail['post_status'] == 'waiting') ? 'selected' : ''; ?> value="waiting">Chờ duyệt</option>
										<option <?= ($product_detail['post_status'] == 'deactive') ? 'selected' : ''; ?> value="deactive">Không được duyệt</option>
									</select>
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6">
									<label for="rating">Đánh giá:</label>
									<select id="rating" name="rating" class="form-control">
										<option value="0">- Chọn -</option>
										<option <?= ($product_detail['rating'] == 1) ? 'selected' : ''; ?> value="1">1 sao</option>
										<option <?= ($product_detail['rating'] == 2) ? 'selected' : ''; ?> value="2">2 sao</option>
										<option <?= ($product_detail['rating'] == 3) ? 'selected' : ''; ?> value="3">3 sao</option>
										<option <?= ($product_detail['rating'] == 4) ? 'selected' : ''; ?> value="4">4 sao</option>
										<option <?= ($product_detail['rating'] == 5) ? 'selected' : ''; ?> value="5">5 sao</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<input style="margin-bottom:10px;" class="btn btn-warning" onclick="AddNewImage();" data-toggle="tooltip" title="Nhấn để chọn thêm ảnh cho sản phẩm" type="button" value="Thêm ảnh mới" />
									Danh sách hình ảnh sản phẩm
									<div class="col-xs-12" id="imagelist">
										<?php
										$i = 0;
										foreach ($images as $image) {
											$i++;
										?>
											<div class="form-group">
												<div class="col-md-2" style="padding-left:0px;">
													<image src="<?= $image->image_link ?>" style="height:100px; width:100%;" />
												</div>
												<div class="col-md-2" style="padding-left:0px;">
													<input class="btn btn-info form-control" onclick="fcall.fcChoiceImg(this);" txthide="imagelist_<?= $i ?>" type="button" value="Chọn file ảnh <?= $i ?>" name="imageadd[<?= $i ?>]" id="imageadd_<?= $i ?>" />
												</div>
												<div class="col-md-8" style="padding-left:0px;">
													<input class="form-control" type="text" name="imagelist[<?php echo $i ?>]" id="imagelist_<?= $i ?>" txthide="imagelist_<?php echo $i ?>" ondblclick="fcall.fcChoiceImg(this);" placeholder="Đường dẫn ảnh <?= $i ?> cho sản phẩm" value="<?= $image->image_link ?>" />
												</div>
											</div>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="info_other">
							<p id="error_url_part" class="col-sm-9 col-md-9 col-lg-9 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 text-danger"></p>
							<div class="form-group">
								<label for="url_part" class="col-sm-3 col-md-3 col-lg-3 control-label">Đường dẫn URL:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="url_part" id="url_part" type="text" onblur="check_value_exist('<?= $product_detail['url_part'] ?>', '#url_part', 'e4_posts', 'url_part', '#error_url_part', 'Đường dẫn URL');" value="<?= $product_detail['url_part'] ?>" />
								</div>

							</div>

							<div class="form-group">
								<label for="meta_title_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Title Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_title_vi" id="meta_title_vi" type="text" value="<?= $product_detail['meta']->meta_title_vi ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_title_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Title Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_title_en" id="meta_title_en" type="text" value="<?= $product_detail['meta']->meta_title_en ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_keyword_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Keyword Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_keyword_vi" id="meta_keyword_vi" type="text" value="<?= $product_detail['meta']->meta_keyword_vi ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_keyword_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Keyword Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_keyword_en" id="meta_keyword_en" type="text" value="<?= $product_detail['meta']->meta_keyword_en ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_description_vi" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Description Tiếng Việt:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_description_vi" id="meta_description_vi" type="text" value="<?= $product_detail['meta']->meta_description_vi ?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="meta_description_en" class="col-sm-3 col-md-3 col-lg-3 control-label">Meta Description Tiếng Anh:</label>
								<div class="col-sm-9 col-md-9 col-lg-9">
									<input class="form-control" name="meta_description_en" id="meta_description_en" type="text" value="<?= $product_detail['meta']->meta_description_en ?>" />
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary " name="submit" value="product_edit">Cập nhật</button>
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->
<script>
	$(".select2").select2();
	var index_image = <?php echo count($images) ?>;

	function AddNewImage() {
		index_image++;
		var value_append = '<div class="form-group"><div class="col-md-2" style="padding-left:0px;"><input class="btn btn-info form-control" onclick="fcall.fcChoiceImg(this);" txthide="imagelist_' + index_image + '" type="button" value="Chọn file ảnh ' + index_image + '" name="imageadd[' + index_image + ']" id="imageadd_' + index_image + '" /></div><div class="col-md-10" style="padding-left:0px;"><input class="form-control" type="text" name="imagelist[' + index_image + ']" id="imagelist_' + index_image + '" txthide="imagelist_' + index_image + '" ondblclick="fcall.fcChoiceImg(this);" placeholder="Đường dẫn ảnh ' + index_image + ' cho sản phẩm" /></div></div>';
		$('#imagelist').append(value_append);
	}
</script>