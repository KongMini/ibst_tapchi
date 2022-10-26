<?php
global $database;
global $ariacms;
global $params;

$query = "SELECT * FROM e4_posts WHERE post_type = 'post' and post_status = 'active' ORDER BY id desc LIMIT 0, 5";
//echo $query ;
$database->setQuery($query);
$posts = $database->loadObjectList();
?>

<section class="zone zone--topic">
<h3><a href="#" class="hashtag">Thông tin cần biết</a></h3>
<div class="clearfix">
	<?php $i=1; foreach($posts  as $post){
	 if($i==1){	// Lấy ra bản tin đầu tiên để cho vào vùng banner
	echo '
		 <div class="focus">
			<article class="story story--focus">
				<a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__thumb">
				<img src="'.$post->image.'" alt="">
				</a>
				 <h2><a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__title">'.$post->{$params->title}.'</a></h2>
				
			</article>
		</div>';
	 } else { // các bản tin hot khác thì hiển thị phía dưới
		 if($i==2) echo '<div class="cols-2"> '; 
		 echo '	<article class="story">
					<a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__thumb">
					<img src="'.$post->image.'" alt="">
					</a>
					<h2><a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__title">'.$post->{$params->title}.'</a></h2>
				</article>'; 	
				
			
	 } $i++; }
	 echo '</div>';
	 ?>
 </div>
</section>
