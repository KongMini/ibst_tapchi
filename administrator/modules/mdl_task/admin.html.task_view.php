<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách bản ghi</h4>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Module title</th>
								<th>Module name</th>
								<th>Function name</th>
								<th>Function code</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($modules as $module) {

							?>
								<tr>
									<td>- - <?php echo $module->title ?></td>
									<td>- - <?php echo $module->name ?></td>
									<td colspan="2"></td>
									<td><?php echo  Model::module_view_link($module) ?></td>

								</tr>
								<?php
								if ($module->task > 0) {
									foreach ($module->list_task as $function) {
								?>
										<tr>
											<td colspan="2"></td>
											<td>- - <?php echo $function->function_name ?></td>
											<td>- - <?php echo $function->function_code ?></td>
											<td><?php echo  Model::task_view_link($function) ?></td>
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