<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

global $database;
global $ariacms ;
$id = $_REQUEST['id'];
$query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = $id";
$database->setQuery($query);
$news_detail = $database->loadRow();

$query = "SELECT * FROM `e4_gopy` LEFT JOIN e4_users ON e4_users.id = e4_gopy.id_user WHERE id_baibao  = ". $news_detail[0];
$database->setQuery($query);
$news_gopy = $database->loadObjectList();


if(count($news_detail) == 0){
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
                        <form method="POST" action="?module=baibao_tacgia&task=news_edit&id=<?php echo $id ?>" name="news_edit" id="news_edit" class="form-horizontal" enctype="multipart/form-data">
                            <div class="modal-content">

                                <div class="modal-body modal-scroll">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs hidden">
                                            <li class="active"><a aria-expanded="true" href="#info_general" data-toggle="tab">Thông tin chung <font class="text-red">*</font></a></li>
                                            <li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin SEO</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="info_general">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label >Tiêu đề</label>
                                                                <input class="form-control" name="title_vi" id="title_vi" type="text" required value="<?=str_replace('"','\'',$news_detail['title_vi']);?>" />
                                                            </div>
                                                        </div>
                                                        <!-- Nếu tác giả gửi file thì hiển thị file-->
                                                        <?php if($news_detail['file']){?>
                                                            <div class="form-group">
                                                                <div class="col-xs-12">
                                                                    <label >File <a href="<?= $news_detail['file'];?>" class="btn btn-success"> Xem file</a></label>
                                                                    <input class="form-control" name="" id="" type="text" value="<?= $news_detail['file'];?>" />

                                                                </div>
                                                            </div>
                                                        <?php }
                                                        if($news_detail['content_vi']){?>
                                                            <!-- Nếu tác giả gửi content thì hiển thị content-->
                                                            <div class="form-group">
                                                                <label for="content_vi" class="col-sm-12 col-md-12 col-lg-12">Nội dung Tiếng Việt</label>
                                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_vi" id="content_vi" rows="43"><?=$news_detail['content_vi']?></textarea>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>


                                                </div>
                                                <?php if($_SESSION['user']['role_type'] == 'ADMIN' && $news_gopy  ){?>
                                                    <div class="form-group">
                                                        <label for="meta_description_en" class="col-sm-12 col-md-12 col-lg-12">Góp ý bài đăng của người kiểm duyệt:</label>
                                                        <div class="col-sm-12 col-md-12 col-lg-12" style="padding: 0 40px;">

                                                            <?php foreach($news_gopy as $new){?>
                                                                <p><?php echo "<b>".$new->fullname ."</b>: ". $new->content?></p>
                                                            <?php }?>

                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($_SESSION['user']['role_type'] == 'CHECK'){?>
                                                    <?php if($news_gopy){?>
                                                        <div class="form-group">
                                                            <label for="meta_description_en" class="col-sm-12 col-md-12 col-lg-12">Góp ý bài đăng:</label>
                                                            <div class="col-sm-12 col-md-12 col-lg-12" style="padding: 0 40px;">

                                                                <?php foreach($news_gopy as $new){?>
                                                                    <p><?php echo "<b>".$new->fullname ."</b>: ". $new->content?></p>
                                                                <?php }?>

                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <div class="form-group">
                                                        <label for="meta_description_en" class="col-sm-12 col-md-12 col-lg-12">Nội dung góp ý:</label>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <textarea class="form-control" rows="3" name="gopy" id="gopy" placeholder="Nội dung góp ý..."></textarea>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <!-- Quyền của người tiếp nhận đồng thời là quản trị viên-->
                                            <?php if($_SESSION['user']['role_type'] == 'ADMIN'){
                                                if($news_detail['gopy'] && $news_detail['status'] == 'chokiemduyet'){?>
                                                    <button type="submit" class="btn btn-success" id="gopy" name="submit" value="gopy">Gửi góp ý cho tác giả</button>
                                                <?php }?>
                                                <!-- Gửi bài cho người kiểm duyệt-->
                                                <?php if($news_detail['status'] == 'chotiepnhan'){?>
                                                    <button type="submit" class="btn btn-primary" id="chokiemduyet" name="submit" value="chokiemduyet">Gửi bài cho người kiểm duyệt</button>
                                                <?php }else if($news_detail['status'] == 'waiting' || $news_detail['status'] == 'dago'){?>
                                                    <button type="submit" class="btn btn-warning" id="xuatban" name="submit" value="xuatban">Xuất bản</button>
                                                <?php }else if($news_detail['status'] == 'xuatban'){?>
                                                    <button type="submit" class="btn btn-warning" id="dago" name="submit" value="dago">Gỡ bài</button>
                                                <?php }?>
                                                <!-- Quyền của người kiểm duyệt-->
                                            <?php }if($_SESSION['user']['role_type'] == 'CHECK'){?>
                                                <?php if($news_detail['status'] == 'chokiemduyet'){?>
                                                    <button type="submit" class="btn btn-success" id="waiting" name="submit" value="gopy">Gửi góp ý cho người tiếp nhận</button>
                                                    <button type="submit" class="btn btn-warning" id="waiting" name="submit" value="waiting">Kiểm duyệt</button>
                                                    <button type="submit" class="btn btn-danger" id="chokiemduyet" name="submit" value="chokiemduyet">Không kiểm duyệt</button>
                                                <?php }?>
                                                <?php if($news_detail['status'] == 'waiting'){?>
                                                    <button type="submit" class="btn btn-danger" id="chokiemduyet" name="submit" value="chokiemduyet">Không kiểm duyệt</button>
                                                <?php }?>
                                                <?php if($news_detail['status'] == 'khongkiemduyet'){?>
                                                    <button type="submit" class="btn btn-warning" id="waiting" name="submit" value="waiting">Kiểm duyệt</button>
                                                <?php }?>
                                            <?php }?>
                                            <!-- <a type="button" class="btn btn-default " data-dismiss="modal">Trở lại</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </form>
                    </div><!-- /.modal-dialog -->
                    <style>
                        div.ck-editor__editable {
                            height: 600px !important;
                            overflow: scroll;
                        }
                    </style>

                    <script src="<?=$ariacms->actual_link ?>plugins/editor/ekeditor5_new/build/ckeditor.js"></script>
                    <script src="<?=$ariacms->actual_link ?>plugins/editor/ckfinder/ckfinder.js"></script>
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
                            .create( document.querySelector( '#content_vi' ), {

                                toolbar: {
                                    items: [
                                        'CKFinder',"|",
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


                            } )
                            .then( editor => {
                                window.editor = editor;

                            } )
                            .catch( error => {
                                console.error( 'Oops, something went wrong!' );
                                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                                console.warn( 'Build id: v10wxmoi2tig-mwzdvmyjd96s' );
                                console.error( error );
                            } );
                    </script>
                    <script>
                        $(".select2").select2();
                    </script>

                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
</section>