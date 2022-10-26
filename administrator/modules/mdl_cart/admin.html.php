<?php
class View
{
	static function cartManager()
	{
?>
		<section class="content-header">
			<h1>Quản lý đơn hàng</h1>
			<ol class="breadcrumb">
				<li><a class="btn btn-warning" href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-list"></i> Danh sách đơn hàng</a></li>
			</ol>
		</section>
<?php
	}
	static function cart_view($carts, $totalRows, $maxRows, $curPg)
	{
		include("admin.html.cart_view.php");
	}
	static function cart_edit($detail, $products)
	{
		include("admin.html.cart_edit.php");
	}
}
?>