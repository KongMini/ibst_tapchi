<?php
global $ariacms;
global $params;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<title><?= _NEWS_CATEGORY ?> - <?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
	<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	<?= $ariacms->getBlock("head"); ?>
</head>

<body>
	<?= $ariacms->getBlock("header"); ?>

	<div class="breadcrumb-option">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb__links">
						<a href="<?= $ariacms->actual_link ?>"><i class="fa fa-home"></i> <?= _HOME ?></a>
						<span><?= _NEWS_CATEGORY ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="blog spad">
		<div class="container">
			<div class="row">
				<?php
				if ($news) {
					$maxRows = $ariacms->web_information->posts_per_page;
					$curPg = $ariacms->getParaUrl('curPg');
					if ($curPg == '') $curPg = 1;
					$curRow = ($curPg - 1) * $maxRows;
					while ($curRow < count($news) && ($curRow < $curPg * $maxRows)) {
						$new = $news[$curRow];
						$curRow++;
				?>
						<div class="col-lg-4 col-md-4 col-sm-6">
							<div class="blog__item">
								<div class="blog__item__pic  set-bg" data-setbg="<?= $new->image ?>"></div>
								<div class="blog__item__text">
									<h6><a href="<?= $ariacms->actual_link . 'chi-tiet/' . $new->url_part . '.html'; ?>"><?= $new->{$params->title} ?></a></h6>
									<ul>
										<li><span><?= $new->fullname ?></span></li>
										<li><?= $ariacms->unixToDate($new->post_created, '/') ?> <?= $ariacms->unixToTime($new->post_created, ':') ?></li>
									</ul>
								</div>
							</div>
						</div>
				<?php
					}
				}
				?>
				<div class="col-lg-12 text-center">
					<div class="pagination__option">
						<?= $ariacms->paginationPublic(count($news), $maxRows, 3) ?>
					</div>
				</div>

			</div>
		</div>
	</section>
	<?= $ariacms->getBlock("footer"); ?>
	<?= $ariacms->getBlock("footer_script"); ?>
</body>

</html>