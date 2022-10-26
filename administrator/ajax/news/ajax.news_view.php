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
//$params = new params();
$id = $_REQUEST['id'];
$query = "SELECT a.id post_id, d.id categoryid , d.url_part url_part_cat ,d.title_vi taxonoky, a.*, b.fullname FROM e4_posts a 
			 left	JOIN e4_users b ON a.user_created = b.id 
			left	 JOIN e4_term_relationships c ON a.id = c.object_id
			left	 JOIN e4_term_taxonomy d ON d.id = c.term_taxonomy_id
			WHERE a.id = '$id' 
			limit 0,1 "; //echo $query;
			
		$database->setQuery($query);
		$detail = $database->loadRow();
		
		
	
		
?>
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=news&task=news_edit&id=<?php echo $id ?>" name="news_edit" id="news_edit" class="form-horizontal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Xem trước bài viết</h4>
			</div>
			<div class="modal-body modal-scroll" style="width: 75%;margin: auto;">
				<div class="nav-tabs-custom">
					<div class="divide-y">
								
						<div class="l-content">

							<div class="details">
								<div class="details__header">
									<h1 class="details__headline"> <?= $detail["title_vi"] ?></h1>
								<div class="details__meta">
									<div class="meta">
										<span class="time">
										<ion-icon name="time-outline"></ion-icon>
										<?php if($detail['aproved_date'] > 0){
										echo $ariacms->unixToDate($detail['aproved_date'], '/') .' '. $ariacms->unixToTime($detail['aproved_date'], ':') ;
										}?>
										</span>
									</div>
									
								</div>	
								
									<div class="lg:flex">
										<h2 class="sapo"> <?= $detail['brief_vi'] ?></h2>
									</div>
								</div>
								
								
								<div class="details__content">
									<?= $detail['content_vi']; ?>
									
									<?php $count= count($posts_relation);
									if($count > 0){?>
										<div class="tags">
											<h3 class="label"><b> Bài viết liên quan:</b></h3>
											<ul>
												<?php
													$count= count($posts_relation);
													$i=0;
													foreach($posts_relation as $post){
														
														?>
														<li><a style=" color: blue;" href="<?= $ariacms->actual_link ?>chi-tiet/<?=$post->url_part?>.html">&nbsp;&nbsp;&nbsp;&nbsp;<?="- ".$post->title_vi?></a></li>
														<?php
													}
												 ?>
											 </ul>
											
											<ul>
												<?php
												foreach ($taxonomies as $taxonomy) {
													if ($taxonomy->taxonomy == 'post_tags') {
												?>
													<li><a href="<?= $ariacms->actual_link . 'blog/' . $taxonomy->url_part . '.html'; ?>"><?= $taxonomy->{$params->title} ?><span>(<?= $taxonomy->count ?>)</span></a></li>
												<?php
													}
												}
												?>

											 </ul>
										</div>
									<?php }?>
									
									<div class="author" style="text-align: right"><strong> <?= $author ?></strong></div>
									<div class="source" style="text-align: right"> <?=$source ?></div>
									<div class="link text-dark" style="text-align: right"><?= $detail['url_coppy']; ?></div>
								</div>
								<script>  
								 $(document).ready(function(){   //alert("d");
								 var menu_active ='<?php echo "tin-tuc/".$detail["url_part_cat"].".html"; ?>'; //alert(menu_active);
								 $("#"+menu_active).removeClass("menu-heading");
									$("#"+menu_active).addClass("menu-heading selected");
									
								});
								</script>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<!--button type="submit" class="btn btn-primary" id="capnhat" name="submit" value="news_edit">Cập nhật</button>
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
						<?php } ?> -->
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