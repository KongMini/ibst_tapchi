<?php
global $database;
global $ariacms;
global $params;
global $ariaConfig_template;
global $web_menus;

$author = $detail['author'];
$source = $detail['post_type']; 
if($detail['post_type']	=='member' || $detail['post_type']	=='post') $source='';


$query = "SELECT * FROM `e4_web_image` WHERE position='banner' and status ='active' ORDER BY id DESC";
$database->setQuery($query);
$banner = $database->loadRow();


$query = "SELECT a.title_vi, a.url_part FROM e4_posts a WHERE a.id in (".$detail['relation'].")";
$database->setQuery($query);
$posts_relation = $database->loadObjectList();

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

<!DOCTYPE html>
<html lang="vi">

<head>
	<title><?= ($detail['meta_title'] != '') ? $detail['meta_title'] : $detail['title_vi']; ?></title>
	<meta name="description" content="<?= ($detail['meta_description'] != '') ? $detail['meta_description'] : $detail['brief'] ?>" />
	<meta name="keywords" content="<?= ($detail['meta_keyword'] != '') ? $detail['meta_keyword'] : $detail['meta_keyword']; ?>" />
	<?php $title_web = str_replace('"',"'",($detail['meta_title'] != '') ?  $detail['meta_title'] : $detail['title']); ?>
	
	<meta property="og:title" content="<?= $title_web; ?>" />
	<meta property="og:description" content="<?= ($detail['meta_description'] != '') ? $detail['meta_description'] : $detail['brief'] ?>" />
	<?php if($detail['image'] != ''){ $url_img = $detail['image'];}else{ $url_img = '/templates/Economic247/images/logo.jpg';} ?>
	<meta property="og:image" content="<?=$url_img?>"/>
	<?= $ariacms->getBlock("head"); ?>
</head>

<body>
<style>
span.text-tiny{font-size:.7em}
span.text-small{font-size:.85em}
span.text-big{font-size:1.4em}
span.text-huge{font-size:1.8em}


