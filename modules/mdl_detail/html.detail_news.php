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
if ($detail['post_type'] == 'member' || $detail['post_type'] == 'post') $source = '';


$query = "SELECT * FROM `e4_web_image` WHERE position='banner' and status ='active' ORDER BY id DESC";
$database->setQuery($query);
$banner = $database->loadRow();


$query = "SELECT a.title_vi, a.url_part FROM e4_posts a WHERE a.id in (" . $detail['relation'] . ")";
$database->setQuery($query);
$posts_relation = $database->loadObjectList();

if (!$ariacms->checkUserLogin()) {
    $lightbox = "uk-toggle";
    $url_login = '#modal-login';
    $url_post = '#modal-login';
} else {
    $lightbox = "";
    $url_login = "javascript:;";
    $url_post = '/member/tao-bai-viet.html';
}

?>

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
<div class="border-top border-bottom main-content margin-below-sticky-header stripe-bg">
    <div class="flex-container page-header" style="display: block">
        <div class="flex-100">
            <div class="heading-container-left text-center">
                <h1 class="center-on-mobile" style="text-align: center"> <?= $detail[$params->title] ?></h1>
			</div>
			
            
			
        </div>

    </div>
</div>

<!-- MAIN CONTENT
================================================== -->
<style>
	.padding-30 {
		padding: 0px;
	}
	ol li{
		text-align: justify;
		color: #000;
		font-weight: 100;
	}
</style>
<div class="white-band main-content">

    <div class="container max-width">

        <div class="padding-30">
            <div class="sticky">
				
				<p class="center-on-mobile" style="text-align: right"> <?= _PUBLICATION_DATE . ": ". date("d-m-Y", $detail['time_edited']) ."</br>" ._NUMBER. ": " . $detail['linhvuc']  ?></h1>
				
                <h4 style="border-bottom: 1px solid"><?= $detail[$params->tacgia] ?></h4>
                <!-- <i class="icofont icofont-open-eye"></i> <a href="#"><?= $detail['visited_count'] + 1 ?>	</a> -->
                <div>
                    <div style="width: 30%; float: left">

                       <h4>  <?= _KEY?>:</h4>
                        <p data-uw-styling-context="true">
                            <?= str_replace(";", '</br>', str_replace(",", '</br>', $detail[$params->tukhoa])) ?>

                        </p>
                    </div>

                    <div style="width: 70%; float: left">
                        <h4 >  <?= _SUMMARY?>:</h4>
                        <p data-uw-styling-context="true">
                            <?= $detail[$params->brief] ?>

                        </p>
                    </div>
                </div>
                <div style="clear: both"></div>

                <div style="border-top: 1px solid; padding-top: 15px">
                    <div style="width: 30%; float: left" style="text-align: justify;">

                        <h4>  <?= _CONTENT?>:</h4>
                        <p data-uw-styling-context="true">
                            <a onclick="urf()" <?php  if($_SESSION['member']){ echo 'target="_blank"';}?> href="<?php  if(!$_SESSION['member']){ echo '/register.html';} else echo $detail[$params->file] ?>"> <i class="fas fa-file-pdf" style="font-size: 60px; color:red"></i></a>

                        </p>
						<script>
							function urf(){
								sessionStorage.setItem("url", "<?=  $detail['url_part']?>");
							}
						</script>
						
                    </div>

                    <div style="width: 70%; float: left">
                        <h4>  <?= _DOCUMENT?>:</h4>
                        
                            <?= $detail[$params->tailieuthamkhao] ?>
						<p data-uw-styling-context="true" style="display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;">
                        </p>
                    </div>
                </div>
                <div style="clear: both"></div>

                <div style="border-top: black solid 1px; margin-bottom: 1rem; padding-top: 15px ">

                    <h4 data-uw-styling-context="true">
                        <?= _RELATED_NEWS?>:
                    </h4>
					<div class="" style="max-height:300px; overflow-y:scroll">
						<div class="acme-news-ticker-box">
							<ul class="">
							<?php  foreach ($news as $new){?>
							
							   <li><a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><?php echo $new -> {$params -> title} ." - ".$new -> tacgia_vi?></a></li>
							<?php }?>
								
							</ul>
						</div>
						
					</div>
					
                </div>

            </div>
        </div>


    </div>
</div>
<script src="../../templates/tapchi/wp-content/cache/autoptimize/js/jquery.js"></script>
<script src="../../templates/tapchi/wp-content/cache/autoptimize/js/acmeticker.js"></script>
<link rel="stylesheet" href="../../templates/tapchi/wp-content/cache/autoptimize//css/style.css">
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.my-news-ticker').AcmeTicker({
            type:'vertical',/*vertical/horizontal/Marquee/type*/
            direction: 'right',/*up/down/left/right*/
            speed:1600,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
            controls: {
                prev: $('.acme-news-ticker-prev'),/*Can be used for vertical/horizontal/typewriter*//*not work for marquee*/
                next: $('.acme-news-ticker-next'),/*Can be used for vertical/horizontal/typewriter*//*not work for marquee*/
                toggle: $('.acme-news-ticker-pause')/*Can be used for vertical/horizontal/marquee/typewriter*/
            }
        });
    })

</script>

<?= $ariacms->getBlock("footer"); ?>

<?= $ariacms->getBlock("footer_script"); ?>
</body>
</html>
