<?php
class View
{
	static function contactManager()
	{
?>
		<section class="content-header">
			<h1>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-files-o"></i> Quản lý liên hệ</a>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning pull-right" href="index.php?module=<?php echo $_REQUEST['module'] ?>&task=contact_newsletter"><i class="fa fa-files-o"></i> Quản lý đăng ký nhận bản tin</a>
			</h1>
		</section>
<?php
	}
	static function contact_view($contacts, $totalRows, $maxRows, $curPg)
	{
		include("admin.html.contact_view.php");
	}
	static function contact_newsletter($contacts, $totalRows, $maxRows, $curPg)
	{
		include("admin.html.contact_newsletter.php");
	}
}
?>