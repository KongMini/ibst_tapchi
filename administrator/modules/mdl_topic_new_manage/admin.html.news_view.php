<?php
global $ariacms;
global $database;
		
	$query = "SELECT * FROM e4_term_taxonomy WHERE taxonomy = 'topic' order by `order`";
	//$database->setQuery($query);
	//$term_taxonomy = $database->loadObjectList();
	$database->setQuery($query);
	$topic_list = $database->loadObjectList();
	$array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt');
	$array_location = array(2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong');
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<form method="get" action="index.php" name="form_news_search" id="form_news_search">
						<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
						<input type="hidden" name="task" id="task" value="news_view" />
						<div class="form-group">
							<div class="col-md-3">
								<input class="form-control" placeholder="Nhập từ khóa tìm kiếm" name="keysearch" id="keysearch" type="text" value="<?php echo $_REQUEST['keysearch'] ?>" />
							</div>
							<div class="col-md-3">
								<select name="category" id="category" class="form-control" onchange="this.form.submit();">
									<option value="">-Chọn danh mục-</option>
									<?php foreach ($topic_list as $taxonomy) { ?>
										<option value="<?php echo $taxonomy->id ?>" <?php echo ($_REQUEST['category'] == $taxonomy->id) ? 'selected="selected"' : ''  ?> > <?php echo $taxonomy->title_vi ?> </option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3">
								<input type="submit" class="btn btn-success" name="timdulieu" value="Tìm" />
							</div>
						</div>
					</form>
					<div class="clear"></div>
					<form method="post" action="index.php?module=topic_news&task=news_update" name="form_news_update_iorder" id="form_news_update_iorder">
						<input type="hidden" name="keyword" id="keyword" value="<?php echo $_REQUEST['category'] ?>" />
						<div class="table-responsive" >
							<table id="table-2" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th  class="text-center"  width="3%">STT</th>
										<th  width="25%">Tiêu đề</th>
										<th width="">Người tạo</th>
										<th width="">Người duyệt</th>
										<th width="15%">Danh mục</th>
										<th width="">Loại tin </th>
										<th width="">Trạng thái</th>
										<th width="">Vị trí</th>
										<th width="">Thao tác</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									foreach ($news as $new) {
										$i++;
									?>
										<tr id="<?php echo $new->id;?>" class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';}  if($new->news_position == 3) {echo 'style="background: #e7c9ab;"';} if($new->news_position == 4) {echo 'style="background: #32b12952;"';} ?>>
											<td  class="text-center">
												<?php echo $i ?>
											</td>
											<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$new->title_vi.'</a>' ?></td>
											<td><?php echo $new->fullname ?></td>
											<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
											<td><?php echo $new->category ?></td>
											<td><?php echo $new->post_type ?></td>
											<td>
												<?php echo $array_status[$new->post_status]; ?> <br />
												<?php echo ($new->aproved_date) ? $ariacms->unixToDate($new->aproved_date, '/') : ''; ?>
											</td>
											<td>
												<?php echo  $array_location[$new->news_position]; ?>
												<input type="number" class="form-control hidden" name="iorder[<?php echo $new->id ?>]" id="iorder_<?php echo $new->id ?>" value="<?php echo $i ?>"  />
											</td>
											
											<td class="text-center">
												<input type="checkbox" name="vitri[]" id="vitri_<?php echo $new->id ?>" value="<?php echo $new->id ?>"  />
											</td>
											
										</tr>
									<?php } ?>
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
						</div>
						<div class="result">&nbsp;</div>
						
						<div class="" style="float: right" >
							<input type="hidden" name="hid_remove" id="hid_remove" value="0">
							<input type="hidden" name="topic_id" id="topic_id" value="">
							<input type="button" onclick="setremove()" name="remove" class="btn btn-danger" value="Gỡ khỏi chủ đề" />
						</div>
						
					</form>
					<div class="clear"></div>
					
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>


<script>
	function setremove(){
		$("#hid_remove").val("1");
		$("#topic_id").val($("#category").val());
		if(confirm("Bạn chắc chắn gỡ các tin đã chọn khỏi chủ đề ? "))
		$("#form_news_update_iorder").submit();	
		
	}
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
  	function tinthuong(id){
		window.location.href = 'index.php?module=topic_manage&task=news_edit&id=' + id;
	}
</script>	

<script type="text/javascript">
   $(document).ready(function() {
        table_2 = $("#table-2");
        table_2.find("tr:even").addClass("alt"); //alert("s");
        table_2.tableDnD({
            onDragClass: "myDragClass",
            onDrop: function(table, row) {
                var rows = table.tBodies[0].rows;
                var debugStr = "Row dropped was "+row.id+". New order: ";
                for (var i=0; i<rows.length; i++) {
                    debugStr += rows[i].id+" ";
                }
				// $(table).parent().find('.result').text(debugStr);
				// Xu ly o day
				// alert("Gọi ajax ở đây");
            },
            onDragStart: function(table, row) {
                //$(table).parent().find('.result').text("Started dragging row "+row.id);
            }
			
        });	
	});		

</script>						