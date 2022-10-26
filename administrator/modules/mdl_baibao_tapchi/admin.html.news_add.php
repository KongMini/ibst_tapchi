<?php
global $ariacms;
global $database;
		// $query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a
		// LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent
		// GROUP BY a.id ORDER BY a.order ";
		// $database->setQuery($query);
		// $taxonomies = $database->loadObjectList();
	// $array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt');
	// $array_location = array(4=> 'Nổi bật trang chủ',3=> 'Tin chính trang chủ', 2=> 'Nổi bật trang trong', 1=>' Tin chính trang trong', 0=>'Tin thường');


	$query = "SELECT * from e4_linhvuc where status='active'";
	$database->setQuery($query);
	$linhvuc = $database->loadObjectList();

	$query = "SELECT * FROM `e4_baibao` WHERE status = 'active' GROUP BY mabaibao;";
	$database->setQuery($query);
	$mabaibao = $database->loadObjectList();

	$query = "SELECT * from e4_chude where status='active'";
	$database->setQuery($query);
	$chude = $database->loadObjectList();

	$query = "SELECT a.*, count(b.parent) sub FROM e4_term_taxonomy a 
	LEFT JOIN (SELECT parent FROM e4_term_taxonomy ) b ON a.id = b.parent 
	GROUP BY a.id ORDER BY a.order ";
	$database->setQuery($query);
	$taxonomies = $database->loadObjectList();

	$query1 = "SELECT a.id, a.title_vi FROM e4_posts a ORDER BY a.id DESC";
	$database->setQuery($query1);
	$postnews = $database->loadObjectList();

	$array_location = array(1=> 'Tin Top',2=> 'Tin tâm điểm', 0=>'Tin thường');
	$array_status = array('waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt');
	?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Thêm mới Tạp chí</h4>
					<!--button class="btn btn-warning pull-right" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/news/ajax.news_add.php');">Thêm mới <i class="fa fa-plus"></i></button>
				</div><!-- /.box-header -->

                    <div class="modal-dialog modal-full">
                        <form method="POST" action="?module=tapchi&task=news_add" name="news_add" id="news_add" class="form-horizontal" enctype="multipart/form-data" >
                            <div class="modal-content">

                                <div class="modal-body modal-scroll">
                                    <div class="nav-tabs-custom">

                                        <div class="tab-content">
                                            <div class="active tab-pane" id="info_general">
                                                <div class="row">
                                                    <input type="hidden" class="form-control" name="type" id="type" value="tapchi" />

                                                    <div class="col-xs-12 col-md-12">
                                                        <label >Mã bài báo<span class="text-red">*<span></label>
                                                        <select id="mabaibao"  class="form-control select2" onchange="crawl()">
                                                            <option value="">- Chọn -</option>
                                                            <?php
                                                            foreach ($mabaibao as $value) {?>
                                                                <option value="<?php echo $value->id?>"> <?php echo $value->mabaibao . "-" . $value->title_vi?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>



                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <div class="form-group row ">
                                                            <div class="col-xs-6">
                                                                <label >Tiêu đề Tiếng Việt<span class="text-red">*</span></label>
                                                                <input class="form-control" name="title_vi" id="title_vi" placeholder="Tiêu đề..." type="text" required value="" />
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label >Tiêu đề Tiếng Anh<span class="text-red">*</span></label>
                                                                <input class="form-control" name="title_en" id="title_en" placeholder="Tiêu đề..." type="text" required value="" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-6">
                                                                <label>Tóm tắt Tiếng Việt<span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="3" name="brief_vi" id="brief_vi" placeholder="Tóm tắt bản tin..." ></textarea>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label>Tóm tắt Tiếng Anh<span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="3" name="brief_en" id="brief_en" placeholder="Tóm tắt bản tin..." ></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row ">
                                                            <div class="col-xs-6">
                                                                <label >Tác giả Tiếng Việt<span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="3" name="tacgia_vi" id="tacgia_vi" placeholder="Tác giả Tiếng Việt..." ></textarea>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label >Tác giả Tiếng Anh<span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="3" name="tacgia_en" id="tacgia_en" placeholder="Tác giả Tiếng Anh..." ></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-xs-12 col-md-6">
                                                                <label>Số tạp chí <span class="text-red">*</span></label>
                                                                <select class="form-control select2" id="id_linhvuc" name="id_linhvuc" data-placeholder="Chọn số..." style="width: 100%;">
                                                                    <?php
                                                                    foreach ($linhvuc as $value) {?>
                                                                        <option value="<?php echo $value->id?>"> <?php echo $value->title_vi . '-'. $value->nam?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>

                                                            <div class="col-xs-12 col-md-6">
                                                                <label >Chủ đề<span class="text-red">*<span></label>
                                                                <select id="news_position" name="id_chude" class="form-control" required>
                                                                    <option value="">- Chọn -</option>
                                                                    <?php
                                                                    foreach ($chude as $value) {?>
                                                                        <option value="<?php echo $value->id?>"> <?php echo $value->title_vi?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <!--div class="col-xs-12 col-md-6">
															<label>Quản lý chuyên đề - topic</label>
															<select class="form-control " id="topic" name="taxonomy[]"  data-placeholder="Chọn chuyên đề..." >
																<?php
                                                            foreach ($taxonomies as $taxonomy) {
                                                                if ($taxonomy->taxonomy == 'topic' && $taxonomy->parent == 0) {
                                                                    $selected = (in_array($taxonomy->id, $term_taxonomy_id_list)) ? 'selected' : '';
                                                                    echo '<option '. $selected .' value="' . $taxonomy->id . '">' . $taxonomy->title_vi . '</option>';

                                                                }
                                                            }
                                                            ?>
															</select>
														</div-->

                                                        </div>
                                                        <div class="form-group">

                                                            <div class="col-xs-12 col-md-6">
                                                                <label>Từ khóa Tiếng Việt</label>
                                                                <input class="form-control" name="tukhoa_vi" id="tukhoa_vi" placeholder="Từ khóa" type="text" value="" />
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">
                                                                <label>Từ khóa Tiếng Anh</label>
                                                                <input class="form-control" name="tukhoa_en" id="tukhoa_en" placeholder="Từ khóa" type="text" value="" />
                                                            </div>

                                                        </div>
                                                        <div class="form-group">

                                                            <div class="col-xs-12 col-md-6">
                                                                <label>Tài liệu tham khảo Tiếng Việt</label>
                                                                <textarea  class="form-control" name="tailieuthamkhao_vi" id='tailieuthamkhao_vi'  placeholder="Tài liệu tham khảo"></textarea>
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">

                                                                <label>Tài liệu tham khảo Tiếng Anh</label>
                                                                <textarea  class="form-control" name="tailieuthamkhao_en" id='tailieuthamkhao_en'  placeholder="Tài liệu tham khảo"></textarea>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
                                                        <div class="form-group hidden">


                                                            <div class="col-xs-12 col-md-4 ">
                                                                <label >Năm tạp chí <span class="text-red"></span></label>
                                                                <input class="form-control" name="namtapchi" id="namtapchi" type="text" value="" />
                                                            </div>

                                                            <div class="col-xs-12 col-md-4">
                                                                <label >Thời gian XB<span class="text-red"></span></label>
                                                                <input class="form-control" name="" id="aproved_date" type="datetime-local" value="<?php echo date('Y-m-d\TH:i') ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row ">
                                                            <div class="col-xs-6">
                                                                <label >File Tiếng Việt<span class="text-red">*</span></label>
                                                                <input class="form-control" name="file_vi" onclick="openPopup('file_vi')" id="file_vi" placeholder="file..." type="text" required value="<?php echo $news_detail['file']?>" />
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label >File Tiếng Anh</label>
                                                                <input class="form-control" name="file_en" onclick="openPopup('file_en')" id="file_en" placeholder="file..." type="text"  value="<?php echo $news_detail['file_en']?>" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class=" col-xs-12 col-md-6">
                                                                <label>Nội dung tiếng việt</label>
                                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_vi" id="content_vi" rows="50"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class=" col-xs-12 col-md-6">
                                                                <label>Nội dung tiếng anh</label>
                                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_en" id="content_en" rows="50"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <script>
                                                            function openPopupImg(id) {
                                                                CKFinder.popup( {
                                                                    chooseFiles: true,
                                                                    onInit: function( finder ) {
                                                                        finder.on( 'files:choose', function( evt ) {
                                                                            var file = evt.data.files.first();
                                                                            document.getElementById( id ).value = file.getUrl();
                                                                            document.getElementById( "new" + id ).src = file.getUrl();
                                                                        } );
                                                                        finder.on( 'file:choose:resizedImage', function( evt ) {
                                                                            document.getElementById( id ).value = evt.data.resizedUrl;

                                                                        } );
                                                                    }
                                                                } );
                                                            }
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

                                                        <script>
                                                            function chooseImg(){
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

                                                        <div class="form-group hidden">
                                                            <div class="col-xs-12 col-md-12">
                                                                <label>Tin liên quan</label>
                                                                <select class="form-control select2" id="category_id" name="" data-placeholder="Chọn tin liên quan..." style="width: 100%;" multiple="multiple">
                                                                    <?php
                                                                    foreach ($postnews as $postnew) {
                                                                        $selected = '';
                                                                        echo '<option '. $selected .' value="' . $postnew->id . '">' . $postnew->title_vi . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group hidden">
                                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                                                <input class="form-control" name="" placeholder="SEO: Từ khóa" id="meta_keyword" type="text" value="" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group hidden">
                                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                                                <textarea class="form-control" rows="3" name="" id="meta_description" placeholder="SEO: Mô tả..."></textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <!--button type="submit" class="btn btn-primary" name="submit" value="news_add">Thêm mới</button-->
                                            <?php if($_SESSION['user']['role_type'] == 'ADMIN' && $news_detail['post_status'] != 'active'){ ?>
                                                <button type="submit" class="btn btn-danger" id="xuatban" name="submit" value="xuatban">Xuất bản</button>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-warning" name="submit" value="xuatban">Chờ xuất bản</button>
                                            <button type="submit" class="btn btn-success" name="submit" value="choduyet">Chờ kiểm duyệt</button>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </form>
                    </div><!-- /.modal-dialog -->

                    <style>
                        div.ck-editor__editable {
                            min-height: 100px !important;

                        }
                    </style>


                    <script src="<?=$ariacms->actual_link ?>plugins/editor/ckeditor5-35/build/ckeditor.js"></script>
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
                            .create( document.querySelector( '#brief_vi' ), {

                                toolbar: {
                                    items: [

                                        'bold',
                                        'link',
                                        'italic',
													
										'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',

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
                            .create( document.querySelector( '#brief_en' ), {

                                toolbar: {
                                    items: [

                                        'bold',
                                        'link',
                                        'italic',
										
										'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',

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
                            } );ClassicEditor
                            .create( document.querySelector( '#tacgia_vi' ), {

                                toolbar: {
                                    items: [ 'bold','italic', 'subscript', 'superscript' ]
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
                            .create( document.querySelector( '#tacgia_en' ), {

                                toolbar: {
                                    items: [ 'bold','italic', 'subscript', 'superscript']
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
                            .create( document.querySelector( '#content_vi' ), {

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
                            .create( document.querySelector( '#content_en' ), {

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
                            .create( document.querySelector( '#tailieuthamkhao_vi' ), {

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
                            .create( document.querySelector( '#tailieuthamkhao_en' ), {

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
                    </script>

	<script>
        $(".select2").select2();
    </script>
    <script type="text/javascript">
        function crawl() {
            var mabaibao = document.getElementById('mabaibao').value;
            var f = "id=" + mabaibao;
            var _url = "ajax/baibao_tapchi/ajax.news_crawl.php?" + f;
            //alert(_url);
            $.ajax({
                url: _url,
                data: f,
                cache: false,
                context: document.body,
                success: function (data) {
                    $("#info_general").html(data);

                    $(".select2").select2();

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
                            .create( document.querySelector( '#tailieuthamkhao_en' ), {

                                toolbar: {
                                    items: [

                                        'bold',
                                        'link',
                                        'italic',
										'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',

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
                            } );ClassicEditor
                            .create( document.querySelector( '#tailieuthamkhao_vi' ), {

                                toolbar: {
                                    items: [

                                        'bold',
                                        'link',
                                        'italic',
										'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',

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
                        .create( document.querySelector( '#brief_vi' ), {

                            toolbar: {
                                items: [

                                    'bold',
                                    'link',
                                    'italic',
									'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',

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
                        .create( document.querySelector( '#brief_en' ), {

                            toolbar: {
                                items: [

                                    'bold',
                                    'link',
                                    'italic',
									'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',

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
                        } );ClassicEditor
                        .create( document.querySelector( '#tacgia_vi' ), {

                            toolbar: {
                                items: [ 'bold','italic', 'subscript', 'superscript']
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
                        .create( document.querySelector( '#tacgia_en' ), {

                            toolbar: {
                                items: [ 'bold','italic', 'subscript', 'superscript' ]
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
                        .create( document.querySelector( '#content_vi' ), {

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
                        .create( document.querySelector( '#content_en' ), {

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
                        .create( document.querySelector( '#tailieuthamkhao_vi' ), {

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
                        .create( document.querySelector( '#tailieuthamkhao_en' ), {

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
                }
            })
        }
    </script>

                    <script type="text/javascript">
                        // function crawl() {
                        //     var mabaibao = document.getElementById('mabaibao').value;
                        //     var f = "id=" + mabaibao;
                        //     var _url = "ajax/baibao_tapchi/ajax.news_crawl.php?" + f;
                        //     alert(_url);
                        //     $.ajax({
                        //         url: _url,
                        //         data: f,
                        //         cache: false,
                        //         context: document.body,
                        //         success: function (data) {
                        //             $("#info_general").html(data);
                        //             const customColorPalette = [
                        //                 {
                        //                     color: 'hsl(4, 90%, 58%)',
                        //                     label: 'Red'
                        //                 },
                        //                 {
                        //                     color: 'hsl(340, 82%, 52%)',
                        //                     label: 'Pink'
                        //                 },
                        //                 {
                        //                     color: 'hsl(291, 64%, 42%)',
                        //                     label: 'Purple'
                        //                 },
                        //                 {
                        //                     color: 'hsl(262, 52%, 47%)',
                        //                     label: 'Deep Purple'
                        //                 },
                        //                 {
                        //                     color: 'hsl(231, 48%, 48%)',
                        //                     label: 'Indigo'
                        //                 },
                        //                 {
                        //                     color: 'hsl(207, 90%, 54%)',
                        //                     label: 'Blue'
                        //                 },
                        //
                        //                 // ...
                        //             ];
                        //
                        //             ClassicEditor
                        //                 .create( document.querySelector( '#content_vi' ), {
                        //
                        //                     toolbar: {
                        //                         items: [
                        //                             'CKFinder',"|",
                        //                             'heading',
                        //                             'bold',
                        //                             'link',
                        //                             'italic',
                        //                             '|',
                        //                             'blockQuote',
                        //                             'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                        //                             'insertTable',
                        //                             'undo',
                        //                             'redo',
                        //
                        //                             'bulletedList',
                        //                             'numberedList',
                        //                             'mediaEmbed',
                        //                             'fontBackgroundColor',
                        //                             'fontColor',
                        //                             'fontSize',
                        //                             'fontFamily',
                        //
                        //                         ]
                        //                     },
                        //                     language: 'vi',
                        //                     image: {
                        //                         toolbar: [
                        //                             'imageTextAlternative',
                        //                             'imageStyle:full',
                        //                             'imageStyle:side'
                        //                         ]
                        //                     },
                        //                     table: {
                        //                         contentToolbar: [
                        //                             'tableColumn', 'tableRow', 'mergeTableCells',
                        //                             'tableProperties', 'tableCellProperties'
                        //                         ],
                        //
                        //                         // Set the palettes for tables.
                        //                         tableProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         },
                        //
                        //                         // Set the palettes for table cells.
                        //                         tableCellProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         }
                        //                     },
                        //                     licenseKey: '',
                        //
                        //
                        //                 } )
                        //                 .then( editor => {
                        //                     window.editor = editor;
                        //
                        //                 } )
                        //                 .catch( error => {
                        //                     console.error( 'Oops, something went wrong!' );
                        //                     console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                        //                     console.warn( 'Build id: v10wxmoi2tig-mwzdvmyjd96s' );
                        //                     console.error( error );
                        //                 } );
                        //         }
						// 		ClassicEditor
                        //                 .create( document.querySelector( '#content_en' ), {
                        //
                        //                     toolbar: {
                        //                         items: [
                        //                             'CKFinder',"|",
                        //                             'heading',
                        //                             'bold',
                        //                             'link',
                        //                             'italic',
                        //                             '|',
                        //                             'blockQuote',
                        //                             'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                        //                             'insertTable',
                        //                             'undo',
                        //                             'redo',
                        //
                        //                             'bulletedList',
                        //                             'numberedList',
                        //                             'mediaEmbed',
                        //                             'fontBackgroundColor',
                        //                             'fontColor',
                        //                             'fontSize',
                        //                             'fontFamily',
                        //
                        //                         ]
                        //                     },
                        //                     language: 'vi',
                        //                     image: {
                        //                         toolbar: [
                        //                             'imageTextAlternative',
                        //                             'imageStyle:full',
                        //                             'imageStyle:side'
                        //                         ]
                        //                     },
                        //                     table: {
                        //                         contentToolbar: [
                        //                             'tableColumn', 'tableRow', 'mergeTableCells',
                        //                             'tableProperties', 'tableCellProperties'
                        //                         ],
                        //
                        //                         // Set the palettes for tables.
                        //                         tableProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         },
                        //
                        //                         // Set the palettes for table cells.
                        //                         tableCellProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         }
                        //                     },
                        //                     licenseKey: '',
                        //
                        //
                        //                 } )
                        //                 .then( editor => {
                        //                     window.editor = editor;
                        //
                        //                 } )
                        //                 .catch( error => {
                        //                     console.error( 'Oops, something went wrong!' );
                        //                     console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                        //                     console.warn( 'Build id: v10wxmoi2tig-mwzdvmyjd96s' );
                        //                     console.error( error );
                        //                 } );
                        //         }
						// 		ClassicEditor
                        //                 .create( document.querySelector( '#tailieuthamkhao_vi' ), {
                        //
                        //                     toolbar: {
                        //                         items: [
                        //                             'CKFinder',"|",
                        //                             'heading',
                        //                             'bold',
                        //                             'link',
                        //                             'italic',
                        //                             '|',
                        //                             'blockQuote',
                        //                             'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                        //                             'insertTable',
                        //                             'undo',
                        //                             'redo',
                        //
                        //                             'bulletedList',
                        //                             'numberedList',
                        //                             'mediaEmbed',
                        //                             'fontBackgroundColor',
                        //                             'fontColor',
                        //                             'fontSize',
                        //                             'fontFamily',
                        //
                        //                         ]
                        //                     },
                        //                     language: 'vi',
                        //                     image: {
                        //                         toolbar: [
                        //                             'imageTextAlternative',
                        //                             'imageStyle:full',
                        //                             'imageStyle:side'
                        //                         ]
                        //                     },
                        //                     table: {
                        //                         contentToolbar: [
                        //                             'tableColumn', 'tableRow', 'mergeTableCells',
                        //                             'tableProperties', 'tableCellProperties'
                        //                         ],
                        //
                        //                         // Set the palettes for tables.
                        //                         tableProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         },
                        //
                        //                         // Set the palettes for table cells.
                        //                         tableCellProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         }
                        //                     },
                        //                     licenseKey: '',
                        //
                        //
                        //                 } )
                        //                 .then( editor => {
                        //                     window.editor = editor;
                        //
                        //                 } )
                        //                 .catch( error => {
                        //                     console.error( 'Oops, something went wrong!' );
                        //                     console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                        //                     console.warn( 'Build id: v10wxmoi2tig-mwzdvmyjd96s' );
                        //                     console.error( error );
                        //                 } );
                        //         }
						// 		ClassicEditor
                        //                 .create( document.querySelector( '#tailieuthamkhao_en' ), {
                        //
                        //                     toolbar: {
                        //                         items: [
                        //                             'CKFinder',"|",
                        //                             'heading',
                        //                             'bold',
                        //                             'link',
                        //                             'italic',
                        //                             '|',
                        //                             'blockQuote',
                        //                             'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify',
                        //                             'insertTable',
                        //                             'undo',
                        //                             'redo',
                        //
                        //                             'bulletedList',
                        //                             'numberedList',
                        //                             'mediaEmbed',
                        //                             'fontBackgroundColor',
                        //                             'fontColor',
                        //                             'fontSize',
                        //                             'fontFamily',
                        //
                        //                         ]
                        //                     },
                        //                     language: 'vi',
                        //                     image: {
                        //                         toolbar: [
                        //                             'imageTextAlternative',
                        //                             'imageStyle:full',
                        //                             'imageStyle:side'
                        //                         ]
                        //                     },
                        //                     table: {
                        //                         contentToolbar: [
                        //                             'tableColumn', 'tableRow', 'mergeTableCells',
                        //                             'tableProperties', 'tableCellProperties'
                        //                         ],
                        //
                        //                         // Set the palettes for tables.
                        //                         tableProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         },
                        //
                        //                         // Set the palettes for table cells.
                        //                         tableCellProperties: {
                        //                             borderColors: customColorPalette,
                        //                             backgroundColors: customColorPalette
                        //                         }
                        //                     },
                        //                     licenseKey: '',
                        //
                        //
                        //                 } )
                        //                 .then( editor => {
                        //                     window.editor = editor;
                        //
                        //                 } )
                        //                 .catch( error => {
                        //                     console.error( 'Oops, something went wrong!' );
                        //                     console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                        //                     console.warn( 'Build id: v10wxmoi2tig-mwzdvmyjd96s' );
                        //                     console.error( error );
                        //                 } );
                        //         }
                        //     });
                        // }
                    </script>

			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>

						
