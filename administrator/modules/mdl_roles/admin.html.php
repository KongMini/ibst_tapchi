<?php
class View
{
	static function showIntroductionManager()
	{
?>
		<section class="content-header">
			<h1><a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>">Quản lý nhóm quyền</a>
				<a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="index.php?module=<?php echo $_REQUEST['module'] ?>">
					Danh sách
				</a>
				<a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/roles/ajax.roles_add.php');">
					Thêm mới
				</a>
			</h1>
		</section>
<?php
	}
	static function roles_view($rows)
	{
		include("admin.html.roles_view.php");
	}
	static function roles_menu_access($row, $items_one, $items_two)
	{
		include("admin.html.roles_menu_access.php");
	}
	static function roles_module_action($row, $modules)
	{
		include("admin.html.roles_module_action.php");
	}
}
?>