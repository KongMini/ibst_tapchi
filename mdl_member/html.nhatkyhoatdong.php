<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;
	$query = "SELECT * FROM `e4_posts` where `user_created` = ". $_SESSION['member']['id']." and `news_position` = 0 ORDER BY id desc";
	$database->setQuery($query);
	$posts = $database->loadObjectList();
	
	
	$query = "select post_id  from e4_post_like where member_id = ".$_SESSION["member"]['id']." ORDER BY id desc";
	$database->setQuery($query);
	$member_likes = $database->loadObjectList();

	$array_liked = array();
	foreach($member_likes as $key){
		array_push($array_liked,$key->post_id);
	}
	$array_liked = array_flip($array_liked);
	//print_r($array_liked);
?>

<!DOCTYPE html>
<html lang="vi">
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
				<div class="lg" style="width: 100%;">
				
					
					
					<h2 class="text-2xl font-semibold mb-3 flex_detail"><a href="<?=$ariacms->actual_link ?>member/nhat-ky-hoat-dong.html"> Hoạt động gần đây</a> </h2>
					  <ul> 
						 <?php 
						 // lấy cái bài viết đã like và comment
						$query = "select a.title_vi, a.url_part,a.image, b.thoigian thoigian, b.trangthai trangthai from e4_posts a, e4_post_like b where a.id = b.post_id and b.member_id = ". $_SESSION['member']['id']."
						Union 
						select c.title_vi, c.url_part,c.image,  d.date_review thoigian,d.state trangthai  from e4_posts c, e4_post_comment d where c.id = d.post_id and d.member_id = ". $_SESSION['member']['id']." and d.state = 0
						order by thoigian desc limit 0,200";
						$database->setQuery($query);
						$histories = $database->loadObjectList();
						 
						 
						 foreach($histories as $key){?>
							<li>
								<a href="<?=$ariacms->actual_link ?>chi-tiet/<?=$key->url_part?>.html">
									<div class="flex py-2 mb-2 rounded-md hover:bg-gray-200">
										<img src="<?= $key->image?>" class="w-20 mr-2" alt="" style="border-radius: 50%;width: 40px; height: 40px;">
										<h4 class="font-medium line-clamp-2"> <?php if($key->trangthai == 1)echo "Bạn đã thích</br>"; else echo "Bạn đã bình luận<br>";?> <b><?= $key->title_vi?></b></h4>
									</div>
								</a>
							</li>
							
						 <?php }?>
					  </ul>
					<div class="clear"></div>
					<div class="sticky-bottom"></div>
				</div>

				
			</div>

		</div>
	</div>
	
</div>
<?= $ariacms->getBlock("footer"); ?>
</body>

</html>