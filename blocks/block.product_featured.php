<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_term_taxonomy WHERE taxonomy = 'product_category' AND position = 'header' AND status = 'active' AND count > 0 ORDER BY e4_term_taxonomy.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();

$query = "SELECT * FROM e4_term_taxonomy WHERE taxonomy = 'product_group' AND position = 'home' AND status = 'active' AND count > 0 ORDER BY e4_term_taxonomy.order LIMIT 0,1";
$database->setQuery($query);
$group = $database->loadRow();

$query = "SELECT c.category, a.*
		FROM e4_posts a
			JOIN (
				SELECT t1.object_id
				FROM e4_term_relationships t1 WHERE t1.term_taxonomy_id = (SELECT id from e4_term_taxonomy WHERE taxonomy = 'product_group' and position = 'home' AND status = 'active' LIMIT 0,1)
				) d ON a.id = d.object_id
			JOIN (
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.url_part) AS category
				FROM e4_term_relationships t1 
					JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'product_category' GROUP BY t1.object_id
				) c ON a.id = c.object_id
		WHERE a.post_type = 'product'  AND a.post_status = 'active'
		order by a.id desc
		";
$database->setQuery($query);
$products = $database->loadObjectList();
?>
<section class="product spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4">
				<div class="section-title">
					<h4><?= $group[$params->title] ?></h4>
				</div>
			</div>
			<div class="col-lg-8 col-md-8">
				<ul class="filter__controls">
					<li class="active" data-filter="*"><?= _ALL ?></li>
					<?php
					foreach ($taxonomies as $taxonomy) {
						echo '<li data-filter=".' . $taxonomy->url_part . '">' . $taxonomy->{$params->title} . '</li>';
					}
					?>
				</ul>
			</div>
		</div>

		<div class="row property__gallery">
			<?php
			foreach ($products as $product) {
				$class = str_replace(',', '', $product->category);
			?>
				<div class="col-lg-3 col-md-4 col-sm-6 mix <?= $class ?>">
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
			?>
		</div>
	</div>
</section>