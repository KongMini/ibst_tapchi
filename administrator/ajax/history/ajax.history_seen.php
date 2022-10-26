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

// sửa id_post -> id và lấy 1 bản ghi tiếp theo

$id = $_REQUEST['id'];
$query = "SELECT * FROM `e4_posts_history` WHERE id_post = ".$id." ORDER BY post_modified DESC LIMIT 0,2";
$database->setQuery($query);
$detail = $database->loadObjectList();
$count =  count($detail);
?>
<div class="modal-dialog modal-wide">

		<div class="modal-content">
			
				<div class="col-md-6" style = "padding: 15px;border-right: 1px solid;">
					<div class="modal-header">				
						<h4 class="modal-title" style = "border-botto: 1px solid;"><b style = "border-bottom: 1px solid;">Sau</b></h4>
					</div>
					<style>
						img {
							vertical-align: middle;
							width: 600px;
						}
					</style>
					<div class="details">
							<div class="details__header">
								<h1 class="details__headline"> <?= $detail[0]->title_vi ?></h1>
								<img src="<?=$detail[0]->image?>" style ="width:100%; vertical-align:middle" alt="">
								<div class="details__meta">
									<div class="meta">
										<span class="time">
										<i class="spr spr__clock"></i>
										<?php if($detail[0]->post_created > 0){
										echo $ariacms->unixToDate($detail[0]->post_created, '/') .' '. $ariacms->unixToTime($detail[0]->post_created, ':') ;}?>
										</span>
										<span>
											<i class="spr spr__user"></i><b><?= $source ?></b>
										</span>
									</div>
								</div>
								<div class="details__summary"><?= $detail[0]->brief ?></div>
							</div>
							<div class="details__content">
							<?= $detail[0]->content_vi ?>
							<div style="text-align: right"><strong> <?= $source ?></strong></div>
							</div>
					</div>
				</div>
				<?php if($count == 2){?>
				<div class="col-md-6" style = "padding: 15px;">
					<div class="modal-header">				
						<h4 class="modal-title"><b style = "border-bottom: 1px solid;">Trước</b></h4>
					</div>
					<div class="details" >
							<div class="details__header">
								<h1 class="details__headline"> <?= $detail[1]->title_vi ?></h1>
								<img src="<?=$detail[1]->image ?>" style ="width:100%; vertical-align:middle" alt="">
								<div class="details__meta">
									<div class="meta">
										<span class="time">
										<i class="spr spr__clock"></i>
										<?php if($detail[1]->post_created> 0){
										echo $ariacms->unixToDate($detail[1]->post_created, '/') .' '. $ariacms->unixToTime($detail[1]->post_created, ':') ;}?>
										</span>
										<span>
											<i class="spr spr__user"></i><b><?= $source ?></b>
										</span>
									</div>
								</div>
								<div class="details__summary"><?= $detail[1]->brief ?></div>
							</div>
							<div class="details__content">
							<?= $detail[1]->content_vi ?>
							<div style="text-align: right"><strong> <?= $source ?></strong></div>
							</div>
					</div>
				</div>
				<?php }?>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	
</div>




<!--div class="modal-dialog modal-wide">
<div class="l-content">

<div class="details">
	<div class="details__header">
		<h1 class="details__headline"> <?= $detail['title_vi'] ?></h1>
		<img src="<?=$detail['image'] ?>" style ="width:100%; vertical-align:middle" alt="">
		<div class="details__meta">
			<div class="meta">
				<span class="time">
				<i class="spr spr__clock"></i>
				<?php if($detail['post_created'] > 0){
				echo $ariacms->unixToDate($detail['post_created'], '/') .' '. $ariacms->unixToTime($detail['post_created'], ':') ;}?>
				</span>
				<span>
					<i class="spr spr__user"></i><b><?= $source ?></b>
				</span>
			</div>
			<div class="right">
				<i class="spr spr__message-square"></i><a href="#comment212095" style="display: inline-block;">0 bình luận</a>
			</div>
		</div>
		<div class="details__summary"><?= $detail['brief'] ?></div>
	</div>
	<div class="details__content">
	<?= $detail['content_vi'] ?>
	<div style="text-align: right"><strong> <?= $source ?></strong></div>
	</div>




	</div>
</div>
</div-->




<script>
	$(".select2").select2();
</script>