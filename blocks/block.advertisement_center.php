<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;
// lấy tin chinh trang chủ	 
$query = "SELECT 
	a.*,b.fullname as fullname,b.image_url FROM e4_posts a LEFT JOIN e4_users b on a.user_created = b.id

 WHERE a.news_position = 2 and a.post_status = 'active' ORDER BY a.iorder asc,a.id desc LIMIT 0,3";
//echo $query ;
$database->setQuery($query);
$posts = $database->loadObjectList();

$query = "SELECT * FROM `e4_web_image` WHERE position='banner' and status ='active' ORDER BY id DESC";
$database->setQuery($query);
$banner = $database->loadRow();

$query1 = "SELECT a.*,b.fullname as fullname,b.image_url FROM e4_posts a LEFT JOIN e4_users b on a.user_created = b.id
 WHERE a.news_position = 1 and a.post_status = 'active' ORDER BY a.iorder asc,a.id desc LIMIT 0,5";
//echo $query ;
$database->setQuery($query1);
$tamdiemthitruong = $database->loadObjectList();

$array_id = array();

$sotrang = $ariacms->getParaUrl('curPg');
if(!is_numeric($sotrang)){
	$sotrang = 1;
}
if(!$ariacms->checkUserLogin()){
	$lightbox = "uk-toggle";
	$url_login = '#modal-login';
	$url_post = '#modal-login';
}else{
	$lightbox = "";
	$url_login = "javascript:;";
	$url_post = '/member/tao-bai-viet.html';
}

?>

