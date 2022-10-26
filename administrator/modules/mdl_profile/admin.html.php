<?php
class VIew
{
	static function profileManagerFront()
	{
?>
		<section class="content-header">
			<h1>Quản lý Tài khoản cá nhân</h1>
			<ol class="breadcrumb">
				<li><a href="index.php"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
				<li class="active">User profile</li>
			</ol>
		</section>
<?php
	}
	static function profile_view($profile)
	{
		include("admin.html.profile_view.php");
	}
}
?>