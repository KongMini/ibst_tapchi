<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

global $database;
global $ariacms;
$id = $_REQUEST['id'];
$query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = $id";
$database->setQuery($query);
$news_detail = $database->loadRow();

$query = "SELECT * FROM `e4_gopy` LEFT JOIN e4_users ON e4_users.id = e4_gopy.id_user WHERE id_baibao  = " . $news_detail[0];
$database->setQuery($query);
$news_gopy = $database->loadObjectList();

$query = "SELECT * from e4_linhvuc where status='active'";
$database->setQuery($query);
$linhvuc = $database->loadObjectList();

$query = "SELECT * from e4_chude where status='active'";
$database->setQuery($query);
$chude = $database->loadObjectList();

if (count($news_detail) == 0) {
    $ariacms->redirect("", "javascript:history.back()");
}

$query = "SELECT * FROM e4_posts_meta WHERE post_id = '$id'";
$database->setQuery($query);
$term_metas = $database->loadObjectList();
foreach ($term_metas as $term_meta) {
    $news_detail['meta']->{$term_meta->meta_key} = $term_meta->meta_value;
}
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Thông tin chi tiết</h4>
                    <div class="modal-dialog modal-wide">
                        <form method="POST" action="?module=baibao_tacgia&task=news_edit&id=<?php echo $id ?>"
                              name="news_edit" id="news_edit" class="form-horizontal" enctype="multipart/form-data">
                            <div class="modal-content">

                                <div class="modal-body modal-scroll">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs hidden">
                                            <li class="active"><a aria-expanded="true" href="#info_general"
                                                                  data-toggle="tab">Thông tin chung <font
                                                            class="text-red">*</font></a></li>
                                            <li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin
                                                    SEO</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="info_general">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <div class="form-group row ">
                                                            <input type="hidden" name="id"
                                                                   value="<?php echo $news_detail['id'] ?>"/>
                                                            <input type="hidden" name="mabaibao"
                                                                   value="<?php echo $news_detail['mabaibao'] ?>"/>
                                                            <input type="hidden" name="id_tacgia"
                                                                   value="<?php echo $news_detail['id_tacgia'] ?>"/>
                                                            <input type="hidden" name="title_vi"
                                                                   value="<?php echo $news_detail['title_vi'] ?>"/>
                                                            <div class="col-xs-12">
                                                                <label>Tiêu đề Tiếng Việt <span class="text-red">*</span></label>
                                                                <input class="form-control" name="title_vi"
                                                                       id="title_vi" placeholder="Tiêu đề..."
                                                                       type="text" required
                                                                       value="<?php echo $news_detail['title_vi'] ?>"/>
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label>Tiêu đề Tiếng Anh </label>
                                                                <input class="form-control" name="title_en"
                                                                       id="title_en" placeholder="Tiêu đề..."
                                                                       type="text"
                                                                       value="<?php echo $news_detail['title_en'] ?>"/>
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label>Tác giả<span class="text-red">*</span></label>
                                                                <textarea  class="form-control" name="tacgia" id="tacgia"
                                                                           placeholder="Tác giả..."><?php echo $news_detail['tacgia'] ?></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label>Giới thiệu Tiếng Việt<span
                                                                            class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="10" name="brief_vi"
                                                                          id="brief_vi"
                                                                          placeholder="Tóm tắt..."><?php echo $news_detail['brief_vi'] ?></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label>Giới thiệu Tiếng Anh<span
                                                                            class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="10" name="brief_en"
                                                                          id="brief_en"
                                                                          placeholder="Tóm tắt..."><?php echo $news_detail['brief_en'] ?></textarea>
                                                            </div>

                                                        </div>
														<div class="form-group">
                                                            <div class="col-xs-12 col-md-12">
                                                                <label>Từ Khóa Tiếng Việt</label>
                                                                <input class="form-control" name="tukhoa"
                                                                       id="tukhoa"
                                                                       placeholder="từ khóa" type="text"
                                                                       value="<?php echo $news_detail['tukhoa'] ?>"/>
                                                            </div>
                                                        </div>
														 <div class="form-group">
                                                            <div class="col-xs-12 col-md-12">
                                                                <label>Từ Khóa Tiếng Anh</label>
                                                                <input class="form-control" name="tukhoa"
                                                                       id="tukhoa"
                                                                       placeholder="từ khóa" type="text"
                                                                       value="<?php echo $news_detail['tukhoa_en'] ?>"/>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12 col-md-12">
                                                                <label>Chủ đề<span class="text-red">*<span></label>
                                                                <select id="news_position" name="id_chude"
                                                                        class="form-control">
                                                                    <option value="">- Chọn chủ đề -</option>
                                                                    <?php
                                                                    foreach ($chude as $value) { ?>
                                                                        <option value="<?php echo $value->id ?>" <?php if ($news_detail['id_chude'] == $value->id) echo "selected" ?>> <?php echo $value->title_vi ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12 col-md-12">
                                                                <label>Số tap chí<span class="text-red">*<span></label>
                                                                <select id="news_position" name="id_chude"
                                                                        class="form-control">
                                                                    <option value="">- Chọn số tạp chí -</option>
                                                                    <?php
                                                                    foreach ($linhvuc as $value) { ?>
                                                                        <option value="<?php echo $value->id ?>" <?php if ($news_detail['id_linhvuc'] == $value->id) echo "selected" ?>> <?php echo $value->title_vi . '-' . $value -> nam ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                       

                                                        

                                                    </div>

                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                                                        <!-- Nếu tác giả gửi file thì hiển thị file-->
                                                        <?php if ($news_detail['file']) { ?>
                                                            <div class="form-group">
                                                                <div class="col-xs-12">
                                                                    <label>File nội dung<a
                                                                                href="<?= $news_detail['file']; ?>"
                                                                                class="btn btn-success"> Xem
                                                                            file</a></label>
                                                                    <input class="form-control" name="" id=""
                                                                           type="text"
                                                                           value="<?= $news_detail['file']; ?>"/>

                                                                </div>
                                                            </div>
                                                        <?php }

                                                        if ($news_detail['content_vi']) {
                                                            ?>
                                                            <!-- Nếu tác giả gửi content thì hiển thị content-->
                                                            <div class="form-group">
                                                                <label for="content_vi"
                                                                       class="col-sm-12 col-md-12 col-lg-12">Nội dung
                                                                    Tiếng Việt</label>
                                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_vi"
                                                                              id="content_vi"
                                                                              rows="43"><?= $news_detail['content_vi'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
														
														<div class="form-group">

                                                            <div class="col-xs-12 col-md-12">
                                                                <label>Tài liệu tham khảo</label>
                                                                <textarea rows="10" class="form-control" name="tailieuthamkhao"
                                                                          id="tailieuthamkhao"
                                                                          placeholder="Tài liệu tham khảo"><?php echo $news_detail['tailieuthamkhao'] ?></textarea>

                                                            </div>

                                                        </div>
                                                    </div>
												

                                                </div>

                                                <?php
                                                $query = "SELECT a.* FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE a.phanbien = 1  and a.publish = 1 ";// . $where . $order . $limit
                                                $database->setQuery($query);
                                                $phanbien = $database->loadObjectList();

                                                // lấy người phản biện
                                                $query = "SELECT * FROM `e4_phanbien`WHERE mabaibao = '" . $news_detail['mabaibao'] . "' and id_baibao = " . $_GET['id'] . " ORDER BY id";// . $where . $order . $limit
                                                $database->setQuery($query);
                                                $nguoiphanbien = $database->loadObjectList();

                                                $array_trangthaiphanhoi = [0 => 'Chưa phản hồi', 1 => 'Đồng ý làm phản biện', 2 => 'Từ chối làm phản biện', 3=> 'Đã phản biện', 4 => "Phản biện mới thay thế", 5 => "Không duyệt phản biện"];
                                                $array_trangthaiphanhoi_color = [0 => '', 1 => 'Blue', 2 => 'Red', 3=>"Orange", 4 => 'Green', 5 => 'Red'];
                                                $array_phanbien = [ 0 => "Không đồng ý đăng", 1=> "Đồng ý đăng có phản hồi", 2 => "Đồng ý đăng", 4 => "Đồng ý đăng, gửi phản biện xem lại"];
                                                $array_thaythepb = [];

                                                $moilaiphanbien = 0;

                                                $is_full = True;
                                                ?>

                                                <div class="form-group">
                                                    <?php for ($i = 0; $i < 3; $i++) {
                                                        $trangthaipb = $nguoiphanbien[$i]->trangthai;

                                                        if ($trangthaipb == 2 || $trangthaipb == 5) {
                                                            $moilaiphanbien++;
                                                            array_push($array_thaythepb, $i);
                                                            $is_full = False;
                                                        }
                                                        if($trangthaipb == 1 || $trangthaipb == 4){
                                                            $is_full = False;
                                                        }
                                                        if($nguoiphanbien[$i]-> id_nguoiphanbien == 0 ) {
                                                            array_push($array_thaythepb, $i);
                                                        }

                                                        ?>
                                                        <div class="col-xs-12">
                                                            <label>Phản biện <?= $i + 1 ?></label>
                                                            <select class="form-control select2" name="phanbien[]"
                                                                <?php if(($trangthaipb == 1 || $trangthaipb ==0) and ($news_detail['status'] == 'chopb' ||
                                                                        $news_detail['status'] == 'chonlaipb' || $news_detail['status'] == 'thaythepb')
                                                                        and $nguoiphanbien[$i]->id_nguoiphanbien > 0)
                                                                    ?> >
                                                                <option value="">- Chọn -</option>
                                                                <?php foreach ($phanbien as $value) { ?>
                                                                    <option value="<?php echo $value->id ?>"
                                                                        <?php if ($nguoiphanbien[$i]->id_nguoiphanbien == $value->id)
                                                                        echo "selected" ?>><?php echo $value->fullname . ' - ' . $value->hocvi ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                            <?php if (($news_detail['status'] == 'chopb' || $news_detail['status'] == 'chonlaipb' ||
                                                                $news_detail['status'] == 'thaythepb') and $nguoiphanbien[$i]->id_nguoiphanbien > 0) { ?>
                                                                <label style="color: <?= $array_trangthaiphanhoi_color[$trangthaipb]?>">
                                                                    Trạng thái: <?= $array_trangthaiphanhoi[$trangthaipb] ?> - Thời gian: <?= Date("H:i:s d-m-Y", $nguoiphanbien[$i] -> time)?>
                                                                </label>
                                                                <br>
                                                            <?php } ?>
                                                            <?php if ($nguoiphanbien[$i]->file and $nguoiphanbien[$i]->trangthai == 3) {
                                                                $slfilegui++;?>
                                                                <label>Ý kiến phản hồi: <b><?= $array_phanbien[$nguoiphanbien[$i]->dongy]?></b> - File phản hồi<a
                                                                            href="<?= $nguoiphanbien[$i]->file ?>"
                                                                            class="btn btn-success"> Xem
                                                                        file</a></label>
                                                                <input class="form-control" name="" id="" type="text"
                                                                       value="<?= $nguoiphanbien[$i]->file ?>"/>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                    <input type="hidden" name="array_thaythepb" value="<?= implode(",",$array_thaythepb)?>">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <!-- Quyền của người tiếp nhận đồng thời là quản trị viên-->
                                            <?php if ($_SESSION['user']['role_type'] == 'ADMIN') {
                                                if ($news_detail['status'] == 'chopb' and $moilaiphanbien > 0) {
                                                    ?>
                                                    <button type="submit" class="btn btn-success" id="chonlaipb"
                                                            name="submit" value="chonlaipb">Gửi yêu cầu thay thế phản biện
                                                    </button>
                                                <?php } ?>

                                                <?php if ($news_detail['status'] == 'chopb' and ($is_full)) {
                                                ?>
                                                <button type="submit" class="btn btn-success" id="guipb"
                                                        name="submit" value="kiemduyetphanhoipb">Gửi phản biện cho ban khoa học
                                                </button>
                                                <?php } ?>

                                                <!-- Gửi bài cho người kiểm duyệt-->
                                                <?php if ($news_detail['status'] == 'chotiepnhan' || $news_detail['status'] == 'phanhoi') { ?>
                                                    <button type="submit" class="btn btn-primary" id="chokiemduyet"
                                                            name="submit" value="chokiemduyet">Gửi ban khoa học kiểm duyệt
                                                    </button>

                                                <?php } else if ($news_detail['status'] == 'waiting' || $news_detail['status'] == 'dago') { ?>
                                                    <button type="submit" class="btn btn-warning" id="xuatban"
                                                            name="submit" value="xuatban">Xuất bản
                                                    </button>
                                                <?php } else if ($news_detail['status'] == 'xuatban') { ?>
                                                    <button type="submit" class="btn btn-warning" id="dago"
                                                            name="submit" value="dago">Gỡ bài
                                                    </button>
                                                <?php } ?>
                                                <!-- Quyền của Ban KH
                                                *-->
                                            <?php }
                                            if ($_SESSION['user']['role_type'] == 'CHECK') { ?>
                                                <?php if ($news_detail['status'] == 'chokiemduyet') { ?>
<!--                                                    <button type="submit" class="btn btn-success" id="waiting"-->
<!--                                                            name="submit" value="gopy">Gửi góp ý cho người tiếp nhận-->
<!--                                                    </button>-->

                                                    <!-- GD Mời phản biện-->
<!--                                                    <button type="submit" class="btn btn-success" id="waiting"-->
<!--                                                            name="submit" value="chonpb">Chọn phản biện-->
<!--                                                    </button>-->

                                                    <!--GD kiểm tra bài phản biện bài bao -> mời Tổng biện tập duyệt -->
                                                    <button type="submit" class="btn btn-success" id="waiting"
                                                            name="submit" value="moipb">Mời phê duyệt phản biện
                                                    </button>
                                                    <button type="submit" class="btn btn-warning" id="dago"
                                                            name="submit" value="dago">Hủy bài
                                                    </button>
<!--                                                    <button type="submit" class="btn btn-warning" id="waiting"-->
<!--                                                            name="submit" value="waiting">Kiểm duyệt-->
<!--                                                    </button>-->
<!--                                                    <button type="submit" class="btn btn-danger" id="chokiemduyet"-->
<!--                                                            name="submit" value="chokiemduyet">Không kiểm duyệt-->
<!--                                                    </button>-->
                                                <?php } ?>
                                                <?php if ($news_detail['status'] == 'chonlaipb') { ?>
                                                    <button type="submit" class="btn btn-danger" id="thaythepb"
                                                            name="submit" value="thaythepb">Thay thế phản biện từ chối
                                                    </button>
                                                <?php } ?>
                                                <?php if ($news_detail['status'] == 'kiemduyetphanhoipb') { ?>
                                                    <button type="submit" class="btn btn-success" id="pheduyetpb"
                                                            name="submit" value="pheduyetpb">Phê duyệt phản biện gửi cho Tổng biên tập
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                            <!-- Quyền của Tổng biên tập/ Phó Tổng biển tập-->
                                            <?php if ($_SESSION['user']['role_type'] == 'POST') { ?>
                                                <!-- Giai đoạn mời phản biện -->
                                                <?php if($news_detail['status'] == 'moipb'){?>
                                                    <button type="submit" class="btn btn-success" id="success" name="submit"
                                                            value="chopb">Phê duyệt
                                                    </button>
                                                    <button type="submit" class="btn btn-danger" id="danger" name="submit"
                                                            value="chokiemduyet">Không phê duyệt
                                                    </button>
                                                <?php }?>
                                                <?php if($news_detail['status'] == 'thaythepb'){?>
                                                    <button type="submit" class="btn btn-success" id="waiting" name="submit"
                                                            value="chopb">Phê duyệt
                                                    </button>
                                                    <button type="submit" class="btn btn-danger" id="waiting" name="submit"
                                                            value="chonlaipb">Không phê duyệt
                                                    </button>
                                                <?php }?>

                                                <?php if ($news_detail['status'] == 'pheduyetpb') { ?>
                                                    <button type="submit" class="btn btn-success" id="pheduyetpb"
                                                            name="submit" value="phanhoitacgia">Phê duyệt
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" id="active"
                                                            name="submit" value="active">Phê duyệt
                                                    </button>
                                                <?php } ?>
                                                <!-- Giai đoạn sau phản biện -> Duyệt đăng bài hay hủy -->
<!--                                                <button type="submit" class="btn btn-warning" id="waiting" name="submit"-->
<!--                                                        value="no-waiting">Phê duyệt đăng bài-->
<!--                                                </button>-->
<!--                                                <button type="submit" class="btn btn-warning" id="waiting" name="submit"-->
<!--                                                        value="no-waiting">Không phê duyệt đăng bài-->
<!--                                                </button>-->

                                                <?php if ($news_detail['status'] == 'waiting') { ?>
                                                    <button type="submit" class="btn btn-success" id="dongydang"
                                                            name="submit" value="dongydang">Đông ý đăng
                                                    </button>
                                                    <button type="submit" class="btn btn-danger" id="dago"
                                                            name="submit" value="dago">Hủy bài
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                            <!-- <a type="button" class="btn btn-default " data-dismiss="modal">Trở lại</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </form>
                    </div><!-- /.modal-dialog -->
                    <style>
                        div.ck-editor__editable {
                            min-height: 150px;
                            max-height: 600px;
                            overflow: scroll;
                        }
                    </style>

                    <script src="<?= $ariacms->actual_link ?>plugins/editor/ckeditor5-3/build/ckeditor.js"></script>
                    <script src="<?= $ariacms->actual_link ?>plugins/editor/ckfinder/ckfinder.js"></script>
                    <script>
                        const customColorPalette = [
                            {
                                color: 'hsl(4, 90%, 58%)',
                                label: 'Red'
                            },
                            {
                                color: 'hsl(340, 82%, 52%)',
                                label: 'Pink'
                            },
                            {
                                color: 'hsl(291, 64%, 42%)',
                                label: 'Purple'
                            },
                            {
                                color: 'hsl(262, 52%, 47%)',
                                label: 'Deep Purple'
                            },
                            {
                                color: 'hsl(231, 48%, 48%)',
                                label: 'Indigo'
                            },
                            {
                                color: 'hsl(207, 90%, 54%)',
                                label: 'Blue'
                            },

                            // ...
                        ];

                        ClassicEditor
                            .create(document.querySelector('#content_vi'), {

                                toolbar: {
                                    items: [
                                        'CKFinder', "|",
                                        'heading',
                                        'bold',
                                        'link',
                                        'italic',
                                        '|',
                                        'blockQuote',
                                        'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                                        'insertTable',
                                        'undo',
                                        'redo',

                                        'bulletedList',
                                        'numberedList',
                                        'mediaEmbed',
                                        'fontBackgroundColor',
                                        'fontColor',
                                        'fontSize',
                                        'fontFamily',

                                    ]
                                },
                                language: 'vi',
                                image: {
                                    toolbar: [
                                        'imageTextAlternative',
                                        'imageStyle:full',
                                        'imageStyle:side'
                                    ]
                                },
                                table: {
                                    contentToolbar: [
                                        'tableColumn', 'tableRow', 'mergeTableCells',
                                        'tableProperties', 'tableCellProperties'
                                    ],

                                    // Set the palettes for tables.
                                    tableProperties: {
                                        borderColors: customColorPalette,
                                        backgroundColors: customColorPalette
                                    },

                                    // Set the palettes for table cells.
                                    tableCellProperties: {
                                        borderColors: customColorPalette,
                                        backgroundColors: customColorPalette
                                    }
                                },
                                licenseKey: '',


                            })
                            .then(editor => {
                                window.editor = editor;

                            })
                            .catch(error => {
                                console.error('Oops, something went wrong!');
                                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                                console.warn('Build id: v10wxmoi2tig-mwzdvmyjd96s');
                                console.error(error);
                            });
                        ClassicEditor
                            .create(document.querySelector('#tacgia'), {

                                toolbar: {
                                    items: [  'bold','italic', 'subscript', 'superscript']
                                },
                                language: 'vi',
                                licenseKey: '',
                            })
                            .then(editor => {
                                window.editor = editor;
                            })
                            .catch(error => {
                                console.error('Oops, something went wrong!');
                                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                                console.warn('Build id: v10wxmoi2tig-mwzdvmyjd96s');
                                console.error(error);
                            });
                        ClassicEditor
                            .create(document.querySelector('#tailieuthamkhao'), {

                                toolbar: {
                                    items: [ 'bold', 'link', 'italic', '|']
                                },
                                language: 'vi',
                                licenseKey: '',
                            })
                            .then(editor => {
                                window.editor = editor;
                            })
                            .catch(error => {
                                console.error('Oops, something went wrong!');
                                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                                console.warn('Build id: v10wxmoi2tig-mwzdvmyjd96s');
                                console.error(error);
                            });
							
						ClassicEditor
                            .create(document.querySelector('#brief_en'), {

                                toolbar: {
                                    items: [ 'bold', 'link', 'italic', '|']
                                },
                                language: 'vi',
                                licenseKey: '',
                            })
                            .then(editor => {
                                window.editor = editor;
                            })
                            .catch(error => {
                                console.error('Oops, something went wrong!');
                                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                                console.warn('Build id: v10wxmoi2tig-mwzdvmyjd96s');
                                console.error(error);
                            });
							 ClassicEditor
                            .create(document.querySelector('#brief_vi'), {

                                toolbar: {
                                    items: [ 'bold', 'link', 'italic', '|']
                                },
                                language: 'vi',
                                licenseKey: '',
                            })
                            .then(editor => {
                                window.editor = editor;
                            })
                            .catch(error => {
                                console.error('Oops, something went wrong!');
                                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                                console.warn('Build id: v10wxmoi2tig-mwzdvmyjd96s');
                                console.error(error);
                            });
                    </script>
                    <script>
                        $(".select2").select2();
                    </script>

                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
</section>