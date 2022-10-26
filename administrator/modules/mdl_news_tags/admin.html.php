<?php
class View
{
	static function showNewsTagsManager()
	{
?>
		<section class="content-header">
			<h1>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-folder"></i> Quản lý thẻ - tags</a>
			</h1>
		</section>
<?php
	}
	static function news_tags_view()
	{
		include("admin.html.news_tags_view.php");
	}
}
?>