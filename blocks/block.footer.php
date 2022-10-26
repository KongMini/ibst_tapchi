<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $analytics_code;
$query ="SELECT * FROM e4_web_image WHERE status='active' AND position ='advertisement' ORDER BY id ";

$database->setQuery($query);

$lienket= $database->loadObjectList();

?>
<div class="band bottom" >   
	<footer class="container">
		<div class="row" style="text-align:center">
			<h3><?=$ariacms->web_information->{$params->name}?></h3>
			<ul style="margin-bottom:0">
				<li>
					<a><i class="fa fa-map-marker" aria-hidden="true"></i> <?= _ADDRESS?>: <?=$ariacms->web_information->{$params->address}?></a>
					&emsp;| &emsp;
					<i class="fa fa-phone" aria-hidden="true"></i> <?= _PHONE?>: <a href="tel:<?=$ariacms->web_information->hotline?>"><?=$ariacms->web_information->hotline?></a>
					&emsp;|&emsp; <i class="fa fa-envelope" aria-hidden="true"></i>Email: 
					<a href="mailtp: <?=$ariacms->web_information->admin_email?>"><?=$ariacms->web_information->admin_email?></a>
                    &emsp;|&emsp; <a href="<?=$ariacms->web_information->facebook?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    &emsp;|&emsp; <a href="<?=$ariacms->web_information->youtube?>"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    &emsp;|&emsp; <a href="<?=$ariacms->web_information->instagram?>"> <i class="fa fa-instagram" aria-hidden="true"></i></a>
				</li>
			</ul>
			<ul style="margin-top: -10px;margin-bottom: 0;">
				<li>
					<a> <?= _REPRESENTATIVE?>: <?=$ariacms->web_information->{$params->daidien}?></a>
					&emsp;| &emsp;
					<a><?= _COPYRIGHT?></a>
					
				</li>
			</ul>
		</div>
		
		
		
	</footer><!-- container -->
</div><!--end band-->