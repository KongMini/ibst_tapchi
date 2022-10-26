<?php
global $ariacms;
global $database;
//print_r($_SESSION["member"]);

$query = "SELECT * from e4_chude where status='active'";
$database->setQuery($query);
$linhvuc = $database->loadObjectList();
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

<!-- Bài báo -->
<div class="main-content" style="margin: 30px 0 0 0">
    <div class="container" style='width: 70%;padding: 10px 20px; background-color: #e3e3e3'>


        <div class="twelve columns">


            <h3 style="text-align: center"><?= _ARTICLE_DETAIL ?></h3>

            <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                <div class="frm-show-form  frm_pro_form "
                     id="form_footerslide-inform">
                    <div class="frm_form_fields ">
                        <fieldset>
                            <input style="width:100%" class="uk-input" required type="hidden" name="id"
                                   placeholder="Tiêu đề (*)" value="<?php echo $member_posts['id'] ?>">

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _Title ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="tieude" required
                                       name="tieude" placeholder="<?= _Title ?>"
                                       value="<?= $member_posts['title_vi'] ?>" readonly>

                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _Title ?> Tiếng anh:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="tieude_en" required
                                       name="tieude" placeholder="<?= _Title ?>"
                                       value="<?= $member_posts['title_en'] ?>" readonly>

                            </div>

                            <div style="display:none" id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _AUTHOR_NAME ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <textarea name="tacgia" id="tacgia" placeholder="<?= _AUTHOR_NAME ?>"<?= $member_posts['tacgia'] ?></textarea>

                            </div>

                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _SUMMARY ?> Tiêng việt:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <textarea required name="tomtat" id="tomtat" rows="5" readonly
                                          data-uw-styling-context="true"><?= $member_posts['brief_vi'] ?></textarea>

                            </div>

                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _SUMMARY ?> Tiếng anh:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <textarea required name="tomtat_en" id="tomtat_en" rows="5" readonly
                                          data-uw-styling-context="true"><?= $member_posts['brief_en'] ?></textarea>

                            </div>

                            <div id="frm_field_15_container"
                                 class="frm_form_field form-field  frm_required_field frm_top_container">
                                <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _TOPIC ?>:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </label>
                                <select required name="linhvuc" id="field_8idq4" readonly>
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
                                <select required name="id_linhvuc" id="field_8idq4" readonly>
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
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input style="width:100%;" class="uk-input choiceImg cursor " id="image" txthide="image"
                                       type="text" name="file" value="<?= $member_posts['11'] ?>"
                                       onclick="download('<?= $member_posts['11'] ?>')"
                                       placeholder="Nhấp để tải file nội dụng" readonly>

                                <textarea style="margin-top:5px " name="noidung" id="noidung" rows="5" readonly
                                          data-uw-styling-context="true"><?= $member_posts['content_vi'] ?></textarea>

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
                                <textarea required name="tailieuthamkhao" id="tailieuthamkhao" rows="5" readonly
                                          data-uw-styling-context="true"><?= $member_posts['tailieuthamkhao'] ?></textarea>
                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _KEY ?> Tiếng việt:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" readonly
                                       name="tukhoa" placeholder="Từ khóa" value="<?= $member_posts['tukhoa'] ?>">

                            </div>
                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _KEY ?> Tiếng anh:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input type="text" id="field_j4r0h_first" readonly
                                       name="tukhoa" placeholder="Từ khóa" value="<?= $member_posts['tukhoa_en'] ?>">

                            </div>



                    </div>
                    </fieldset>
                </div>
            </div>
        </div>

    </div>

</div>


<div class="main-content" style="margin: 30px 0 0 0">
    <div class="container" style='width: 70%;padding: 10px 20px; background-color: #e3e3e3'>


        <div class="twelve columns">

            <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                <form action="<?php echo $ariacms->actual_link . 'member/phan-bien.html'; ?>" method="post"
                      class="frm-show-form  frm_pro_form "
                      id="form_footerslide-inform">
                    <h3 style="text-align: center"><?= _COMMENTARY_ARTICLE ?></h3>

                    <?php
                    $query = "SELECT * FROM `e4_phanbien` WHERE id_nguoiphanbien =" . $_SESSION['member']['id'] . "  AND id_baibao =" . $member_posts['id'];
                    $database->setQuery($query);
                    $phanbien = $database->loadRow();
                    ?>


                    <div id="frm_field_15_container"
                         class="frm_form_field form-field  frm_required_field frm_top_container">
                        <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _Feedback ?>:
                            <span class="frm_required" aria-hidden="true">*</span>
                        </label>
                        <input style="width:100%" class="uk-input" required type="hidden" name="id"
                               value="<?php echo $member_posts['id_phanbien'] ?>">

                        <select required name="dongy" id="field_8idq4">
                           
                           
                            
                            <option value="2" <?php if ($value->id == $phanbien['dongy']) echo "selected"; ?>> Đồng ý đăng
                            </option>
							<option value="1" <?php if ($value->id == $phanbien['dongy']) echo "selected"; ?>> Đồng ý đăng có chỉnh sửa
                            </option>
							<option value="3" <?php if ($value->id == $phanbien['dongy']) echo "selected"; ?>> Đồng ý đăng, gửi phản biện xem lại
                            </option>
						<option value="0" <?php if ($value->id == $phanbien['dongy']) echo "selected"; ?>> Không đồng ý đăng
                            </option>
                        </select>


                    </div>

                    <div id="frm_field_6-first_container"
                         class="frm_form_field form-field frm_form_subfield-first  frm6"
                         data-sub-field-name="first">
                        <div id="field_j4r0h_label" class="frm_primary_label"><?= _CONTENT ?>:
                            <span class="frm_required" aria-hidden="true">*</span>
                        </div>

                        <input style="width:100%;" class="uk-input choiceImg cursor " id="filepb"
                               type="text"
                               name="file" value="<?= $phanbien['file'] ?>" onclick="openPopup('filepb')"
                               placeholder="Nhấp để tải file phản biện..">
							   
						<textarea style="margin-top:5px "   id="noidungphanbien" name="noidungphanbien" rows="5"
                                          data-uw-styling-context="true"><?= $member_posts['content_vi'] ?></textarea>
                    </div>
					<?php //if($member_posts['trangthai']  == 1 ){?>
                    <div class="frm_submit" style="text-align: center">
                        <?php //if ($member_posts['status'] == 'chopb' ) { ?>
                            <button class="frm_button_submit frm_final_submit" type="submit"
                                    formnovalidate="formnovalidate" name="submit" value="user"><?= _COMMENTARY_ARTICLE ?>
                            </button>
                        <?php //} ?>


                    </div>

					<?php //}?>
                </form>
            </div>

        </div>

    </div>

</div>

<script>
    function download(link) {
        window.location.href = link;
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
        .create(document.querySelector('#tacgia'), {

            toolbar: {
                items: [
                    'bold', 'italic'
                ]
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
        .create(document.querySelector('#noidungphanbien'), {

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

                    'bold', 'italic',


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
