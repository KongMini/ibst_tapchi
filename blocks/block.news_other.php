<?php
global $database;
global $ariacms;
global $params;
global $ariaConfig_template;
$query = "SELECT a.*, c.fullname FROM e4_posts a 
			JOIN e4_users c ON a.user_created = c.id
			JOIN (SELECT b.object_id FROM e4_term_relationships b JOIN e4_term_taxonomy c ON b.term_taxonomy_id = c.id AND c.id IN (" . $_SESSION['categoryid'] . ") WHERE b.object_type = 'post') t ON a.id = t.object_id
			JOIN e4_term_relationships d ON d.object_id = a.id 
			WHERE a.post_type = 'post' and a.news_position in (3,0)
		GROUP BY a.id 
		order by   news_position desc limit 0,6 ";  //echo $query;
$database->setQuery($query);
$posts = $database->loadObjectList();

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
<section class="zone zone--suggest">

 
<?php 


$query = "select post_id  from e4_post_like where member_id = ".$_SESSION["member"]['id']." ORDER BY id desc";
$database->setQuery($query);
$member_likes = $database->loadObjectList();

$array_liked = array();
foreach($member_likes as $key){
	array_push($array_liked,$key->post_id);
}
$array_liked = array_flip($array_liked);


$i=1; foreach($posts  as $post){ 
	$like="";
	if($array_liked[$post->id] > -1){
		$like = 'style="color: blue;"';
	}

?>
	
<div class="lg:flex lg:space-x-6 py-6 danhsachtin">
			
			<div class="flex-1 lg:pt-0 pt-4">
				
				<div class="story__meta">
                    <div class="story__avatar">
                        <img src="<?if($post->image_url) echo $post->image_url; else echo "/upload/noiavatar.png"; ?>" alt="Mạnh Quân" class="img-fluid rounded-circle">
                    </div>
                    <div class="story__info">
                        <h3 class="story__author"><?=$post->fullname?></h3>
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
                        <div class="story__time"><time datetime="<?php echo date('Y-m-d H:i:s',$post->post_created) ?>" class="time-ago"><?=$hienthingay?></time></div>
                    </div>
                </div>
				
				<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="text-xl font-semibold line-clamp-2">  <?=$post->title_vi?></a>
				<p class="line-clamp-2 pt-1"> <?=$post->brief_vi?></p>
				
				<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>">
					<div class="w-full overflow-hidden relative shadow-sm"> 
						<img id="avt<?=$k?>" src="<?php if(trim($post->image)){echo  $post->image;} else {echo "/upload/noimage1.png";}?>" alt="" class="w-full h-full inset-0 object-cover">
					</div>
				</a>
				<div class="flex items-center pt-3">
					
					
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
		</div><?php } ?>  

</section>