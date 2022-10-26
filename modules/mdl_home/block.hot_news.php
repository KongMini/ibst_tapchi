<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;


$query = "SELECT * FROM `e4_web_image` WHERE position='advertisement' and status ='active' ORDER BY region DESC LIMIT 3";
//echo $query ;
$database->setQuery($query);
$banner = $database->loadObjectList();

$query = "SELECT title_vi,url_part FROM `e4_term_taxonomy` where taxonomy = 'post_tags' LIMIT 0,5";
//echo $query ;
$database->setQuery($query);
$tags = $database->loadObjectList();

?>
<link rel="stylesheet" href="<?= $ariacms->actual_link ?>templates/<?= $ariaConfig_template ?>/css/owl.carousel.css">
<link rel="stylesheet" href="<?= $ariacms->actual_link ?>templates/<?= $ariaConfig_template ?>/css/owl.theme.default.css">
<link rel="stylesheet" href="<?= $ariacms->actual_link ?>templates/<?= $ariaConfig_template ?>/css/owl.theme.green.css">
<script src="<?= $ariacms->actual_link ?>templates/<?= $ariaConfig_template ?>/js/owl.carousel.js"></script>
<div>

	<div  class="sidebar_inner" data-simplebar="init" style="padding-bottom:150px">
			<script src="https://www.fireant.vn/Scripts/web/widgets.js"></script>
			<div id="fan-quote-328"></div>
			<script type="text/javascript">
				new FireAnt.MarketsWidget({
					"container_id": "fan-quote-328",
					"locale": "vi",
					"price_line_color": "#71BDDF",
					"grid_color": "#999999",
					"label_color": "#999999",
					"width": "100%",
					"height": "120px"
				});
				new FireAnt.StockWidget({
					
					"width": "100%",
					"height": "300px"
				});
			</script>
			<script>
				   // $( window ).on( "load", function() {
						// var x = document.getElementsByTagName('tr');
						// console.log(x);

				// });
				// $( document ).ready(function() {
					// var x = document.getElementsByTagName('tr');
					// console.log(x);
					// alert('run');
				// });

			</script>
					<div class="divide-y">
					
					<!-- Bài viết top 1 -->
						
							<div class="grid grid-cols-2 gap-2 p-2">
								<?php foreach($banner as $key){?>
								  <a <?php if($key->link) echo "href='".$key->link."'"?> class="col-span-2 relative">  
									  <img src="<?=$key->image?>" alt="" class="rounded-md w-full lg:h-76 object-cover">
								  </a>
								 <?php }?>

							
							</div>
						

					</div>
					
					
						
					<iframe style="margin:auto;" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FDi%25E1%25BB%2585n-%25C4%2590%25C3%25A0n-Kinh-T%25E1%25BA%25BF-247-102156831967891&tabs&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=251420733258426"  height="130"  style="width: 97%%;border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true"  allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
					<iframe style="margin:auto;" src="https://www.facebook.com/plugins/group.php?href=https%3A%2F%2Fwww.facebook.com%2Fgroups%2F774800516759454&show_social_context=true&show_metadata=true&appId=251420733258426"  height="222" style="width: 100%;border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
					<!--div class="foot">
						<h4 class="text-xl font-semibold mb-3 " > Fanpage </h4>

						<div class="flex flex-wrap gap-2 " >
						<?php if($ariacms->web_information->facebook){?>
							<a href="<?=$ariacms->web_information->facebook ?>" class="bg-gray-100 py-1.5 px-4 rounded-full">Facebook</a>
						<?php }if($ariacms->web_information->instagram) {?>
							
							<a href="<?=$ariacms->web_information->instagram ?>" class="bg-gray-100 py-1.5 px-4 rounded-full">Instagram</a>
						<?php }?>	
						
						</div>
					</div-->
		</div>
</div>
<script>
$(document).ready(function(){
  $(".owl-carousel").owlCarousel();
});
$('#tamdiem').owlCarousel({
	loop:true,
	margin:10,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:2
		}
	}
});
$('#tinnoibat').owlCarousel({
	loop:true,
	margin:10,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:1
		},
		1000:{
			items:1
		}
	}
})
</script>