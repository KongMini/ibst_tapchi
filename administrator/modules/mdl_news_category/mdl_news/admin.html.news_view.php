<?php
global $ariacms;
global $database;
		$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
		GROUP BY a.id ORDER BY a.order ";
		$database->setQuery($query);
		$taxonomies = $database->loadObjectList();
	$array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');
	$array_location = array(4=> 'Nổi bật trang chủ',3=> 'Tin chính trang chủ', 2=> 'Nổi bật trang trong', 1=>' Tin chính trang trong', 0=>'Tin thường');
	$array_posttype = array('post'=>'Post');				
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách bài viết</h4>
					<button class="btn btn-warning pull-right" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/news/ajax.news_add.php');">Thêm mới <i class="fa fa-plus"></i></button>
				</div><!-- /.box-header -->
				<ul class="nav nav-tabs">
				  <li class="<?php if($_REQUEST['tab'] == 'home'){ echo 'active';} ?>"><a href="index.php?module=news&tab=home">Chờ duyệt</a></li>
				  <li class="<?php if($_REQUEST['tab'] == 'menu1'){ echo 'active';} ?>"><a href="index.php?module=news&tab=menu1">Đã xuất bản</a></li>
				  <li class="<?php if($_REQUEST['tab'] == 'menu2'){ echo 'active';} ?>"><a href="index.php?module=news&tab=menu2">Từ chối</a></li>
				  <li class="<?php if($_REQUEST['tab'] == 'menu3'){ echo 'active';} ?>"><a href="index.php?module=news&tab=menu3">Đã gỡ</a></li>
				</ul>
				<?php
				//echo '<pre>';
				//print_r($_SESSION);
				//echo '</pre>';
				?>
				<div class="tab-content">
					<div id="home" class="tab-pane fade <?php if($_REQUEST['tab'] == 'home'){ echo 'in active';} ?>">
				  <!-- Tab chờ duyệt -->
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th  class="text-center"  width="3%">STT</th>
									<th  width="25%">Tiêu đề</th>
									<th width="">Người tạo</th>
									<th width="">Người duyệt</th>
									<th width="15%">Danh mục</th>
									<th width="">Ngày XB</th>
									<th width="">Vị trí</th>
									<th width="">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								<form method="get" action="index.php" name="form_news_search" id="form_news_search">
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
									<input type="hidden" name="task" id="task" value="news_view" />
									<tr>
										<td>
											<select name="page_size" id="page_size" class="form-control" onchange="this.form.submit();">
												<option value="">Hiển thị</option>
												<option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>- - 10 - -</option>
												<option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>- - 15 - -</option>
												<option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>- - 20 - -</option>
												<option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>- - 30 - -</option>
												<option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>- - 50 - -</option>
												<option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>- - 100 - -</option>
												<option value="999999999" <?php echo ($_REQUEST['page_size'] == '999999999') ? 'selected="selected"' : '' ?>>- - Tất cả - -</option>
											</select>
										</td>
										<td><input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" /></td>
										<td>
											<select name="user_created" id="user_created" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_created'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="user_review" id="user_review" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_review'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="category" id="category" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
											
													foreach ($taxonomies as $taxonomy) {
														if ($taxonomy->taxonomy == 'category'  && $taxonomy->parent == 0) {
															?>
															<option value="<?php echo $taxonomy->title_vi ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->title_vi) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<input class="form-control" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										
										<td>
											<select name="vitri" id="vitri" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>										
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($_REQUEST['vitri'] !='' && $_REQUEST['vitri'] == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
									</tr>
								</form>

								<?php
								$i = 0;
								foreach ($news as $new) {
									if($new->post_status == 'waiting'){
									$i++;
								?>
									<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';}  if($new->news_position == 3) {echo 'style="background: #e7c9ab;"';} if($new->news_position == 4) {echo 'style="background: #32b12952;"';} ?>>
										<td  class="text-center">
											<?php echo $i ?>
										</td>
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<?php echo  $array_location[$new->news_position]; ?>
										</td>
										<td><?= Model::news_view_link($new) ?></td>
									</tr>
								<?php
								} }
								?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-5">
								<div aria-live="polite" role="status" id="example1_info" class="dataTables_info">Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?> đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?> trong số <?php echo $totalRows ?> bản ghi</div>
							</div>
							<div class="col-sm-7">
								<div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
									<ul class="pagination">
										<?= $ariacms->paginationAdmin($totalRows, $maxRows, 5) ?>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->
				  </div>
				  <div id="menu1" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu1'){ echo 'in active';} ?>">
				  <!-- /.Đã duyệt -->
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th  class="text-center"  width="3%">STT</th>
									<th  width="25%">Tiêu đề</th>
									<th width="">Người tạo</th>
									<th width="">Người duyệt</th>
									<th width="15%">Danh mục</th>
									<th width="">Ngày XB</th>
									<th width="">Vị trí</th>
									<th width="">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								<form method="get" action="index.php" name="form_news_search" id="form_news_search">
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
									<input type="hidden" name="task" id="task" value="news_view" />
									<tr>
										<td>
											<select name="page_size" id="page_size" class="form-control" onchange="this.form.submit();">
												<option value="">Hiển thị</option>
												<option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>- - 10 - -</option>
												<option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>- - 15 - -</option>
												<option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>- - 20 - -</option>
												<option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>- - 30 - -</option>
												<option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>- - 50 - -</option>
												<option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>- - 100 - -</option>
												<option value="999999999" <?php echo ($_REQUEST['page_size'] == '999999999') ? 'selected="selected"' : '' ?>>- - Tất cả - -</option>
											</select>
										</td>
										<td><input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" /></td>
										<td>
											<select name="user_created" id="user_created" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_created'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="user_review" id="user_review" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_review'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="category" id="category" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
											
													foreach ($taxonomies as $taxonomy) {
														if ($taxonomy->taxonomy == 'category'  && $taxonomy->parent == 0) {
															?>
															<option value="<?php echo $taxonomy->title_vi ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->title_vi) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<input class="form-control" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										
										<td>
											<select name="vitri" id="vitri" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>										
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($_REQUEST['vitri'] !='' && $_REQUEST['vitri'] == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
									</tr>
								</form>

								<?php
								$i = 0;
								foreach ($news as $new) {
									if($new->post_status == 'active'){
									$i++;
								?>
									<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';}  if($new->news_position == 3) {echo 'style="background: #e7c9ab;"';} if($new->news_position == 4) {echo 'style="background: #32b12952;"';} ?>>
										<td  class="text-center">
											<?php echo $i ?>
										</td>
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<?php echo  $array_location[$new->news_position];    ?>
										</td>
										<td><?= Model::news_view_link($new) ?></td>
									</tr>
								<?php
								} }
								?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-5">
								<div aria-live="polite" role="status" id="example1_info" class="dataTables_info">Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?> đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?> trong số <?php echo $totalRows ?> bản ghi</div>
							</div>
							<div class="col-sm-7">
								<div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
									<ul class="pagination">
										<?= $ariacms->paginationAdmin($totalRows, $maxRows, 5) ?>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- /.Đã duyệt -->
				  </div>
				  <div id="menu2" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu2'){ echo 'in active';} ?>">
					<!-- /.Từ chôi -->
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th  class="text-center"  width="3%">STT</th>
									<th  width="25%">Tiêu đề</th>
									<th width="">Người tạo</th>
									<th width="">Người duyệt</th>
									<th width="15%">Danh mục</th>
									<th width="">Ngày XB</th>
									<th width="">Vị trí</th>
									<th width="">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								<form method="get" action="index.php" name="form_news_search" id="form_news_search">
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
									<input type="hidden" name="task" id="task" value="news_view" />
									<tr>
										<td>
											<select name="page_size" id="page_size" class="form-control" onchange="this.form.submit();">
												<option value="">Hiển thị</option>
												<option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>- - 10 - -</option>
												<option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>- - 15 - -</option>
												<option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>- - 20 - -</option>
												<option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>- - 30 - -</option>
												<option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>- - 50 - -</option>
												<option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>- - 100 - -</option>
												<option value="999999999" <?php echo ($_REQUEST['page_size'] == '999999999') ? 'selected="selected"' : '' ?>>- - Tất cả - -</option>
											</select>
										</td>
										<td><input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" /></td>
										<td>
											<select name="user_created" id="user_created" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_created'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="user_review" id="user_review" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_review'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="category" id="category" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
											
													foreach ($taxonomies as $taxonomy) {
														if ($taxonomy->taxonomy == 'category'  && $taxonomy->parent == 0) {
															?>
															<option value="<?php echo $taxonomy->title_vi ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->title_vi) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<input class="form-control" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										
										<td>
											<select name="vitri" id="vitri" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>										
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($_REQUEST['vitri'] !='' && $_REQUEST['vitri'] == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
									</tr>
								</form>

								<?php
								$i = 0;
								foreach ($news as $new) {
									if($new->post_status == 'deactive'){
									$i++;
								?>
									<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';}  if($new->news_position == 3) {echo 'style="background: #e7c9ab;"';} if($new->news_position == 4) {echo 'style="background: #32b12952;"';} ?>>
										<td  class="text-center">
											<?php echo $i ?>
										</td>
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<?php echo  $array_location[$new->news_position]; ?>
										</td>
										<td><?= Model::news_view_link($new) ?></td>
									</tr>
								<?php
								} }
								?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-5">
								<div aria-live="polite" role="status" id="example1_info" class="dataTables_info">Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?> đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?> trong số <?php echo $totalRows ?> bản ghi</div>
							</div>
							<div class="col-sm-7">
								<div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
									<ul class="pagination">
										<?= $ariacms->paginationAdmin($totalRows, $maxRows, 5) ?>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- /.Từ chối -->
				  </div>
				  <div id="menu3" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu3'){ echo 'in active';} ?>">
					<!-- /.Đã gỡ bài -->
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th  class="text-center"  width="3%">STT</th>
									<th  width="25%">Tiêu đề</th>
									<th width="">Người tạo</th>
									<th width="">Người duyệt</th>
									<th width="15%">Danh mục</th>
									<th width="">Ngày XB</th>
									<th width="">Vị trí</th>
									<th width="">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								<form method="get" action="index.php" name="form_news_search" id="form_news_search">
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
									<input type="hidden" name="task" id="task" value="news_view" />
									<tr>
										<td>
											<select name="page_size" id="page_size" class="form-control" onchange="this.form.submit();">
												<option value="">Hiển thị</option>
												<option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>- - 10 - -</option>
												<option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>- - 15 - -</option>
												<option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>- - 20 - -</option>
												<option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>- - 30 - -</option>
												<option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>- - 50 - -</option>
												<option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>- - 100 - -</option>
												<option value="999999999" <?php echo ($_REQUEST['page_size'] == '999999999') ? 'selected="selected"' : '' ?>>- - Tất cả - -</option>
											</select>
										</td>
										<td><input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" /></td>
										<td>
											<select name="user_created" id="user_created" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_created'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="user_review" id="user_review" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
												foreach ($users as $user) {
												?>
													<option value="<?php echo $user->id ?>" <?php echo ($_REQUEST['user_review'] == $user->id) ? 'selected="selected"' : ''; ?>><?php echo $user->fullname ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<select name="category" id="category" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>
												<?php
											
													foreach ($taxonomies as $taxonomy) {
														if ($taxonomy->taxonomy == 'category'  && $taxonomy->parent == 0) {
															?>
															<option value="<?php echo $taxonomy->title_vi ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->title_vi) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<input class="form-control" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										
										<td>
											<select name="vitri" id="vitri" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>										
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($_REQUEST['vitri'] !='' && $_REQUEST['vitri'] == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
									</tr>
								</form>

								<?php
								$i = 0;
								foreach ($news as $new) {
									if($new->post_status == 'lock'){
									$i++;
								?>
									<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';}  if($new->news_position == 3) {echo 'style="background: #e7c9ab;"';} if($new->news_position == 4) {echo 'style="background: #32b12952;"';} ?>>
										<td  class="text-center">
											<?php echo $i ?>
										</td>
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<?php echo  $array_location[$new->news_position];    ?>
										</td>
										<td><?= Model::news_view_link($new) ?></td>
									</tr>
								<?php
								} }
								?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-5">
								<div aria-live="polite" role="status" id="example1_info" class="dataTables_info">Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?> đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?> trong số <?php echo $totalRows ?> bản ghi</div>
							</div>
							<div class="col-sm-7">
								<div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
									<ul class="pagination">
										<?= $ariacms->paginationAdmin($totalRows, $maxRows, 5) ?>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- /.Đã gỡ bài -->
					</div>
				</div>
				
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>

<script language=javascript type=text/javascript>
  
  	function aproved(id,status){  //alert("s");
		var f="news_id="+id+"&status="+status;
		var _url="ajax/news/ajax.news_aproved.php"; 
		$.ajax({
			url: _url,
			data:f,
			cache: false,
			context: document.body,
			success: function(data) {
				window.location.href = "";
			}
		});
	}
</script>							
