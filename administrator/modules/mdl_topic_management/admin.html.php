<?php
class View
{
	static function showNewsManager()
	{
?>
		<section class="content-header">
			<h1>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-files-o"></i> Quản lý tin chính - tin nổi bật</a>
			</h1>
			<button class="btn btn-warning pull-right" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/news/ajax.news_list.php');">Thêm mới <i class="fa fa-plus"></i></button>
		</section>
<?php
	}
	static function news_view($news, $totalRows, $maxRows, $curPg, $users, $taxonomies)
	{
		include("admin.html.news_view.php");
	}
}
?>