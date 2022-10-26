<?php
class View
{
	static function viewhome()
	{
		global $ariacms;
		global $params;		
		global $database;
		function text_limit_hotnews($str,$limit=10)
		 {
			 if(stripos($str," ")){
				 $ex_str = explode(" ",$str);
				 if(count($ex_str)>$limit){
				 for($i=0;$i<$limit;$i++){
				 $str_s.=$ex_str[$i]." ";
				 }
				 return $str_s;
				 }else{
				 return $str;
				 }
				 }else{
				 return $str;
			 }
		 }
	// lấy tin nổi bật trang chủ	 
	$query = "SELECT * FROM e4_posts WHERE news_position = 4 and post_status = 'active' ORDER BY news_position desc LIMIT 0, 1";
	$database->setQuery($query);
	$hot = $database->loadObjectList();
	
	// lấy tin chinh trang chủ	 
	$query = "SELECT * FROM e4_posts WHERE news_position in (3,4) and post_status = 'active' ORDER BY news_position desc LIMIT 0, 4";
	//echo $query ;
	$database->setQuery($query);
	$posts = $database->loadObjectList();
?>


<!DOCTYPE html>
<title>Trang tin tài chính tổng hợp</title>

<head>
	<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
	<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	
	<?= $ariacms->getBlock("head"); ?>
	
</head>

<body data-rootzoneid="0">

<?= $ariacms->getBlock("header"); ?>
<div class="site-content">
<div class="l-grid" >
<div class="l-content">

<style>

	.cols-4>* {
    width: 25%;
    padding: 0 10px;
}

</style>


<div class="highlight">
	<?php 
	 	// Lấy ra bản tin đầu tiên để cho vào vùng banner
	echo '
		 <div class="focus">
			<article class="story">
				<a href="'.$ariacms->actual_link . 'chi-tiet/' . $hot['url_part'] . '.html" class="story__thumb">
				<img src="'.$hot['image'].'" alt="">
				</a>
				 <div class="meta">
				<h2><a href="'.$ariacms->actual_link . 'chi-tiet/' . $hot['url_part'] . '.html" class="story__title">'.$hot[$params->title].'</a></h2>
				</div>
			</article>
		</div>';
	  foreach($posts  as $post){ // các bản tin hot khác thì hiển thị phía dưới
		  echo '<div class="cols-4"> '; 
		 echo '	<article class="story">
					<a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__thumb">
					<img src="'.$post->image.'" alt="">
					</a>
					<h2><a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__title">'.text_limit_hotnews($post->{$params->title},13).'</a></h2>
				</article>'; 	
				
			
	 }; 
	 echo '</div>';
	 ?>
</div>	



<?= $ariacms->getBlock("advertisement_center"); ?>
<?= $ariacms->getBlock("news_recent"); ?>

<!-- lấy tin theo danh mục -->
<div id="news_by_categories" style="display: none">
 <?= $ariacms->getBlock("news_by_categories"); ?>
</div>
<!-- hết lấy tin theo danh mục --->

</div>


<div class="sidebar">
<div id="sticky-top-0"></div>

 <?= $ariacms->getBlock("hot_topic"); ?>

 <?= $ariacms->getBlock("news_related"); ?>

<div id="sticky-top"></div>

</div>
</div>
</div>

<div id="loading" style="display: none;">Đang tải tin...</div>
<div class="sticky-bottom"></div>
<?= $ariacms->getBlock("footer"); ?>


</body></html>

<?php
	}
}
?>