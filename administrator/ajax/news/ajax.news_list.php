<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
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

$order = ' order by a.aproved_date desc';
$limit = " LIMIT 0,50";

$query = "SELECT a.*, b.fullname, c.category, d.tags,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
FROM e4_posts a
	LEFT JOIN e4_users b ON a.user_created = b.id 
	LEFT JOIN ( 
		SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category
		FROM e4_term_relationships t1 
		LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'category' GROUP BY t1.object_id
		) c ON a.id = c.object_id
	LEFT JOIN ( 
		SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS tags
		FROM e4_term_relationships t1 
		LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'post_tags' GROUP BY t1.object_id
		) d ON a.id = d.object_id
WHERE a.post_status = 'active' and a.news_position != 2 " . $order . $limit;

$database->setQuery($query);
$news = $database->loadObjectList();

$term_taxonomy_id_list = explode(",", $news_detail['term_taxonomy_id_list']);
$array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');
$array_location = array(2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong', 0=>'Tin thường');
$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
GROUP BY a.id ORDER BY a.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();
?>
<div class="modal-dialog modal-wide">
	<form method="POST" action="index.php?module=topic_manage&task=news_hot" name="news_hot" id="news_hot" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Thêm tin nổi bật</h4>
			</div>
			<div class="modal-body modal-scroll">
				<div class="form-group">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<input class="form-control" placeholder="Nhập từ khóa tìm kiếm" name="keyword" id="keyword" type="text" />
					</div>
					<div class="col-md-2">
						<select name="category2" id="category2" class="form-control" onchange="timkiemthongtin()">
							<option value="home"  <?php echo ($_REQUEST['category'] == 'home') ? 'selected="selected"' : ''  ?>>Trang chủ</option>
							<?php
								foreach ($taxonomies as $taxonomy) {
									if ($taxonomy->taxonomy == 'category'  && $taxonomy->parent == 0) {
										?>
										<option value="<?php echo $taxonomy->title_vi ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->title_vi) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';
									<?php }
								}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<a class="btn btn-success" href="javascript:;" onclick="timkiemthongtin()"> Tìm kiếm</a>
					</div>
				</div>
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center"  width="3%">STT</th>
								<th width="25%">Tiêu đề</th>
								<th width="">Người tạo</th>
								<th width="">Người duyệt</th>
								<th width="15%">Danh mục</th>
								<th width="">Ngày XB</th>
								<th width="">Vị trí</th>
								<th width="">Chọn</th>
							</tr>
						</thead>
						<tbody id="thongtintimkiem">
							<?php
							$i = 0;
							foreach ($news as $new) {
								$i++;
							?>
							<?php if($new->aproved_date > time()){ $title_post = "<i style='color: #ec3e3e'>".$new->title_vi."</i>";$color = "color: #ec3e3e";}else{$title_post = $new->title_vi;$color = "";} ?>
								<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} ?>>
									<td  class="text-center">
										<?php echo $i ?>
									</td>
									<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$title_post.'</a>' ?></td>
									<td><?php echo $new->fullname ?></td>
									<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
									<td><?php echo $new->category ?></td>
									<td style="<?=$color?>">
										<?php echo ($new->aproved_date) ? date("d/m/Y H:i",$new->aproved_date) : ''; ?>
									</td>
									<td>
										<?php echo $array_location[$new->news_position]; ?>
									</td>
									<td class="text-center">
										<input type="checkbox" name="vitri[]" id="vitri_<?php echo $new->id ?>" value="<?php echo $new->id ?>"  />
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div><!-- /.Đã duyệt -->
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<input type="submit" name="tin_top" class="btn btn-success" value="Cập nhật tin top" /> 
						<input type="submit" name="tin_phai" class="btn btn-success" value="Cập nhật tin bên phải" /> 
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->
<script>
	$(".select2").select2();
	
	function timkiemthongtin(){
		var keyword = $('#keyword').val();
		var category = $('#category2').val();
		
		var f="category="+category+"&keyword="+keyword;
		var _url="ajax/news/ajax.news_search.php"; 
		$.ajax({
			url: _url,
			data:f,
			cache: false,
			context: document.body,
			success: function(response) {
				//alert(response);
				$('#thongtintimkiem').html(response);
				//window.location.href = "";
			}
		});
	}
</script>