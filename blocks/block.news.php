<?php 
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM  e4_web_home  WHERE status = 'active' AND parent = 1  ORDER BY id ";

//echo $query ;

$database->setQuery($query);

$gioithieu = $database->loadObjectList(); 

$query1 ="SELECT * FROM e4_tapchi WHERE post_status='active' AND type = 'tapchi' ORDER BY id Limit 0,6";
$database->setQuery($query1);
$tapchi= $database->loadObjectList();

?>

<div class="white-band " style="padding: 25px 0 100px 0; background-image: linear-gradient(90deg, #ffffff 49.75%, #fafafa 49.75%, #fafafa 50%, #ffffff 50%, #ffffff 99.75%, #fafafa 99.75%, #fafafa 100%); background-size: 402.00px 402.00px;">

<div class="flex-container max-width">
	
<div class="flex-50 padding-30">
	<div class="stick">
		<?php foreach ($gioithieu as $key => $gt) {
		?>
<h2 class="center-on-mobile "><?=$gt->{$params->title}?>  </h2>
<div class="hr-box-left"><div class="hr-box-sm outer"></div><div class="hr-box-sm inner"></div><div class="hr-box-sm middle"></div><div class="hr-box-sm inner"></div><div class="hr-box-sm outer"></div></div>

<p><?=$gt->{$params->brief}?></p>





<?php } ?>


	</div>

</div>


<div class="flex-50">	
	
	<div class="flex-container center-on-mobile sticky">
		<!-- Số tạp chí --> 
		<?php foreach ($tapchi as $key => $post) {
			?>
		<div class="flex-col-portfolio-page" >
		<div class="project-container">
		<a href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html">
			<div class="project-image-container"><picture class="attachment-full size-full">
<source type="image/webp" data-lazy-srcset="<?=$post->hinhdaidien?>" srcset="<?=$post->hinhdaidien?>" data-lazy-sizes="(max-width: 765px) 100vw, 765px"/>
<img width="765" height="430" src="<?=$post->hinhdaidien?>" alt="" data-lazy-srcset="<?=$post->hinhdaidien?>" data-lazy-sizes="(max-width: 765px) 100vw, 765px" data-lazy-src="<?=$post->hinhdaidien?>"/>
</picture>
<noscript>
	<picture class="attachment-full size-full">
<source type="image/webp" srcset="<?=$post->hinhdaidien?>" sizes="(max-width: 765px) 100vw, 765px"/>
<img width="765" height="430" src="<?=$post->hinhdaidien?>" alt="" srcset="<?=$post->hinhdaidien?>" sizes="(max-width: 765px) 100vw, 765px"/>
</picture>
</noscript></div></a>		<div class="client-name-container"><a class="client-name" href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><?=$post->{$params->title}?> </a>		<p class="city"><i class="fa fa-calendar" aria-hidden="true"></i>
						<?=$ariacms->unixToDate($post->post_created, '/')?></p>
		</div>
		</div>
</div>
<?php } ?>
<!--   end -->
		
		
</div>

	




</div>
	





</div>
</div>
