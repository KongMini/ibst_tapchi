<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách mã nhúng</h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th class="col-md-2">Tiêu đề VN</th>
								<th class="col-md-6">Mã nhúng</th>
								<th>Vị trí</th>
								<th class="col-md-1">Sắp xếp</th>
								<th class="col-md-1">Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach ($analytics_codes as $analytics_code) {
								$i++;
							?>
								<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
									<td><?php echo $i ?></td>
									<td><?php echo $analytics_code->title_vn ?></td>
									<td><textarea class="form-control" rows="10" name="code" id="code" placeholder="Nội dung thẻ nhúng..." disabled="disabled"><?php echo $analytics_code->code ?></textarea></td>
									<td>
										<select class="form-control" name="position" id="position" onchange="update_value_by_id('e4_analytics_code', 'position', '<?php echo $analytics_code->id ?>', this.value);">
											<option value="header" <?php echo ($analytics_code->position == 'header') ? 'selected="selected"' : '' ?>>Đầu trang</option>
											<option value="footer" <?php echo ($analytics_code->position == 'footer') ? 'selected="selected"' : '' ?>>Cuối trang</option>
										</select>
									</td>
									<td>
										<input type="number" class="form-control" name="region" id="region" value="<?php echo  $analytics_code->region ?>" onchange="update_value_by_id('e4_analytics_code', 'region', '<?php echo $analytics_code->id ?>', this.value);" />
									</td>
									<td><?php echo  Model::analytics_code_view_link($analytics_code) ?></td>
								</tr>
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