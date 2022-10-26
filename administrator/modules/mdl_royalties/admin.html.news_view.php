<?php
global $ariacms;
$array_status = array(1=> 'Đã thanh toán', 0=>'Chờ thanh toán');
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div>
				<div class="box-header">
					<form method="post" action="index.php?module=royalties" name="form_news_search" id="form_news_search">
						<div class="form-group">
							<input type="hidden" name="module" id="module" value="<?php echo $_REQUEST['module'] ?>" />
							<input type="hidden" name="task" id="task" value="news_view" />
							<label for="title_vi" class="col-sm-1 col-md-1 col-lg-1">Từ ngày </label>						
							<div class="col-sm-3 col-md-3 col-lg-3">
								<input type = "date" class="form-control" name="from" id="from" value="<?php echo $_REQUEST['from'];?>" required  />
							</div>	
							
							<label  class="col-sm-1 col-md-1 col-lg-1"></label>
							
							<label for="title_vi" class="col-sm-1 col-md-1 col-lg-1">Đến ngày </label>						
							<div class="col-sm-3 col-md-3 col-lg-3">
								<input type = "date" class="form-control" name="to" id="to" value="<?php echo $_REQUEST['to'];?>" required />
							</div>	
							
							<label  class="col-sm-1 col-md-1 col-lg-1"></label>
							<button class="btn btn-primary " name="input_submit_search" type="submit" value="Tìm kiếm">Tìm kiếm</button>
						</div>
						
					</form>
				</div>
				
				<div class="tab-content">
				
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th width="5%" class="text-center">STT</th>
										<th width="30%" class="text-center">Bài viết</th>
										<th width="13%" class="text-center">Người viết</th>
										<th width="13%" class="text-right">Giá trị</th>
										<th width="" class="text-center">Trạng thái</th>
										<th width="" class="text-center">Ngày đăng</th>
										<th width="" class="text-center">Ghi Chú</th>
										<th width="" class="text-center">Thao tác</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									foreach ($news as $new) {
										$i++;
										// thứ tự STT, bài viêt, người viết, giá, trạng thái, ghi chú, thao tác
									?>
										<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : '' ; ?> valign-middle">
											<td class="text-center">
												<?php echo $i ?>
											</td>
											<td><?php echo $new->title_vi  ?></td>
											
											<td class="text-center"><?php echo $new->fullname ?></td>
											
											<td class="text-right"><?php echo number_format($new->price)?></td>
											
											<td class="text-center"><?php echo $array_status[$new->status] ?></td>
											<td class="text-center"> <?php echo date("d-m-Y", $new->date_created); ?> </td>
											<td><?php echo $new->notice ?> </td>
											<td class="text-center" >
												<?= Model::news_view_link($new) ?>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<div class="pull-right">
								<a href="javascript:;" class="btn btn-success" onclick="XuatExcel()"> Xuất excel </a>
							</div>
							<div class="clear"></div>
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
					
					
					
					
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
<div id="xxx">
</div>
<script>


	function XuatExcel(){
		
		var from = $("#from").val();
        var to = $("#to").val();
        var f = "from="+from+"&to="+to;
        var _url = "excel/ajax.WGexcel.php";
		
        $.ajax({
            url: _url,
            data: f,
            cache: false,
            context: document.body,
            success: function (data) {
				$("#xxx").html(data);
				//alert(data);
                window.location = "excel/"+data;
            }
        });
		/**/
    }

</script>							

