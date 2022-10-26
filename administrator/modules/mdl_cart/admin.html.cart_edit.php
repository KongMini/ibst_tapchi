<?php
global $ariacms;
?>
<section class="content">
	<div class="row">
		<div class="col-md-4">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<h3 class="profile-username text-center">Đơn hàng số <?= $detail['id'] ?></h3>
					<p class="text-muted text-center">Tạo lúc: <?= $ariacms->unixToDate($detail['date_created'], "/") . " " . $ariacms->unixToTime($detail['date_created'], ":") ?></p>

					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							Khách hàng:
							<a class="pull-right"><?php echo $detail['name'] ?></a>
						</li>
						<li class="list-group-item">
							Điện thoại
							<a class="pull-right"><?php echo $detail['phone'] ?></a>
						</li>
						<li class="list-group-item">
							Email
							<a class="pull-right"><?php echo $detail['email'] ?></a>
						</li>
						<li class="list-group-item">
							Địa chỉ
							<a class="pull-right"><?php echo $detail['address'] ?></a>
						</li>
						<li class="list-group-item">
							Ghi chú
							<a class="pull-right"><?php echo $detail['content'] ?></a>
						</li>
					</ul>

					<form method="post" action="index.php?module=cart&task=cart_edit&id=<?= $detail['id'] ?>">
						<div class="form-group">
							<label for="comment">Ghi chú quản lý:</label>
							<textarea class="form-control" rows="3" name="comment" id="comment" placeholder="Tóm tắt giới thiệu bản tin..."><?= $detail['comment'] ?></textarea>
						</div>
						<div class="form-group">
							<label for="status">Trạng thái xử lý:</label>
							<select id="status" name="status" class="form-control">
								<option <?= ($detail['status'] == 'new') ? 'selected' : ''; ?> value="new">Mới tạo</option>
								<option <?= ($detail['status'] == 'processed') ? 'selected' : ''; ?> value="processed">Đã xử lý</option>
								<option <?= ($detail['status'] == 'cancel') ? 'selected' : ''; ?> value="cancel">Hủy đơn</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary " name="submitCart" value="cart_edit">Cập nhật</button>
						</div>
					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->

		<div class="col-md-8">
			<div class="box">
				<div class="box-header">
					<h4 class="pull-left">Danh sách sản phẩm</h4>
					<h4 class="pull-right text-danger">Tổng tiền: <?= $ariacms->formatPrice($detail['total']) ?></h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th class="col-md-4">Sản phẩm</th>
								<th class="col-md-2">Giá</th>
								<th class="col-md-2">Số lượng</th>
								<th class="col-md-2">Tổng cộng</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$sum = 0;
							$total = 0;
							foreach ($products as $product) {
								$i++;
								$total  += $sum;
							?>
								<form method="post" action="index.php?module=cart&task=cart_edit&id_detail=<?= $product->id ?>">
									<input type="hidden" name="submitCart" value="cart_edit_detail">
									<tr class="<?= ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
										<td><?= $i ?></td>
										<td>
											<a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $product->url_part ?>.html" target="_blank">
												<img src="<?= $product->image ?>" style="height:100px" />
												<?= $product->title_vi ?>
											</a>
										</td>
										<td>
											<input class="form-control" name="price" type="number" value="<?= $product->price ?>" onchange="this.form.submit();" />
										</td>
										<td>
											<input class="form-control" type="number" name="quantity" value="<?= $product->quantity ?>" onchange="this.form.submit();" />
										</td>
										<td><?= $ariacms->formatPrice($product->quantity * $product->price)  ?></td>
										<td>
											<a href="?module=cart&task=cart_delete&id_detail=<?= $product->id ?>" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip" title="Xóa" data-original-title="Xóa"></i></a>
											<input class="hidden" name="submitDetail" type="submit">
										</td>
									</tr>
								</form>
							<?php
							}
							?>

						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>