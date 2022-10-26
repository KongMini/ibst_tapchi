<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Danh sách nhóm tin tức</h4>
					<button class="btn btn-warning pull-right" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/news_group/ajax.news_group_add.php');">Thêm mới <i class="fa fa-plus"></i></button>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="" class="table table-bordered table-hover">
					<thead>
							<tr>
								<th class="col-md-2">Tên tiếng Việt</th>
								<th class="col-md-2">Tên tiếng Anh</th>
								<th class="col-md-2">Đường dẫn URL</th>
								<th class="col-md-1">Bài viết</th>
								<th class="col-md-1">Vị trí</th>
								<th class="col-md-1">Sắp xếp</th>
								<th class="col-md-1">Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php Model::printMenuAction('e4_term_taxonomy', '', '', 'group'); ?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>