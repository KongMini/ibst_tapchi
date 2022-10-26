<?php
global $ariacms;
global $params;
?>
<!DOCTYPE html>
<title>Tạp chí tài chính số </title>

		<head>
			<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
			<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<?= $ariacms->getBlock("head"); ?>
		</head>

<body>

<?= $ariacms->getBlock("header"); ?>

<div class="site-content">
<div class="l-grid" data-startpage="0" data-objectid="0" data-listtype="2" data-pagetype="0" data-searchtype="0">
<div class="l-content">
<div class="highlight" >
<?php
				if ($news) {
					$maxRows = $ariacms->web_information->posts_per_page; //echo $maxRows;
				//	$maxRows=6;
					$curPg = $ariacms->getParaUrl('curPg');
					if ($curPg == '') $curPg = 1;
					$curRow = ($curPg - 1) * $maxRows;
					while ($curRow < count($news) && ($curRow < $curPg * $maxRows)) {
						$new = $news[$curRow];
						$curRow++;							
						 if($curRow==1){	// Lấy ra bản tin đầu tiên để cho vào vùng banner
						echo '
							 <div class="focus">
								<article class="story">
									<a href="'.$ariacms->actual_link . 'chi-tiet/' . $new->url_part . '.html" class="story__thumb">
									<img src="'.$new->image.'" alt="">
									</a>
									 <div class="meta">
									<h2><a href="'.$ariacms->actual_link . 'chi-tiet/' . $new->url_part . '.html" class="story__title">'.$new->{$params->title}.'</a></h2>
									</div>
								</article>
							</div>';
						 } else { // các bản tin hot khác thì hiển thị phía dưới
							 if($curRow==2) echo '<div class="cols-4"> '; 
							 echo '	<article class="story">
										<a href="'.$ariacms->actual_link . 'chi-tiet/' . $new->url_part . '.html" class="story__thumb">
										<img src="'.$new->image.'" alt="">
										</a>
										<h2><a href="'.$ariacms->actual_link . 'chi-tiet/' . $new->url_part . '.html" class="story__title">'.$new->{$params->title}.'</a></h2>
									</article>'; 	
									
								
						 }  
					}
				 echo '</div>';
				} ?>

</div>

<?= $ariacms->getBlock("footer"); ?>


</body></html>