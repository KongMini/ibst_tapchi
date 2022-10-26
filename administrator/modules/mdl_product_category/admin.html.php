<?php
class View
{
	static function showProductCategoryManager()
	{
?>
		<section class="content-header">
			<h1>
				<a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-folder"></i> Quản lý danh mục</a>
			</h1>
		</section>
<?php
	}
	static function product_category_view()
	{
		include("admin.html.product_category_view.php");
	}
}
?>