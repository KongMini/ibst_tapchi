<script language="javascript">
	$(document).ready(function() {
		var ListRole = "<?php echo $row['menu_id'] ?>";
		var MenuArr = ListRole.split(",");
		$("input[type='checkbox']").each(function() {
			for (i = 0; i < MenuArr.length; i++) {
				if ($(this).val() == MenuArr[i]) {
					$(this).attr('checked', 'checked');
				}
			}
		});
	})

	function checkForm() {
		var IdRoleList = "";
		$("input[type='checkbox']:checked").each(function() {
			IdRoleList = IdRoleList + $(this).val() + ',';
		});

		IdRoleList = IdRoleList.substr(0, IdRoleList.length - 1);
		$("#menu_id_list").val(IdRoleList);

		return true;
	}
</script>

<form name="addform" method="post" action="index.php?module=<?php echo $_REQUEST["module"] ?>&task=roles_menu_access&id=<?php echo $row['id'] ?>" enctype="multipart/form-data">
	<input type="hidden" value="" name="menu_id_list" id="menu_id_list" />
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Danh sách menu <span class="text-red"><?php echo $row['role_code'] ?></span> được phép truy cập</h3>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="col-md-1 text-center">Chọn</th>
									<th>Tên Tiếng Việt</th>
									<th>Tên Tiếng Anh</th>
									<th>Trạng thái</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($items_one as $item_one) {
								?>
									<tr>
										<td class="col-md-1 text-center"><input type="checkbox" value="<?php echo $item_one->id ?>"></td>
										<td><b><?php echo $item_one->title_vi ?></b></td>
										<td><b><?php echo $item_one->title_en ?></b></td>
										<td>
											<?php
											if ($item_one->status == "active") {
											?>
												<a href="javascript:void(0);">Đang mở</a>
											<?php
											} else {
											?>
												<a href="javascript:void(0);">Đã khóa</a>
											<?php
											}
											?>
										</td>
									</tr>
									<?php
									foreach ($items_two as $item_two) {
										if ($item_two->parent_id == $item_one->id) {
									?>
											<tr>
												<td class="col-md-1 text-center"><input type="checkbox" value="<?php echo $item_two->id ?>"></td>
												<td>- - - - <?php echo $item_two->title_vi ?></td>
												<td>- - - - <?php echo $item_two->title_en ?></td>
												<td>
													<?php
													if ($item_two->status == "active") {
													?>
														<a href="javascript:void(0);">Đang mở</a>
													<?php
													} else {
													?>
														<a href="javascript:void(0);" class="text-black">Đã khóa</a>
													<?php
													}
													?>
												</td>
											</tr>
								<?php
										}
									}
								}
								?>
							</tbody>
						</table>

					</div><!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" name="submit" class="btn btn-primary" value="Cập nhật" onclick="return checkForm();" />
						<input type="reset" class="btn btn-default" value="Làm lại" />
					</div>
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section>
</form>