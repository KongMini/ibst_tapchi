<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;
	$query = "SELECT * FROM `e4_users` where `id` = ". $_SESSION['member']['id'];
	$database->setQuery($query);
	$user = $database->loadRow();
	
	//echo Date("Y-m-d",$user["ngaysinh"]);
	
	$query = "select post_id  from e4_post_like where member_id = ".$_SESSION["member"]['id']." ORDER BY id desc";
	$database->setQuery($query);
	$member_likes = $database->loadObjectList();

	$array_liked = array();
	foreach($member_likes as $key){
		array_push($array_liked,$key->post_id);
	}
	$array_liked = array_flip($array_liked);
	//print_r($array_liked);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
	<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
	<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
	
	<meta property="og:site_name" content="<?= $ariacms->web_information->{$params->name} ?>" />
	<meta property="og:url" content="<?= $ariacms->c_url ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>

	<?= $ariacms->getBlock("head"); ?>

</head>

    <body class="home page-template-default page page-id-7 wp-custom-logo" id="page-top">
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


    <div class="main-content" style="margin: 50px 0 0 0">
        <div class="container" style='width: 60%'>


            <div class="twelve columns">


                <h3 style="text-align: center"><?= _YOUR_PROFILE ?></h3>

                <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                    <form action="" method="post"
                          class="frm-show-form  frm_pro_form "
                          id="form_footerslide-inform">
                        <div class="frm_form_fields ">
                            <fieldset>



                                <div id="frm_field_6-first_container"
                                     class="frm_form_field form-field frm_form_subfield-first  frm6"
                                     data-sub-field-name="first">
                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _FULLNAME ?>:
                                        <span class="frm_required" aria-hidden="true">*</span>
                                    </div>

                                    <input type="email" id="field_j4r0h_first" required
                                           name="fullname" value="<?= $_SESSION['member']['fullname']?>">

                                </div>
                                <div id="frm_field_7-last_container"
                                     class="frm_form_field form-field frm_form_subfield-last  frm6"
                                     data-sub-field-name="last">

                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _PHONE ?>
                                        <span class="frm_required" aria-hidden="true">*</span>
                                    </div>
                                    <input type="text" id="field_j4r0h_last" required
                                           name="homephone" value="<?= $_SESSION['member']['homephone']?>">

                                </div>

                                <div id="frm_field_15_container"
                                     class="frm_form_field form-field  frm_required_field frm_top_container">
                                    <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _DEGREE ?>
                                        <span class="frm_required" aria-hidden="true">*</span>
                                    </label>
                                    <select required name="hocvi" id="field_8idq4" data-frmval="Select An Answer"
                                            data-reqmsg="This field cannot be blank." aria-required="true"
                                            data-invmsg="Which statement best describes where you are in the project process? is invalid"
                                            aria-invalid="false">
                                        <option value="">Học vị</option>
                                        <option value="GS" <?php if( $_SESSION['member']['hocvi'] == 'GS') echo " selected"?>>Giáo sư</option>
                                        <option value="PGS" <?php if( $_SESSION['member']['hocvi'] == 'PGS') echo " selected"?>>Phó giáo sư</option>
                                        <option value="TS" <?php if( $_SESSION['member']['hocvi'] == 'TS') echo " selected"?>>Tiến sĩ</option>
                                    </select>


                                </div>

                                <div id="frm_field_6-first_container"
                                     class="frm_form_field form-field frm_form_subfield-first  frm6"
                                     data-sub-field-name="first">
                                    <div id="field_j4r0h_label" class="frm_primary_label">Email:
                                        <span class="frm_required" aria-hidden="true">*</span>
                                    </div>

                                    <input type="email" id="field_j4r0h_first" required
                                           name="username" value="<?= $_SESSION['member']['email']?>">

                                </div>
                                <div id="frm_field_7-last_container"
                                     class="frm_form_field form-field frm_form_subfield-last  frm6"
                                     data-sub-field-name="last">

                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _PASSWORD ?>

                                    </div>
                                    <input type="password" id="field_j4r0h_last" required
                                           name="password">

                                </div>

                                <div id="frm_field_7-last_container"
                                     class="frm_form_field form-field frm_form_subfield-last  frm6"
                                     data-sub-field-name="last">

                                    <div id="field_j4r0h_label" class="frm_primary_label"><?= _PASSWORD_AGAIN ?>
                                    </div>
                                    <input type="password" id="field_j4r0h_last" required
                                           name="re_password">

                                </div>


                                <div class="frm_submit" style="text-align: center">

                                    <button class="frm_button_submit frm_final_submit" type="submit"
                                            formnovalidate="formnovalidate" name="edit" value="user"><?= _EDIT_INFO ?>
                                    </button>

                                </div>
                        </div>
                        </fieldset>
                </div>
                </form>
            </div>

        </div>

    </div>


    <?= $ariacms->getBlock("footer"); ?>

    <?= $ariacms->getBlock("footer_script"); ?>
</body>

</html>