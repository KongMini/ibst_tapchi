<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;
//print_r($_SESSION["member"]);
?>

<!DOCTYPE html>
<html>
<head>
<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />

<meta property="og:site_name" content="<?= $ariacms->web_information->{$params->name} ?>" />
<meta property="og:url" content="<?= $ariacms->c_url ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>

<meta property="og:image" content="https://taichinhso.net.vn/upload/banner.png"/>

<?= $ariacms->getBlock("head"); ?>
<!--
<script type="text/javascript" src="/plugins/editor/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="/templates/aptcms/bootstrap/css/bootstrap.min.css">
<script src="/templates/aptcms/bootstrap/js/bootstrap.min.js"></script>
-->
</head>
<body>
<div class="w1200">
<?= $ariacms->getBlock("header"); ?>
</div>
<style>
.tabcontent {
  display: none;
}
.active a{
	color:blue;
	font-weight: 600;
	    border-bottom: 3px solid #2a41e8;
}
.cd-secondary-nav ul li:not(:last-child) {
    padding-right: 10px;
}
table{
	margin-top:30px;
}
table, th, td {
  border: 1px solid #818181;
      color: #818181;
}
td.tdst{
	padding:10px;
}
td.tdst.ct{
	text-align: center;
}
</style>
<div class="main_content w1200" style="min-height: 450px; padding: 0 50px">
		<div class="mcontainer">
			<div class="flex justify-between  flex-col-reverse lg:flex-row">
                        <nav class="cd-secondary-nav pl-2 is_ligh -mb-0.5 border-transparent">
                            <!--<ul>
                                <li class="tablinks active" onclick="openCity(event, 'dadang')" style="display: inline-block;"><a href="#0"> Đã được duyệt </a></li>
                                <li class="tablinks" onclick="openCity(event, 'choduyet')" style="display: inline-block;"><a href="#0" >Đang chờ duyệt </a></li>
                                <li class="tablinks" onclick="openCity(event, 'bituchoi')" style="display: inline-block;"><a href="#0">Bị từ chối </a></li>
                                <li class="tablinks" onclick="openCity(event, 'dabigo')" style="display: inline-block;"><a href="#0">Bài đã gỡ </a></li>
                            </ul>-->
                        </nav>

                        <div class="flex items-center space-x-1.5 flex-shrink-0 pr-3  justify-center order-1">
                            <!-- <a href="#" class="text-blue-500"> See all </a> -->
                            <!--a href="/member/tao-bai-viet.html" class="flex items-center justify-center h-10 px-5 rounded-md bg-blue-600 text-white  space-x-1.5" style="background-color:#f44336">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                </svg>
                                <span> Thêm bài viết </span>
                            </a-->
							<table>
							  <tr>
								<th style="width:4%">STT</th>
								<th style="width:10%">Mã bài báo</th>
								<th style="width:30%">Tiêu đề</th>
								<th style="width:12%">Ngày mời phản biện</th>
								<th style="width:12%">Ngày chấp nhận phản biện</th>
								<th style="width:12%">Ngày gửi phản biện </th>
								<th style="width:12%">Đánh giá</th>
								<th style="width:10%">Thao tác</th>
							  </tr>
							  
							  <?php foreach($phanbien_posts as $k => $post ) {
							  if($post->dongy == 0 ){
								    if($post -> ngaypb > 0)
										$status = 'Không đồng ý đăng';
									if($post -> trangthai == 1){
										$status = 'Đồng ý phản biện';
									}
									if($post -> trangthai == 2){
										$status = 'Từ chối phản biện';
									}
							  } else if ($post->dongy == 1){
									$status = 'Đồng ý đăng có chỉnh sửa';
							  }else if ($post->dongy == 2){
									$status = 'Đồng ý đăng';
							  }
							  ?>
							  <tr>
							  
								<td class="tdst ct"><?=$k+1?></td>
								<td class="tdst"><a href='phan-bien.html?id=<?=$post->id?>'><?php echo $post->mabaibao ?></a></td>
								<td class="tdst"><a href='phan-bien.html?id=<?=$post->id?>'><?php echo $post->title_vi ?></a></td>
								<td class="tdst"><a href='phan-bien.html?id=<?=$post->id?>'><?php if($post->ngayguipb) echo Date("d-m-Y H:i:s",$post->ngayguipb) ?></a></td>
								<td class="tdst"><a href='phan-bien.html?id=<?=$post->id?>'><?php if($post->ngaydongypb) echo Date("d-m-Y H:i:s",$post->ngaydongypb) ?></a></td>
								<td class="tdst"><a href='phan-bien.html?id=<?=$post->id?>'><?php if($post->ngaypb) echo Date("d-m-Y H:i:s",$post->ngaypb) ?></a></td>
								<td class="tdst ct"><a href='phan-bien.html?id=<?=$post->id?>'><?php echo $status ?></a></td>
								<td class="tdst ct"><a href='phan-bien.html?id=<?=$post->id?>'><i class="fa fa-eye" aria-hidden="true"></i></a></td>
							  </tr>
							  <?php } ?>
							</table>
                            
                        </div>
                    </div>

					<!--
					<div id="dadang" class="tabcontent" style="display: block;">
					  <?php 
						$n_active = 0;
						foreach($phanbien_posts as $post) {
						if($post->status == 'chokiemduyet'){ $n_active++;
						$like="";
						if($array_liked[$post->id] > -1){
							$like = 'style="color: blue;"';
						}?>
						<div class="lg:flex lg:space-x-6 py-6">
	
							<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>">
								<div class="lg:w-60 w-full h-40 overflow-hidden rounded-lg relative shadow-sm"> 
									 <img src="<?=$post->image?>" alt="" class="w-full h-full absolute inset-0 object-cover">
									 <div class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
										<i class="spr spr__clock"></i><?php if($post->post_created > 0){ echo $ariacms->unixToDate($post->post_created, '/') .' '. $ariacms->unixToTime($post->post_created, ':') ;}?>
									 </div>
								</div>
							</a>
							
							<div class="flex-1 lg:pt-0 pt-4"> 
								 
								<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="text-xl font-semibold line-clamp-2">  <?=$post->title_vi?></a>
								<p class="line-clamp-2 pt-1"> <?=$post->brief_vi?></p>
								
								<div class="flex items-center pt-3">
									<div class="flex items-center" id="like<?=$post->id?>">  
										<a href="<?=$url_login;?>" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="likepost('<?=$post->id?>')" <?php } ?> class="items-center"><ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="thumbs up outline" <?= $like ?>></ion-icon>  <?php echo $post->number_like ?> </a>
									</div>
									<div class="flex items-center mx-4" > 
										<a href="<?=$url_login;?>" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="commentpost('<?=$post->id?>','<?=$_SESSION["member"]['id']?>')" <?php } ?> class="items-center">
										<ion-icon name="chatbubble-ellipses-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>  <?php echo $post->number_comment ?> 
										</a>
									</div>
								</div>

							</div>
						</div>
						<?php } } 
						if($n_active == 0){
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<a class="text-xl font-semibold line-clamp-2">  Chưa có bài đăng nào</a>
						</div>
						<?php } ?>
					</div>

					<div id="choduyet" class="tabcontent">
					  <?php 
						$n_waiting = 0;
						foreach($phanbien_posts as $post) {
						if($post->post_status == 'choduyet'){ $n_waiting++;
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<div class="flex-1 lg:pt-0 pt-4">
								<a href="javascript:;" data-toggle="collapse" data-target="#baiviet<?php echo $post->id; ?>" class="text-xl font-semibold line-clamp-2"><h3> <?=$post->title_vi?></h3></a>
								<i class="spr spr__clock"></i><?php if($post->post_created > 0){ echo $ariacms->unixToDate($post->post_created, '/') .' '. $ariacms->unixToTime($post->post_created, ':') ;}?>
								
								<div id="baiviet<?php echo $post->id; ?>" class="collapse">
									<div class="sa-lsnmain clearfix">
										<p class="line-clamp-2 pt-1"> <?=$post->content_vi?></p>
									</div>
								</div>
							</div>
						</div>
						<?php } } 
						if($n_waiting == 0){
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<a class="text-xl font-semibold line-clamp-2">  Chưa có bài đăng nào</a>
						</div>
						<?php } ?>
					</div>

					<div id="bituchoi" class="tabcontent">
					
					  <?php 
						$n_deactive = 0;
						foreach($phanbien_posts as $post) {
						if($post->post_status == 'deactive'){ $n_deactive++;
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<div class="flex-1 lg:pt-0 pt-4">
								<a href="javascript:;" data-toggle="collapse" data-target="#baiviet<?php echo $post->id; ?>" class="text-xl font-semibold line-clamp-2"><h3> <?=$post->title_vi?></h3></a>
								<i class="spr spr__clock"></i><?php if($post->post_created > 0){ echo $ariacms->unixToDate($post->post_created, '/') .' '. $ariacms->unixToTime($post->post_created, ':') ;}?>
							
								<div id="baiviet<?php echo $post->id; ?>" class="collapse">
									<div class="sa-lsnmain clearfix">
										<p class="line-clamp-2 pt-1"> <?=$post->content_vi?></p>
									</div>
								</div>
							</div>
						</div>
						<?php } } 
						if($n_deactive == 0){
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<a class="text-xl font-semibold line-clamp-2">  Chưa có bài đăng nào</a>
						</div>
						<?php } ?>
					</div>
					
					<div id="dabigo" class="tabcontent">
						<?php 
						$n_lock = 0;
						foreach($phanbien_posts as $post) {
						if($post->post_status == 'lock'){ $n_lock++;
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<a href="javascript:;">
								<div class="lg:w-60 w-full h-40 overflow-hidden rounded-lg relative shadow-sm"> 
									 <img src="<?=$post->image?>" alt="" class="w-full h-full absolute inset-0 object-cover">
									 <div class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
										<i class="spr spr__clock"></i><?php if($post->post_created > 0){ echo $ariacms->unixToDate($post->post_created, '/') .' '. $ariacms->unixToTime($post->post_created, ':') ;}?>
									 </div>
								</div>
							</a>
							<div class="flex-1 lg:pt-0 pt-4">
								<a href="javascript:;" class="text-xl font-semibold line-clamp-2">  <?=$post->title_vi?></a>
								<p class="line-clamp-2 pt-1"> <?=$post->brief_vi?></p>
								
								<div class="flex items-center pt-3">
									<div class="flex items-center">  
										<a href="javascript:;" class="items-center"><ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="thumbs up outline"></ion-icon>  <?=$post->number_like?> </a>
									</div>
									<div class="flex items-center mx-4" > 
										<a href="javascript:;" class="items-center">
											<ion-icon name="chatbubble-ellipses-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>  <?=$post->number_comment?> 
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php } } 
						if($n_lock == 0){
						?>
						<div class="lg:flex lg:space-x-6 py-6">
							<a class="text-xl font-semibold line-clamp-2">  Chưa có bài đăng nào</a>
						</div>
						<?php } ?>
					</div>
					
				-->
				
				<div class="clear"></div>
		</div>
	</div>
</div>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
	tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
	tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<script>

function suabaiviet($id){
	//alert($id);
	$.ajax({
		url: '<?= $ariacms->actual_link ?>ajax/ajax.suabaiviet.php',
		type: 'post',
		data: {row:$id},
		success: function(response){
			//alert(response.trim());
			if(response.trim()==1){
				window.location.href ="/member/sua-bai-viet.html";
			}else{
				alert('Không tìm thấy bài viết');
			}
		}
	}); 
}

function xoabaiviet($id){
	//alert($id);
	$.ajax({
		url: '<?= $ariacms->actual_link ?>ajax/ajax.xoabaiviet.php',
		type: 'post',
		data: {row:$id},
		success: function(response){
			//alert(response.trim());
			if(response.trim()==1){
				alert('Bài viết đã được xóa!');
				window.location.href ="/member/bai-viet.html";
			}else{
				alert('Không tìm thấy bài viết');
			}
		}
	}); 
}
</script>

<?= $ariacms->getBlock("footer"); ?>
<?= $ariacms->getBlock("footer_script"); ?>
</body>
</html>
