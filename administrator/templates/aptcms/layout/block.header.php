<?php
@session_start();
global $actual_link;
global $database;
$query = "Select * from e4_leftmenu where status = 'active' and toolbar = 'active'  order by region";
$database->setQuery($query);
$toolbars = $database->loadObjectList();
?>
<header class="main-header">
	<!-- Logo -->
	<a href="index.php" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>CMS</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>IBST CMS</b></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="javascipt:void(0);" onclick="set_sidebar_config();" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<?php
		foreach ($toolbars as $toolbar) {
		?>
			<a href="index.php<?php echo $toolbar->link ?>">
				<button class="btn btn-default hidden-xs hidden-sm" style="margin-top:8px;"><?php echo $toolbar->title_vi ?></button>
			</a>
		<?php } ?>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo ($_SESSION["user"]['image_url'] != '') ? $_SESSION["user"]['image_url'] : 'templates/aptcms/dist/img/no-image.png'; ?>" class="user-image" alt="User Image">
						<span class="hidden-xs"><?php echo $_SESSION["user"]['fullname'] ?></span>
					</a>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a onclick="return confirmAction();" href="logout.php" id="logout">Đăng xuất</a>
				</li>
			</ul>
		</div>
	</nav>
</header>