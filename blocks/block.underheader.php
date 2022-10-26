<?php

global $database;

global $ariacms;

global $params;

$query = "SELECT * FROM  e4_web_image  WHERE status = 'active' AND position='banner' ORDER BY id ";

$database->setQuery($query);

$banners = $database->loadObjectList();

// Lấy ra số hiện tại
$query = "SELECT * FROM e4_linhvuc where time_end < ". time()." and status = 'active' and nam = '". date('Y')."' ORDER BY id DESC LIMIT 0,1";

$database->setQuery($query);

$sohientai = $database->loadRow();

if(!$sohientai){
	
	$query = "SELECT * FROM e4_linhvuc  ORDER BY id DESC LIMIT 0,1";

	$database->setQuery($query);

	$sohientai = $database->loadRow();
	
}

foreach ($banners as $key => $banner) {


    ?>

	<style>
		.flex-hero-col .test a { width: 20%;}
		@media only screen and (min-width: 0) and (max-width: 767px) {
			.flex-hero-col .test a{ width: 70%}
		}
	</style>
    <div data-bg="<?= $banner->image ?>"
         style=" background-position: center bottom; background-size: cover; position: relative"
         class="flex-hero-image rocket-lazyload" alt="Front Page">


        <div id="color-overlay">

            <div class="flex-hero-col hero-col-1">


                <!-- <h1><?= $banner->{$params->title} ?></h1> -->


                <p class="small-text desktop-only"><?= $banner->{$params->title} ?></p>


                <p class="test">


                    <a href="<?= $ariacms->actual_link ?>chu-de/<?= $sohientai['url_part']?>.html" class="button button-primary"> <?= _CURRENT_ISSUES?></a>
                    </br>
                    <a href="<?= $ariacms->actual_link ?>chu-de.html" class="button button-primary"> <?= _ALL_ISSUES?></a>
                    </br>
                    <a style="background-color: #ef6f07;" href="<?= $ariacms->actual_link ?>member/tao-bai-viet.html" class="button button-primary"> <?= _SUBMIT_PAPER?> </a>
                </p>

            </div>


            <div class="flex-hero-col hero-col-2">&nbsp;</div>


        </div>


    </div>


<?php } ?>



