<?php
global $ariacms;
global $database;
//print_r($_SESSION["member"]);


$query = "SELECT * from e4_chude where status='active'";
$database->setQuery($query);
$linhvuc = $database->loadObjectList();

$query = "SELECT MAX(id) as isEdit FROM e4_baibao WHERE mabaibao ='".  $member_posts['mabaibao']."'";
$database->setQuery($query);
$isEdit = $database->loadRow();

$isEdit = $isEdit['isEdit'];
if($isEdit == $member_posts['id']){
    $isEdit = True;
}else{
    $isEdit = False;
}

// Lấy phản biện
$query = "SELECT * FROM `e4_phanbien` WHERE mabaibao = '".$member_posts['mabaibao']."' and id_baibao = ". $member_posts['id'];
$database->setQuery($query);
$phanbien = $database->loadObjectList();


if ($member_posts['status'] == 'waiting') {
    // lấy người phản biện
    $query = "SELECT * FROM `e4_phanbien`WHERE mabaibao = '" . $member_posts['mabaibao'] . "' and id_baibao = " . $member_posts['id'] . "";// . $where . $order . $limit
    $database->setQuery($query);
    $nguoiphanbien = $database->loadObjectList();
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= $ariacms->getBlock("head"); ?>
    <script>
        filemanageUrl = '<?php echo $ariacms->actual_link ?>file-manager.php';
    </script>
    <script src="<?=$ariacms->actual_link ?>plugins/editor/ckeditor5-35/build/ckeditor.js"></script>
    <script src="<?=$ariacms->actual_link ?>plugins/editor/ckfinder/ckfinder.js"></script>

</head>
<body class="w1200">

<?= $ariacms->getBlock("header"); ?>
<!-- sidebar -->

<!-- Phản biện-->

<?php if ($phanbien && ($member_posts['status'] == 'phanhoitacgia' || $member_posts['status'] == 'phanhoi' || $member_posts['status'] == 'active') ) { ?>
    <div class="main-content" style="margin: 30px 0 0 0">
        <div class="container" style='width: 70%;padding: 10px 20px; background-color: #e3e3e3'>


            <div class="twelve columns">


                <h3 style="text-align: center"><?= "Phản biện bài báo" ?></h3>

                <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                    <div class="frm_form_fields ">
                        <fieldset>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Các phản biện bài báo:

                                </div>
                                <?php foreach ($phanbien as $k => $v){?>
                                        <?php if($v -> file){?>
                                        <a target="_blank" href="<?= $v -> file?>">&emsp; - Phản biện bài báo <?= $k + 1?></a><br>
                                <?php }
                                }?>
                            </div>

                    </div>
                    </fieldset>
                </div>

            </div>

        </div>

    </div>
<?php } ?>


<!-- Bài báo -->
<div class="main-content" style="margin: 30px 0 0 0">
    <div class="container" style='width: 70%;padding: 10px 20px; background-color: #e3e3e3'>


        <div class="twelve columns">


            <h3 style="text-align: center"><?= _EDIT ?></h3>

            <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                <form action="<?php echo $ariacms->actual_link . 'member/cap-nhat-bai-viet.html'; ?>" method="post"
                      class="frm-show-form  frm_pro_form "
                      id="form_footerslide-inform">
                    <div class="frm_form_fields ">
                        <fieldset>
                            <input style="width:100%" class="uk-input"  type="hidden" name="mabaibao"
                                   value="<?php echo $member_posts['mabaibao'] ?>">
                            <input style="width:100%" class="uk-input"  type="hidden" name="id"
                                   value="<?php echo $member_posts['id'] ?>">
                            <input style="width:100%" class="uk-input"  type="hidden" name="status"
                                   value="<?php echo $member_posts['status'] ?>">

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Tiêu đề Tiếng Việt:
                                    <span class="" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" 
                                       name="tieude" placeholder="Tiêu đề Tiếng Việt"
                                       value="<?= $member_posts['title_vi'] ?>">
								<div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;" onclick="clickhd('hd_tieudevi')">
                                    <span class="frm_required" id="hd_tieudevi"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tieudevi_img" src="/ckfinder/userfiles/images/TieudeTV.jpg" style="width: 100%; display: none">

                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Tiêu đề Tiếng Anh:
                                    <span class="" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" 
                                       name="tieude_en" placeholder="Tiêu đề Tiếng Anh"
                                       value="<?= $member_posts['title_en'] ?>">
								<div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;" onclick="clickhd('hd_tieudevi')">
                                    <span class="frm_required" id="hd_tieudevi"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tieudevi_img" src="/ckfinder/userfiles/images/TieudeTA.jpg" style="width: 100%; display: none">

                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _AUTHOR_NAME ?>:
                                    <span class="" aria-hidden="true">*</span>
                                </div>

                                <textarea  name="tacgia" rows="5" id='tacgia'
                                          data-uw-styling-context="true"><?= $member_posts['tacgia'] ?></textarea>
								<div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;" onclick="clickhd('hd_tacgia')">
                                    <span class="frm_required" id="hd_tacgia"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tacgia_img" src="/ckfinder/userfiles/images/Tacgia.jpg" style="width: 100%; display: none">
                            </div>


                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Từ khóa Tiếng Việt:
                                    <span class="" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" 
                                       name="tukhoa" placeholder="Từ khóa Tiếng Việt"
                                       value='<?= $member_posts['tukhoa'] ?>'>
								 <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tukhoa')">
                                    <span class="frm_required" id="hd_tukhoa"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tukhoa_img" src="/ckfinder/userfiles/images/TukhoaTV.jpg" style="width: 100%; display: none" >
                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Từ khóa Tiếng Anh:
                                    <span class="" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" 
                                       name="tukhoa_en" placeholder="Từ khóa Tiếng Anh"
                                       value='<?= $member_posts['tukhoa_en'] ?>'>
								
                                  <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tukhoaen')">
                                    <span class="frm_required" id="hd_tukhoaen"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tukhoaen_img" src="/ckfinder/userfiles/images/TukhoaTA.jpg" style="width: 100%; display: none" >
                            </div>

                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label">Tóm tắt Tiếng Việt:
                                    <span class="" aria-hidden="true">*</span>
                                </div>
                                <textarea  name="tomtat" rows="5" id='tomtat'
                                          data-uw-styling-context="true"><?= $member_posts['brief_vi'] ?></textarea>
								<div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tomtat')">
                                    <span class="frm_required" id="hd_tomtat"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tomtat_img" src="/ckfinder/userfiles/images/TomtatTV.jpg" style="width: 100%; display: none">
                            </div>

                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label">Tóm tắt Tiếng Anh:
                                    <span class="" aria-hidden="true">*</span>
                                </div>
                                <textarea  name="tomtat_en" rows="5" id='tomtat_en'
                                          data-uw-styling-context="true"><?= $member_posts['brief_en'] ?></textarea>
								<div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tomtatta')">
                                    <span class="frm_required" id="hd_tomtatta"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tomtatta_img" src="/ckfinder/userfiles/images/TomtatTA.jpg" style="width: 100%; display: none">
                            </div>

                            <div id="frm_field_15_container"
                                 class="frm_form_field form-field  _field frm_top_container">
                                <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _TOPIC ?>:
                                    <span class="" aria-hidden="true">*</span>
                                </label>
                                <select  name="chude" id="field_8idq4">
                                    <option value="">Chọn Chủ đề</option>
                                    <?php foreach ($linhvuc as $value) { ?>
                                        <option value="<?php echo $value->id ?>" <?php if ($value->id == $member_posts['id_chude']) echo "selected"; ?>> <?php echo $value->title_vi ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <?php
                            $query = "SELECT * from e4_linhvuc where status='active' AND (time_start < ". time()." and time_end > ". time().")";
                            $database->setQuery($query);
                            $linhvuc = $database->loadObjectList();
                            ?>
                            <div id="frm_field_15_container"
                                 class="frm_form_field form-field  frm_required_field frm_top_container">
                                <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _NUMBER ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </label>
                                <select required name="id_linhvuc" id="field_8idq4">
                                    <option value="">Chọn số tạp chí</option>
                                    <?php foreach ($linhvuc as $value) { ?>
                                        <option value="<?php echo $value->id ?>" <?php if ($value->id == $member_posts['id_linhvuc']) echo "selected"; ?>> <?php echo $value->title_vi . "-" . $value -> nam ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _CONTENT ?>:
                                    <span class="" aria-hidden="true">*</span>
                                </div>

                                <input style="width:100%;" class="uk-input choiceImg cursor "id="image"
                                       type="text" name="file" onclick="openPopup('image')" name="file" value="<?= $member_posts['file'] ?>"
                                       onclick="fcall.fcChoiceImg(this);" placeholder="Nhấp để tải file nội dụng..">

                                <textarea style="margin-top:5px "   id="noidung" name="noidung" rows="5"
                                          data-uw-styling-context="true"><?= $member_posts['content_vi'] ?></textarea>

                            </div>

                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _DOCUMENT ?>:
                                    <span class="" aria-hidden="true">*</span>
                                </div>
                                <!--                                <input style="width:100%;" class="uk-input choiceImg cursor " id="image" txthide="image"-->
                                <!--                                       type="text" name="tailieuthamkhao" onclick="fcall.fcChoiceImg(this);"-->
                                <!--                                       placeholder="Nhấp để tải file tài liệu tham khảo.." >-->
                                <textarea name="tailieuthamkhao" rows="5" id="tailieuthamkhao"
                                          data-uw-styling-context="true"><?= $member_posts['tailieuthamkhao'] ?></textarea>
							    <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tailieuthamkhao')">
                                    <span class="frm_required" id="hd_tailieuthamkhao"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tailieuthamkhao_img" src="/ckfinder/userfiles/images/Tailieuthamkhao.jpg" style="width: 100%; display: none">
                            </div>
                            <div class="frm_submit" style="text-align: center">
                                <?php if (($member_posts['status'] != 'active') and $isEdit == True) { ?>
                                    <button class="frm_button_submit frm_final_submit" type="submit"
                                            formnovalidate="formnovalidate" name="submit" value="update"><?= _EDIT ?>
                                    </button>
									
                                <?php } ?>
								  <?php if (($member_posts['status'] == 'phanhoitacgia' and $member_posts['status'] != 'active')  and $isEdit == True ) { ?>
                                    <button style="background: #4fff38;border-color:#4fff38" class="frm_button_submit frm_final_submit" type="submit"
                                            formnovalidate="formnovalidate" name="submit" value="phanhoitacgia"><?= _EDIT_PB ?>
                                    </button>
									
                                <?php } ?>
                            </div>
							

                    </div>
                    </fieldset>
            </div>
            </form>
        </div>

    </div>

</div>

<script>
                                function clickhd(id){
                                    var id_img = id + '_img';
                                    var display = document.getElementById(id_img).style.display;
                                    if(display == 'none'){
                                        document.getElementById(id_img).style.display = 'block';
                                        document.getElementById(id).innerText = 'Tắt hướng dẫn';
                                    }
                                    else{
                                        document.getElementById(id_img).style.display = 'none';
                                        document.getElementById(id).innerText = 'Hướng dẫn';
                                    }
                                }

                            </script>
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
        .create( document.querySelector( '#tacgia' ), {

            toolbar: {
                items: [
                    'bold','italic', 'subscript', 'superscript','alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                ]
            },
            language: 'vi',

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

    ClassicEditor
        .create(document.querySelector('#noidung'), {

            toolbar: {
                items: [
                    'MathType',
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
        .create(document.querySelector('#tailieuthamkhao'), {

            toolbar: {
                items: [

                    'bold', 'italic', '|',
                    'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                    'insertTable',
                    'undo',
                    'redo',


                ]
            },
            language: 'vi',

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
        .create( document.querySelector( '#tomtat' ), {

            toolbar: {
                items: [

                    'bold','italic', '|',
                    'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                    'insertTable',
                    'undo',
                    'redo',


                ]
            },
            language: 'vi',

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
 ClassicEditor
        .create( document.querySelector( '#tomtat_en' ), {

            toolbar: {
                items: [

                    'bold','italic', '|',
                    'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                    'insertTable',
                    'undo',
                    'redo',


                ]
            },
            language: 'vi',

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


<style>
    div.ck-editor__editable {
        min-height: 150px !important;
        overflow: scroll;
    }
</style>
<?= $ariacms->getBlock("footer"); ?>
<?= $ariacms->getBlock("footer_script"); ?>
</body>
</html>
