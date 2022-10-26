<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách nhóm quyền</h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Tên nhóm quyền</th>
								<th>Mô tả</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($rows as $menu_admin) {
							?>
								<tr>
									<td><?php echo $menu_admin->role_code ?></td>
									<td><?php echo $menu_admin->role_desc ?></td>
									<td><?php echo  Model::roles_view_link($menu_admin) ?></td>
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