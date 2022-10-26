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
$query = "SELECT a.*,b.*,C.fullname from e4_royalties a 
			left join e4_posts b on b.id = a.post_id 
			left join e4_users c on c.id = a.user_id 
			WHERE a.id = $id order by a.id desc";
$database->setQuery($query);
$news_detail = $database->loadRow();

$array_status = array(1=> 'Đã thanh toán', 0=>'Chờ thanh toán');




?>
<div class="modal-dialog modal-wide" style="width:50%;">
	<form method="POST" action="?module=royalties&task=news_edit&id=<?php echo $id ?>" name="news_edit" id="news_edit" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin nhuận bút</h4>
			</div>
			<div class="modal-body modal-scroll">
				<div class="nav-tabs-custom">
					
					<div class="tab-content">
						<div class="active tab-pane" id="info_general">
							<div class="form-group">
								<label for="title_vi" class="col-sm-12 col-md-12 col-lg-12">Tiêu đề Tiếng Việt <span class="text-red">*</span></label>
								
								<div class="col-sm-12 col-md-12 col-lg-12">
									<input class="form-control" name="title_vi" id="title_vi" type="text" required value="<?=$news_detail['title_vi']?>" readonly />
								</div>
								
							</div>
							<div class="form-group">
								<label for="title_vi" class="col-sm-12 col-md-12 col-lg-12">Người viết <span class="text-red">*</span></label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<input  class="form-control" name="user" id="user" type="text" required value="<?=$news_detail['fullname']?>" readonly />
								</div>
					
							</div>
							<div class="form-group">
								<label for="title_vi" class="col-sm-12 col-md-12 col-lg-12"> Trạng thái <span class="text-red">*</span></label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<select name="status" id="status" class="form-control" onchange="this.form.submit();">
											<option value="0" <?php echo ('0' == $news_detail['status']) ? 'selected="selected"' : ''; ?>>Chờ thanh toán</option>
											<option value="1" <?php echo ('1' == $news_detail['status']) ? 'selected="selected"' : ''; ?>>Đã thanh toán</option>
									</select>
									<!--input  class="form-control" name="status" id="status" type="text" value="<?= $array_status[$news_detail['status']]?>" readonly /-->
								</div>
								
							</div>
							<div class="form-group">
								<label for="title_en" class="col-sm-12 col-md-12 col-lg-12">Giá tiền</label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<input type="number" class="form-control" name="price" id="price" type="text" value="<?=$news_detail['price']?>" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="title_en" class="col-sm-12 col-md-12 col-lg-12">Ghi chú</label>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<textarea class="form-control" name="notice" id="notice"><?= $news_detail['notice']?></textarea>
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
						<button type="submit" class="btn btn-primary" id="capnhat" name="submit" value="news_edit">Cập nhật</button>
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