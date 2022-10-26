<?php
global $ariacms;
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách đơn hàng</h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th>Gửi lúc</th>
								<th>Tên KH</th>
								<th>Điện thoại / Email</th>
								<th>Địa chỉ</th>
								<th>Nội dung</th>
								<th>Tổng tiền</th>
								<th>Trạng thái</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach ($carts as $cart) {
								$i++;
							?>
								<tr class="<?= ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
									<td><?= $i ?></td>
									<td><?= $ariacms->unixToDate($cart->date_created, '/') ?> <?= $ariacms->unixToTime($cart->date_created, ':') ?></td>
									<td><?= $cart->name ?></td>
									<td><?= $cart->phone ?><br /><?= $cart->email ?></td>
									<td><?= $cart->address ?></td>
									<td><?= $cart->content ?></td>
									<td><?= $ariacms->formatPrice($cart->total) ?></td>
									<td><?= ($cart->status == 'new') ? 'Mới tạo' : (($cart->status == 'processed') ? 'Đã xử lý' : (($cart->status == 'cancel') ? 'Đã hủy đơn' : 'Không xác định')) ?></td>
									<td><?= Model::cart_view_link($cart) ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-sm-5">
							<div aria-live="polite" role="status" id="example1_info" class="dataTables_info">Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?> đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?> trong số <?php echo $totalRows ?> bản ghi</div>
						</div>
						<div class="col-sm-7">
							<div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
								<ul class="pagination">
									<?= $ariacms->paginationAdmin($totalRows, $maxRows, 5) ?>
								</ul>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>