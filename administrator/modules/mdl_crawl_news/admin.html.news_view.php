<?php
global $ariacms;
global $database;
$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
		GROUP BY a.id ORDER BY a.order ";
		$database->setQuery($query);
		$taxonomies = $database->loadObjectList();
$array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');
$array_location = array(2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong', 0=>'Tin thường');	
$array_posttype = array("VTC"=>"VTC","CAFEF"=>"CAFEF","TOQUOC"=>"TOQUOC","VIETNAMNET"=>"VIETNAMNET","GIADINH"=>"GIADINH","DAIDOANKET"=>"DAIDOANKET","CONGLUAN"=>"CONGLUAN");
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div><!-- /.box-header -->
				<ul class="nav nav-tabs">
					<li class="<?php if($_REQUEST['tab'] == 'home'){ echo 'active';} ?>"><a href="index.php?module=crawl_news&tab=home">Tin crawl</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu5'){ echo 'active';} ?>"><a href="index.php?module=crawl_news&tab=menu5">Bỏ tin crawl</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu4'){ echo 'active';} ?>"><a href="index.php?module=crawl_news&tab=menu4">Chờ duyệt</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu1'){ echo 'active';} ?>"><a href="index.php?module=crawl_news&tab=menu1">Đã xuất bản</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu2'){ echo 'active';} ?>"><a href="index.php?module=crawl_news&tab=menu2">Từ chối</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu3'){ echo 'active';} ?>"><a href="index.php?module=crawl_news&tab=menu3">Đã gỡ</a></li>
				</ul>
				
				<div class="tab-content">
				<div id="home" class="tab-pane fade <?php if($_REQUEST['tab'] == 'home'){ echo 'in active';} ?>">
					<div class="box-body table-responsive">
						<form method="get" action="index.php" name="form_news_search" id="form_news_search">
							<div class="">
								<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
								<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
								<input type="hidden" name="task" id="task" value="news_view" />
								<div class="col-md-3">
									<select name="page_size" id="page_size" class="form-control" onchange="this.form.submit();">
										<option value="">Hiển thị</option>
										<option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>10 tin</option>
										<option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>15 tin</option>
										<option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>20 tin</option>
										<option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>30 tin</option>
										<option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>50 tin</option>
										<option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>100 tin</option>
									</select>
								</div>
								<div class="col-md-4">
									<input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" placeholder="Nhập tiêu đề..." />
								</div>
								<div class="col-md-4">
									<select name="post_type" id="post_type" class="form-control no-padding" onchange="this.form.submit();">
										<option value="all" <?php echo ($_REQUEST['post_type'] == 'all') ? 'selected="selected"' : '' ?>  >Tất cả nguồn</option>
										<?php foreach($array_posttype as $key => $post_type){ ?>
										<option value="<?=$key?>" <?php echo ($_REQUEST['post_type'] == $key) ? 'selected="selected"' : '' ?> ><?php echo $post_type ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
									<button class="btn btn-primary" name="search" type="submit" value="Tìm kiếm" >Lọc <i class="fa fa-filter"></i></button>
								</div>
							</div>
						</form>
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<form method="POST" action="index.php?module=crawl_news&tab=home&task=news_delete" name="news_hot" id="news_hot" class="form-horizontal">
								
								<thead>
									<tr>
										<th width="5%">STT</th>
										<th width="45%">Tiêu đề</th>
										<th width="10%">Nguồn tin</th>
										<th width="10%">Người duyệt</th>
										<th width="10%">Ngày XB</th>								
										<th width="10%">Ngày lấy</th>								
										<th width="10%" class="text-center"><input type="checkbox" class="check_all " name="check_all" id="check_all" value="0" /> Chọn tất cả</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									foreach ($news as $new) {
										$i++;
									?>
										<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
											<td>
												<?php echo $i ?>
											</td>
											<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/crawl_news/ajax.crawl_news_review.php\')">'.$new->title_vi.'</a>' ?></td>
											<td><?php echo $new->post_type ?></td>
											<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
											<td><?php echo $ariacms->unixToDate($new->post_created, "/") . " " . $ariacms->unixToTime($new->post_created, ":") ?></td>
											<td><?php echo $ariacms->unixToDate($new->aproved_date, "/") . " " . $ariacms->unixToTime($new->aproved_date, ":") ?></td>
											
											<td class="text-center"><?= Model::news_view_link($new) ?></td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td colspan="7" >
											<button class="btn btn-warning pull-right" > Xóa Bản Ghi</button>
											<a href="index.php?module=crawl_news&tab=home&task=delete_all" onclick="return confirm('Bạn có chắc chắn xóa toàn bộ dữ liệu không?')" class="btn btn-danger">Xóa tất cả</a>
										</td>
									</tr>
								</tbody>
								</form>
							</table>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<div aria-live="polite" role="status" id="example1_info" class="dataTables_info">Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?> đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?> trong số <?php echo $totalRows ?> bản ghi</div>
							</div>
							<div class="col-sm-7">
								<div id="example1_paginate" class="dataTables_paginate paging_simple_numbers">
									<ul class="pagination">
										<?= $ariacms->paginationAdmin($totalRows, $maxRows, 10) ?>
									</ul>
								</div>
							</div>
						</div>

					</div><!-- /.box-body -->
				</div>
				<div id="menu5" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu5'){ echo 'in active';} ?>">
					<div class="box-body table-responsive">
						
						<form method="get" action="index.php" name="form_news_search" id="form_news_search">
							<div class="">
								<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
								<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
								<input type="hidden" name="task" id="task" value="news_view" />
								<div class="col-md-3">
									<select name="page_size" id="page_size" class="form-control" onchange="this.form.submit();">
										<option value="">Hiển thị</option>
										<option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>10 tin</option>
										<option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>15 tin</option>
										<option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>20 tin</option>
										<option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>30 tin</option>
										<option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>50 tin</option>
										<option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>100 tin</option>
									</select>
								</div>
								<div class="col-md-4">
									<input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" placeholder="Nhập tiêu đề..." />
								</div>
								<div class="col-md-4">
									<select name="post_type" id="post_type" class="form-control no-padding" onchange="this.form.submit();">
										<option value="all" <?php echo ($_REQUEST['post_type'] == 'all') ? 'selected="selected"' : '' ?>  >Tất cả nguồn</option>
										<?php foreach($array_posttype as $key => $post_type){ ?>
										<option value="<?=$key?>" <?php echo ($_REQUEST['post_type'] == $key) ? 'selected="selected"' : '' ?> ><?php echo $post_type ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1">
									<button class="btn btn-primary" name="search" type="submit" value="Tìm kiếm" >Lọc <i class="fa fa-filter"></i></button>
								</div>
							</div>
						</form>
						
						<div class="box-body  table-responsive">
							<table class="table table-bordered table-hover">
							<form method="POST" action="index.php?module=crawl_news&tab=home&task=news_delete" name="news_hot" id="news_hot" class="form-horizontal">
							
								<thead>
									<tr>
										<th width="5%">STT</th>
										<th width="45%">Tiêu đề</th>
										<th width="10%">Nguồn tin</th>
										<th width="10%">Người duyệt</th>
										<th width="10%">Ngày XB</th>								
										<th width="10%">Ngày lấy</th>								
										<th width="10%"><input type="checkbox" class="check_all " name="check_all" id="check_all" value="0" /> Chọn tất cả</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									foreach ($news as $new) {
										$i++;
									?>
										<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle">
											<td>
												<?php echo $i ?>
											</td>
											<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/crawl_news/ajax.crawl_news_review.php\')">'.$new->title_vi.'</a>' ?></td>
											<td><?php echo $new->post_type ?></td>
											<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
											<td><?php echo $ariacms->unixToDate($new->post_created, "/") . " " . $ariacms->unixToTime($new->post_created, ":") ?></td>
											<td><?php echo $ariacms->unixToDate($new->aproved_date, "/") . " " . $ariacms->unixToTime($new->aproved_date, ":") ?></td>
											
											<td class="text-center"> <?= Model::news_view_link($new) ?></td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td colspan="7" >
											<button class="btn btn-warning pull-right" > Xóa Bản Ghi</button>
										</td>
									</tr>
								</tbody>
								</form>
							</table>
						</div>
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
				<div id="menu4" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu4'){ echo 'in active';} ?>">
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
									<th width="">Loạt tin </th>
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
											<select name="post_type" id="post_type" class="form-control no-padding" onchange="this.form.submit();">
												<option value="" <?php echo ($_REQUEST['post_type'] == 'all') ? 'selected="selected"' : '' ?>  >Tất cả</option>
												<?php foreach($array_posttype as $key => $post_type){ ?>
												<option value="<?=$key?>" <?php echo ($_REQUEST['post_type'] == $key) ? 'selected="selected"' : '' ?> ><?php echo $post_type ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<input class="form-control no-padding" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										<td>
											<select name="vitri" id="vitri" class="form-control no-padding" onchange="this.form.submit();">
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
										<td><?php echo $new->post_type ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<select name="vitri2" id="vitri2" class="form-control no-padding" onchange="update_value_by_id('e4_posts', 'news_position', '<?php echo $new->id ?>', this.value);">							
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($new->news_position == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><?= Model::news_view_link2($new) ?></td>
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
									<th width="">Loạt tin </th>
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
															<option value="<?php echo $taxonomy->id ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->id) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<select name="post_type" id="post_type" class="form-control no-padding" onchange="this.form.submit();">
												<option value="" <?php echo ($_REQUEST['post_type'] == 'all') ? 'selected="selected"' : '' ?>  >Tất cả</option>
												<?php foreach($array_posttype as $key => $post_type){ ?>
												<option value="<?=$key?>" <?php echo ($_REQUEST['post_type'] == $key) ? 'selected="selected"' : '' ?> ><?php echo $post_type ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<input class="form-control no-padding" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										<td>
											<select name="vitri" id="vitri" class="form-control no-padding" onchange="this.form.submit();">
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
								<?php if($new->aproved_date > time()){ $title_post = "<i style='color: #ec3e3e'>".$new->title_vi."</i>";$color = "color: #ec3e3e";}else{$title_post = $new->title_vi;$color = "";} ?>
									<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';} ?>>
										<td  class="text-center">
											<?php echo $i ?>
										</td>
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$title_post.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td><?php echo $new->post_type ?></td>
										<td style="<?=$color?>">
											<?php echo ($new->aproved_date) ? date("d/m/Y H:i",$new->aproved_date) : ''; ?>
										</td>
										<td>
											<select name="vitri2" id="vitri2" class="form-control no-padding" onchange="update_value_by_id('e4_posts', 'news_position', '<?php echo $new->id ?>', this.value);">							
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($new->news_position == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><?= Model::news_view_link2($new) ?></td>
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
									<th width="">Loạt tin </th>
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
															<option value="<?php echo $taxonomy->id ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->id) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<select name="post_type" id="post_type" class="form-control no-padding" onchange="this.form.submit();">
												<option value="" <?php echo ($_REQUEST['post_type'] == 'all') ? 'selected="selected"' : '' ?>  >Tất cả</option>
												<?php foreach($array_posttype as $key => $post_type){ ?>
												<option value="<?=$key?>" <?php echo ($_REQUEST['post_type'] == $key) ? 'selected="selected"' : '' ?> ><?php echo $post_type ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<input class="form-control no-padding" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										<td>
											<select name="vitri" id="vitri" class="form-control no-padding" onchange="this.form.submit();">
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
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_get.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td><?php echo $new->post_type ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<select name="vitri2" id="vitri2" class="form-control no-padding" onchange="update_value_by_id('e4_posts', 'news_position', '<?php echo $new->id ?>', this.value);">							
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($new->news_position == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><?= Model::news_view_link2($new) ?></td>
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
				<div id="menu3" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu3'){ echo 'in active';} ?>">
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
									<th width="">Loạt tin </th>
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
															<option value="<?php echo $taxonomy->id ?>"  <?php echo ($_REQUEST['category'] == $taxonomy->id) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>';										
														
														<?php }
													}
												?>
											</select>
										</td>
										<td>
											<select name="post_type" id="post_type" class="form-control no-padding" onchange="this.form.submit();">
												<option value="" <?php echo ($_REQUEST['post_type'] == 'all') ? 'selected="selected"' : '' ?>  >Tất cả</option>
												<?php foreach($array_posttype as $key => $post_type){ ?>
												<option value="<?=$key?>" <?php echo ($_REQUEST['post_type'] == $key) ? 'selected="selected"' : '' ?> ><?php echo $post_type ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<input class="form-control no-padding" name="date_post" id="date_post" type="date" value="<?php echo $_REQUEST['date_post'] ?>" onchange="this.form.submit();" />
										</td>
										<td>
											<select name="vitri" id="vitri" class="form-control no-padding" onchange="this.form.submit();">
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
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_get.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
										<td><?php echo $new->category ?></td>
										<td><?php echo $new->post_type ?></td>
										<td>
											<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
										</td>
										<td>
											<select name="vitri2" id="vitri2" class="form-control no-padding" onchange="update_value_by_id('e4_posts', 'news_position', '<?php echo $new->id ?>', this.value);">							
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($new->news_position == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td><?= Model::news_view_link2($new) ?></td>
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
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>

<SCRIPT language=javascript type=text/javascript>
  
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
		
		
	$(document).ready(function(){
		$('.check_all').on('change', function() {
		   if($(".check_all:checked").val() == 0){
			   $('.vitri').prop('checked',true);
		   }else{
			   $('.vitri').prop('checked',false);
			}
		});
		
		$('.vitri').on('change', function() {
		   $('.check_all').prop('checked',false);
		});
	});	
	
	function timkiemthongtin(){
		var keyword = $('#keyword2').val();
		var category = $('#category2').val();
		
		var f="category="+category+"&keyword="+keyword;
		var _url="ajax/newsForTopic/ajax.news_search.php"; 
		$.ajax({
			url: _url,
			data:f,
			cache: false,
			context: document.body,
			success: function(response) {
				//alert(response);
				$('#thongtintimkiem').html(response);
				//window.location.href = "";
			}
		});
	}	
</script>							
