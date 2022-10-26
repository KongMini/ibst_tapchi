<?php
global $database;
global $ariacms;
$role = $_SESSION["user"]['permission'];
// Lấy danh sách các module mà quyền được truy cập
$query = "Select menu_id from e4_roles where id=" . $role;
$database->setQuery($query);
$query_role = $database->loadRow();

$query = "SELECT a.*,count(b.id) submenu 
		FROM e4_leftmenu a 
			LEFT JOIN (SELECT id, parent_id FROM e4_leftmenu WHERE level = 2 and status ='active') b ON a.id = b.parent_id
		where a.level = 1 and a.status = 'active' and a.id IN (" . $query_role['menu_id'] . ")  
		GROUP BY a.id
		order by region";
$database->setQuery($query);
$menu_admins = $database->loadObjectList();
?>
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<?php
			foreach ($menu_admins as $key => $menu_admin) {
				$query = "SELECT * from e4_leftmenu where level = 2 and status = 'active' and parent_id = " . $menu_admin->id . " and id IN (" . $query_role['menu_id'] . ")  
		order by region";
				$database->setQuery($query);
				$sub_menus = $database->loadObjectList();
				$check = 0;
				foreach ($sub_menus as $sub_menu) {
					$check += strpos(strtolower($ariacms->c_url), $sub_menu->link);
				}
			?>
				<li class="treeview <?php echo ($check > 0) ? ' active ' : '' ?>">
					<a href="<?php echo ($menu_admin->link != "") ? 'index.php' . $menu_admin->link : 'javascript:void(0);' ?>">
						<?php echo ($menu_admin->icon != "") ? '<i class="' . $menu_admin->icon . '"></i>' : '<i class="fa fa-folder"></i>' ?>
						<span><?php echo $menu_admin->title_vi ?></span>
						<?php echo ($menu_admin->submenu > 0) ? '<i class="fa fa-angle-left pull-right"></i>' : '' ?>
					</a>
					<?php
					if ($menu_admin->submenu > 0) {
					?>
						<ul class="treeview-menu">
							<?php
							foreach ($sub_menus as $sub_menu) {
								strpos(strtolower($ariacms->c_url), $sub_menu->link) > 0 ? $style = ' active ' : $style = '';
							?>
								<li class="<?php echo $style ?>"><a href="index.php<?php echo $sub_menu->link ?>"><i class="fa fa-angle-right"></i><?php echo $sub_menu->title_vi ?></a></li>
							<?php
							}
							?>
						</ul>
					<?php
					}
					?>
				</li>
				
				
			<?php } ?>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>