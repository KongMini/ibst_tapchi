<?php
global $ariacms;
global $params;
global $database;

  
function text_limit_cat($str,$limit=10)
 {
	 if(stripos($str," ")){
		 $ex_str = explode(" ",$str);
		 if(count($ex_str)>$limit){
		 for($i=0;$i<$limit;$i++){
		 $str_s.=$ex_str[$i]." ";
		 }
		 return $str_s."...";
		 }else{
		 return $str;
		 }
		 }else{
		 return $str;
	 }
 }

$catid = $ariacms->getParam("task"); 
$query = "select * from e4_term_taxonomy where url_part = '".$catid."' " ;
$database->setQuery($query);
$topics = $database->loadRow();
$query = "select post_id  from e4_post_like where member_id = ".$_SESSION["member"]['id']." ORDER BY id desc";
$database->setQuery($query);
$member_likes = $database->loadObjectList();

$array_liked = array();
foreach($member_likes as $key){
	array_push($array_liked,$key->post_id);
}
$array_liked = array_flip($array_liked);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
	
	<title><?= ($category['title_vi'] != '') ? $category['title_vi'] : $ariacms->web_information->{$params->name}; ?></title>
	<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
	
	<meta property="og:site_name" content="<?= $ariacms->web_information->{$params->name} ?>" />
	<meta property="og:url" content="<?= $ariacms->c_url ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>
	<meta property="og:image" content="/templates/Economic247/images/logo.jpg"/>
	<?= $ariacms->getBlock("head"); ?>
	
</head>
<body>


<div id="wrapper">

	<?= $ariacms->getBlock("header"); ?>

	<!-- sidebar -->
	
	<?= $ariacms->getBlock("menu"); ?>
	
	<!-- Main Contents -->
	<div class="main_content">
		<div class="mcontainer">
			
			<div class="lg:flex  lg:space-x-12">
				<div class="lg:w-3/4">
					<?php
					if(!$ariacms->checkUserLogin()){
						$lightbox = "uk-toggle";
						$url_login = '#modal-login';
						$url_post = '#modal-login';
					}else{
						$lightbox = "";
						$url_login = "javascript:;";
						$url_post = '/member/tao-bai-viet.html';
					}?>
					<div class="flex justify-between relative md:mb-4 mb-3">
						<div class="flex-1">
							<h2 class="text-3xl font-semibold">Bài viết mới</h2>
						</div>
						<a href="<?=$url_post?>" <?=$lightbox?> class="flex items-center justify-center h-9 lg:px-5 px-2 rounded-md bg-blue-600 text-white space-x-1.5 absolute right-0" style="background-color:#f44336">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
							</svg>
							<span class="md:block hidden" style="background-color:#f44336"> Tạo bài viết </span>
						</a> 
					</div>
					
					<div class="clear"></div>
					<?php
					if(count($news) > 0){
					$sotrang = $ariacms->getParaUrl('curPg');
					if(!is_numeric($sotrang)){
						$sotrang = 1;
					}?>
					
					<div class="divide-y">
						
						<!-- Bài viết top 1 -->
						
							<?php 
							foreach($news as $key => $post){
								$like="";
								if($array_liked[$post->id] > -1){
									$like = 'style="color: blue;"';
								}
							?>
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
							<?php  }?>
				
						
					</div>	
					
<div class="timeline" id="news_timeline2"> 
 
</div>

<div id="ic-loading" style="display: none">
	<i class="fa fa-spinner"></i>
</div>

<div class="hidden" id="boxemthem">
	<div class="xemthem text-center">
		<?php if($sotrang > 1){ ?><a class="btn btn-default" id="quaylai" href="" style="margin-right: 10px;" title="Quay lại">Quay lại</a><?php } ?>
		<a class="btn btn-primary" id="xemthemtin2" style="display: none;background: #003366;" href="" title="Xem thêm">Xem thêm</a>
	</div>
</div> 
<div class="hidden" id="boxemthem">
	<div class="xemthem text-center">
		<a class="btn btn-primary" id="xemthemtin" onclick="xemthemtin()" style="background: #003366;" href="javascript:;" title="Xem thêm">Xem thêm</a>
	</div>
</div> 
<input type="hidden" id="catid" value="<?php echo $category['submenu'];?>">
<input type="hidden" id="task" value="<?php echo $ariacms->getParam("task");;?>">
<input type="hidden" id="row" value="<?php echo $maxRows;?>">
<input type="hidden" id="all" value="1000">
<input type="hidden" id="trangso" value="<?=$sotrang?>">
<input type="hidden" id="trangtruoc" value="<?=$sotrang-1?>">
<script> 

$(document).ready(function(){ 
	$(window).scroll(function(){	 
		var position = $(window).scrollTop();
		var bottom = $(document).height() - $(window).height();
		var manhinh = $(window).width();//alert(manhinh);
		//alert($('.l-content').height() +"_"+ $(window).height());
		//alert(position+'_'+bottom);
		var trang = $('#trangso').val()*1;
		if(trang > 4){
			$('#xemthemtin2').show();
			$("#xemthemtin2").attr("href", "?curPg="+trang);
		}
		if(manhinh > 855){
			if( position >= bottom-1 ){
				//alert("aaaaa");
				$('#ic-loading').show();
				var catid = $('#catid').val();
				var task = $('#task').val();
				var trangtruoc = $('#trangtruoc').val()*1;
				var row = $('#row').val()*1;
				var allcount = $('#all').val()*1;
				var rowperpage = <?=$maxRows?>;
				row = row + rowperpage*1;
				
				if(row <= allcount){
					
					$.ajax({
						//alert(row+'_'+allcount);
						url: '<?= $ariacms->actual_link ?>ajax/ajax.addnews2.php',
						type: 'post',
						data: {catid:catid,row:row,trang:trang,task:task},
						success: function(response){ //alert(response);
							$('#ic-loading').hide();
							if(response.trim() != ''){
								trangtiep = trang+1;
								$('#row').val(row);
								$('#trangso').val(trangtiep);
								$("#xemthemtin2").attr("href", "?curPg="+trangtiep);
								$("#quaylai").attr("href", "?curPg="+trangtruoc);
								$("#news_timeline2").append(response).fadeIn("slow");
							}else{
								$("#boxemthem").attr("style", "display:none");
								$('#ic-loading').hide();
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
	var allcount = $('#all').val()*1;
	var rowperpage = <?=$maxRows?>;
	var catid = $('#catid').val();
	row = row + rowperpage;
	var trang = $('#trangso').val()*1;
	if(row <= allcount){
		$('#row').val(row);
		$.ajax({
			url: '<?= $ariacms->actual_link ?>ajax/ajax.addnews2.php',
			type: 'post',
			data: {catid:catid,row:row,trang:trang},
			success: function(response){ //alert(response);
				//alert(response.trim());
				$('#ic-loading').hide();
				if(response.trim() != ''){
					trangtiep = trang+1;
					$('#row').val(row);
					$('#all').val(allcount);
					$('#trangso').val(trangtiep);
					$("#news_timeline2").append(response).fadeIn("slow");
				}
			}
		}); 
	} else { $("#boxemthem").hide();}
}
</script>	
			<?php }else{ ?>
			<h4>Không có bài viết nào</h4>
			<?php } ?>
			</div>
			<?= $ariacms->getBlock("hot_news"); ?>
		</div>
	</div>
	
	</div>	
</div>
<?= $ariacms->getBlock("footer"); ?>


</body>
</html>