<?php
global $ariacms;
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách bản ghi</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<form action="?module=<?php echo $_REQUEST['module'] ?>&task=user_view" method="GET">
						<input type="hidden" value="<?php echo $_REQUEST['module'] ?>" name="module" />
						<div class="row box-body">
							<div class="col-md-4 ">
								<input class="form-control" name="keyword" id="keyword" value="<?php echo $_REQUEST['keyword'] ?>" placeholder="Thông tin người dùng..." type="text">
							</div>
							<div class="col-md-2 ">
								<input class="form-control datepicker" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date'] ?>" placeholder="Tạo từ ngày..." type="text">
							</div>
							<div class="col-md-2 ">
								<input class="form-control datepicker" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date'] ?>" placeholder="Đến ngày..." type="text">
							</div>
							<div class="col-md-2 ">
								<select name="status" class="form-control">
									<option value="">Trạng thái</option>
									<option value="2" <?php echo ($_REQUEST['status'] == 2) ? "selected" : "" ?>>Không hiển thị</option>
									<option value="1" <?php echo ($_REQUEST['status'] == 1) ? "selected" : "" ?>>Hiển thị</option>
								</select>
							</div>
							<div class="col-md-2 ">
								<input type="submit" class="form-control btn btn-primary " value="Lọc danh sách" />
							</div>
						</div>
					</form>
					<table id="" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th>Loại</th>
								<th>FullName</th>
								<th>Email</th>
								<th>Ngày tạo</th>
								<th>Nhóm Quyền</th>
								<th>Vai trò</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($totalRows > 0) {
								$cl = 1;
								while ($curRow < count($users) && ($curRow < $curPg * $maxRows)) {
									$i++;
									$user = $users[$curRow];
									$curRow++;
							?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo  $user->user_type ?></td>
										<td><?php echo  $user->fullname ?></td>
										<td><?php echo  $user->email ?></td>
										<td><?php echo  $ariacms->unixToDate($user->date_created, "/") . " " . $ariacms->unixToTime($user->date_created, ":") ?></td>
										<td><?php echo  $user->role_code ?></td>
										<td><?php echo  $user->menu_privilege ?></td>
										<td>
											<?php if ($user->publish == "1") {
											?>
												<a data-toggle="tooltip" title="Nhấn để hủy kích hoạt" href="index.php?module=user&task=user_unpublish&id=<?php echo $user->id ?>">
													<i class="fa fa-eye"></i>
												</a>&nbsp;
											<?php
											} else {
											?>
												<a data-toggle="tooltip" title="Nhấn để kích hoạt" href="index.php?module=user&task=user_publish&id=<?php echo $user->id ?>">
													<i class="fa fa-eye-slash text-black"></i>
												</a>&nbsp;
											<?php
											}
											?>
											<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('<?php echo $user->id ?>','ajax/user/ajax.user_get.php')">
												<i class="fa fa-edit" data-toggle="tooltip" title="Cập nhật thông tin"></i>
											</a>&nbsp;
											<!--<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('<?php echo $user->id ?>','ajax/user/ajax.user_get.php')"><i class="fa fa-user-plus" aria-hidden="true"></i></a>	
											&nbsp;-->
											<a data-toggle="tooltip" title="Xóa" href="index.php?module=user&task=user_delete&id=<?php echo  $user->id ?>" onclick="return confirmAction();">
												<i class="fa fa-trash text-red"></i>
											</a>&nbsp;
										</td>
									</tr>
							<?php
								}
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
									<?php echo $ariacms->paginationAdmin($totalRows, $maxRows, 5) ?>
								</ul>
							</div>
						</div>
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>