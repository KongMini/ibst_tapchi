<?php
global $ariacms;
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general" data-toggle="tab">Thông tin chung</a></li>
                    <li><a href="#meta_info" data-toggle="tab">Thông tin meta SEO</a></li>
                    <li><a href="#settings" data-toggle="tab">Thông tin cấu hình</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <form class="form-horizontal"
                              action="index.php?module=<?= $_REQUEST["module"] ?>&task=web_information_edit"
                              id="frm_web_information_edit" method="POST" name="frm_profile_edit"
                              enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="name_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Tên công ty Tiếng
                                    Việt <span class="text-red">*</span> :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="name_vi"
                                           value="<?= $ariacms->web_information->name_vi ?>" name="name_vi"
                                           placeholder="Tên đầy đủ công ty Tiếng Việt" required/>
                                </div>
                                <label for="name_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Tên công ty Tiếng
                                    Anh :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="name_en" id="name_en" type="text"
                                           value="<?= $ariacms->web_information->name_en ?>"
                                           placeholder="Tên đầy đủ công ty Tiếng Anh"/>
                                </div>
                            </div>
                            <!--div class="form-group">
                <label for="slogan_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Slogan Tiếng Việt <span class="text-red">*</span> :</label>
                <div class="col-sm-4 col-md-4 col-lg-4">
                  <input type="text" class="form-control" id="slogan_vi" value="<?= $ariacms->web_information->slogan_vi ?>" name="slogan_vi" placeholder="Slogan đặc trưng của công ty Tiếng Việt" required />
                </div>
                <label for="slogan_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Slogan Tiếng Anh :</label>
                <div class="col-sm-4 col-md-4 col-lg-4">
                  <input class="form-control" name="slogan_en" id="slogan_en" type="text" value="<?= $ariacms->web_information->slogan_en ?>" placeholder="Slogan đặc trưng của công ty Tiếng Anh" />
                </div>
              </div-->
                            <div class="form-group">
                                <label for="address_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Địa chỉ Tiếng
                                    Việt <span class="text-red">*</span> :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="address_vi"
                                           value="<?= $ariacms->web_information->address_vi ?>" name="address_vi"
                                           placeholder="Địa chỉ của công ty Tiếng Việt" required/>
                                </div>
                                <label for="address_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Địa chỉ Tiếng
                                    Anh :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="address_en" id="address_en" type="text"
                                           value="<?= $ariacms->web_information->address_en ?>"
                                           placeholder="Địa chỉ của công ty Tiếng Anh"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hotline" class="col-sm-2 col-md-2 col-lg-2 control-label">Hotline :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="hotline"
                                           value="<?= $ariacms->web_information->hotline ?>" name="hotline"
                                           placeholder="Số điện thoại hotline của công ty"/>
                                </div>
                                <label for="phone" class="col-sm-2 col-md-2 col-lg-2 control-label">Điện thoại :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="phone" id="phone" type="text"
                                           value="<?= $ariacms->web_information->phone ?>"
                                           placeholder="Số điện thoại bàn hoặc tổng đài"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="brief_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">ISSN :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="brief_vi" id="brief_vi" type="text"
                                           value="<?= $ariacms->web_information->brief_vi ?>"
                                           placeholder="ISSN"/>

                                </div>
                                <label for="brief_en" class="col-sm-2 col-md-2 col-lg-2 control-label">DOI :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">

                                    <input class="form-control" name="brief_en" id="brief_en" type="text"
                                           value="<?= $ariacms->web_information->brief_en ?>"
                                           placeholder="DOI"/>

                                </div>
                            </div>
							<div class="form-group">
                                <label for="daidien_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Đại điện Tiếng việt :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="daidien_vi" id="daidien_vi" type="text"
                                           value="<?= $ariacms->web_information->daidien_vi ?>"
                                           placeholder="ISSN"/>

                                </div>
                                <label for="daidien_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Đại điện Tiếng anh :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">

                                    <input class="form-control" name="daidien_en" id="daidien_en" type="text"
                                           value="<?= $ariacms->web_information->daidien_en ?>"
                                           placeholder="DOI"/>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_email" class="col-sm-2 col-md-2 col-lg-2 control-label">Email
                                    :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="admin_email" class="form-control" name="admin_email" id="admin_email"
                                           value="<?= $ariacms->web_information->admin_email ?>"/>
                                </div>
                                <label for="fax" class="col-sm-2 col-md-2 col-lg-2 control-label">Fax :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="fax" class="form-control" name="fax" id="fax"
                                           value="<?= $ariacms->web_information->fax ?>"/>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="facebook" class="col-sm-2 col-md-2 col-lg-2 control-label">Facebook
                                    :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="facebook" class="form-control" name="facebook" id="facebook"
                                           value="<?= $ariacms->web_information->facebook ?>"/>
                                </div>
                                <label for="twitter" class="col-sm-2 col-md-2 col-lg-2 control-label">Twitter :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="twitter" class="form-control" name="twitter" id="twitter"
                                           value="<?= $ariacms->web_information->twitter ?>"/>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="youtube" class="col-sm-2 col-md-2 col-lg-2 control-label">Youtube :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="youtube" class="form-control" name="youtube" id="youtube"
                                           value="<?= $ariacms->web_information->youtube ?>"/>
                                </div>
                                <label for="instagram" class="col-sm-2 col-md-2 col-lg-2 control-label">Instagram
                                    :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="instagram" class="form-control" name="instagram" id="instagram"
                                           value="<?= $ariacms->web_information->instagram ?>"/>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-danger" name="sb_web_information_edit"
                                            value="web_information_edit">Cập nhật
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="meta_info">
                        <form class="form-horizontal"
                              action="index.php?module=<?= $_REQUEST["module"] ?>&task=web_information_edit"
                              id="frm_web_information_edit" method="POST" name="frm_profile_edit"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="meta_title_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Meta Title
                                    Tiếng Việt :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <textarea class="form-control" rows="3" name="meta_title_vi" id="meta_title_vi"
                                              placeholder="Meta Title Website Tiếng Việt"><?= $ariacms->web_information->meta_title_vi ?></textarea>
                                </div>
                                <label for="meta_title_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Meta Title
                                    Tiếng Anh :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <textarea class="form-control" rows="3" name="meta_title_en" id="meta_title_en"
                                              placeholder="Meta Title Website Tiếng Anh"><?= $ariacms->web_information->meta_title_en ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Meta
                                    Keyword Tiếng Việt :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <textarea class="form-control" rows="3" name="meta_keyword_vi" id="meta_keyword_vi"
                                              placeholder="Meta Keyword Website Tiếng Việt"><?= $ariacms->web_information->meta_keyword_vi ?></textarea>
                                </div>
                                <label for="meta_keyword_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Meta
                                    Keyword Tiếng Anh :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <textarea class="form-control" rows="3" name="meta_keyword_en" id="meta_keyword_en"
                                              placeholder="Meta Keyword Website Tiếng Anh"><?= $ariacms->web_information->meta_keyword_en ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="meta_description_vi" class="col-sm-2 col-md-2 col-lg-2 control-label">Meta
                                    Description Tiếng Việt :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <textarea class="form-control" rows="3" name="meta_description_vi"
                                              id="meta_description_vi"
                                              placeholder="Meta Description Website Tiếng Việt"><?= $ariacms->web_information->meta_description_vi ?></textarea>
                                </div>
                                <label for="meta_description_en" class="col-sm-2 col-md-2 col-lg-2 control-label">Meta
                                    Description Tiếng Anh :</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <textarea class="form-control" rows="3" name="meta_description_en"
                                              id="meta_description_en"
                                              placeholder="Meta Description Website Tiếng Anh"><?= $ariacms->web_information->meta_description_en ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-danger" name="sb_web_information_edit"
                                            value="web_information_edit">Cập nhật
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal"
                              action="index.php?module=<?= $_REQUEST["module"] ?>&task=web_information_edit"
                              id="frm_web_information_edit" method="POST" name="frm_profile_edit"
                              enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="mailserver_url" class="col-sm-2 col-md-2 col-lg-2 control-label">Mail Server
                                    URL:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="mailserver_url"
                                           value="<?= $ariacms->web_information->mailserver_url ?>"
                                           name="mailserver_url" placeholder="URL máy chủ mail" required/>
                                </div>
                                <label for="mailserver_login" class="col-sm-2 col-md-2 col-lg-2 control-label">Mail
                                    Server Login:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="mailserver_login" id="mailserver_login"
                                           type="text" value="<?= $ariacms->web_information->mailserver_login ?>"
                                           placeholder="Email đăng nhập Server"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mailserver_pass" class="col-sm-2 col-md-2 col-lg-2 control-label">Mail
                                    Server Pass:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="mailserver_pass"
                                           value="<?= $ariacms->web_information->mailserver_pass ?>"
                                           name="mailserver_pass" placeholder="Mật khẩu mail server" required/>
                                </div>
                                <label for="mailserver_port" class="col-sm-2 col-md-2 col-lg-2 control-label">Mail
                                    Server Port:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="mailserver_port" id="mailserver_port" type="text"
                                           value="<?= $ariacms->web_information->mailserver_port ?>"
                                           placeholder="Cổng mail server"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="posts_per_page" class="col-sm-2 col-md-2 col-lg-2 control-label">Bài viết
                                    mỗi trang<span class="text-red">*</span>:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="posts_per_page"
                                           value="<?= $ariacms->web_information->posts_per_page ?>"
                                           name="posts_per_page" placeholder="Số lượng bài viết tối đa mỗi trang"
                                           required/>
                                </div>
                                <label for="product_per_page" class="col-sm-2 col-md-2 col-lg-2 control-label">Sản phẩm
                                    mỗi trang<span class="text-red">*</span>:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="product_per_page" id="product_per_page"
                                           type="text" value="<?= $ariacms->web_information->product_per_page ?>"
                                           placeholder="Số lượng sản phẩm mỗi trang" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="admin_per_page" class="col-sm-2 col-md-2 col-lg-2 control-label">Phân trang
                                    Admin<span class="text-red">*</span>:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" class="form-control" id="admin_per_page"
                                           value="<?= $ariacms->web_information->admin_per_page ?>"
                                           name="admin_per_page" placeholder="Phân trang Admin" required/>
                                </div>
                                <label for="image_max_size" class="col-sm-2 col-md-2 col-lg-2 control-label">Kích thước
                                    ảnh tối đa:</label>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input class="form-control" name="image_max_size" id="image_max_size" type="text"
                                           value="<?= $ariacms->web_information->image_max_size ?>"
                                           placeholder="Đơn vị Mb"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-danger" name="sb_web_information_edit"
                                            value="web_information_edit">Cập nhật
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->

            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->

    </div><!-- /.row -->
</section><!-- /.content -->