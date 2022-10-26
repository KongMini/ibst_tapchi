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
					<h4 class="box-title">Thêm mới bài viết</h4>
					<!--button class="btn btn-warning pull-right" data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/news/ajax.news_add.php');">Thêm mới <i class="fa fa-plus"></i></button>
				</div><!-- /.box-header -->
					
					<div class="modal-dialog modal-full">
						<form method="POST" action="?module=news&task=news_add" name="news_add" id="news_add" class="form-horizontal" enctype="multipart/form-data" >
							<div class="modal-content">
								
								<div class="modal-body modal-scroll">
									<div class="nav-tabs-custom">
										
										<div class="tab-content">
											<div class="active tab-pane" id="info_general">
												<div class="row">
													
												<input type="hidden" class="form-control" name="type" id="type" value="post" />
														
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
															<label>Giới thiệu Tiếng Việt<span class="text-red">*</span></label>
															<textarea class="form-control" rows="3" name="brief_vi" id="brief_vi" placeholder="Tóm tắt giới thiệu bản tin..." required></textarea>
														</div>
														<div class="col-xs-6">
															<label>Giới thiệu Tiếng Anh<span class="text-red">*</span></label>
															<textarea class="form-control" rows="3" name="brief_en" id="brief_en" placeholder="Tóm tắt giới thiệu bản tin..." required></textarea>
														</div>
													</div>
													<div class="form-group hidden">
														<div class="col-xs-12 col-md-6">
															<label>Lĩnh Vực <span class="text-red">*</span></label>
															<select class="form-control select2" id="id_linhvuc" name="" data-placeholder="Chọn danh mục..." style="width: 100%;" multiple="multiple">
																<?php 
																foreach ($linhvuc as $value) {?>
																	<option value="<?php echo $value->id?>"> <?php echo $value->title_vi?><option>
																<?php }?>
															</select>
														</div>
															
														<div class="col-xs-12 col-md-6">
															<label >Chủ đề<span class="text-red">*<span></label>
															<select id="news_position" name="" class="form-control" >
																<option value="">- Chọn -</option>
																<?php 
																foreach ($chude as $value) {?>
																	<option value="<?php echo $value->id?>"> <?php echo $value->title_vi?><option>
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
													<div class="form-group hidden">
														
														<div class="col-xs-12 col-md-12">
															<!--div class="form-group">
																<div class="col-xs-12">
																	<label >Từ khóa<span class="text-red">*</span></label>
																	<input class="form-control" name="tags" id="tags" placeholder="Từ khóa..." type="text" required value="" />
																</div>
															</div-->
															<label>Từ Khóa</label>
															<input class="form-control" name="" id="tukhoa" placeholder="Số tạp chí" type="text" value="" />
														</div>
													
													</div>
												
												</div>
												
												<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
													<!-- <div class="form-group">
														<div class="col-xs-12 col-md-4">
															<label >Số tạp chí <span class="text-red"></span></label>
															<input class="form-control" name="sotapchi" id="sotapchi" placeholder="Số tạp chí" type="text" value="" />
														</div>
														
														<div class="col-xs-12 col-md-4">
															<label >Năm tạp chí <span class="text-red"></span></label>
															<input class="form-control" name="namtapchi" id="namtapchi" type="text" value="" />
														</div>
								
														<div class="col-xs-12 col-md-4">
															<label >Thời gian XB<span class="text-red"></span></label>
															<input class="form-control" name="" id="aproved_date" type="datetime-local" value="<?php echo date('Y-m-d\TH:i') ?>" />
														</div>
													</div> -->
													
													<div class="form-group row">
														<label for="staticEmail" class="col-sm-4 col-xs-12 col-form-label">Ảnh đại diện<span class="text-red">*<span><?php
														$image_avatar = '/upload/noimage.png';
														?>
														<img style="height:60px;" id="newImg" txthide="image" class="choiceImg cursor " src="<?=$image_avatar?>" onclick="openPopupImg('Img')" data-toggle="tooltip" title="" data-original-title="Nhấn để chọn ảnh đại diện trên hệ thống"></label><!--fcall.fcChoiceImg(this);-->
														<div class="col-sm-8 col-xs-12">
															<input  name="hinhdaidien" class="form-control" id="Img" onclick="openPopupImg('Img')" accept="image/png, image/jpeg" required>
														</div>
													</div>

<!--													<div class="form-group row">-->
<!--														<label for="staticEmail" class="col-sm-4 col-xs-12 col-form-label">Bìa tạp chí<span class="text-red">*<span>-->
<!--														<button onclick="openPopup('biatapchi')" >Chọn File</button></label>
<!--														<div class="col-sm-8 col-xs-12">-->
<!--															<input  name="biatapchi" class="form-control" id="biatapchi" onchange="openPopup('biatapchi')" accept="image/png, image/jpeg" required>-->
<!--														</div>-->
<!--													</div>-->
<!--													<div class="form-group row">-->
<!--														<label for="staticEmail" class="col-sm-4 col-xs-12 col-form-label">Mục Lục<span class="text-red">*&emsp;<span>-->
<!--														<button onclick="openPopup('mucluc')" >Chọn File</button></label>
<!--														<div class="col-sm-8 col-xs-12">-->
<!--															<input  name="mucluc" class="form-control" id="mucluc" onchange="openPopup('biatapchi')" accept="image/png, image/jpeg" required>-->
<!--														</div>-->
<!--													</div>-->
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <div class="form-group ">
                                                            <label>Nội dung tiếng việt</label>
                                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                                <textarea class="form-control" name="content_vi" id="content_vi" rows="50"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
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
	
	<script>
		function getContent(){
			var url = $("#crawl").val();
			$('#ic-loading').show();
			$.ajax({
				url: "ajax/news/ajax.news_crawl.php",
				data: "url=" + url,
				cache: false, 
				context: document.body,
				success: function(data){
					$('#ic-loading').hide();
					$("#info_general").html(data);
				}
			});
		}
		
		
		
	</script>

			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>

						
