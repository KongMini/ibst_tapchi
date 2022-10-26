<?php
global $database;
global $ariacms;
global $params;
global $ariaConfig_template;
global $web_menus;

$visited_count = $detail['visited_count'] + 1;
$row = new stdClass;
$row->id = $detail['id'];
$row->visited_count = $visited_count;
$database->updateObject('e4_tapchi', $row, 'id');

$author = $detail['author'];
$source = $detail['post_type'];
if($detail['post_type']	=='member' || $detail['post_type']	=='post') $source='';


$query = "SELECT * FROM `e4_web_image` WHERE position='banner' and status ='active' ORDER BY id DESC";
$database->setQuery($query);
$banner = $database->loadRow();


$query = "SELECT a.title_vi, a.url_part FROM e4_posts a WHERE a.id in (".$detail['relation'].")";
$database->setQuery($query);
$posts_relation = $database->loadObjectList();

if(!$ariacms->checkUserLogin()){
    $lightbox = "uk-toggle";
    $url_login = '#modal-login';
    $url_post = '#modal-login';
}else{
    $lightbox = "";
    $url_login = "javascript:;";
    $url_post = '/member/tao-bai-viet.html';
}

?>

<!doctype html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<?= $ariacms->getBlock("head"); ?>
<body class="home page-template-default page page-id-7 wp-custom-logo" id="page-top">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-dark-grayscale"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 0.49803921568627" /><feFuncG type="table" tableValues="0 0.49803921568627" /><feFuncB type="table" tableValues="0 0.49803921568627" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-grayscale"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 1" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0 1" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-purple-yellow"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.54901960784314 0.98823529411765" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0.71764705882353 0.25490196078431" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-blue-red"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 1" /><feFuncG type="table" tableValues="0 0.27843137254902" /><feFuncB type="table" tableValues="0.5921568627451 0.27843137254902" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-midnight"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 0" /><feFuncG type="table" tableValues="0 0.64705882352941" /><feFuncB type="table" tableValues="0 1" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-magenta-yellow"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.78039215686275 1" /><feFuncG type="table" tableValues="0 0.94901960784314" /><feFuncB type="table" tableValues="0.35294117647059 0.47058823529412" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-purple-green"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.65098039215686 0.40392156862745" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0.44705882352941 0.4" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-blue-orange"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.098039215686275 1" /><feFuncG type="table" tableValues="0 0.66274509803922" /><feFuncB type="table" tableValues="0.84705882352941 0.41960784313725" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg>

<?= $ariacms->getBlock("header"); ?>
<div class="border-top border-bottom main-content margin-below-sticky-header stripe-bg">
    <div class="flex-container page-header">
        <div class="flex">
            <div class="heading-container-left "><h1 class="center-on-mobile"><i class="fa-solid fa-square-full"></i>  <?= $detail[$params->title] ?></h1></div>
        </div>

    </div>
</div>

<!-- MAIN CONTENT
================================================== -->

<div class="white-band main-content">

    <div class="flex-container max-width">

		<style>
			figure {
				margin: 0em 0px;
			}
			table {
				margin-top: 30px;
				/* margin: 50px auto; */
				padding: 0;
				width: 100%;
			}
			td, th {
				padding: 0in 5.4pt;
				vertical-align: top;
				width: 242.6pt;
				font-weight: 100;
				color: #000;
				padding: 0;
			}
		</style>

        <div class="flex-66 padding-30" style='padding: 0 30px'>
            <div class="sticky" style="text-align: justify;">
                <p>  <?= $detail[$params->content] ?></p>
            </div>
        </div>
		<style>
			pre, blockquote, dl, figure, table, p, ul, ol, form {
			margin-bottom: 0.1rem !important;
		}
		</style>

        <div class="flex-33 padding-30">
            <!-- <p><img width="1920" height="1080" src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%201920%201080'%3E%3C/svg%3E" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="Law Firm SEO Tips" loading="lazy" data-lazy-srcset="https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips.jpg 1920w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-300x169.jpg 300w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-1024x576.jpg 1024w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-768x432.jpg 768w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-1536x864.jpg 1536w" data-lazy-sizes="(max-width: 1920px) 100vw, 1920px" data-lazy-src="../wp-content/uploads/2022/03/law-firm-seo-tips.jpg" /><noscript><img width="1920" height="1080" src="../wp-content/uploads/2022/03/law-firm-seo-tips.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="Law Firm SEO Tips" loading="lazy" srcset="https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips.jpg 1920w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-300x169.jpg 300w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-1024x576.jpg 1024w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-768x432.jpg 768w, https://www.dangilroy.com/wp-content/uploads/2022/03/law-firm-seo-tips-1536x864.jpg 1536w" sizes="(max-width: 1920px) 100vw, 1920px" /></noscript></p> -->
            <div class="portfolio-testimonial sticky" id="sidebar-list-2">
                <p><img width="1920" height="1080" src="<?= $detail['hinhdaidien'] ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="Law Firm SEO Tips" loading="lazy" data-lazy-srcset="<?= $detail['hinhdaidien'] ?>" data-lazy-sizes="(max-width: 1920px) 100vw, 1920px" data-lazy-src="<?= $detail['hinhdaidien'] ?>" /><noscript><img width="1920" height="1080" src="<?= $detail['hinhdaidien'] ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="Law Firm SEO Tips" loading="lazy" srcset="<?= $detail['hinhdaidien'] ?>" sizes="(max-width: 1920px) 100vw, 1920px" /></noscript></p>
            </div>

        </div>

    </div>
</div>







<?= $ariacms->getBlock("footer"); ?>

<?= $ariacms->getBlock("footer_script"); ?>
</body>
</html>
