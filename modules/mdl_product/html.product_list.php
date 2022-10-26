<?php
global $ariacms;
global $params;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<title><?= _PRODUCT_LIST ?> - <?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
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
						<span><?= _PRODUCT_LIST ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>


	<section class="shop spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="shop__sidebar">
						<div class="sidebar__categories">
							<div class="section-title">
								<h4><?= _CATEGORIES ?></h4>
							</div>
							<div class="categories__accordion">
								<div class="accordion" id="accordionExample">

									<?php
									foreach ($taxonomies as $taxonomy) {
										if ($taxonomy->taxonomy == 'product_category' && $taxonomy->submenu > 0 && $taxonomy->parent == 0) {
									?>
											<div class="card">
												<div class="card-heading <?= ($taxonomy->url_part == $ariacms->getParam('task')) ? ' active' : ''; ?>">
													<a data-toggle="collapse" data-target="#collapse<?= $taxonomy->id ?>"><?= $taxonomy->{$params->title} ?></a>
												</div>
												<div id="collapse<?= $taxonomy->id ?>" class="collapse <?= ($taxonomy->url_part == $ariacms->getParam('task')) ? ' show' : ''; ?>" data-parent="#accordionExample">
													<div class="card-body">
														<ul>
															<?php
															foreach ($taxonomies as $taxonomy_sub) {
																if ($taxonomy->id == $taxonomy_sub->parent) {
															?>
																	<li><a href="<?= $ariacms->actual_link . 'san-pham/' . $taxonomy_sub->url_part . '.html'; ?>"><?= $taxonomy_sub->{$params->title} ?></a></li>
															<?php
																}
															}
															?>
														</ul>
													</div>
												</div>
											</div>
										<?php
										} else if ($taxonomy->taxonomy == 'product_category' && $taxonomy->parent == 0) {
										?>
											<div class="card">
												<div class="card-heading-not-sub">
													<a href="<?= $ariacms->actual_link . 'san-pham/' . $taxonomy->url_part . '.html'; ?>"><?= $taxonomy->{$params->title} ?></a>
												</div>
											</div>
									<?php
										}
									}
									?>
								</div>
							</div>
						</div>
						<form method="post" action="<?= $ariacms->c_url ?>">
							<div class="sidebar__sizes">
								<div class="section-title">
									<h4><?= _SEARCH ?> <?= _PRODUCT ?></h4>
								</div>
							</div>
							<?php
							foreach ($taxonomies as $taxonomy) {
								if ($taxonomy->taxonomy == 'product_type' && $taxonomy->submenu > 0 && $taxonomy->parent == 0) {
							?>
									<div class="sidebar__sizes">
										<div class="section-title">
											<h4><?= $taxonomy->{$params->title} ?></h4>
										</div>
										<div class="size__list">
											<?php
											foreach ($taxonomies as $taxonomy_sub) {
												if ($taxonomy->id == $taxonomy_sub->parent) {
													$checked = (in_array($taxonomy_sub->id, $_SESSION["filter"]->taxonomy)) ? 'checked' : '';
											?>
													<label for="<?= $taxonomy_sub->url_part ?>">
														<?= $taxonomy_sub->{$params->title} ?>
														<input type="checkbox" name="taxonomy[]" id="<?= $taxonomy_sub->url_part ?>" value="<?= $taxonomy_sub->id ?>" <?= $checked ?> />
														<span class="checkmark"></span>
													</label>
											<?php
												}
											}
											?>
										</div>
									</div>

							<?php
								}
							}
							?>
							<div class="sidebar__sizes">
								<div class="section-title">
									<h4><?= _PRICE_LEVEL ?></h4>
								</div>
								<div class="form-group">
									<input min="0" step="1000" name="price_from" placeholder="<?=_FROM?>" type="number" class="form-control" style="margin: 10px 0px;" value="<?= ($_SESSION["filter"]->price_from > 0) ? $_SESSION["filter"]->price_from : '' ?>">
									<input min="0" step="1000" name="price_to" placeholder="<?=_TO?>" type="number" class="form-control" style="margin: 10px 0px;" value="<?= ($_SESSION["filter"]->price_to > 0) ? $_SESSION["filter"]->price_to : '' ?>">
								</div>
								<button type="submit" class="site-btn" name="btn_filter" value="filter"><?= _FILTER ?></button>
							</div>
						</form>
					</div>
				</div>

				<div class="col-lg-9 col-md-9">
					<div class="row">
						<?php
						if ($products) {
							$maxRows = $ariacms->web_information->product_per_page;
							$curPg = $ariacms->getParaUrl('curPg');
							if ($curPg == '') $curPg = 1;
							$curRow = ($curPg - 1) * $maxRows;
							while ($curRow < count($products) && ($curRow < $curPg * $maxRows)) {
								$product = $products[$curRow];
								$curRow++;
						?>
								<div class="col-md-4 col-sm-6">
									<div class="product__item">
										<div class="product__item__pic set-bg" data-setbg="<?= $product->image ?>">
											<?= ($product->product_sale < $product->product_price && $product->product_sale > 0) ? '<div class="label sale">Sale</div>' : ''; ?>
											<ul class="product__hover">
												<li><a href="<?= $product->image ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
												<li><a title="<?=_ADD_TO_CART?>" onclick="cartAdd(<?=$product->id?>)" href="javascript:void(0);"><span class="icon_bag_alt"></span></a></li>
											</ul>
										</div>
										<div class="product__item__text">
											<h6><a href="<?= $ariacms->actual_link . 'chi-tiet/' . $product->url_part . '.html'; ?>"><?= $product->{$params->title} ?></a></h6>
											<div class="rating">
												<?php
												for ($i = 0; $i < 5; $i++) {
													if ($i < $product->rating)
														echo '<i class="fa fa-star"></i>&nbsp;';
													else
														echo '<i class="fa fa-star-o"></i>&nbsp;';
												}
												?>
											</div>
											<div class="product__price">
												<?= ($product->product_sale > 0) ? $ariacms->formatPrice($product->product_sale) : _CONTACT; ?>
												<?= ($product->product_price > 0) ? '<span>' . $ariacms->formatPrice($product->product_price) . '</span>' : ""; ?>
											</div>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>
						<div class="col-lg-12 text-center">
							<div class="pagination__option">
								<?= $ariacms->paginationPublic(count($products), $maxRows, 3) ?>
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