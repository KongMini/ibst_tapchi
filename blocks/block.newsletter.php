<?php 
global $ariacms;
global $database;
global $params;
$query ="SELECT * FROM e4_web_image WHERE status='active' AND position ='advertisement' ORDER BY id ";
$database->setQuery($query);
$lienket= $database->loadObjectList();
// print_r($lienket);die();

?>
<link rel="stylesheet" type="text/css" href="/templates/tapchi/slick/slick.css"/>
 <link rel="stylesheet" type="text/css" href="/templates/tapchi/slick/slick-theme.css"/>
  <script type="text/javascript" src="/templates/tapchi/slick/slick.min.js"></script> 
 
        <style>

		.slick-slide {
		  padding: 5px 5px;
		}

		.slick-arrow:before {
		  color: black;
		}
		.slick-dots {
		  bottom: -30px;
		}

		.slider {
		  margin: 5px 0px;
		}
		.slider-nav{
			border-top: 2px solid #fece00;
		}
		.slider-nav div.slick-slide.slick-current.slick-active.slick-center{
			opacity: 1;
		}
		.slider.slider-nav div.slick-slide {
			opacity: 0.5;
		}
		 </style>
<section class="cta">
<div class="container ">
        <div class="slider slider-x ">
			 <?php foreach ($lienket as $key => $lk) {
 	?>
				<div align="center">
					<a><img src="<?=$lk->image?>" /></a>
				</div>
			 <?php } ?>
		</div>
		<script>
		$('.slider-x').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
});
		
        </script>
<!-- <div class="twelve columns">
<h2>Ready to Get Started?</h2>
<p>Let's schedule a call and get you a quote</p>
<p><a href="../request-a-quote/index.html" class="button button-black"><i class="fal fa-long-arrow-right"></i>  Get Your Quote</a></p>
</div> -->
</div>
</section>	
