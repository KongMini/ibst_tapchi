<?php
global $database;
global $ariacms;
global $params;
function text_limit($str,$limit=10)
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
if($catid == ""){
	$query = "SELECT * FROM e4_term_taxonomy WHERE taxonomy = 'topic' and position = 'home' and status = 'active' and count >0 ORDER BY `order` asc";
}else{
$query = "SELECT * FROM  e4_term_taxonomy  WHERE taxonomy = 'topic'
   and id in (select topic_id from e4_topic_categories 
	where category_id = (select id from e4_term_taxonomy where url_part = '$catid' )) and  status = 'active' and count > 0  ORDER BY `order` asc ";
}
$database->setQuery($query);
$topics = $database->loadObjectList();
?>
<?php foreach($topics as $topic){
	$i=1; $link = $ariacms->actual_link . 'chu-de/'.$topic->url_part.'.html'; 
	$query2 = "SELECT a.*, c.fullname FROM e4_posts a 
			JOIN e4_users c ON a.user_created = c.id
			JOIN (SELECT b.object_id FROM e4_term_relationships b JOIN e4_term_taxonomy c ON b.term_taxonomy_id = c.id AND c.id IN (" .$topic->id . ") WHERE b.object_type = 'post') t ON a.id = t.object_id
			JOIN e4_term_relationships d ON d.object_id = a.id 
			WHERE a.post_type = 'post' and a.post_status = 'active' /*and a.news_position in (3,0)*/
		GROUP BY a.id
		order by news_position desc limit 0,5";
	$database->setQuery($query2);
	$posts = $database->loadObjectList();
	if(count($posts) > 0){?>
	<section class="zone zone--topic">
		<h3><a href="<?=$link?>" class="hashtag"><?=$topic->title_vi?></a></h3>
		<div class="clearfix">
		<?php // Lấy ra tin thuộc Topic 	
		foreach($posts as $key=> $post){		
		 if($key==0){	// Lấy ra bsản tin đầu tiên để cho vào vùng banner ?>
			
			<div class="focus">
				<article class="story story--focus">
					<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'?>" class="story__thumb">
					<img src="<?=$post->image?>" alt="">
					</a>
					 <h2><a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'?>" class="story__title"><?=text_limit($post->{$params->title},13)?></a></h2>
					
				</article>
			</div>
			
		<?php } } ?>
		<div class="cols-2">
		<?php foreach($posts as $key2=> $post){
			if($key2 != 0){
			?>
			<article class="story">
				<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'?>" class="story__thumb">
				<img src="<?=$post->image?>" alt="">
				</a>
				<h2><a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'?>" class="story__title"><?=text_limit($post->{$params->title},18)?></a></h2>
			</article> 
		<?php }} ?>
		</div>
		</div>
	</section> 
<?php } } ?>
	 
	 