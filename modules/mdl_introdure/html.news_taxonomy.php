<?php
class View
{
	static function viewhome()
	{
		global $ariacms;
		global $params;		
		global $database;
		global $ariaConfig_template;
		function text_limit_hotnews($str,$limit=10)
		 {
			 if(stripos($str," ")){
				 $ex_str = explode(" ",$str);
				 if(count($ex_str)>$limit){
				 for($i=0;$i<$limit;$i++){
				 $str_s.=$ex_str[$i]." ";
				 }
				 return $str_s;
				 }else{
				 return $str;
				 }
				 }else{
				 return $str;
			 }
		 }
?>


<!DOCTYPE html>
<html lang="vi">
<head>
	<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
	<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:site_name" content="<?= $ariacms->web_information->{$params->name} ?>" />
	<meta property="og:url" content="<?= $ariacms->c_url ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>
	<meta property="og:image" content="/templates/Economic247/images/logo.jpg"/>

	<?= $ariacms->getBlock("head"); ?>
	
</head>

<body>


<div id="wrapper">

	<?= $ariacms->getBlock("header"); ?>

	<!-- sidebar -->
	
	<?= $ariacms->getBlock("menu"); ?>
	
	<!-- Main Contents -->
	<div class="main_content">
		<div class="mcontainer">
			
			<div class="lg:flex  lg:space-x-12">
				<?= $ariacms->getBlock("advertisement_center"); ?>
				<?php //$ariacms->getBlock("hot_news"); ?>
			</div>
		</div>
	</div>
	
</div>
<?= $ariacms->getBlock("footer"); ?>
</body>

</html>

<?php
	}
}
?>