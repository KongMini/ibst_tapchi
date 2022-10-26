<?php
global $ariacms;
global $database;
$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
		GROUP BY a.id ORDER BY a.order ";
$database->setQuery($query);
$taxonomies = $database->loadObjectList();
$array_status = array('active' => 'Đã xuất bản', 'waiting' => 'Chờ duyệt', 'deactive' => 'Không được duyệt', 'lock' => 'Đã gỡ');
$array_location = array(2 => 'Nổi bật trang chủ', 1 => 'Nổi bật trang trong', 0 => 'Tin thường');
$array_posttype = array('post' => 'Post');

//print_r($_SESSION['user']['role_type']);
$task = $_REQUEST['tab'];
//	if($_SESSION['user']['role_type']== "CHECK"){
//		if( $task == "chotiepnhan" || $task == "xuatban" || $task == "dago"){
//			echo "<script>alert('Bạn không có quyền thao tác chức năng này'); location.href='index.php?module=baibao_tacgia&tab=waiting'</script>";
//		}
//	}
$array_status = array('chotiepnhan' => 'Chờ tiếp nhận', 'chonlaipb' => 'Mời phản biện thay thế', 'moipb' => 'Phê duyệt phản biện',
    'chopb' => 'Chờ phản hồi phản biện', 'dago' => 'Đã gỡ', 'chokiemduyet' => 'Chờ kiểm duyệt', 'khongduocduyet' => 'Không được duyệt',
    'kiemduyetphanhoipb' => 'Kiểm duyệt phản hồi của phản biện', 'pheduyetpb' => 'Phê duyệt phản biện bài báo', 'phanhoitacgia'=>'Tác giả phản hồi phản biện',
    'phanhoi'=> 'Phản hồi phản biện', 'active' => 'Đồng ý đăng bài');

