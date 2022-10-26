<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_term_taxonomy WHERE taxonomy = 'product_group' AND position = 'home' AND status = 'active' AND count > 0 ORDER BY e4_term_taxonomy.order LIMIT 1,3 ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();

$query = "SELECT c.groups, a.*
		FROM e4_posts a
			JOIN (
				SELECT t1.object_id, GROUP_CONCAT(' ', t2.id) AS groups
					FROM e4_term_relationships t1 
					JOIN ( SELECT id from e4_term_taxonomy WHERE taxonomy = 'product_group' AND position = 'home' AND status = 'active' LIMIT 1,3 ) t2 ON t1.term_taxonomy_id = t2.id GROUP BY t1.object_id
				) c ON a.id = c.object_id
		WHERE a.post_type = 'product' AND a.post_status = 'active'
		order by a.id desc
		";
$database->setQuery($query);
$products = $database->loadObjectList();
?>
<section class="trend spad">
	<div class="container">
		<div class="row">
			<?php
			foreach ($taxonomies as $taxonomy) {
			?>
				<div class="col-lg-4 col-md-4 col-sm-6">
					<div class="trend__content">
						<div class="section-title">
							<h4><?= $taxonomy->{$params->title} ?></h4>
						</div>
						<?php
						foreach ($products as $product) {
							$checkItem = explode(',', $product->groups);
							if (in_array($taxonomy->id, $checkItem)) {
						?>
								<div class="trend__item">
									<div class="trend__item__pic">
										<img class="img-thumb" src="<?= ($product->image_thumb != '') ? $product->image_thumb : $product->image ?>" alt="<?= $product->{$params->title} ?>">
									</div>
									<div class="trend__item__text">
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
						<?php
							}
						}
						?>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</section>