<?php
session_start();
if (file_exists("../../../configuration.php")) {
    require_once("../../../configuration.php");
} else {
    echo "Missing Configuration File";
    exit();
}
//Include Database Controller
if (file_exists("../../../include/database.php")) {
    require_once("../../../include/database.php");
} else {
    echo "Missing Database File";
    exit();
}
//Include System File
if (file_exists("../../../include/ariacms.php")) {
    require_once("../../../include/ariacms.php");
} else {
    echo "Missing System File";
    exit();
}

$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();

$id = $_REQUEST['id'];

$query = "SELECT * FROM `e4_baibao` where status = 'active' GROUP BY mabaibao;";
$database->setQuery($query);
$mabaibao = $database->loadObjectList();


$query = "SELECT a.* FROM e4_baibao a 
	WHERE  a.id = $id";
$database->setQuery($query);
$news_detail = $database->loadRow();


$query = "SELECT * from e4_linhvuc where status='active'";
$database->setQuery($query);
$linhvuc = $database->loadObjectList();

$query = "SELECT * from e4_chude where status='active'";
$database->setQuery($query);
$chude = $database->loadObjectList();


?>
<div class="active tab-pane" id="info_general">
    <div class="row">
        <input type="hidden" class="form-control" name="type" id="type" value="tapchi"/>

        <div class="col-xs-12 col-md-12">
            <label>Mã bài báo<span class="text-red">*<span></label>
            <select id="mabaibao" class="form-control select2" onchange="crawl()">
                <option value="">- Chọn -</option>
                <?php
                foreach ($mabaibao as $value) { ?>
                    <option value="<?php echo $value->id ?>"> <?php echo $value->mabaibao . "-" . $value->title_vi ?></option>
                <?php } ?>
            </select>
        </div>


        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group row ">
                <div class="col-xs-6">
                    <label>Tiêu đề Tiếng Việt<span
                                class="text-red">*</span></label>
                    <input class="form-control" name="title_vi" id="title_vi"
                           placeholder="Tiêu đề..." type="text" required
                           value="<?php echo $news_detail['title_vi'] ?>"/>
                </div>
                <div class="col-xs-6">
                    <label>Tiêu đề Tiếng Anh<span
                                class="text-red">*</span></label>
                    <input class="form-control" name="title_en" id="title_en"
                           placeholder="Tiêu đề..." type="text" required
                           value="<?php echo $news_detail['title_en'] ?>"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    <label>Tóm tắt Tiếng Việt<span
                                class="text-red">*</span></label>
                    <textarea class="form-control" rows="3" name="brief_vi"
                              id="brief_vi"
                              placeholder="Tóm tắt giới thiệu bản tin..."
                              ><?php echo $news_detail['brief_vi'] ?></textarea>
                </div>
                <div class="col-xs-6">
                    <label>Tóm tắt Tiếng Anh<span
                                class="text-red">*</span></label>
                    <textarea class="form-control" rows="3" name="brief_en"
                              id="brief_en"
                              placeholder="Tóm tắt giới thiệu bản tin..."
                              ><?php echo $news_detail['brief_en'] ?></textarea>
                </div>
            </div>
            <div class="form-group row ">
                <div class="col-xs-6">
                    <label>Tác giả Tiếng Việt<span
                                class="text-red">*</span></label>

                    <textarea class="form-control" rows="3" name="tacgia_vi"
                              id="tacgia_vi"
                              placeholder="Tóm tắt giới thiệu bản tin..."
                              ><?php echo $news_detail['tacgia'] ?></textarea>
                </div>
                <div class="col-xs-6">
                    <label>Tác giả Tiếng Anh<span
                                class="text-red">*</span></label>

                    <textarea class="form-control" rows="3" name="tacgia_en"
                              id="tacgia_en"
                              placeholder="Tóm tắt giới thiệu bản tin..."
                              ><?php echo $news_detail['tacgia'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-md-6">
                    <label>Sô tạp chí <span class="text-red">*</span></label>
                    <select class="form-control select2" id="id_linhvuc"
                            name="id_linhvuc"
                            data-placeholder="Chọn danh mục..."
                            style="width: 100%;">

                        <?php
                        foreach ($linhvuc

                                 as $value) { ?>
                            <option value="<?php echo $value->id ?>" <?php if ($news_detail['id_linhvuc'] == $value->id) echo "selected" ?>> <?php echo $value->title_vi . '-'. $value->nam?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-xs-12 col-md-6">
                    <label>Chủ đề<span class="text-red">*<span></label>
                    <select id="news_position" name="id_chude"
                            class="form-control" required>

                        <?php
                        foreach ($chude

                        as $value) { ?>
                        <option value="<?php echo $value->id ?>" <?php if ($news_detail['id_chude'] == $value->id) echo "selected" ?>> <?php echo $value->title_vi ?>
                        <option>
                            <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <div class="col-xs-12 col-md-6">
                    <label>Từ khóa Tiếng Việt</label>
                    <input class="form-control" name="tukhoa_vi" id="tukhoa_vi" placeholder="Từ khóa" type="text"
                           value="<?php echo $news_detail['tukhoa'] ?>"/>
                </div>
                <div class="col-xs-12 col-md-6">
                    <label>Từ khóa Tiếng Anh</label>
                    <input class="form-control" name="tukhoa_en" id="tukhoa_en" placeholder="Từ khóa" type="text"
                           value="<?php echo $news_detail['tukhoa_en'] ?>"/>
                </div>

            </div>
            <div class="form-group">

                <div class="col-xs-12 col-md-6">
                    <label>Tài liệu tham khảo Tiếng Việt</label>
                    <textarea class="form-control" name="tailieuthamkhao_vi" id="tailieuthamkhao_vi"
                              placeholder="Tài liệu tham khảo"><?php echo $news_detail['tailieuthamkhao'] ?></textarea>
                </div>
                <div class="col-xs-12 col-md-6">

                    <label>Tài liệu tham khảo Tiếng Anh</label>
                    <textarea class="form-control" name="tailieuthamkhao_en" id="tailieuthamkhao_en"
                              placeholder="Tài liệu tham khảo"><?php echo $news_detail['tailieuthamkhao'] ?></textarea>
                </div>

            </div>

        </div>

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
            <div class="form-group hidden">
                <!-- <div class="col-xs-12 col-md-4">
                                                                    <label >Số tạp chí <span class="text-red"></span></label>
                                                                    <input class="form-control" name="sotapchi" id="sotapchi" placeholder="Số tạp chí" type="text" value="<?php echo $news_detail['sotapchi'] ?>" />
                                                                </div> -->

                <div class="col-xs-12 col-md-4 ">
                    <label>Năm tạp chí <span class="text-red"></span></label>
                    <input class="form-control" name="namtapchi" id="namtapchi"
                           type="text"
                           value="<?php echo $news_detail['namtapchi'] ?>"/>
                </div>

                <div class="col-xs-12 col-md-4">
                    <label>Thời gian XB<span class="text-red"></span></label>
                    <input class="form-control" name="" id="aproved_date"
                           type="datetime-local"
                           value="<?php echo $news_detail['post_created'] ?>"/>
                </div>
            </div>

            <div class="form-group row ">
                <div class="col-xs-6">
                    <label>File Tiếng Việt<span
                                class="text-red">*</span></label>
                    <input class="form-control" name="file_vi"
                           onclick="openPopup('file_vi')" id="file_vi"
                           placeholder="file..." type="text" required
                           value="<?php echo $news_detail['file'] ?>"/>
                </div>
                <div class="col-xs-6">
                    <label>File Tiếng Anh</label>
                    <input class="form-control" name="file_en"
                           onclick="openPopup('file_en')" id="file_en"
                           placeholder="file..." type="text"
                           value="<?php echo $news_detail['file'] ?>"/>
                </div>
            </div>


            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="form-group ">
                    <label>Nội dung tiếng việt<span
                                class="text-red">*</span></label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_vi"
                                                                              id="content_vi" rows="50"
                                                                              ><?php echo $news_detail['content_vi'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nội dung tiếng anh</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_en"
                                                                              id="content_en"
                                                                              rows="50"><?php echo $news_detail['content_en'] ?></textarea>
                    </div>
                </div>
            </div>
            <script>
                function openPopupImg(id) {
                    CKFinder.popup({
                        chooseFiles: true,
                        onInit: function (finder) {
                            finder.on('files:choose', function (evt) {
                                var file = evt.data.files.first();
                                document.getElementById(id).value = file.getUrl();
                                document.getElementById("new" + id).src = file.getUrl();
                            });
                            finder.on('file:choose:resizedImage', function (evt) {
                                document.getElementById(id).value = evt.data.resizedUrl;

                            });
                        }
                    });
                }

                function openPopup(id) {
                    CKFinder.popup({
                        chooseFiles: true,
                        onInit: function (finder) {
                            finder.on('files:choose', function (evt) {
                                var file = evt.data.files.first();
                                document.getElementById(id).value = file.getUrl();
                            });
                            finder.on('file:choose:resizedImage', function (evt) {
                                document.getElementById(id).value = evt.data.resizedUrl;

                            });
                        }
                    });
                }
            </script>

            <script>
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
                            //$("#image").val() = e.target.result;
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>


        </div>

    </div>

</div>
