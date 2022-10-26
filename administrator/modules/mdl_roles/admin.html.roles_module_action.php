<script language="javascript">
	$(document).ready(function() {
		checked_by_list("<?php echo $row['module_name_list'] . ',' . $row['function_code_list'] ?>", "input[type='checkbox']");
	})

	function checkForm() {
		set_list_to_element(".module:checked", "#module_name_list");
		set_list_to_element(".function:checked", "#function_code_list");
		return true;
	}
</script>
<form name="addform" method="post" action="index.php?module=<?php echo $_REQUEST["module"] ?>&task=roles_module_action&id=<?php echo $row['id'] ?>" enctype="multipart/form-data">
	<input type="hidden" value="" name="module_name_list" id="module_name_list" />
	<input type="hidden" value="" name="function_code_list" id="function_code_list" />
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Danh sách chức năng <span class="text-red"><?php echo $row['role_code'] ?></span> được phép thao tác</h3>
						<input type="submit" name="submit" class="btn btn-primary pull-right" value="Cập nhật" onclick="return checkForm();" />
					</div><!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Tên chức năng</th>
									<th>Mã chức năng</th>
									<th class="col-md-1 text-center">Chọn</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($modules as $module) {
								?>
									<tr class="bg-gray-light">
										<td>- - <?php echo $module->title ?></td>
										<td>- - <?php echo $module->name ?></td>
										<td class="col-md-1 text-center"><input type="checkbox" class="module" value="<?php echo $module->name ?>"></td>
									</tr>
									<?php
									if ($module->task > 0) {
										foreach ($module->list_task as $function) {
									?>
											<tr>
												<td>- - - - <?php echo $function->function_name ?></td>
												<td>- - - - <?php echo $function->function_code ?></td>
												<td class="col-md-1 text-center"><input type="checkbox" class="function" value="<?php echo $function->function_code ?>"></td>
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
					<div class="box-footer">
						<input type="submit" name="submit" class="btn btn-primary pull-right" value="Cập nhật" onclick="return checkForm();" />
					</div>
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section>
</form>