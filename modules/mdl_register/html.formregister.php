<?php
global $ariacms;
global $database;
//print_r($_SESSION["member"]);
?>

<!DOCTYPE html>
<html lang="vi-VN" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">

<?= $ariacms->getBlock("head"); ?>
<script type="javascript">
    $('.message a').click(function () {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
</script>

<!doctype html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>

<?= $ariacms->getBlock("head"); ?>
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


            <h3 style="text-align: center"><?= _SIGN_UP ?></h3>

            <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_2_container">
                <form action="<?php echo $ariacms->actual_link . 'register/check-register.html'; ?>" method="post"
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
                                       name="fullname">

                            </div>
                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _PHONE ?>
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <input type="text" id="field_j4r0h_last" required
                                       name="phonenumber">

                            </div>

                            <div id="frm_field_15_container"
                                 class="frm_form_field form-field  frm_required_field frm_top_container">
                                <label for="field_8idq4" id="field_8idq4_label" class="frm_primary_label"><?= _DEGREE ?></label>
                                <input type="text" id="field_j4r0h_last" name="hocvi">
                            </div>

                            <div id="frm_field_6-first_container"
                                 class="frm_form_field form-field frm_form_subfield-first  frm6"
                                 data-sub-field-name="first">
                                <div id="field_j4r0h_label" class="frm_primary_label">Email:
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>

                                <input type="email" id="field_j4r0h_first" required
                                       name="username">

                            </div>
                            <div id="frm_field_7-last_container"
                                 class="frm_form_field form-field frm_form_subfield-last  frm6"
                                 data-sub-field-name="last">

                                <div id="field_j4r0h_label" class="frm_primary_label"><?= _PASSWORD ?>
                                    <span class="frm_required" aria-hidden="true">*</span>
                                </div>
                                <input type="password" id="field_j4r0h_last" required
                                       name="password">

                            </div>
                            <div class="frm_submit" style="text-align: center">

                                <button class="frm_button_submit frm_final_submit" type="submit"
                                        formnovalidate="formnovalidate" name="submit" value="user"><?= _SIGN_UP ?>
                                </button>

                            </div>

                            <div id="frm_field_18_container"
                                 class="frm_form_field form-field  frm_required_field frm_top_container">
                                <label for="field_8268q" id="field_8268q_label" class="frm_primary_label"
                                       style="text-align: center;">
                                    <a style="color: red"
                                       href="<?php echo $ariacms->actual_link . 'register.html'; ?>"> <?= _ALREADY_REGISTERED ?>
                                        ?</a>
                                </label>
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
<script>


    function checkSo(id) {
        var so = $("input[id='" + id + "']").val();
        var valRegExp = /^\d+\.?\d*$/;
        if (so == "") {
            return;
        }
        if (!valRegExp.test(so)) {
            alert("Nhập vào không phải số!");
            $("input[id='" + id + "']").val(so.replace(/[a-zA-Z_+-]+/g, ""));
            return;
        }

    }
</script>