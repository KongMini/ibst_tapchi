<?php

class View
{
    static function viewhome($taxonomies, $key)
    {
        global $ariacms;
        global $params;
        global $database;
        ?>
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
            <meta name="description"
                  content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>
            <meta name="keywords"
                  content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>"/>
            <meta property="og:title"
                  content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
            <meta property="og:description"
                  content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>
            <?= $ariacms->getBlock("head"); ?>

            <style>
                .hlw {
                    color: #c0262c;
                    font-weight: 700;
                }
            </style>
        </head>

        <?php
        // hàm tô đậm từ khóa
        function highlightWords($text, $word)
        {
            $text = preg_replace('#' . preg_quote($word) . '#i', '<span class="hlw">\\0</span>', $text);
            return $text;
        }

        if (!$ariacms->checkUserLogin()) {
            $lightbox = "uk-toggle";
            $url_login = '#modal-login';
            $url_post = '#modal-login';
        } else {
            $lightbox = "";
            $url_login = "javascript:;";
            $url_post = '/member/tao-bai-viet.html';
        }

        $query = "select post_id  from e4_post_like where member_id = " . $_SESSION["member"]['id'] . " ORDER BY id desc";
        $database->setQuery($query);
        $member_likes = $database->loadObjectList();

        $array_liked = array();
        foreach ($member_likes as $data_post) {
            array_push($array_liked, $data_post->post_id);
        }
        $array_liked = array_flip($array_liked);
        ?>

        <body  class="page-template page-template-page-contact page-template-page-contact-php page page-id-32 wp-custom-logo"
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


        <?= $ariacms->getBlock("header"); ?>
		
		<style>
			.grid-item {
				width: 100%;
				padding-bottom: 0%;
				margin-bottom: 0%;
				position: relative;
			}
			.card-interior{
				padding: 20px 0 0 0;
			}
			h2.entry-title a{
				font-size: 22px
			}
			.max-width{
				padding: 0 80px;
			}
			pre, blockquote, dl, figure, table, p, ul, ol, form {
				margin-bottom: 0.5rem;
			}
		</style>
		
        
        </div>
        <div class="border-top border-bottom main-content margin-below-sticky-header stripe-bg">
            <div class="flex-container page-header">
                <div class="flex-50">
                    <div class="heading-container-left "><h1 class="center-on-mobile"><i
                                    class="fa-solid fa-square-full"></i> <?= _RESULTS?></h1></div>
                </div>

            </div>
        </div>
		<div class="main-content">
            <div class="container">


                <div class="twelve columns">


                    <h3 style="text-align: center;cursor:pointer" onclick="search()" ><?= _ADVANCED_SEARCH ?></h3>

                    <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container" style="display:none;">
                        <form action="" method="post" class="frm-show-form  frm_pro_form "
                              id="form_footerslide-inform">
                            <div class="frm_form_fields ">
                                <fieldset>

                                    <div id="frm_field_7_container"
                                         class="frm_form_field form-field  frm_required_field frm_top_container frm_half frm_half">

                                        <input type="email" id="field_2hyqd" name="keysearch" value="<?= $key ?>">
                                    </div>

                                    <div class="frm_fields_container">

                                        <fieldset aria-labelledby="field_j4r0h_label">
                                            <legend class="frm_screen_reader frm_hidden">
                                                Name
                                            </legend>

                                            <div class="frm_combo_inputs_container" id="frm_combo_inputs_container_6"
                                                 data-name-layout="first_last">

                                                <div id="frm_field_6-first_container"
                                                     class="frm_form_field form-field frm_form_subfield-first  frm6"
                                                     data-sub-field-name="first">
                                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _AUTHOR_NAME?>
                                                        <span class="frm_required" aria-hidden="true">*</span>
                                                    </div>

                                                    <input type="text" id="field_j4r0h_first" value="<?= $_POST['author'];?>" name="author">

                                                </div>
                                                <div id="frm_field_6-last_container"
                                                     class="frm_form_field form-field frm_form_subfield-last  frm6"
                                                     data-sub-field-name="last">

                                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _KEY?>
                                                        <span class="frm_required" aria-hidden="true">*</span>
                                                    </div>
                                                    <input type="text" id="field_j4r0h_last" value="<?= $_POST['key_word'];?>" name="key_word">

                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="frm_fields_container">
                                        <fieldset aria-labelledby="field_j4r0h_label">
                                            <legend class="frm_screen_reader frm_hidden">
                                                Name
                                            </legend>

                                            <div class="frm_combo_inputs_container" id="frm_combo_inputs_container_6"
                                                 data-name-layout="first_last">

                                                <div id="frm_field_6-first_container"
                                                     class="frm_form_field form-field frm_form_subfield-first  frm6"
                                                     data-sub-field-name="first">
                                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _FROM?>
                                                        <span class="frm_required" aria-hidden="true">*</span>
                                                    </div>

                                                    <input type="date" id="field_j4r0h_first" value="<?= $_POST['from'];?>" name="from">

                                                </div>
                                                <div id="frm_field_6-last_container"
                                                     class="frm_form_field form-field frm_form_subfield-last  frm6"
                                                     data-sub-field-name="last">

                                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _TO?>
                                                        <span class="frm_required" aria-hidden="true">*</span>
                                                    </div>
                                                    <input type="date" id="field_j4r0h_last" value="<?= $_POST['to'];?>" name="to">

                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="frm_submit" style="text-align: center">

                                        <button class="frm_button_submit frm_final_submit" type="submit"
                                                formnovalidate="formnovalidate"><?= _SEARCH?>
                                        </button>

                                    </div>
                            </div>
                            </fieldset>
                    </div>
                    </form>
					
					<script>
						function search(){
							var style = document.getElementById('frm_form_2_container').style;
							if(style.display == 'none')
								style.display = 'block';
							else
								style.display = 'none';
						}
					</script>
				
				</div>
            </div>
        </div>
        <div class="white-band main-content">
            <div class="flex-container max-width">

                <?php if ($taxonomies) { ?>

                    <div class="grid-row">
                        <?php
                        foreach ($taxonomies as $new) {
                            ?>
                            <div class="grid-item center-on-mobile">
                                <div class="card-interior">
                                    <!--<p class="blog-date">March 23, 2022</p>-->
                                    <h2 class="entry-title"><a
                                                href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><?= $new->{$params->title} ?></a>
                                    </h2>
                                    <p class="excerpt"></p>
                                    <p><?= $new->{$params->tacgia} ?></p>
                                    <p></p>
                                    <p><a class=""
                                          href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><i
                                                    class="fa fa-caret-right" aria-hidden="true"></i><?=_SEE_DETAILS?></a>
                                    </p>
                                </div>

                            </div>
                        <?php } ?>


                    </div>
                <?php } else { ?>
                    <div class="row">

                        <div style="text-align:center">
                                <span>
                                    Không có kết quả tìm kiềm phù hợp
                                </span>
                        </div>

                    </div>
                <?php } ?>
            </div>


            <!-- This website is like a Rocket, isn't it? Performance optimized by WP Rocket. Learn more: https://wp-rocket.me -->
        </div>
        <?= $ariacms->getBlock("footer"); ?>
        <?= $ariacms->getBlock("footer_script"); ?>


        </body>

        </html>
        <?php
    }
}

?>