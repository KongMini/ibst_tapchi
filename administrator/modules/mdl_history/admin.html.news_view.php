<?php
global $ariacms;
global $database;
		$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
		GROUP BY a.id ORDER BY a.order ";
		$database->setQuery($query);
		$taxonomies = $database->loadObjectList();
	$array_action = array('add'=>'Thêm','edit'=>'Chỉnh sửa','delete'=>'Xóa');
				
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div><!-- /.box-header -->
			

				
				  <!-- Tab chờ duyệt -->
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th  class="text-center"  width="10%">STT</th>
									<th  width="30%">Tiêu đề</th>
									<th width="20%">Người thao tác</th>
									<th width="20%"> Ngày thao tác</th>
									<th width="20%">Hành động </th>
								</tr>
							</thead>
							<tbody>
								<form method="get" action="index.php" name="form_news_search" id="form_news_search">
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									
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
											<select name="vitri" id="vitri" class="form-control" onchange="this.form.submit();">
												<option value="">- Chọn -</option>										
												<?php foreach ( $array_location as  $key=> $location){ ?>
												<option value="<?php echo $key ?>" <?php echo ($_REQUEST['vitri'] !='' && $_REQUEST['vitri'] == $key) ? 'selected="selected"' : '' ?>><?=$location?></option>			
												<?php } ?>
											</select>
										</td>
										<td>
											<select name="action" id="action" class="form-control" onchange="this.form.submit();">
												<option value="" >- Chọn -</option>
												<option value="add" <?php echo ($_REQUEST['action'] == 'add') ? 'selected="selected"' : '' ?>>Thêm</option>
												<option value="edit" <?php echo ($_REQUEST['action'] == 'edit') ? 'selected="selected"' : '' ?>>Chỉnh sửa</option>
												<option value="delete" <?php echo ($_REQUEST['action'] == 'delete') ? 'selected="selected"' : '' ?>>Xóa</option>
											</select>
										</td>
									</tr>
								</form>

								<?php
								$i = 0;
								foreach ($news as $new) {
								
									$i++;
									// NOTE: SƯA id_post -> id ở (onclick="showCNTT(\'' . $new->id_post ))
								?>
									<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle"  >
										<td  class="text-center">
											<?php echo $i ?>
										</td>
										<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id_post . '\',\'ajax/history/ajax.history_seen.php\')">'.$new->title_vi.'</a>' ?></td>
										<td><?php echo $new->fullname ?></td>
										<td ><?php 
			
										echo ($new->post_modified) ? $ariacms->unixToTime($new->post_modified, ':')." - ".$ariacms->unixToDate($new->post_modified, '/') : ''; ?></td>
									
										<td>
											<?php echo $array_action[$new->action] ?>
										</td>
									
									</tr>
								<?php
								 }
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
