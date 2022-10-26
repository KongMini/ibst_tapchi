<?php
global $ariacms;
global $params;
?>
<!DOCTYPE html>
<!-- saved from url=(0023)https://giaoduc.net.vn/ -->
<title>Giáo dục Việt Nam</title>

		<head>
			<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
			<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<?= $ariacms->getBlock("head"); ?>
		</head>

<body data-rootzoneid="0">

<?= $ariacms->getBlock("header"); ?>

<div class="site-content">
<div class="l-grid" data-startpage="0" data-objectid="0" data-listtype="2" data-pagetype="0" data-searchtype="0">
<div class="l-content">
<?= $ariacms->getBlock("hot_news"); ?> 
<?= $ariacms->getBlock("news_recent"); ?>
<div class="pager">
<span id="main_PagingList1_pager">
<a id="main_PagingList1_pager_preControl" class="pre__page" href="https://giaoduc.net.vn/" style="display: none;">Quay lại</a>
<a id="main_PagingList1_pager_nextControl" class="next__page" href="https://giaoduc.net.vn/" style="display: none;">Xem tiếp</a>
</span>
</div>
</div>

<div class="sidebar">

<div id="sticky-top-0"></div>
 <?= $ariacms->getBlock("news_related"); ?>
 <?= $ariacms->getBlock("news_related"); ?>
 <?= $ariacms->getBlock("news_related"); ?>
 
 
<!-- chủ đề nổi bật -->
 <?= $ariacms->getBlock("news_related"); ?>
 
<!-- hết chủ đề nổi bật -->

<div id="sticky-top"></div>
<!-- Đọc nhiều, thảo luận -->
<?= $ariacms->getBlock("news_related"); ?>
<!-- hết đọc nhiều, thảo luận -->
</div>
</div>
</div>

<div id="loading" style="display: none;">Đang tải tin...</div>
<div class="sticky-bottom"></div>
<?= $ariacms->getBlock("footer"); ?>

</body></html>