<div class="lg:w-2/3">
	<iframe src="https://online.fliphtml5.com/sghel/htbz/#p=1" width="100%" height="500px">
	</iframe>
	<?php if(isset($banner)){?>
		<div class="divide-y">
		
		<!-- Bài viết top 1 -->
			<div class="hotbanner">
				<div class="grid grid-cols-2 gap-2 p-2" style="padding: 0">
					  <a href="<?= $banner['link']?>" class="col-span-2 relative">  
						  <img src="<?= $banner['image']?>" alt="" class="rounded-md w-full lg:h-76 object-cover">
					  </a>
				</div>
			</div>
		</div>
	<?php }?>
		
	<div class="clear"></div>
	
	
		<style>
			.owl-carousel .owl-nav button.owl-prev{
			background: none;
			color: inherit;
			border: none;
			padding: 20px !important;
			font: inherit;
		}
		figure.cover_image{
			height:300px;
			background-color: transparent;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center center;
			background-size: cover;
		}
		
		</style>
		
	<div class="divide-y">
		
		<!-- Bài viết top 1 -->
		<div class="hotnew">
			<h2>&nbsp;</h2>
			<div class="owl-carousel owl-theme" id="tinnoibat">
					
				<?php foreach($posts as $key => $post){
				array_push($array_id,$post->id);
				?>
				<div class=" lg:space-x-6">
					<div class="w-full overflow-hidden  relative shadow-sm"> 
						<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>">
						<figure style="background-image: url('<?php if(trim($post->image)){echo  $post->image;} else {echo "/upload/noimage1.png";}?>')" class="w-full h-full inset-0 object-cover cover_image"></figure>
							
						</a>
					</div>
					<div class="noidung_tamdiem">
						<div class="story__meta">
							<div class="story__avatar">
								<img src="<?if($post->image_url) echo $post->image_url; else echo "/upload/noiavatar.png"; ?>" alt="<?= $post->fullname?>" class="img-fluid rounded-circle">
							</div>
							<div class="story__info">
								<h3 class="story__author"><b><?=$post->fullname?></b></h3>
								<?php
								$first_date = time();
								$secon_date = $post->post_created;
								$diff = abs($first_date - $secon_date);
								$phut = $diff / 24;
								
								if($phut >= 60){
									$gio = floor($phut/60);
									if($gio < 48){
										$hienthingay = floor($gio).' giờ trước';
									}else{
										$hienthingay = date('H:i d/m/Y',$post->post_created);
									}
								}else{
									$hienthingay = floor($phut).' phút trước';
								}
								?>
								<div class="story__time" style="margin-top: -5px;"><time datetime="<?php echo date('Y-m-d H:i:s',$post->post_created) ?>" class="time-ago"><?=$hienthingay?></time></div>
							</div>
						</div>
						<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="text-xl font-semibold line-clamp-2">  <?=$post->title_vi?></a>
						<p class="line-clamp-3 pt-1"> <?=$post->brief_vi?></p>	
					</div>
				</div>
				<?php }?>
			</div>
		</div>
		<div class="clear"></div>
		<?php if(count($tamdiemthitruong ) > 0){?>
		<div class="lam-seo "> <!--xs:hidden-->
			<h2>Hot trend</h2>
			<div class="owl-carousel owl-theme " id="tamdiem">
				<?php foreach($tamdiemthitruong as $key => $tamdiem){
				array_push($array_id,$tamdiem->id);?>
				<div class=" lg:space-x-6">
					<div class="w-full h-40 overflow-hidden  relative shadow-sm"> 
						<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $tamdiem->url_part . '.html';?>"><img id="avt<?=$k?>" src="<?php if(trim($tamdiem->image)){echo  $tamdiem->image;} else {echo "/upload/noimage1.png";}?>" alt="" class="w-full h-full inset-0 object-cover"></a>
					</div>
					<div class="noidung_tamdiem">
					
						<div class="story__meta">
							<div class="story__avatar">
								<img src="<?if($tamdiem->image_url) echo $tamdiem->image_url; else echo "/upload/noiavatar.png"; ?>" alt="<?= $tamdiem->fullname?>" class="img-fluid rounded-circle">
							</div>
							<div class="story__info">
								<h3 class="story__author"><b><?=$tamdiem->fullname?></b></h3>
								<?php
								$first_date = time();
								$secon_date = $tamdiem->post_created;
								$diff = abs($first_date - $secon_date);
								$phut = $diff / 24;
								
								if($phut >= 60){
									$gio = floor($phut/60);
									if($gio < 48){
										$hienthingay = floor($gio).' giờ trước';
									}else{
										$hienthingay = date('H:i d/m/Y',$tamdiem->post_created);
									}
								}else{
									$hienthingay = floor($phut).' phút trước';
								}
								?>
								<div class="story__time" style="margin-top: -5px;"><time datetime="<?php echo date('Y-m-d H:i:s',$tamdiem->post_created) ?>" class="time-ago"><?=$hienthingay?></time></div>
							</div>
						</div>

						
					
						<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $tamdiem->url_part . '.html';?>" class="text-xl font-semibold line-clamp-2">  <?=$tamdiem->title_vi?></a>
						<p class="line-clamp-3 pt-1"> <?=$tamdiem->brief_vi?></p>	
					</div>
				</div>
				<?php }?>
			</div>
		</div>
		<?php }?>
		<div class="clear"></div>
		<?php
		$str_id = implode(',',$array_id);
		$maxRows = $ariacms->web_information->posts_per_page; 
		$query = "SELECT a.*,b.fullname as fullname,b.image_url FROM e4_posts a LEFT JOIN e4_users b on a.user_created = b.id WHERE a.id not in (".$str_id.") and a.post_status = 'active' ORDER BY aproved_date desc";
		$database->setQuery($query);
		$posts_news = $database->loadObjectList();
		?>
		<?php 
			$query = "select post_id  from e4_post_like where member_id = ".$_SESSION["member"]['id']." ORDER BY id desc";
			$database->setQuery($query);
			$member_likes = $database->loadObjectList();

			$array_liked = array();
			foreach($member_likes as $key){
				array_push($array_liked,$key->post_id);
			}
			$array_liked = array_flip($array_liked);

			$curPg = $ariacms->getParaUrl('curPg');
			if ($curPg == '') $curPg = 1;
			$curRow = ($curPg - 1) * $maxRows;
			$k = 0;
			while ($curRow < count($posts_news) && ($curRow < $curPg * $maxRows)) {
				$k++;
			$post = $posts_news[$curRow];
			$curRow++;
			$like="";
			if($array_liked[$post->id] > -1){
				$like = 'style="color: blue;"';
			}
		?>
		
		<div class="lg:flex lg:space-x-6 py-6 danhsachtin">
			
			<div class="flex-1 lg:pt-0 pt-4">
				
				<div class="story__meta">
					<div class="story__avatar">
						<img src="<?if($post->image_url) echo $post->image_url; else echo "/upload/noiavatar.png"; ?>" alt="<?= $post->fullname?>" class="img-fluid rounded-circle">
					</div>
					<div class="story__info">
						<h3 class="story__author"><b><?=$post->fullname?></b></h3>
						<?php
						$first_date = time();
						$secon_date = $post->post_created;
						$diff = abs($first_date - $secon_date);
						$phut = $diff / 24;
						
						if($phut >= 60){
							$gio = floor($phut/60);
							if($gio < 48){
								$hienthingay = floor($gio).' giờ trước';
							}else{
								$hienthingay = date('H:i d/m/Y',$post->post_created);
							}
						}else{
							$hienthingay = floor($phut).' phút trước';
						}
						?>
						<div class="story__time" style="margin-top: -5px;"><time datetime="<?php echo date('Y-m-d H:i:s',$post->post_created) ?>" class="time-ago"><?=$hienthingay?></time></div>
					</div>
				</div>
				
				<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="text-xl font-semibold line-clamp-2">  <?=$post->title_vi?></a>
				<p class="line-clamp-2 pt-1"> <?=$post->brief_vi?></p>
				
				<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>">
					<div class="w-full overflow-hidden relative shadow-sm"> 
						<img id="avt<?=$k?>" src="<?php if(trim($post->image)){echo  str_replace("http://taichinhso.newwaytech.vn", "",$post->image);} else {echo "/upload/noimage1.png";}?>" alt="" class="w-full h-full inset-0 object-cover">
					</div>
				</a>
				<div class="flex items-center pt-3">
					<style>
						.image{    
							height: 40px;
							width: 40px;
							margin-right: 5px;
							border: 100%;
						}
					</style>
					
					<div class="flex items-center" id="like<?=$post->id?>">  
						<a href="<?=$url_login;?>" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="likepost('<?=$post->id?>')" <?php } ?> class="items-center">
						<ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="thumbs up outline" <?= $like ?>></ion-icon> <?php echo $post->number_like ?> </a>
					</div>
					<div class="flex items-center mx-4" > 
						<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>#comment<?= $post->id?>" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="commentpost('<?=$post->id?>','<?=$_SESSION["member"]['id']?>')" <?php } ?> class="items-center">
						<ion-icon name="chatbubble-ellipses-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>  <?php echo $post->number_comment ?> 
						</a>
					</div>
					<div class="flex items-center mx-2" > 
						<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $ariacms->actual_link ?>chi-tiet/<?=$post->url_part?>.html" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="commentpost('<?=$post->id?>','<?=$_SESSION["member"]['id']?>')" <?php } ?> class="items-center">
							<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=164228616928969&autoLogAppEvents=1"></script>
										 
						 <ion-icon name="share-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon> 
						</a>
					</div>
				</div>	
			</div>
		</div>
		<?php if($k == 5){
			$query = "SELECT title_vi,url_part FROM `e4_term_taxonomy` where taxonomy = 'post_tags' LIMIT 0,5";
			//echo $query ;
			$database->setQuery($query);
			$tags = $database->loadObjectList();
			//print_r($tags);
			
			?>
				
				<div class="  py-6 danhsachtin">
					<div class="story__meta">
						<h4 class="text-xl font-semibold mb-3 " style="color: blue;"> Xu hướng: </h4>
					</div>
					<?php foreach($tags as $tag){?>
							<a href="<?=$ariacms->actual_link . 'tag/' . $tag->url_part . '.html';?>" class=" bg-gray-100 py-1.5 px-4 rounded-full">#<?= $tag->title_vi?></a>&nbsp;
						
					<?php }?>
				</div>
			<?php  }?>
	<?php } ?>		
	</div>
	<div class="timeline" id="news_timeline2"></div>

	<div id="ic-loading" style="display: none">
		<ion-icon name="sync-outline"></ion-icon>
	</div>	

	<div class="hidden-md hidden-lg hidden" id="boxemthem">
		<div class="xemthem text-center">
			<a class="btn btn-primary" id="xemthemtin" onclick="xemthemtin()" href="javascript:;">Xem thêm</a>
		</div>
	</div>
	<input type="hidden" id="row" value="<?php echo $maxRows;?>">
	<input type="hidden" id="all" value="1000">
	<input type="hidden" id="trangso" value="<?=$sotrang?>">
	<input type="hidden" id="trangtruoc" value="<?=$sotrang-1?>">
	
	<div class="hidden-md hidden-lg" id="boxemthem">
		<div class="xemthem" style="background-color: #ebebeb;border-radius: 10px;padding: 10px;">
			<div style="width:50%;float: left;">
				<img src="https://biz9.vn/templates/Economic247/images/logo5.jpg">
			</div>
			<div style="width:50%;float: left;padding-left:30px" >
				<p><strong>THÔNG TIN LIÊN HỆ</strong></p>
				<p><a href="/introdure.html"><strong>- Chính sách bảo mật</strong></a></p>
				<p><a href="/about.html"><strong>- Điều khoản sử dụng</strong></a></p>
			</div>
			<div style="clear:both; padding:5px">
			</div>
			<div>
			<p><strong>Giấy phép mạng xã hội số 66/GP-BTTTT do Bộ Thông tin Truyền thông cấp ngày 25/01/2022</strong></p>

			<p><strong>Chịu trách nhiệm nội dung</strong>: Đỗ Đình Lâm</p>

			<p><strong>Vận hành bởi</strong>: <?= $ariacms->web_information->name_vi ?></p>

			<p><strong>Văn phòng</strong>: <?= $ariacms->web_information->address_vi ?></p>

			<p><strong>Hotline</strong>: <?= $ariacms->web_information->hotline ?></p>

			<p><strong>Email</strong>: <?= $ariacms->web_information->admin_email ?></p>
			</div>

		</div>
	</div>
	
			<script>

				$(document).ready(function(){ 
					$(window).scroll(function(){	 
						var position = $(window).scrollTop();
						var bottom = $(document).height() - $(window).height();
						var manhinh = $(window).width();
						if(manhinh > 855){
							if( position >= bottom-1 ){
								$('#ic-loading').show();
								var trang = $('#trangso').val()*1;
								var trangtruoc = $('#trangtruoc').val()*1;
								var row = $('#row').val()*1;
								var allcount = $('#all').val()*1;
								var rowperpage = <?=$maxRows?>;
								row = row + rowperpage*1;
								if(row <= allcount){
									$.ajax({
										url: '<?= $ariacms->actual_link ?>ajax/ajax.addnews.php',
										type: 'post',
										data: {row:row,trang:trang},
										success: function(response){ //alert(response);
											$('#ic-loading').hide();
											if(response.trim() != ''){
												trangtiep = trang+1;
												$('#row').val(row);
												$('#trangso').val(trangtiep);
												$("#xemthemtin").attr("href", "?curPg="+trangtiep);
												$("#quaylai").attr("href", "?curPg="+trangtruoc);
												$("#news_timeline2").append(response).fadeIn("slow");
											}
										}
									}); 
								} else { $('#ic-loading').hide();}
							}
						}
					});
				});

				function xemthemtin(){
					var row = $('#row').val()*1;
					var rowperpage = 20;
					var allcount = $('#all').val()*1 + rowperpage*1;
					row = row*1 + rowperpage*1;
					var trang = $('#trangso').val()*1;
					if(row <= allcount){
						$('#ic-loading').show();
						$.ajax({
							url: '<?= $ariacms->actual_link ?>ajax/ajax.addnews.php',
							type: 'post',
							data: {row:row,trang:trang},
							success: function(response){
								$('#ic-loading').hide();
								if(response.trim() != ''){
									trangtiep = trang+1;
									$('#row').val(row);
									$('#all').val(allcount);
									$('#trangso').val(trangtiep);
									$("#quaylai").attr("href", "?curPg="+trang);
									$("#news_timeline2").append(response).fadeIn("slow");
								}
							}
						}); 
					} else {$('#ic-loading').hide();}
				}
			</script>
</div>
