<?php
class View
{
	static function showproductManager()
	{
?>
		<section class="content-header">
			<h1>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-files-o"></i> Quản lý sản phẩm</a>
			</h1>
		</section>
<?php
	}
	static function product_view($product, $totalRows, $maxRows, $curPg, $users)
	{
		include("admin.html.product_view.php");
	}
}
?>