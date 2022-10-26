<?php
global $ariacms;
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th width="">Bài viết</th>
								<th width="">Người comment</th>
								<th width="">Nội dung</th>
								<th width="">Email</th>
								<!--<th class="col-md-2">Thẻ</th>-->
								<th width="">Trạng thái</th>
								<th width="">Người duyệt</th>
								<th width="">Thao tác</th>
							</tr>
						</thead>
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
										
									</td>
									<td>
										
									</td>
									<td>
										<select id="state" name="state" class="form-control " onchange="this.form.submit();" />
										<option value="" <?php echo ($_REQUEST['state'] == 'all') ? 'selected="selected"' : '' ?> >- Chọn -</option>
										<option value="0" <?php echo ($_REQUEST['state'] == '0') ? 'selected="selected"' : '' ?>>Đã duyệt</option>
										<option value="1" <?php echo ($_REQUEST['state'] == '1') ? 'selected="selected"' : '' ?>>Chờ duyệt</option>
										</select>
									</td>
									<td>
										
									</td>
									<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
								</tr>
						</form>

						<tbody>
							<form action="" method="post">
							<?php
							$i = 0;
							foreach ($news as $new) {
								$i++;
							?>
								<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : '' ; ?> valign-middle">
									<td>
										<?php echo $i ?>
									</td>
									<td><?php echo $new->title_vi  ?></td>
									<td><?php echo $new->user_cmt ?></td>
									<td ><?php echo $new->content?></td>
									<td><?php echo $new->mail_user ?></td>
									
									<td>
										<?php if($new->state==1){echo "Chờ duyệt";}
										else {
											echo "Đã duyệt<br/>".date("d/m/Y",strtotime($new->date_review));
										}?>
										
									</td>
									<td><?php echo $new->fullname ?> </td>
									<td>
										<?= Model::news_view_link($new) ?>
									</td>
								</tr>
							<?php
							}
							?>
							</form>
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

<SCRIPT language=javascript type=text/javascript> 
 
	function remove_Comment(id){
		$.ajax({
			 url: 'http://localhost/taichinhso/administrator/ajax/news_comment/ajax.remove_comment.php',
			 type: 'post',
			 data: {id:id},
			 success: function(){
				alert("bạn xóa comment thành công");
			 }
			}); 
	} 	
</script>							

