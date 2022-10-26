<?php

class View
{
    static function viewhome()
    {
        global $ariacms;
        global $params;
        global $analytics_code;
        ?>


        <!doctype html>
        <html lang="en-US">

        <!-- Mirrored from www.dangilroy.com/contact/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Jul 2022 04:26:35 GMT -->
        <!-- Added by HTTrack -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
        <title><?= _CONTACT ?>
            | <?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>

        <?= $ariacms->getBlock("head"); ?>
        <body class="page-template page-template-page-contact page-template-page-contact-php page page-id-32 wp-custom-logo"
              id="page-top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-dark-grayscale">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0 0.49803921568627"/>
                        <feFuncG type="table" tableValues="0 0.49803921568627"/>
                        <feFuncB type="table" tableValues="0 0.49803921568627"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-grayscale">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0 1"/>
                        <feFuncG type="table" tableValues="0 1"/>
                        <feFuncB type="table" tableValues="0 1"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-purple-yellow">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0.54901960784314 0.98823529411765"/>
                        <feFuncG type="table" tableValues="0 1"/>
                        <feFuncB type="table" tableValues="0.71764705882353 0.25490196078431"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-blue-red">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0 1"/>
                        <feFuncG type="table" tableValues="0 0.27843137254902"/>
                        <feFuncB type="table" tableValues="0.5921568627451 0.27843137254902"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-midnight">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0 0"/>
                        <feFuncG type="table" tableValues="0 0.64705882352941"/>
                        <feFuncB type="table" tableValues="0 1"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-magenta-yellow">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0.78039215686275 1"/>
                        <feFuncG type="table" tableValues="0 0.94901960784314"/>
                        <feFuncB type="table" tableValues="0.35294117647059 0.47058823529412"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-purple-green">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0.65098039215686 0.40392156862745"/>
                        <feFuncG type="table" tableValues="0 1"/>
                        <feFuncB type="table" tableValues="0.44705882352941 0.4"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none"
             style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
            <defs>
                <filter id="wp-duotone-blue-orange">
                    <feColorMatrix color-interpolation-filters="sRGB" type="matrix"
                                   values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 "/>
                    <feComponentTransfer color-interpolation-filters="sRGB">
                        <feFuncR type="table" tableValues="0.098039215686275 1"/>
                        <feFuncG type="table" tableValues="0 0.66274509803922"/>
                        <feFuncB type="table" tableValues="0.84705882352941 0.41960784313725"/>
                        <feFuncA type="table" tableValues="1 1"/>
                    </feComponentTransfer>
                    <feComposite in2="SourceGraphic" operator="in"/>
                </filter>
            </defs>
        </svg>
        <!-- STICKY HEADER
        ================================================== -->
        <?= $ariacms->getBlock("header"); ?>


        <!-- MAIN CONTENT
        ================================================== -->

        <div class="main-content" style="margin-top: 50px">
            <div class="container">


                <div class="four columns">


                    <div class="portfolio-testimonial" id="sidebar-list">
                        <h1><?= $ariacms->web_information->{$params->name} ?></h1>
                        <div class="hr-box-left">
                            <div class="hr-box-sm outer"></div>
                            <div class="hr-box-sm inner"></div>
                            <div class="hr-box-sm middle"></div>
                            <div class="hr-box-sm inner"></div>
                            <div class="hr-box-sm outer"></div>
                        </div>
                        <strong><i class="fa fa-map-marker"></i><?= _ADDRESS ?>:</strong>
                            <span itemprop="address" >
                                <?= $ariacms->web_information->{$params->address} ?>
                            </span>

                        <p><strong> <i class="fa fa-phone"></i> <?= _PHONE ?>:</strong>
                            <span itemprop="telephone"><?= $ariacms->web_information->hotline ?>:</span></p>

                        <p><strong><i class="fa fa-envelope"></i></i>Email</strong>
                            <a href="#" data-enc-email="uryyb[at]qnatvyebl.pbz" class="mail-link"
                               data-wpel-link="ignore"><?= $ariacms->web_information->admin_email ?></a></p>

                        <p>
                            <strong style="font-size: 20px;">
                                <a href="<?= $ariacms->web_information->facebook ?>"><i class="fa fa-facebook"
                                                                                        aria-hidden="true"></i></a>

                                <a href="<?= $ariacms->web_information->youtube ?>"><i class="fa fa-youtube"
                                                                                       aria-hidden="true"></i></a>

                                <a href="<?= $ariacms->web_information->instagram ?>"> <i class="fa fa-instagram"
                                                                                          aria-hidden="true"></i></a>
                            </strong>
                        </p>


                    </div>
                </div>

                <div class="eight columns">


                    <h2><?= _CONTACT ?></h2>

                    <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_3_container">

                        <form enctype="multipart/form-data" method="post" class="frm-show-form  frm_pro_form ">
                            <div class="frm_form_fields ">
                                <fieldset>
                                    <legend class="frm_screen_reader">Quick Contact Form</legend>
                                    <h3 class="frm_form_title">Quick Contact Form</h3>
                                    <div class="frm_fields_container">
                                        <input type="hidden" name="frm_action" value="create"/>
                                        <input type="hidden" name="form_id" value="3"/>
                                        <input type="hidden" name="frm_hide_fields_3" id="frm_hide_fields_3" value=""/>
                                        <input type="hidden" name="form_key" value="footerslide-inform6de04614f7"/>
                                        <input type="hidden" name="item_meta[0]" value=""/>
                                        <input type="hidden" id="frm_submit_entry_3" name="frm_submit_entry_3"
                                               value="aaed40b75c"/><input type="hidden" name="_wp_http_referer"
                                                                          value="/contact/"/>
                                        <div id="frm_field_22_container"
                                             class="frm_form_field form-field  frm_required_field frm_top_container">
                                            <div class="frm_primary_label"><?= _FULLNAME?>
                                                <span class="frm_required" aria-hidden="true">*</span>
                                            </div>
                                            <input type="name" name="txtName" style="width: 100%"/>
                                        </div>
                                        <div id="frm_field_23_container"
                                             class="frm_form_field form-field  frm_required_field frm_top_container frm_half frm_half">
                                            <label for="field_2hyqd8e93778c92" id="field_2hyqd8e93778c92_label"
                                                   class="frm_primary_label">Email
                                                <span class="frm_required" aria-hidden="true">*</span>
                                            </label>
                                            <input type="email" name="txtEmail"/>


                                        </div>
                                        <div id="frm_field_24_container"
                                             class="frm_form_field form-field  frm_required_field frm_top_container frm_half frm_half">
                                            <label for="field_85ycmc4bbf5c986" id="field_85ycmc4bbf5c986_label"
                                                   class="frm_primary_label"><?= _PHONE ?>
                                                <span class="frm_required" aria-hidden="true">*</span>
                                            </label>
                                            <input type="tel" name="txtPhone" data-reqmsg="This field cannot be blank."
                                                   aria-required="true" data-invmsg="Number is invalid"
                                                   aria-invalid="false"
                                                   pattern="((\+\d{1,3}(-|.| )?\(?\d\)?(-| |.)?\d{1,5})|(\(?\d{2,6}\)?))(-|.| )?(\d{3,4})(-|.| )?(\d{4})(( x| ext)\d{1,5}){0,1}$"/>


                                        </div>
                                        <div id="frm_field_34_container"
                                             class="frm_form_field form-field  frm_required_field frm_top_container">
                                            <label for="field_5f5qrc7a23293b7" id="field_5f5qrc7a23293b7_label"
                                                   class="frm_primary_label"><?= _CONTENT?>
                                                <span class="frm_required" aria-hidden="true">*</span>
                                            </label>
                                            <textarea name="txtContent" rows="5"
                                                      data-reqmsg="This field cannot be blank." aria-required="true"
                                                      data-invmsg="What can you tell us about your project? is invalid"
                                                      aria-invalid="false"></textarea>


                                        </div>
                                        <!-- <div id="frm_field_35_container" class="frm_form_field form-field  frm_none_container">
                                            <label for="g-recaptcha-response" id="field_n72cd2e1a2c463_label" class="frm_primary_label">reCAPTCHA
                                                <span class="frm_required" aria-hidden="true"></span>
                                            </label>
                                            <div id="field_n72cd2e1a2c463" class="frm-g-recaptcha" data-sitekey="6Lfxcf0eAAAAAF7NWBzAlU9M9pO6tj9BAWGcjH4i" data-size="normal" data-theme="light"></div>


                                        </div> -->
                                        <input type="hidden" name="item_key" value=""/>


                                        <button class="frm_button_submit frm_final_submit" type="submit"
                                                name="btnSubmit" value="contact" formnovalidate="formnovalidate"><?= _SUBMIT?>
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

        <!-- REVIEWS
        ================================================== -->


        <!-- PAGE BOTTOM
        ================================================== -->

        <?= $ariacms->getBlock("footer"); ?>

        <?= $ariacms->getBlock("footer_script"); ?>
        </body>

        <!-- Mirrored from www.dangilroy.com/contact/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Jul 2022 04:26:37 GMT -->
        </html>

        <!-- This website is like a Rocket, isn't it? Performance optimized by WP Rocket. Learn more: https://wp-rocket.me -->
        <?php
    }
}

?>