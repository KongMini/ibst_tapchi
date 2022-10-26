<?php
global $ariacms;
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div>
				<ul class="nav nav-tabs">
					<li class="<?php if($_REQUEST['tab'] == 'menu1'){ echo 'active';} ?>"><a href="index.php?module=news_comment&tab=menu1">Đã duyệt</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu2'){ echo 'active';} ?>"><a href="index.php?module=news_comment&tab=menu2">Chờ duyệt</a></li>
					<li class="<?php if($_REQUEST['tab'] == 'menu3'){ echo 'active';} ?>"><a href="index.php?module=news_comment&tab=menu3">Đã gỡ</a></li>
				</ul>
				
				
				<div class="tab-content">
					<div id="menu1" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu1'){ echo 'in active';} ?>">
						<div class="box-body table-responsive">
							<form method="get" action="index.php" name="form_news_search" id="form_news_search">
								<div class="form-group">
								
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />
									<input type="hidden" name="task" id="task" value="news_view" />
									<div class="col-md-3">
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
									</div>
									<div class="col-md-4">
										<input class="form-control" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" onchange="this.form.submit();" /></td>
									</div>
									<div class="col-md-4">
										<select name="user_created" id="user_created" class="form-control" onchange="this.form.submit();">
													<option value="">- Chọn -</option>
													<?php
													foreach ($users as $user) {
													?>
														<option value="<?php echo $user->user_cmt ?>" <?php echo ($_REQUEST['user_created'] == $user->user_cmt) ? 'selected="selected"' : ''; ?>><?php echo $user->user_cmt ?></option>
													<?php
													}
													?>
												</select>
									</div>
									<div class="col-md-1">
										<button class="btn btn-primary" name="search" type="submit" value="Tìm kiếm" >Lọc <i class="fa fa-filter"></i></button>
									</div>
								</div>
							</form>
							<table class="table table-bordered table-hover">
							<form method="POST" action="" name="form1" id="form1" class="form-horizontal">		
									<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
									<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />							
								<thead>
									<tr>
										<th width="5%">STT</th>
										<th width="20%">Bài viết</th>
										<th width="15%">Người comment</th>
										<th width="30%">Nội dung</th>
										<th width="">Email</th>
										<th width="">Ngày duyệt</th>
										<th width="">Người duyệt</th>
										<th class="text-center"><input type="checkbox" class="check_all " name="check_all" id="check_all" value="0" /> Chọn tất cả</th>
									</tr>
								</thead>
								<tbody>	
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
												<?php 
													echo date("d/m/Y",$new->date_review);
												?>
												
											</td>
											<td><?php echo $new->fullname ?> </td>
											<td class="text-center" >
												<?= Model::news_view_link($new) ?>
											</td>
										</tr>
									<?php
									}
									?>
									<tr>
									<td colspan="7" >
										<button class="btn btn-danger pull-right" id="delete1" > Xóa Mục Chọn</button>
									</td>
									<td colspan="8" >
										<button class="btn btn-warning pull-right" id="remove1" >Gỡ Mục Chọn</button>
									</td>
								</tr>
								</tbody>
								</form>
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
				
					<!-- tab2 -->
				
					<div id="menu2" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu2'){ echo 'in active';} ?>">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th width="5%">STT</th>
										<th width="20%">Bài viết</th>
										<th width="10%">Người comment</th>
										<th width="30%">Nội dung</th>
										<th width="15%">Email</th>
										<th width="10%">Ngày comment</th>
										
										<th width="10%" class="text-center"><input type="checkbox" class="check_all " name="check_all" id="check_all" value="0" /> Chọn tất cả</th>
									</tr>
								</thead>
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
														<option value="<?php echo $user->user_cmt ?>" <?php echo ($_REQUEST['user_created'] == $user->user_cmt) ? 'selected="selected"' : ''; ?>><?php echo $user->user_cmt ?></option>
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
												<!--select id="state" name="state" class="form-control " onchange="this.form.submit();" />
												<option value="" <?php echo ($_REQUEST['state'] == 'all') ? 'selected="selected"' : '' ?> >- Chọn -</option>
												<option value="0" <?php echo ($_REQUEST['state'] == '0') ? 'selected="selected"' : '' ?>>Đã duyệt</option>
												<option value="1" <?php echo ($_REQUEST['state'] == '1') ? 'selected="selected"' : '' ?>>Chờ duyệt</option>
												</select-->
											</td>
											
											<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
										</tr>
								</form>

								<tbody>
									<form method="POST" action="" name="form2" id="form2" class="form-horizontal">	
										<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
										<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />			
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
											<td ><?php echo str_replace ("<img ","<img width='100%'",$new->content)?></td>
											<td><?php echo $new->mail_user ?></td>
											
											<td>
												<?php echo date("d/m/Y",$new->date_cmt);
												?>
												
											</td>
										
											<td class="text-center" >
												<?= Model::news_view_link($new) ?>
											</td>
										</tr>
									<?php
									}
									?>
											<tr>
										<td colspan="6" >
											<button class="btn btn-success pull-right" id="add2" > Duyệt Mục Chọn</button>
										</td>
										<td colspan="7" >
											<button class="btn btn-warning pull-right" id="delete2" >Gỡ Mục Chọn</button>
										</td>
									</tr>
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
					</div>
				
				<!-- tab3 -->	
			
					<div id="menu3" class="tab-pane fade <?php if($_REQUEST['tab'] == 'menu3'){ echo 'in active';} ?>">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th width="5%">STT</th>
										<th width="20%">Bài viết</th>
										<th width="15%">Người comment</th>
										<th width="30%">Nội dung</th>
										<th width="">Email</th>
										<th width="">Ngày Gỡ</th>
										<th width="">Người Gỡ</th>
										<th class="text-center"><input type="checkbox" class="check_all " name="check_all" id="check_all" value="0" /> Chọn tất cả</th>
									</tr>
								</thead>
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
														<option value="<?php echo $user->user_cmt ?>" <?php echo ($_REQUEST['user_created'] == $user->user_cmt) ? 'selected="selected"' : ''; ?>><?php echo $user->user_cmt ?></option>
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
												<!--select id="state" name="state" class="form-control " onchange="this.form.submit();" />
												<option value="" <?php echo ($_REQUEST['state'] == 'all') ? 'selected="selected"' : '' ?> >- Chọn -</option>
												<option value="0" <?php echo ($_REQUEST['state'] == '0') ? 'selected="selected"' : '' ?>>Đã duyệt</option>
												<option value="1" <?php echo ($_REQUEST['state'] == '1') ? 'selected="selected"' : '' ?>>Chờ duyệt</option>
												</select-->
											</td>
											<td>
												
											</td>
											<td><button class="btn btn-primary" name="input_submit_search" type="submit" value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button></td>
										</tr>
								</form>

								<tbody>
									<form method="POST" action="" name="form3" id="form3" class="form-horizontal">	
										<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
										<input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>" />		
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
												<?php
													echo date("d/m/Y",$new->date_review);
												?>
												
											</td>
											<td><?php echo $new->fullname ?> </td>
											<td class="text-center" >
												<?= Model::news_view_link($new) ?>
											</td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td colspan="7" >
											<button class="btn btn-success pull-right" id="add3" > Duyệt Mục Chọn</button>
										</td>
										<td colspan="8" >
											<button class="btn btn-danger pull-right" id="delete3" >Xóa Mục Chọn</button>
										</td>
									</tr>
									
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
					</div>
				</div>	
					
					
					
					
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
	
	// tab đã duyệt;
	var form1 = document.getElementById("form1");
	var delete1 = document.getElementById("delete1");
	var remove1 = document.getElementById("remove1");
	
	
	delete1.addEventListener("click", function(){
		var r =  confirm("Bạn có chắc muốn xóa");
		if(r == true)
			document.getElementById("form1").setAttribute("action","index.php?module=news_comment&task=news_delete");
			form1.submit();
			var btnut = document.getElementById("delete1");
			btnut.setAttribute("disabled",true);
			
	});
	remove1.addEventListener("click", function(){
		var r =  confirm("Bạn có chắc muốn gỡ");
		if(r == true)
		document.getElementById("form1").setAttribute("action","index.php?module=news_comment&task=news_edit");
			form1.submit();
			var btnut = document.getElementById("remove1");
			btnut.setAttribute("disabled",true);
	});
	// tab chờ duyệt
	var form2 = document.getElementById("form2");
	var delete2 = document.getElementById("delete2");
	var add2 = document.getElementById("add2");
	
	
	delete2.addEventListener("click", function(){
		var r =  confirm("Bạn có chắc muốn xóa");
		if(r == true)
			document.getElementById("form2").setAttribute("action","index.php?module=news_comment&task=news_delete");
			form2.submit();
			var btnut = document.getElementById("delete2");
			btnut.setAttribute("disabled",true);		
	});
	add2.addEventListener("click", function(){
		var r =  confirm("Bạn có chắc muốn duyệt");
		if(r == true)
		document.getElementById("form2").setAttribute("action","index.php?module=news_comment&task=news_add");
			form2.submit();
			var btnut = document.getElementById("add2");
			btnut.setAttribute("disabled",true)	;
	});
	// tab đã gỡ
	var form3 = document.getElementById("form3");
	var delete3 = document.getElementById("delete3");
	var add3 = document.getElementById("add3");
	
	
	delete3.addEventListener("click", function(){
		var r =  confirm("Bạn có chắc muốn xóa");
		if(r == true)
			document.getElementById("form3").setAttribute("action","index.php?module=news_comment&task=news_delete");
			form3.submit();
			var btnut = document.getElementById("delete3");
			btnut.setAttribute("disabled",true);
			
	});
	add3.addEventListener("click", function(){
		var r =  confirm("Bạn có chắc muốn duyệt");
		if(r == true)
		document.getElementById("form3").setAttribute("action","index.php?module=news_comment&task=news_add");
			form3.submit();
			var btnut = document.getElementById("add3");
			btnut.setAttribute("disabled",true)	;
	});
</script>							

