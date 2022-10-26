<?php
session_start();
if (file_exists("../../../configuration.php")) {
	require_once("../../../configuration.php");
} else {
	echo "Missing Configuration File";
	exit();
}
//Include Database Controller
if (file_exists("../../../include/database.php")) {
	require_once("../../../include/database.php");
} else {
	echo "Missing Database File";
	exit();
}
//Include System File
if (file_exists("../../../include/ariacms.php")) {
	require_once("../../../include/ariacms.php");
} else {
	echo "Missing System File";
	exit();
}
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$id = $_REQUEST['id'];
$query = "SELECT a.*, count(b.id) submenu 
			FROM e4_leftmenu a 
				LEFT JOIN (SELECT id, parent_id FROM e4_leftmenu WHERE level = 2) b ON a.id = b.parent_id
			WHERE a.level = 1 
			GROUP BY a.id
			ORDER BY a.region ";
$database->setQuery($query);
$menu_admins = $database->loadObjectList();

foreach ($menu_admins as $menu_admin) {
	$query = "SELECT a.*, count(b.id) submenu 
			FROM e4_leftmenu a 
				LEFT JOIN (SELECT id, parent_id FROM e4_leftmenu WHERE level = 3) b ON a.id = b.parent_id
			WHERE a.level = 2 AND a.parent_id = " . $menu_admin->id . "
			GROUP BY a.id
			ORDER BY a.region ";
	$database->setQuery($query);
	$menu_admin->menu_sub = $database->loadObjectList();
}
?>

<div class="modal-dialog">
	<form method="POST" action="?module=menu_admin&task=menu_admin_add" name="menu_admin_add" id="menu_admin_add">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
			</div>
			<div class="modal-body">
				<p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
				<div class="form-group ">
					<label for="title_vn">Tên Tiếng Việt <span class="text-red">*</span></label>
					<input class="form-control" name="title_vi" id="title_vi" type="text" required />
				</div>
				<div class="form-group ">
					<label for="title_en">Tên Tiếng Anh</label>
					<input class="form-control" name="title_en" id="title_en" type="text" />
				</div>
				<div class="form-group ">
					<label for="parent_id">Thuộc menu</label>
					<select name="parent_id" id="parent_id" class="form-control">
						<option value="0">Chọn menu cha</option>
						<?php
						foreach ($menu_admins as $menu_admin) {
						?>
							<option value="<?php echo $menu_admin->id ?>"><?php echo $menu_admin->title_vi ?></option>
							<?php
							foreach ($menu_admin->menu_sub as $menu_sub) {
							?>
								<option value="<?php echo $menu_sub->id ?>">- - <?php echo $menu_sub->title_vi ?></option>
							<?php
							}
							?>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group ">
					<label for="link">Đường dẫn</label>
					<input class="form-control" name="link" id="link" type="text" />
				</div>
				<div class="form-group ">
					<label for="icon">Icon Fontawesome</label>
					<input class="form-control" name="icon" id="icon" type="text" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary pull-left" name="submit" value="menu_admin_add">Cập nhật</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>

			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->