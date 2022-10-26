	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h4 class="box-title">Danh sách menu admin</h4>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Tên tiếng Việt</th>
									<th>Tên tiếng Anh</th>
									<th>Thao tác</th>
									<th class="col-md-1">Vị trí</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($menu_admins as $menu_admin) {

								?>
									<tr class="bg-gray-light">
										<td><?php echo $menu_admin->title_vi ?></td>
										<td><?php echo $menu_admin->title_en ?></td>
										<td><?php echo  Model::menu_admin_view_link($menu_admin) ?></td>
										<td>
											<input type="number" class="form-control" name="region_<?php echo  $menu_admin->id ?>" id="region_<?php echo  $menu_admin->id ?>" value="<?php echo  $menu_admin->region ?>" onchange="update_value_by_id('e4_leftmenu', 'region', '<?php echo $menu_admin->id ?>', this.value);" />
										</td>
									</tr>
									<?php
									if ($menu_admin->submenu > 0) {
										foreach ($menu_admin->menu_sub as $menu_sub) {
									?>
											<tr>
												<td>- - - - <?php echo $menu_sub->title_vi ?></td>
												<td>- - - - <?php echo $menu_sub->title_en ?></td>
												<td><?php echo  Model::menu_admin_view_link($menu_sub) ?></td>
												<td>
													<input type="number" class="form-control" name="region_<?php echo  $menu_sub->id ?>" id="region_<?php echo  $menu_sub->id ?>" value="<?php echo  $menu_sub->region ?>" onchange="update_value_by_id('e4_leftmenu', 'region', '<?php echo $menu_sub->id ?>', this.value);" />
												</td>
											</tr>
									<?php
										}
									}
									?>
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