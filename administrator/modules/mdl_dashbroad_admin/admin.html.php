<?php
class View
{
  static function index($useronline,$row,$comment,$news)
  { ?>
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <section class="content">
		
		<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header ">
				
				<script type="text/javascript" src="templates/aptcms/js/highcharts.js"></script>
				<script>
					$(function () {
						var arr1 = [];
						var arr2 = [];
						var arr3 = [];
						var arr4 = [];
					<?php
					$today = date('Y-m-d');
					for($i=0;$i<31;$i++){
						// Trừ đi 10 ngày
						$ngaytt = strtotime(date("Y-m-d", strtotime($today)) . -$i." day");
						$ngaytt = strftime("%d/%m/%Y", $ngaytt);?>
						arr1.push("<?php echo $ngaytt;?>");
						var key1 =0;
							var key2 =0;
							var key3=0;
						<?php
							//print_r( date("d/m/Y",$show->ngay)));
							//$array_thuthu = $array_doanhthu = array();
							
						foreach($row as $show){
							if($ngaytt == date("d/m/Y",$show->ngay)){
								
							?>	
							key1=<?php echo $show->mobile;?>;
							key2=<?php echo $show->web;?>;
							key3=<?php echo $show->toantrang;?>;
							//break;
							//exit();
						<?php	
							}
						}
						?>
							arr2.push(key1);
							arr3.push(key2);
							arr4.push(key3);
						
						<?php
					}
					 ?>
					 
						//alert(arr1);
						arr2 = arr2.reverse();
						arr3 = arr3.reverse();
						arr4 = arr4.reverse();
						Highcharts.chart('chart1', {
							
							title: {
								text: 'Thống kê lượt truy cập',
							},
							xAxis: {
								categories: arr1.reverse()
							},
							yAxis: {
								title: {
									text: 'Views'
								},
								plotLines: [{
									value: 0,
									width: 1,
									color: '#f5a208'
								}]
							},
							tooltip: {
								valueSuffix: 'views'
							},
							
							series: [{
								name: 'mobile',
								data: arr2,
								color: "#1e8be9"
							},{
								name: 'web',
								data: arr3,
								color: "#d23636"
							}
							,{
								name: 'toàn trang',
								data: arr4,
								color: "#f5a208"
							}
							
							]
						});
					});
						
				</script>
	
				<div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div> 		

				</div>
				<div  id="topview"></div>
				
				<div class="tab-content">
				
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th width="5%" class="text-center">STT</th>
										<th class="">Tài khoản đang hoạt động</th>
										<th class="">Phân loại</th>
									</tr>
									<?php $i = 0;
									if($useronline){
										foreach($useronline as $user){ $i++;?>
										<tr>
											<td class="text-center"><?php echo $i; ?></td>
											<td><?php echo $user->fullname; ?></td>
											<td><?php if( $user->user_type == "public")echo "Người dùng ";else echo "Quản trị viên"; ?></td>
										</tr>
										<?php } 
										} else {
									?>
										<tr>
											<td class="text-center"><?php echo "0"; ?></td>
											<td><?php echo "Hiện tại không có người dùng online" ?></td>
										</tr>
										<?php }?>
								</thead>
								<tbody>
								</tbody>
							</table>
							
						</div><!-- /.box-body -->
				</div>	
					
					
					
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div>
		
	</section>
 
<?php }
}
?>