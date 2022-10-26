<?php
global $ariacms;
global $params;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<title><?= ($detail[$params->meta_title] != '') ? $detail[$params->meta_title] : $detail[$params->title]; ?></title>

	<meta name="description" content="<?= ($detail[$params->meta_description] != '') ? $detail[$params->meta_description] : $detail[$params->brief] ?>" />
	<meta name="keywords" content="<?= ($detail[$params->meta_keyword] != '') ? $detail[$params->meta_keyword] : $detail[$params->title]; ?>" />
	<meta property="og:title" content="<?= ($detail[$params->meta_title] != '') ? $detail[$params->meta_title] : $detail[$params->title]; ?>" />
	<meta property="og:description" content="<?= ($detail[$params->meta_description] != '') ? $detail[$params->meta_description] : $detail[$params->brief]; ?>" />
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
						<a href="<?= $ariacms->actual_link ?>blog.html">Blog</a>
						<span><?= $detail[$params->title] ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="blog-details spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8">
					<div class="blog__details__content">
						<div class="blog__details__item">
							<?= ($detail['image'] != '') ? '<img style="width:100%" src="' . $detail['image'] . '" alt="' . $detail[$params->title] . '">' : '' ?>
							<div class="blog__details__item__title">
								<h4><?= $detail[$params->title] ?></h4>
								<ul>
									<li><span><?= $detail['fullname'] ?></span></li>
									<li><?= $ariacms->unixToDate($detail['post_created'], '/') ?> <?= $ariacms->unixToTime($detail['post_created'], ':') ?></li>
								</ul>
							</div>
						</div>
						<div class="blog__details__desc">
							<?= $detail[$params->brief] ?>
						</div>
						<div class="blog__details__desc">
							<?= $detail[$params->content] ?>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="blog__sidebar">
						<div class="blog__sidebar__item">
							<div class="section-title">
								<h4><?= _NEWS_CATEGORY ?></h4>
							</div>
							<ul>
								<?php
								// foreach ($taxonomies as $taxonomy) {
								// 	if ($taxonomy->taxonomy == 'category')
								// 		$total += $taxonomy->count;
								// }
								?>
								<!--li><a href="<?= $ariacms->actual_link ?>blog.html"><?= _ALL ?> <span>(<?= $total ?>)</span></a></li-->
								<?php
								foreach ($taxonomies as $taxonomy) {
									if ($taxonomy->taxonomy == 'category' && $taxonomy->parent == 0) {
								?>
										<li><a href="<?= $ariacms->actual_link . 'blog/' . $taxonomy->url_part . '.html'; ?>"><?= $taxonomy->{$params->title} ?><span>(<?= $taxonomy->count ?>)</span></a></li>
										<?php
										foreach ($taxonomies as $taxonomy_sub) {
											if ($taxonomy->id == $taxonomy_sub->parent) {
										?>
												<li><a href="<?= $ariacms->actual_link . 'blog/' . $taxonomy_sub->url_part . '.html'; ?>">-- <?= $taxonomy_sub->{$params->title} ?><span>(<?= $taxonomy_sub->count ?>)</span></a></li>
								<?php
											}
										}
									}
								}
								?>
							</ul>
						</div>
						<div class="blog__sidebar__item">
							<div class="section-title">
								<h4><?= _NEWS_RELATED ?></h4>
							</div>
							<?php
							if ($news_relateds) {
								foreach ($news_relateds as $news_related) {
							?>
									<a href="<?= $ariacms->actual_link . 'chi-tiet/' . $news_related->url_part . '.html'; ?>" class="blog__feature__item">
										<div class="blog__feature__item__pic">
											<?php
											if ($news_related->image_thumb != '') {
												echo '<img style="max-width:100px" src="' . $news_related->image_thumb . '" alt="' . $news_related->{$params->title} . '">';
											} else if ($news_related->image != '') {
												echo '<img style="max-width:100px" src="' . $news_related->image . '" alt="' . $news_related->{$params->title} . '">';
											}
											?>
										</div>
										<div class="blog__feature__item__text">
											<h6><?= $news_related->{$params->title} ?></h6>
											<span><?= $ariacms->unixToDate($news_related->post_created, '/') ?> <?= $ariacms->unixToTime($news_related->post_created, ':') ?></span>
										</div>
									</a>
							<?php
								}
							}
							?>
						</div>
						<div class="blog__sidebar__item">
							<div class="section-title">
								<h4>Tags</h4>
							</div>
							<div class="blog__sidebar__tags">
								<?php
								foreach ($taxonomies as $taxonomy) {
									if ($taxonomy->taxonomy == 'post_tags') {
								?>
										<a href="<?= $ariacms->actual_link . 'blog/' . $taxonomy->url_part . '.html'; ?>"><?= $taxonomy->{$params->title} ?><span>(<?= $taxonomy->count ?>)</span></a>

								<?php
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?= $ariacms->getBlock("news_recent"); ?>
	<?= $ariacms->getBlock("footer"); ?>
	<?= $ariacms->getBlock("footer_script"); ?>
</body>

</html>