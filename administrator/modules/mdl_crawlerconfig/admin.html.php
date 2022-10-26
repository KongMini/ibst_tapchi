<?php
class View
{
	static function blocksManagerFront()
	{
?>
		<section class="content-header">
			<h1><a class="col-lg-2 col-md-4 col-sm-5 col-xs-12 btn-lg btn btn-warning " href="index.php?module=<?php echo $_REQUEST['module'] ?>">Quản lý Blocks<a>
						<a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="index.php?module=<?php echo $_REQUEST['module'] ?>">
							Danh sách
						</a>
						<a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#show_block_add">
							Thêm mới
						</a>
			</h1>
		</section>
	<?php
	}
	static function block_view($blocks)
	{
	?>
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h4 class="box-title">Danh sách bản ghi</h4>
						</div><!-- /.box-header -->
						<div class="box-body">
							<table id="" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Config key</th>
										<th>Config Name</th>
										<th>Config Value</th>
										<th class="col-md-1">Is Enable</th>
										<th class="col-md-1">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($blocks as $block) {

									?>
										<form method="POST" action="?module=crawlerconfig&task=block_edit&id=<?php echo $block->id ?>" name="block_edit" id="block_edit" enctype="multipart/form-data">
											<tr>
												<td><input class="form-control" name="config_key" id="config_key" type="text" required value="<?php echo $block->config_key ?>" /></td>
												<td><input class="form-control" name="config_name" id="config_name" type="text" required value="<?php echo $block->config_name ?>" /></td>
												<td><input class="form-control" name="config_values" id="config_values" type="text" required value="<?php echo $block->config_value ?>" /></td>
												<td><input class="form-control" name="is_enable" id="is_enable" type="text" value="<?php echo $block->is_enable ?>" /></td>
												<td><?php echo  Model::block_view_link($block) ?></td>
												<td><input type="submit" class="btn btn-primary " name="submit" value="Sửa"></td>	
											</tr>
											
										</form>
									<?php
									}
									?>
								</tbody>
							</table>

						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</section>

		<div class="modal fade " id="show_block_add" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<form method="POST" action="?module=block&task=block_add" name="block_add" id="block_add" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
						</div>
						<div class="modal-body">
							<div class="form-group ">
								<label for="bname">Blocks Name <span class="text-red">*</span></label>
								<input class="form-control" name="bname" id="bname" type="text" required />
							</div>
							<div class="form-group ">
								<label for="bfilename">Blocks File</label>
								<input class="" name="bfilename" id="bfilename" type="file" />
							</div>
							<div class="form-group ">
								<label for="bposition">Blocks Position <span class="text-red">*</span></label>
								<input class="form-control" name="bposition" id="bposition" type="text" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary pull-left" name="submit" value="block_add">Cập nhật</button>
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>
						</div>
					</div><!-- /.modal-content -->
				</form>
			</div><!-- /.modal-dialog -->
		</div>

<?php
	}
}
?>

<SCRIPT language=javascript type=text/javascript>
  
  	function edit(name,index){  alert("s");
		var f="news_id="+id;
		var _url="ajax/news/ajax.news_aproved.php"; 
		 $.ajax({
				url: _url,
				data:f,
				cache: false,
				context: document.body,
				success: function(data) {
					$("#user_aproved"+id).html(data);
			   
				}
			});
		}
</script>	