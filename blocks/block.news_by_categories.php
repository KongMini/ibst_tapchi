<?php
global $database;
global $ariacms;
global $params;

$query = "SELECT * FROM  e4_term_taxonomy  WHERE taxonomy = 'category'   and  status = 'active' and count >0  ORDER BY id desc ";
//echo $query ;
$database->setQuery($query);
$categories = $database->loadObjectList();
?>
<style>

</style>
<?php $i=1;
foreach($categories as $category){
	  ?>
	<div class="baotintheodm animated wow fadeInUp delay-200 go animated">
	<h3 class="tieudedanhmuc"><a href="#"><?=$category->title_vi?></a></h3>
	<?php // Lấy ra tin thuộc Topic 
		$query = "SELECT a.*, c.fullname FROM e4_posts a 
			JOIN e4_users c ON a.user_created = c.id
			JOIN (SELECT b.object_id FROM e4_term_relationships b JOIN e4_term_taxonomy c ON b.term_taxonomy_id = c.id AND c.id IN (" .$category->id . ") WHERE b.object_type = 'post') t ON a.id = t.object_id
			JOIN e4_term_relationships d ON d.object_id = a.id 
			WHERE /*a.post_type = 'post' and */ a.news_position in (1,2)
		GROUP BY a.id
		order by  a.id desc limit 0,5";
	//echo $query ;
	$database->setQuery($query);
	$posts = $database->loadObjectList();?>
	
	<div class="col-md-4" >
	<?php 
	foreach($posts as $key=> $post){ 
		if($key==0){
	?>
		<article>
			<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="story__thumb">
			<img src="<?=$post->image?>" alt="">
			</a>
			 <h2 class="owl-link"><a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="story__title"><?=$post->{$params->title}?></a></h2>
			
		</article>

	<?php } } ?>
	</div>
	<div class="col-md-8" >
	<?php 
	foreach($posts as $key=> $post){ 
		if($key!=0){
	?>
	
	<article class="story timeline2">
		<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'?>" class="story__thumb">
			<img src="<?=$post->image;?>" alt="">
			
		</a>
		<div class="summary"><a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'?>"><?=$post->{$params->title}?></a></div>
	</article>
	<?php } } ?>
	
	</div>
	<div style="clear: both"></div>
	</div>
<?php $i++; } ?>
 