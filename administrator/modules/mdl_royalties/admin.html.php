<?php
class View
{
	static function showNewsManager()
	{
?>
		<section class="content-header">
			<h1>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-files-o"></i> Nhuận bút</a>
			</h1>
			<a href="javascript:;" class="btn btn-success pull-right" onclick="XuatExcel()"> Xuất excel </a>
		</section>
<?php
	}
	static function news_view($news, $totalRows, $maxRows, $curPg, $users)
	{
		include("admin.html.news_view.php");
	}
}
?>