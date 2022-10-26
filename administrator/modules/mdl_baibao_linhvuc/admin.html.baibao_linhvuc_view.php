<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách số báo chí</h4>
					<button class="btn btn-warning pull-right" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/baibao_linhvuc/ajax.baibao_linhvuc_add.php');">Thêm mới <i class="fa fa-plus"></i></button>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="col-md-3">Tên tiếng Việt</th>
								<th class="col-md-3">Tên tiếng Anh</th>
								<th class="col-md-2">Đường dẫn URL</th>
								<th class="col-md-2">Năm</th>
<!--								<th class="col-md-1">Bài viết</th>-->
<!--								<th class="col-md-1">Vị trí </th>-->
<!--								<th class="col-md-1">Sắp xếp</th>-->
								<th class="col-md-2">Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php Model::printMenuAction('e4_linhvuc', '', '', 'category'); ?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>