<?php
class View
{
	static function viewhome()
	{
		global $ariacms;
		global $params;
		global $database;
?>
		<!DOCTYPE html>
		<html lang="vi">

		<head>
			<title><?= _VIEW_CART ?> - <?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
			<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<?= $ariacms->getBlock("head"); ?>
			<style>
				#checkout_input input {
					height: 30px;
					width: 100%;
					border: 1px solid #e1e1e1;
					border-radius: 2px;
					margin-bottom: 5px;
					font-size: 14px;
					padding-left: 20px;
					color: #666666;
				}
			</style>
		</head>

		<body>
			<?= $ariacms->getBlock("header"); ?>
			<div class="breadcrumb-option">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="breadcrumb__links">
								<a href="<?= $ariacms->actual_link ?>"><i class="fa fa-home"></i> <?= _HOME ?></a>
								<span>Giỏ hàng</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<section style="padding-bottom:0px" class="shop-cart spad">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="shop__cart__table">
								<table>
									<thead>
										<tr>
											<th><?= _PRODUCT ?></th>
											<th><?= _PRICE ?></th>
											<th><?= _QUANTITY ?></th>
											<th><?= _TOTAL ?></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sum = 0;
										$count_ = 0;
										$total = 0;
										foreach ($_SESSION['orderCart'] as $productID => $qt) {
											$item = $ariacms->selectOne('e4_posts', 'id', '=', $productID);
											$sum    = $item["product_sale"] * $qt;
											$total  += $sum;
											$count_++;
										?>
											<tr>
												<td class="cart__product__item">
													<img style="height:100px;" src="<?= $item["image"] ?>" alt="<?= $item[$params->title] ?>">
													<div class="cart__product__item__title">
														<h6><?= $item[$params->title] ?></h6>
														<div class="rating">
															<?php
															for ($i = 0; $i < 5; $i++) {
																if ($i < $item['rating'])
																	echo '<i class="fa fa-star"></i>&nbsp;';
																else
																	echo '<i class="fa fa-star-o"></i>&nbsp;';
															}
															?>
														</div>
													</div>
												</td>
												<td class="cart__price"><?= ($item['product_sale'] > 0) ? $ariacms->formatPrice($item['product_sale']) : _CONTACT; ?></td>
												<td class="cart__quantity">
													<input style="width:50%" class="form-control" type="number" value="<?= $qt ?>" id="quantity_<?= $productID ?>" onchange="cartEdit(<?= $productID ?>)">
												</td>
												<td class="cart__total"><?= ($item['product_sale'] > 0) ? $ariacms->formatPrice($sum) : _CONTACT; ?></td>
												<td class="cart__close"><span class="icon_close" onclick="cartDelete(<?= $productID ?>)"></span></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="cart__btn">
								<a href="<?= $ariacms->actual_link ?>san-pham.html">Mua thêm</a>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="cart__btn update__btn">
								<a href="<?= $ariacms->c_url ?>"><span class="icon_loading"></span> Cập nhật giỏ hàng</a>
							</div>
						</div>
					</div-->
				</div>
			</section>
			<section style="padding-top:0px" class="checkout spad">
				<div class="container">
					<form action="<?= $ariacms->c_url ?>" class="checkout__form" method="post">
						<div class="row">
							<div class="col-lg-8">
								<h5>Thông tin liên hệ</h5>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4">
										<div class="checkout__form__input" id="checkout_input">
											<p><?= _NAME ?> <span>*</span></p>
											<input type="text" required name="txtName">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
										<div class="checkout__form__input " id="checkout_input">
											<p><?= _PHONE ?> <span>*</span></p>
											<input type="text" required name="txtPhone">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
										<div class="checkout__form__input " id="checkout_input">
											<p>Email </p>
											<input type="email" name="txtEmail">
										</div>
									</div>
									<div class="col-lg-12">
										<div class="checkout__form__input" id="checkout_input">
											<p><?= _ADDRESS ?></p>
											<input type="text" name="txtAddress">
										</div>
										<div class="checkout__form__input" id="checkout_input">
											<p><?= _CONTENT ?></p>
											<textarea class="form-control" type="text" placeholder="Ghi chú đặt hàng" name="txtContent"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="checkout__order">
									<h5>Đơn hàng của bạn</h5>
									<div class="checkout__order__total">
										<ul>
											<li>Tổng sản phẩm <span><?= $count_ ?></span></li>
											<li>Tổng thanh toán <span><?= $ariacms->formatPrice($total) ?></span></li>
										</ul>
									</div>
									<input type="hidden" value="<?=$total?>" name="total">
									<button type="submit" class="site-btn" name="btnSubmit" value="sendOder">Gửi đơn hàng</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
			<?= $ariacms->getBlock("footer"); ?>
			<?= $ariacms->getBlock("footer_script"); ?>
		</body>

		</html>
<?php
	}
}
?>