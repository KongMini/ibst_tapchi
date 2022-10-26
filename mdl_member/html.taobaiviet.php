<?php
global $ariacms;
global $database;
//print_r($_SESSION["member"]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= $ariacms->getBlock("head"); ?>
    <script>
        filemanageUrl = '<?php echo $ariacms->actual_link ?>file-manager.php';
    </script>
    <script src="<?=$ariacms->actual_link ?>plugins/editor/ckeditor5-3/build/ckeditor.js"></script>
    <script src="<?=$ariacms->actual_link ?>plugins/editor/ckfinder/ckfinder.js"></script>


</head>
<body>
<div class="w1200">
    <?= $ariacms->getBlock("header"); ?>
    <!-- sidebar -->

    <?php
    $query = "SELECT * from e4_chude where status='active'";
    $database->setQuery($query);
    $linhvuc = $database->loadObjectList();
    ?>
</div>

<div class="main-content" style="margin: 30px 0 0 0">
    <div class="container" style='width: 70%; padding: 10px 20px; background-color: #e3e3e3'>


        <div class="twelve columns">


            <h3 style="text-align: center"><?= _CREATE ?></h3>

            <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                <form action="<?php echo $ariacms->actual_link . 'member/dang-bai.html'; ?>" method="post"
                      class="frm-show-form  frm_pro_form "
                      id="form_footerslide-inform">
                    <div class="frm_form_fields ">
                        <fieldset>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Tiêu đề Tiếng Việt:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" required
                                       name="tieude" placeholder="Tiêu đề Tiếng Việt"
                                       value="">
                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;" onclick="clickhd('hd_tieudevi')">
                                    <span class="frm_required" id="hd_tieudevi"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tieudevi_img" src="/ckfinder/userfiles/images/TieudeTV.jpg" style="width: 100%; display: none">

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
							<div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Tiêu đề Tiếng Anh:

                                </div>

                                <input type="text" id="field_j4r0h_first"
                                       name="tieude_en" placeholder="Tiêu đề Tiếng Anh"
                                       value="">
                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;" onclick="clickhd('hd_tieudeen')">
                                    <span class="frm_required" id="hd_tieudeen"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tieudeen_img" src="/ckfinder/userfiles/images/TieudeTA.jpg" style="width: 100%; display: none">
                            </div>
							
                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _AUTHOR_NAME ?>:

                                </div>
								
								<textarea  name="tacgia" rows="5" id='tacgia'
                                          ><?= $_SESSION['member']['fullname'] ?></textarea>

                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;" onclick="clickhd('hd_tacgia')">
                                    <span class="frm_required" id="hd_tacgia"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tacgia_img" src="/ckfinder/userfiles/images/Tacgia.jpg" style="width: 100%; display: none">

                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Từ khóa Tiếng Việt:

                                </div>

                                <input type="text" id="field_j4r0h_first"
                                       name="tukhoa" placeholder="Từ khóa Tiếng Việt">
                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tukhoa')">
                                    <span class="frm_required" id="hd_tukhoa"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tukhoa_img" src="/ckfinder/userfiles/images/TukhoaTV.jpg" style="width: 100%; display: none">
                            </div>
							
							<div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Từ khóa Tiếng Anh:

                                </div>

                                <input type="text" id="field_j4r0h_first"
                                       name="tukhoa_en" placeholder="Từ khóa Tiếng Anh">
                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tukhoaen')">
                                    <span class="frm_required" id="hd_tukhoaen"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tukhoaen_img" src="/ckfinder/userfiles/images/TukhoaTA.jpg" style="width: 100%; display: none">
                            </div>

                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label">Tóm tắt Tiếng Việt:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <textarea required name="tomtat" rows="5" ></textarea>
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
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <textarea required name="tomtat_en" rows="5" ></textarea>
                                 <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                      onclick="clickhd('hd_tomtaten')">
                                     <span class="frm_required" id="hd_tomtaten"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                 </div>
                                 <img id="hd_tomtaten_img" src="/ckfinder/userfiles/images/TomtatTA.jpg" style="width: 100%; display: none">
                            </div>

                            <div id="frm_field_15_container"
                                 class="frm_form_field form-field  frm_required_field frm_top_container">
                                <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _TOPIC ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </label>
                                <select required name="chude" id="field_8idq4">
                                    <option value="">Chọn Chủ đề</option>
                                    <?php foreach ($linhvuc as $value) { ?>
                                        <option value="<?php echo $value->id ?>"> <?php echo $value->title_vi ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <?php
                                $query = "SELECT * from e4_linhvuc where status='active' AND (time_start < ". time()." and time_end > ". time().") order by id desc";
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
                                        <option value="<?php echo $value->id ?>"> <?php echo $value->title_vi . "-" . $value -> nam ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _CONTENT ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input style="width:100%;" class="uk-input choiceImg cursor " id="image"
                                       type="text" name="file" onclick="openPopup('image')"
                                       placeholder="Nhấn để tải file nội dụng.." required>

                                <textarea style="margin-top:5px " name="noidung" rows="5" id="noidung"
                                          ></textarea>
                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_noidung')">
                                    <span class="frm_required" id="hd_noidung"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_noidung_img" src="/ckfinder/userfiles/images/09_apil.jpg" style="width: 100%; display: none">
                            </div>
							
                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _DOCUMENT ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <!--                                <input style="width:100%;" class="uk-input choiceImg cursor " id="image" txthide="image"-->
                                <!--                                       type="text" name="tailieuthamkhao" onclick="fcall.fcChoiceImg(this);"-->
                                <!--                                       placeholder="Nhấp để tải file tài liệu tham khảo.." required>-->
                                <textarea  name="tailieuthamkhao" rows="5"
                                           id="tailieuthamkhao"></textarea>
                                <div id="field_j4r0h_label" class="frm_primary_label" style=" text-align: right; margin-right: 10px; cursor:pointer;"
                                     onclick="clickhd('hd_tailieuthamkhao')">
                                    <span class="frm_required" id="hd_tailieuthamkhao"  aria-hidden="true" style="font-size: 12px">Hướng dẫn</span>
                                </div>
                                <img id="hd_tailieuthamkhao_img" src="/ckfinder/userfiles/images/tailieuthamkhao.jpg" style="width: 100%; display: none">
                            </div>

                            <div class="frm_submit" style="text-align: center">

                                <button class="frm_button_submit frm_final_submit" type="submit"
                                        name="submit" value="user"><?= _SUBMIT_PAPER ?>
                                </button>

                            </div>

                    </div>
                    </fieldset>
            </div>
            </form>
        </div>

    </div>

</div>


</div>
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
                    'bold','italic', 'subscript', 'superscript'
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
        .create( document.querySelector( '#noidung' ), {

            toolbar: {
                items: [
                    'MathType',
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
    ClassicEditor
        .create( document.querySelector( '#tailieuthamkhao' ), {

            toolbar: {
                items: [

                    'bold','italic',


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
        CKFinder.popup( {
            chooseFiles: true,
            onInit: function( finder ) {
                finder.on( 'files:choose', function( evt ) {
                    var file = evt.data.files.first();
                    document.getElementById( id ).value = file.getUrl();
                } );
                finder.on( 'file:choose:resizedImage', function( evt ) {
                    document.getElementById( id ).value = evt.data.resizedUrl;

                } );
            }
        } );
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