</style>
<div id="wrapper">

		<?= $ariacms->getBlock("header"); ?>

        <!-- sidebar -->
		
        <?= $ariacms->getBlock("menu"); ?>
		
        <!-- Main Contents -->
        <div class="main_content">
            <div class="mcontainer">
				
				<div class="lg:flex  lg:space-x-12">
					
						<div class="lg:w-2/3">
							<div class="divide-y">
							<?php if(isset($banner)){?>
							<!-- Bài viết top 1 -->
								<div class="hotbanner">
									<div class="grid grid-cols-2 gap-2 p-2"  style="padding: 0">
										  <a href="<?= $banner['link']?>" class="col-span-2 relative">  
											  <img src="<?= $banner['image']?>" alt="" class="rounded-md w-full lg:h-76 object-cover">
										  </a>
									</div>
								</div>
							<?php }?>
							</div>
							<style>
									.style{
										background: #fff;
										border: 1px solid #fff;
										margin-bottom: 20px;
										padding: 15px 10px;
										border-radius: 10px;
									}
									[contenteditable] {
									  outline: 0px solid transparent;
									}
							</style>
							<div class="clear"></div>
								<div class="divide-y">
									
									<div class="l-content style">
									
										<div class="details " >
											<div class="details__header " >
													<div class="lg:flex" >
												
													<div class="details__meta" style="padding-bottom:25px">
														<div class="flex items-center pt-3">
															<style>
																.image1{    
																	height: 40px;
																	width: 40px;
																	margin-right: 5px;
																	border: 100%;
																}
															</style>
															<img src="/upload/noiavatar.png" class="bg-gray-200 border border-white rounded-full w-10 h-10 image1">
															
															<div class="flex-1 font-semibold capitalize" style="line-height: 1.0;">
																<a class="text-black"> <?= $detail["fullname"] ?></a></br>
																<span class="time" style="font-size: 12px;line-height: -0.9px;; font-weight: 300;">
																	<ion-icon name="time-outline"></ion-icon>
																	<?php
																		$first_date = time();
																		$secon_date = $detail['aproved_date'];
																		$diff = abs($first_date - $secon_date);
																		$phut = $diff / 24;
																		
																		if($phut >= 60){
																			$gio = floor($phut/60);
																			if($gio < 48){
																				$hienthingay = floor($gio).' giờ trước';
																			}else{
																				$hienthingay = date('H:i d/m/Y',$detail['aproved_date']);
																			}
																		}else{
																			$hienthingay = floor($phut).' phút trước';
																		}
																		echo $hienthingay;
																	?>
																	
																	
																
																</span>
															</div>
														
															<div class="right">
																<div class="social" style="display: flex;">
																	<div class="fb-share-button" data-layout="button_count" data-size="small" style="margin-top: -6px;">
																		<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $ariacms->actual_link ?>chi-tiet/<?=$detail['url_part']?>.html" class="fb-xfbml-parse-ignore">Chia sẻ</a>
																	</div>
																	
																	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=164228616928969&autoLogAppEvents=1"></script>

																	<div class="zalo-share-button" style="margin-left: 4px; margin-top: 1px;" data-href="" data-oaid="579745863508352884" data-layout="1" data-color="blue" data-customize=false></div>
																	<script src="https://sp.zalo.me/plugins/sdk.js"></script>
																</div>
															</div>
														</div>

														
														<div class="meta">
															
														</div>
													</div>
												</div>

												<h1 class="details__headline"> <?= $detail[$params->title] ?></h1>
												
											
												<div class="lg:flex">
													<h2 class="sapo"> <?= $detail['brief_vi'] ?></h2>
												</div>
											</div>
											

											
											<div class="details__content">
												<?= str_replace("http://127.0.0.1:8083", "", $detail['content_vi']); ?>
												
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
												
												<!--div class="author" style="text-align: right"><strong> <?= $detail["fullname"] ?></strong></div>
												<div class="source" style="text-align: right"> <?=$source ?></div>
												<div class="link text-dark" style="text-align: right"><?= $detail['url_coppy']; ?></div-->
											</div>
											<script>  
											 $(document).ready(function(){   //alert("d");
											 var menu_active ='<?php echo "tin-tuc/".$detail["url_part_cat"].".html"; ?>'; //alert(menu_active);
											 $("#"+menu_active).removeClass("menu-heading");
												$("#"+menu_active).addClass("menu-heading selected");
												
											});
											</script>
											<div class="details__footer">
												<iframe src="https://www.facebook.com/plugins/like.php?href=<?= $ariacms->actual_link ?>chi-tiet/<?=$detail['url_part']?>.html&width=150&layout=button_count&action=like&size=small&share=true&height=46&appId=251420733258426" width="150" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
												<div class="tags">
													
													<h3 class="label">
														<b><ion-icon name="pricetags-outline"></ion-icon> Từ khóa: </b>
														<?=$detail['tukhoa']?>
													</h3>
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

												<!-- Comment --> 
												<?php 
												// lấy comment được duyệt 
												$post_id = $detail[post_id];
												$query = "select a.*,b.fullname, b.image_url from e4_post_comment a left join e4_users b on a.member_id = b.id where a.state = 0 and a.post_id = ".$post_id;
												$database->setQuery($query);
												$comments = $database->loadObjectList();
												?>

												<section class="zone zone--comment">
					
												<a id="comment<?=$detail['id']?>"></a>
												<h3 class="zone_heading">bình luận (<?php echo sizeof($comments); ?>)</h3>
												<style>
													.inputComment{content:'Bình luận của bạn';color:#555;}
													.inputComment:empty::before{content:'Bình luận của bạn';color:#555;}
													.inputComment:empty:focus::before{content:"";}
													.inputComment{overflow-x:hidden;}
													.inputComment *{margin-right:24px;font-size:14px;}
													.inputComment img{max-width:100%;}
												</style>
												
												<div class="zone__body">
													<div class="cmt-container">
														<div class="cmt-container-story">
														
															<br>
															<div class="clearfix"></div>
															<div class="bg-gray-100 relative dark:bg-gray-800" style="border: none;border-radius: 20px">
															  <div class="bg-transparent shadow-none px-5" style="padding:10px ;width:95%;" >
																	<div contenteditable="true"  id="input" class="inputComment" style="padding:0" placeholder="First name" >
																	
																	</div>
															  </div>
															  <div class="-m-0.5 absolute  flex items-center right-3 text-xl" style="right:1.7rem;bottom:3px">
																  <a <?php if($_SESSION["member"]){?> onclick="upload()" <?php }else {?> href="#modal-login"  uk-toggle <?php }?>>
																		
																	  <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline">
																		<input type="file" id="image" id="file1" style="display:none" onchange="readURL(this);" name="hinhanh" accept="image/png, image/jpeg" />
																	  </ion-icon>
																  </a>
															  </div>
															   <div class="-m-0.5 absolute flex items-center right-3 text-xl" style="right:0.2rem;bottom:3px;color: #0f2fff" >
																  <a <?php if($_SESSION["member"]){?> onclick="sentComment();" <?php }else {?> href="#modal-login"  uk-toggle <?php }?>>
																	  <ion-icon name="paper-plane-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline"></ion-icon>
																  </a>
															  </div>
															</div>
															<div class="py-4 space-y-4 dark:border-gray-600">
																  <?php 
																  foreach ($comments as $cm) { ?>
																  <div class="flex">
																	  <div class="w-10 h-10 rounded-full relative flex-shrink-0">
																		  <?php if($cm->image_url !=''){
																			  $image_url = $cm->image_url;
																		  }else{
																			  $image_url = '/upload/noimage.png';
																		  } ?>
																		  <img src="<?=$image_url?>" alt="" class="absolute h-full rounded-full w-full">
																	  </div>
																	  <div>
																		  <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
																			  <h3><b><?php echo $cm->fullname;?></b> <ion-icon name="time-outline"></ion-icon> <?php echo date('H:i d/m/Y',$cm->date_review);?></h3>
																			  <p class="leading-6"><?php echo $cm->content;?></p>
																			  <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
																		  </div>
																		
																	  </div>
																  </div>
																  <?php } ?>
															  </div>
														</div>
													</div>
												</div>
												</section>

												<script>
																		
												function readURL(input) {

													if (input.files && input.files[0]) {
														var fd = new FormData();
														var files =  input.files[0];
														fd.append('hinhanh',files);
														//console.log(files);
													   $.ajax({
														  url: '<?= $ariacms->actual_link ?>ajax/ajax.uploadImage.php',
														  type: 'post',
														  data: fd,
														  contentType: false,
														  processData: false,
														  success: function(response){
															  //alert(response);
															 if(response != 0){
																 var img = document.createElement('img');
																	
																	img.src = "<?= $ariacms->actual_link ?>"+response;
																	
																	document.getElementById('input').appendChild(img);
																	down.innerHTML = "Image Element Added."; 
																 
															 }else{
																alert('file not uploaded');
															 }
														  }
													   });
													}
												}
					
												
												function upload(){
													document.getElementById("image").click();
													
												}
												function sentComment(){
													var myElement = document.getElementById("input");
												
													
													// lấy giá trị cần thêm
													var content =  myElement.innerHTML ;
													var postid ="<?php echo $detail["post_id"]; ?>";
													if(content.length > 9 && postid > 0){
													// hết
														$.ajax({
															url: '<?= $ariacms->actual_link ?>ajax/ajax.addcomment.php',
															type: 'post',
															data: {postid:postid,content:content},
															success: function(){
																alert("Bình luận của bạn đang được chờ duyệt");
																$('#content').val('');
															}
														}); 
													}else{
														alert("Vui lòng nhập bình luận hợp lệ.");
													}
												}
												</script>

												<!-- hết comment -->

												 <!-- tin khác --> 
												
												<!-- hết tin khác -->
											</div>
										</div>
									</div>
									<?= $ariacms->getBlock("news_other"); ?>
									<div class="sidebar">
										<div id="sticky-top-0"></div>

										 <?= $ariacms->getBlock("hot_topic"); ?>
										 <?= $ariacms->getBlock("news_related"); ?>

										 <div id="sticky-top"></div>
									</div>
								</div>
							<div class="sticky-bottom"></div>
						</div>
						
					<?= $ariacms->getBlock("hot_news"); ?>
				</div>

			</div>
		</div>
		
		
	</div>
	<?= $ariacms->getBlock("footer"); ?>
	
	
</body>
</html>