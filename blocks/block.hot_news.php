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
<div  class="lg:w-1/3 w-full flex-shrink-0">
	<div uk-sticky="offset:100" class="uk-sticky uk-active uk-sticky-fixed" data-simplebar="init" style="position: fixed;">
			<div id="bieudo">
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
			</div>
			<div class="divide-y" id="banner_ads">
					
				<div style="margin: 5px 0">
					<?php foreach($banner as $key){?>
					  <a <?php if($key->link) echo "href='".$key->link."'"?> class=" relative">  
						  <img src="<?=$key->image?>" alt="" class="rounded-md w-full lg:h-76 object-cover"  style="margin: 5px 0; border-radius:0px">
					  </a>
					 <?php }?>

				
				</div>
			</div>
			<div class="divide-y" id="fanpage_fb">
				<div id="fb-root"></div>
				<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0&appId=251420733258426&autoLogAppEvents=1" nonce="s40lL7BZ"></script>
				<div id="fb-root"></div>
				<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0&appId=251420733258426&autoLogAppEvents=1" nonce="WckzZCZR"></script>

				<div style="width:100%" class="fb-page" data-href="https://www.facebook.com/Di%E1%BB%85n-%C4%90%C3%A0n-Kinh-T%E1%BA%BF-247-102156831967891" data-tabs="" data-width="1000px" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
					
				</div>
				<div style="width:100%" class="fb-group" data-href="https://www.facebook.com/groups/774800516759454/?ref=web_social_plugin" data-width="" data-show-social-context="true" data-show-metadata="false">
					
				</div>
			
			</div>
			
		</div>
	</div>

<style>
#banner_ads, #fanpage_fb{display: block;}

</style>

<script>
$(document).ready(function(){
  $(".owl-carousel").owlCarousel();
});
$('#tamdiem').owlCarousel({
	autoplay:true,
	loop:true,
	nav:true,
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
	autoplay:true,
	loop:true,
	margin:10,
	nav:true,
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

jQuery(document).ready(function($) { 
	var bieudo = $("#bieudo");
	var banner_ads = $("#banner_ads");
	var fanpage_fb = $("#fanpage_fb");
	
	$(window).scroll(function(){
		
		if($(this).scrollTop() > 1000 && $(this).scrollTop() <= 4000){
			/*$( "#banner_ads" ).animate({
				opacity: 1,
			  }, 1500, function() {
				  banner_ads.show();
				  bieudo.hide();
				  fanpage_fb.hide();
			  });*/
			  banner_ads.show();
			  bieudo.hide();
			  fanpage_fb.show();
		}else if($(this).scrollTop() > 4000){
			bieudo.hide();
			banner_ads.hide();
			fanpage_fb.show();
		}else{
			bieudo.show();
			banner_ads.show();
			fanpage_fb.show();
		}
	})
})

</script>