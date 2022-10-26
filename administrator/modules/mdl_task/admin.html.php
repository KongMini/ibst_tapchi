<?php
class View
{
	static function tasksManagerFront()
	{
?>
		<section class="content-header">
			<h1><a class="col-lg-3 col-md-4 col-sm-5 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>">Quản lý Task - Modules<a>
						<a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="index.php?module=<?php echo $_REQUEST['module'] ?>">
							Danh sách
						</a>
						<a class="col-lg-2 col-md-2 col-sm-3 col-xs-12 btn btn-success pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/module/ajax.module_add.php');">
							Thêm mới Module
						</a>
			</h1>
		</section>
<?php
	}

	static function task_view($modules)
	{
		include("admin.html.task_view.php");
	}
}
?>