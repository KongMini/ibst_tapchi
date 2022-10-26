<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

global $database;
global $ariacms ;
$id = $_REQUEST['id'];
$query = "SELECT a.* FROM e4_tapchi a 
	WHERE a.type='post' and a.id = $id";
$database->setQuery($query);
$news_detail = $database->loadRow();

if(count($news_detail) == 0){
	$ariacms->redirect("", "javascript:history.back()");
}

$query = "SELECT * from e4_linhvuc where status='active'";
$database->setQuery($query);
$linhvuc = $database->loadObjectList();

$query = "SELECT * from e4_chude where status='active'";
$database->setQuery($query);
$chude = $database->loadObjectList();


$term_taxonomy_id_list = explode(",", $news_detail['term_taxonomy_id_list']);

$relation_id_list = explode(",", $news_detail['relation']);

$array_status = array('waiting'=>'Chờ duyệt','active'=>'Đã xuất bản','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');

$array_location = array(0=>'Tin thường',2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong');
?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h4 class="box-title">Cập nhật thông tin chi tiết</h4>
<div class="modal-dialog modal-wide">
	<form method="POST" action="?module=news&task=news_edit&id=<?php echo $id ?>" name="news_edit" id="news_edit" class="form-horizontal" enctype="multipart/form-data">
		<div class="modal-content">
			
			<div class="modal-body modal-scroll">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs hidden">
						<li class="active"><a aria-expanded="true" href="#info_general" data-toggle="tab">Thông tin chung <font class="text-red">*</font></a></li>
						<li><a aria-expanded="false" href="#info_other" data-toggle="tab">Thông tin SEO</a></li>
					</ul>
					<div class="tab-content">
					<div class="row">
													
													
													<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
														<div class="form-group row ">
															<div class="col-xs-6">
																<label >Tiêu đề Tiếng Việt<span class="text-red">*</span></label>
																<input class="form-control" name="title_vi" id="title_vi" placeholder="Tiêu đề..." type="text" required value="<?php echo $news_detail['title_vi']?>" />
															</div>
															<div class="col-xs-6">
																<label >Tiêu đề Tiếng Anh<span class="text-red">*</span></label>
																<input class="form-control" name="title_en" id="title_en" placeholder="Tiêu đề..." type="text" required value="<?php echo $news_detail['title_en']?>" />
															</div>
														</div>
														<div class="form-group">
															<div class="col-xs-6">
																<label>Giới thiệu Tiếng Việt<span class="text-red">*</span></label>
																<textarea class="form-control" rows="3" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..." required><?php echo $news_detail['brief_vi']?></textarea>
															</div>
															<div class="col-xs-6">
																<label>Giới thiệu Tiếng Anh<span class="text-red">*</span></label>
																<textarea class="form-control" rows="3" name="brief_en" id="brief_en" placeholder="Tóm tắt giới thiệu bản tin..." required><?php echo $news_detail['brief_en']?></textarea>
															</div>
														</div>
														<div class="form-group hidden">
															<div class="col-xs-12 col-md-6">
																<label>Lĩnh Vực <span class="text-red">*</span></label>
																<select class="form-control select2" id="" name="id_linhvuc" data-placeholder="Chọn danh mục..." style="width: 100%;">
																	<?php 
																	foreach ($linhvuc as $value) {?>
																		<option value="<?php echo $value->id?>" <?php if($news_detail['id_linhvuc'] == $value->id) echo "selected" ?>> <?php echo $value->title_vi?><option>
																	<?php }?>
																</select>
															</div>
																
															<div class="col-xs-12 col-md-6 hidden">
																<label >Chủ đề<span class="text-red">*<span></label>
																<select id="news_position" name="" class="form-control">
																	<option value="">- Chọn -</option>
																	<?php 
																	foreach ($chude as $value) {?>
																		<option value="<?php echo $value->id?>" <?php if($news_detail['id_chude'] == $value->id) echo "selected" ?>> <?php echo $value->title_vi?><option>
																	<?php }?>
																</select>
															</div>
														</div>
														<div class="form-group hidden">															
															<div class="col-xs-12 col-md-12">
																<label>Từ Khóa</label>
																<input class="form-control" name="" id="tukhoa" placeholder="Số tạp chí" type="text" value="<?php echo $news_detail['tukhoa']?>" />
															</div>
														
														</div>
													
													</div>
													
													<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
														<!-- <div class="form-group">
															<div class="col-xs-12 col-md-4">
																<label >Số tạp chí <span class="text-red"></span></label>
																<input class="form-control" name="sotapchi" id="sotapchi" placeholder="Số tạp chí" type="text" value="<?php echo $news_detail['sotapchi']?>" />
															</div>
															
															<div class="col-xs-12 col-md-4">
																<label >Năm tạp chí <span class="text-red"></span></label>
																<input class="form-control" name="namtapchi" id="namtapchi" type="text" value="<?php echo $news_detail['namtapchi']?>" />
															</div>
									
															<div class="col-xs-12 col-md-4">
																<label >Thời gian XB<span class="text-red"></span></label>
																<input class="form-control" name="" id="aproved_date" type="datetime-local" value="<?php echo $news_detail['post_created']?>" />
															</div>
														</div> -->
														
														<div class="form-group row">
															<label for="staticEmail" class="col-sm-4 col-xs-12 col-form-label">Ảnh đại diện<span class="text-red">*<span>
                                                            <?php if($news_detail['hinhdaidien']) $image_avatar = $news_detail['hinhdaidien']; else $image_avatar = '/upload/noimage.png';
															?>
															<img style="height:60px;" id="newImg" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="openPopupImg('Img')" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
															<div class="col-sm-8 col-xs-12">
																<input  name="hinhdaidien" class="form-control" id="Img" onchange="openPopupImg('Img')" value="<?php echo $news_detail['hinhdaidien']?>" accept="image/png, image/jpeg" required>
															</div>
														</div>
	

                                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                            <div class="form-group ">
                                                                <label>Nội dung tiếng việt<span class="text-red">*</span></label>
                                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_vi" id="content_vi" rows="50" required><?php echo $news_detail['content_vi']?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nội dung tiếng anh</label>
                                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                                    <textarea class="form-control" name="content_en" id="content_en" rows="50"><?php echo $news_detail['content_en']?></textarea>
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
													

														</div>
													</div>
													
												</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary" id="capnhat" name="submit" value="news_edit">Cập nhật</button>
						<?php if($_SESSION['user']['role_type'] == 'ADMIN' && $news_detail['post_status'] != 'active'){ ?>
							<button type="submit" class="btn btn-warning" id="xuatban" name="submit" value="xuatban">Xuất bản</button>
						<?php } ?>
						<?php if($_SESSION['user']['role_type'] == 'ADMIN' || $_SESSION['user']['role_type'] == 'CHECK'){?>
							<?php if($news_detail['post_status'] == 'active'){ // Nếu đã duyệt hiển thị nút gỡ, cập nhật ?>
							<button type="submit" class="btn btn-danger" id="gobaidang" name="submit" value="gobaidang">Gỡ bài</button>
							<?php }elseif($news_detail['post_status'] == 'waiting'){ // Nếu đang chờ duyệt thì hiển thị nút đăng, hủy, cập nhật ?>
							<button type="submit" class="btn btn-danger" id="tuchoi" name="submit" value="tuchoi">Từ chối</button>
							<?php }elseif($news_detail['post_status'] == 'deactive' || $news_detail['post_status'] == 'lock'){ // Nếu từ chối hiển thị nút duyệt tin trạng thái chờ, cập nhật ?>
							<button type="submit" class="btn btn-warning" id="choxuly" name="submit" value="choxuly">Chờ xử lý</button>
							<?php } ?>
						<?php } ?>
						<button type="button" class="btn btn-default " data-dismiss="modal">Đóng lại</button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</form>
</div><!-- /.modal-dialog -->
	<style>
		div.ck-editor__editable {
			height: 705px !important;
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
	</script>
<script>
	$(".select2").select2();
</script>

			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>