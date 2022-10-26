<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách hình ảnh</h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th class="col-md-2">Hình ảnh</th>
								<th class="col-md-3">Tiêu đề VN</th>
								<th class="col-md-3">Tiêu đề EN</th>
								<th>Vị trí</th>
								<th class="col-md-1">Sắp xếp</th>
								<th class="col-md-1">Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach ($web_images as $web_image) {
								$i++;
							?>
								<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
									<td><?php echo $i ?></td>
									<td><?php echo ($web_image->image != "") ? '<img style="max-width:100%;" src="' . $web_image->image . '" />' : 'Không có ảnh'; ?></td>
									<td><?php echo $web_image->title_vi ?></td>
									<td><?php echo $web_image->title_en ?></td>
									<td><?php  if($web_image->position=="advertisement") echo "Quảng cáo bên phải";else echo $web_image->position ?>
									</td>
									<td>
										<input type="number" class="form-control" name="region" id="region" value="<?php echo  $web_image->region ?>" onchange="update_value_by_id('e4_web_image', 'region', '<?php echo $web_image->id ?>', this.value);" />
									</td>
									<td><?php echo  Model::web_image_view_link($web_image) ?></td>
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