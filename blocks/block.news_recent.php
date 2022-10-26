<?php
global $database;
global $ariacms;
global $params;

$maxRows = $ariacms->web_information->posts_per_page; 
$query = "SELECT * FROM e4_posts WHERE /*post_type = 'post'*/  post_status = 'active' ORDER BY id desc LIMIT 0,".$maxRows;
$database->setQuery($query);
$posts = $database->loadObjectList();
?>


<!-- VTC  Lấy tin từ VTC
- CAFEF  Lấy tin từ cafef
- TOQUOC  Lấy tin từ trang tổ quốc
- VIETNAMNET  Lấy tin từ vietnamnet
- GIADINH  Lấy tin từ giadinhvietnam 
-->
		
 <div class="timeline" id="news_timeline"> 
 	<?php $i=1;foreach($posts  as $post){ 		
	
	echo '	<article class="story" id="'.$post->id .'">
			<h2>
				<a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__title">'.$post->{$params->title}.' </a>
			</h2>
			<span class="time"><i class="spr spr__clock"></i>'?><?php if($post->post_created > 0){ echo $ariacms->unixToDate($post->post_created, '/') .' '. $ariacms->unixToTime($post->post_created, ':') ;}?> <?php echo '</span> 
			<a href="'.$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html" class="story__thumb">
				<img src="'.$post->image.'" alt="">
			</a>
			<div class="summary">'.$post->{$params->title}.'</div>
			</article> '; 
	} ?>	
 </div>
 <div class="timeline" id="news_timeline2"> 
 
 </div>
 <div id="ic-loading" style="display: none">
	<i class="fa fa-spinner"></i>
 </div>
<div class="hidden-md hidden-lg" id="boxemthem">
	<div class="xemthem text-center">
		<a class="btn btn-primary" href="javascript:;" onclick="xemthemtin()">Xem thêm</a>
	</div>
</div> 

<input type="hidden" id="row" value="0">
<input type="hidden" id="all" value="30">

<script> 
$(document).ready(function(){   //alert("s");
	$(window).scroll(function(){	 
		var position = $(window).scrollTop();
		var bottom = $(document).height() - $(window).height();
		var manhinh = $(window).width();//alert(manhinh);
		//alert($('.l-content').height() +"_"+ $(window).height());
		if(manhinh > 855){
			if( position == bottom ){
				$('#ic-loading').show();
				var row = $('#row').val()*1;
				var allcount = $('#all').val()*1;
				var rowperpage = 10;
				row = row + rowperpage;
				if(row <= allcount){
					$('#row').val(row);
					$.ajax({
						url: '<?= $ariacms->actual_link ?>ajax/ajax.addnews.php',
						type: 'post',
						data: {row:row},
						success: function(response){ //alert(response);
						//alert(response.trim());
							$('#ic-loading').hide();
							if(response.trim() == ''){
								$("#news_by_categories").show();
							}else{
								$("#news_timeline2").append(response).fadeIn("slow");
							}
						}
					}); 
				} else { $("#news_by_categories").show();$('#ic-loading').hide();}
			}
		}
	});
});

function xemthemtin(){
	var row = $('#row').val()*1;
	var allcount = $('#all').val()*1;
	var rowperpage = 10;
	row = row + rowperpage;
	if(row <= allcount){
		$('#ic-loading').show();
		$('#row').val(row);
		$.ajax({
			url: '<?= $ariacms->actual_link ?>ajax/ajax.addnews.php',
			type: 'post',
			data: {row:row},
			success: function(response){ //alert(response);
				//alert(response.trim());
				$('#ic-loading').hide();
				if(response.trim() == ''){
					$("#news_by_categories").show();
				}else{
					$("#news_timeline2").append(response).fadeIn("slow");
				}
			}
		}); 
	} else { $("#news_by_categories").show(); $("#boxemthem").hide();$('#ic-loading').hide();}
}
</script>
