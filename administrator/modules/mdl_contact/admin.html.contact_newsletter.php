<?php
global $ariacms;
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách liên hệ</h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th >Gửi lúc</th>
								<th >Điện thoại / Email</th>
								<th >Trạng thái</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach ($contacts as $contact) {
								$i++;
							?>
								<tr class="<?= ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
									<td><?= $i ?></td>
									<td><?= $ariacms->unixToDate($contact->date_created,'/') ?> <?= $ariacms->unixToTime($contact->date_created,':') ?></td>
									<td><?= $contact->email ?></td>
									<td>
										<select class="form-control" name="status" id="status" onchange="update_value_by_id('e4_contacts', 'status', '<?= $contact->id ?>', this.value);">
											<option value="new" <?= ($contact->status == 'new') ? 'selected="selected"' : '' ?>>Mới tạo</option>
											<option value="seen" <?= ($contact->status == 'seen') ? 'selected="selected"' : '' ?>>Đã xem</option>
										</select>
									</td>
									<td><?= Model::contact_view_link($contact) ?></td>
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