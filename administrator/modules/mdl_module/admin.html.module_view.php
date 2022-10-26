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
								<th>Module type</th>
								<th>Module name</th>
								<th>Module folder</th>
								<th>Module title</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($modules as $module) {

							?>
								<tr>
									<form name="module_<?php echo $module->id ?>" id="module_<?php echo $module->id ?>" action="?module=<?php echo $_REQUEST['module'] ?>&task=<?php echo $_REQUEST['module'] ?>_edit&id=<?php echo $module->id ?>" method="POST">
										<td>
											<select name="type" id="type_<?php echo $module->id ?>" class="form-control">
												<option value="">No selected</option>
												<option value="admin" <?php echo ($module->type == 'admin') ? 'selected="selected"' : '' ?>>Admin</option>
												<option value="public" <?php echo ($module->type == 'public') ? 'selected="selected"' : '' ?>>Public</option>
											</select>
										<td><input type="text" value="<?php echo $module->name ?>" class="form-control" id="name_<?php echo $module->id ?>" name="name" /></td>
										<td><input type="text" value="<?php echo $module->folder ?>" class="form-control" id="folder_<?php echo $module->id ?>" name="folder" /></td>
										<td><input type="text" value="<?php echo $module->title ?>" class="form-control" id="title_<?php echo $module->id ?>" name="title" title="<?php echo $module->title ?>" data-toggle="tooltip" /></td>
										<td><?php echo  Model::module_view_link($module) ?></td>
										<input type="submit" name="submit" value="module_edit" class="hide" />
									</form>
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