?>
<section class="content-header">
    <h1>
        <a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning "
           href="index.php?module=<?php echo $_REQUEST['module'] ?>"><i class="fa fa-files-o"></i> Quản lý bài báo</a>
    </h1>
    <!-- <a class="btn btn-warning pull-right"  href="index.php?module=baibao_tacgia&task=news_add">Thêm mới <i class="fa fa-plus"></i></a> -->
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <!--				<ul class="nav nav-tabs">-->
                <!--				  <li class="-->
                <?php //if($_REQUEST['tab'] == 'chotiepnhan'){ echo 'active';} ?><!--"><a href="index.php?module=baibao_tacgia&tab=chotiepnhan">Chờ tiếp nhận</a></li>-->
                <!--				  <li class="-->
                <?php //if($_REQUEST['tab'] == 'waiting'){ echo 'active';} ?><!--"><a href="index.php?module=baibao_tacgia&tab=waiting">Phản biện</a></li>-->
                <!--				  <li class="-->
                <?php //if($_REQUEST['tab'] == 'chokiemduyet'){ echo 'active';} ?><!--"><a href="index.php?module=baibao_tacgia&tab=chokiemduyet">Chờ kiểm duyệt</a></li>-->
                <!--				  <li class="-->
                <?php //if($_REQUEST['tab'] == 'khongduocduyet'){ echo 'active';} ?><!--"><a href="index.php?module=baibao_tacgia&tab=khongduocduyet">Không được duyệt</a></li>-->
                <!--				  <li class="-->
                <?php //if($_REQUEST['tab'] == 'dago'){ echo 'active';} ?><!--"><a href="index.php?module=baibao_tacgia&tab=dago">Đã gỡ</a></li><li class="-->
                <?php //if($_REQUEST['tab'] == 'xuatban'){ echo 'active';} ?><!--"><a href="index.php?module=baibao_tacgia&tab=xuatban">Đã xuất bản</a></li>-->
                <!--				</ul>-->

                <div class="tab-content">
                    <div id="chotiepnhan" class="tab-pane fade in active">
                        <!-- Tab chờ duyệt -->
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" width="3%">STT</th>
                                    <th>Mã bài báo</th>
                                    <th width="25%">Tiêu đề</th>
                                    <th width="">Tác giả</th>
                                    <th width="">Số tạp chí</th>
                                    <th width="">Ngày tạo</th>
                                    <th width="">Trạng thái</th>
                                    <th width="">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                <form method="get" action="index.php" name="form_news_search" id="form_news_search">
                                    <input type="hidden" name="module" id="module"
                                           value="<?php echo $_REQUEST['module'] ?>"/>
                                    <input type="hidden" name="tab" id="tab" value="<?php echo $_REQUEST['tab'] ?>"/>
                                    <input type="hidden" name="task" id="task" value="news_view"/>
                                    <tr>
                                        <td>
                                            <select name="page_size" id="page_size" class="form-control"
                                                    onchange="this.form.submit();">
                                                <option value="">Hiển thị</option>
                                                <option value="10" <?php echo ($_REQUEST['page_size'] == '10') ? 'selected="selected"' : '' ?>>
                                                    - - 10 - -
                                                </option>
                                                <option value="15" <?php echo ($_REQUEST['page_size'] == '15') ? 'selected="selected"' : '' ?>>
                                                    - - 15 - -
                                                </option>
                                                <option value="20" <?php echo ($_REQUEST['page_size'] == '20') ? 'selected="selected"' : '' ?>>
                                                    - - 20 - -
                                                </option>
                                                <option value="30" <?php echo ($_REQUEST['page_size'] == '30') ? 'selected="selected"' : '' ?>>
                                                    - - 30 - -
                                                </option>
                                                <option value="50" <?php echo ($_REQUEST['page_size'] == '50') ? 'selected="selected"' : '' ?>>
                                                    - - 50 - -
                                                </option>
                                                <option value="100" <?php echo ($_REQUEST['page_size'] == '100') ? 'selected="selected"' : '' ?>>
                                                    - - 100 - -
                                                </option>
                                                <option value="999999999" <?php echo ($_REQUEST['page_size'] == '999999999') ? 'selected="selected"' : '' ?>>
                                                    - - Tất cả - -
                                                </option>
                                            </select>
                                        </td>
                                        <td><input class="form-control" name="mabaibao" id="mabaibao" type="text"
                                                   value="<?php echo $_REQUEST['mabaibao'] ?>"
                                                   onchange="this.form.submit();"/></td>
                                        <td><input class="form-control" name="keysearch" id="keysearch" type="text"
                                                   value="<?php echo $_REQUEST['keysearch'] ?>"
                                                   onchange="this.form.submit();"/></td>
                                        <td>
                                            <select name="user_created" id="user_created" class="form-control"
                                                    onchange="this.form.submit();">
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
                                            <select name="id_linhvuc" id="id_linhvuc" class="form-control"
                                                     onchange="this.form.submit();">
                                                <option value="">- Chọn -</option>
                                                <?php
                                                foreach ($linhvuc as $v) {
                                                    ?>
                                                    <option value="<?php echo $v->id ?>" <?php echo ($_REQUEST['id_linhvuc'] == $v->id) ? 'selected="selected"' : ''; ?>><?php echo $v->title_vi ."-".$v-> nam ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td>
                                            <select name="status" id="status" class="form-control"
                                                    onchange="this.form.submit();">
                                                <option value="">- Chọn -</option>
                                                <?php
                                                foreach ($array_status as $k => $v) {
                                                    ?>
                                                    <option value="<?php echo $k ?>" <?php echo ($_REQUEST['status'] == $k) ? 'selected="selected"' : ''; ?>><?php echo $v ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" name="input_submit_search" type="submit"
                                                    value="Tìm kiếm">Lọc <i class="fa fa-filter"></i></button>
                                        </td>
                                    </tr>
                                </form>

                                <?php
                                $i = 0;
                                // print_r($news);
                                foreach ($news as $new) {
                                    $i++;

                                    ?>
                                    <tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if ($new->news_position == 1) {
                                        echo 'style="background: #d0d0d0;"';
                                    }
                                    if ($new->news_position == 2) {
                                        echo 'style="background: #b6e9e4;"';
                                    }
                                    if ($new->news_position == 3) {
                                        echo 'style="background: #e7c9ab;"';
                                    }
                                    if ($new->news_position == 4) {
                                        echo 'style="background: #32b12952;"';
                                    } ?>>
                                        <td class="text-center">
                                            <?php echo $i ?>
                                        </td>
                                        <td>
                                            <a href='index.php?module=baibao_tacgia&task=news_edit&id=<?php echo $new->id ?>'><?= $new->mabaibao ?></a>
                                        </td>
                                        <td>
                                            <a href='index.php?module=baibao_tacgia&task=news_edit&id=<?php echo $new->id ?>'><?= $new->title_vi ?></a>
                                        </td>
                                        <td><?php echo $new->fullname ?></td>
                                        <td><?php echo $new->sotapchi . '-' . $new->namtapchi ?></td>
                                        <td>
                                            <?php echo Date("d/m/Y", $new->date_created) ?>
                                        </td>
                                        <td><?php echo $array_status[$new->status] ?></td>
                                        <td class="text-center">
                                            <?php
											if($_SESSION['user']['role_type'] == "CHECK" ){
												$trangthai = " and (a.status = 'khongpheduyetpb' or  a.status = 'chokiemduyet' or a.status = 'chonlaipb' or a.status = 'kiemduyetphanhoipb') " ;
												if($new->status == 'khongpheduyetpb' || $new->status == 'chokiemduyet' || $new->status == 'chonlaipb' || $new->status == 'kiemduyetphanhoipb' ){
													 echo '<a  href="index.php?module=baibao_tacgia&task=news_edit&id=' . $new->id . '" ><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
												}
											}
											if($_SESSION['user']['role_type'] == "POST"){
												$trangthai = " and a.status = 'moipb' or a.status = 'thaythepb' or a.status = 'pheduyetpb'" ;
												if($new->status == 'moipb' || $new->status == 'thaythepb' || $new->status == 'pheduyetpb' ){
													 echo '<a  href="index.php?module=baibao_tacgia&task=news_edit&id=' . $new->id . '" ><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
												}
											}
											if($_SESSION['user']['role_type'] == "ADMIN"){
												echo '<a  href="index.php?module=baibao_tacgia&task=news_edit&id=' . $new->id . '" ><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
											}
                                            
                                            // echo '<a href ="?module=baibao_tacgia&task=news_delete&id=' . $new->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
                                            // if($new->post_status == 'active'){
                                            // 	echo '<a href ="javascript:void(0);" onclick="aproved('.$new->id.',1)"><i class="fa fa-ban" title="Gỡ bài" aria-hidden="true"></i></a>';
                                            // }else {
                                            // 	echo '<a href ="javascript:void(0);" onclick="aproved('.$new->id.',0)"><i class="fa fa-thumbs-up" title="Xuất bản" aria-hidden="true"></i></a>';
                                            // }
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div aria-live="polite" role="status" id="example1_info" class="dataTables_info">
                                        Hiển thị từ <?php echo $curPg * $maxRows - $maxRows + 1 ?>
                                        đến <?php echo ($curPg * $maxRows > $totalRows) ? $totalRows : $curPg * $maxRows; ?>
                                        trong số <?php echo $totalRows ?> bản ghi
                                    </div>
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

<script language=javascript type=text/javascript>

    function aproved(id, status) {  //alert("s");
        var f = "news_id=" + id + "&status=" + status;
        var _url = "ajax/news/ajax.news_aproved.php";
        $.ajax({
            url: _url,
            data: f,
            cache: false,
            context: document.body,
            success: function (data) {
                window.location.href = "";
            }
        });
    }

    // Longph thêm
    function getContent() {
        var url = $("#url_coppy").val();
        // alert(url);
        var _url = "ajax/news/ajax.news_crawl.php";
        $.ajax({
            url: _url,
            data: "url=" + url,
            cache: false,
            context: document.body,
            success: function (data) {
                // alert(2);
                $("#info_general").html(data);
            }
        });
    }

    function chooseImg() {
        $("#img").click();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#newImg')
                    .attr('src', e.target.result)
                    .height(60);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>							
