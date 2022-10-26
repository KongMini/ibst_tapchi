<?php

global $ariacms;
global $params;		
global $database;
global $ariaConfig_template;
function text_limit($str,$limit=10)
{
	if(stripos($str," ")){
		$ex_str = explode(" ",$str);
		if(count($ex_str)>$limit){
			for($i=0;$i<$limit;$i++){
				$str_s.=$ex_str[$i]." ";
			}
			return $str_s;
		}else{
			return $str;
		}
	}else{
		return $str;
	}
}
?>


<!doctype html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

 <head>
<meta name="google-site-verification" content="R5RRjtgb1OFBHTsgUvaNtPJ10MuodbzWHUiUz3uAN0Q" />
<meta name="google-site-verification" content="sixAci5VS7cvOdqcOafysSsUGwKzTAOpwB1uoYsHa0M" />
<meta name="verify-v1" content="vC35EcQpMwUv1wphX5oHoXjd92E1uZhIutp9eXO9uMk=" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />

	<!-- This site is optimized with the Yoast SEO plugin v19.0 - https://yoast.com/wordpress/plugins/seo/ -->
	<link media="all" href="/templates/tapchi/wp-content/cache/autoptimize/css/autoptimize_0e1b5559e852493a7712ddab072ae0c7.css" rel="stylesheet" />
	<link media="print" href=/templates/tapchi/wp-content/cache/autoptimize/css/auto_a.css" rel="stylesheet" />
	<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
	<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@300;400&amp;family=Overpass:wght@300;400&amp;family=Roboto&amp;display=swap" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@300;400&amp;family=Overpass:wght@300;400&amp;family=Roboto&amp;display=swap" media="print" onload="this.media='all'" /><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@300;400&amp;family=Overpass:wght@300;400&amp;family=Roboto&amp;display=swap" /></noscript>
	<meta name="description" content="Make sure your mid-sized website design is professional, attractive, and consistent with your brand. Ask us for a quote." />
	<link rel="canonical" href="index.html" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
	<meta property="og:url" content="index.html" />
	<meta property="og:site_name" content="Dan Gilroy Design" />
	<meta property="article:publisher" content="https://www.facebook.com/DanGilroyDesign/" />
	<meta property="article:modified_time" content="2022-05-03T23:11:20+00:00" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@dangilroydesign" />
	<meta name="twitter:label1" content="Est. reading time" />
	<meta name="twitter:data1" content="8 minutes" />
	<script type="application/ld+json" class="yoast-schema-graph">{"@context":"https://schema.org","@graph":[{"@type":"Organization","@id":"https://www.dangilroy.com/#organization","name":"Dan Gilroy Design","url":"https://www.dangilroy.com/","sameAs":["https://www.linkedin.com/company/9803785/admin/","https://www.facebook.com/DanGilroyDesign/","https://twitter.com/dangilroydesign"],"logo":{"@type":"ImageObject","inLanguage":"en-US","@id":"https://www.dangilroy.com/#/schema/logo/image/","url":"https://www.dangilroy.com/wp-content/uploads/2022/03/Dan-Gilroy-Design-2022.png","contentUrl":"https://www.dangilroy.com/wp-content/uploads/2022/03/Dan-Gilroy-Design-2022.png","width":1600,"height":277,"caption":"Dan Gilroy Design"},"image":{"@id":"https://www.dangilroy.com/#/schema/logo/image/"}},{"@type":"WebSite","@id":"https://www.dangilroy.com/#website","url":"https://www.dangilroy.com/","name":"Dan Gilroy Design","description":"Law Firm Website Design","publisher":{"@id":"https://www.dangilroy.com/#organization"},"potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://www.dangilroy.com/?s={search_term_string}"},"query-input":"required name=search_term_string"}],"inLanguage":"en-US"},{"@type":"WebPage","@id":"https://www.dangilroy.com/mid-sized-law-firm-website-design/#webpage","url":"https://www.dangilroy.com/mid-sized-law-firm-website-design/","name":"Website Design For Mid-Sized Law Firms | Mid-Size Law Firm Web Design","isPartOf":{"@id":"https://www.dangilroy.com/#website"},"datePublished":"2021-07-25T23:55:02+00:00","dateModified":"2022-05-03T23:11:20+00:00","description":"Make sure your mid-sized website design is professional, attractive, and consistent with your brand. Ask us for a quote.","breadcrumb":{"@id":"https://www.dangilroy.com/mid-sized-law-firm-website-design/#breadcrumb"},"inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["https://www.dangilroy.com/mid-sized-law-firm-website-design/"]}]},{"@type":"BreadcrumbList","@id":"https://www.dangilroy.com/mid-sized-law-firm-website-design/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"https://www.dangilroy.com/"},{"@type":"ListItem","position":2,"name":"Website Design For Mid-Sized Law Firms"}]}]}</script>
	<!-- / Yoast SEO plugin. -->


<link href='https://fonts.gstatic.com/' crossorigin rel='preconnect' />



	









<script type='text/javascript' src='https://code.jquery.com/jquery-3.6.0.min.js' id='jquery-core-js'></script>



<link rel="https://api.w.org/" href="/templates/tapchi/wp-json/index.html" /><link rel="alternate" type="application/json" href="/templates/tapchi/wp-json/wp/v2/pages/22.json" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="/templates/tapchi/xmlrpc0db0.html?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/templates/tapchi/wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 5.9.3" />
<link rel='shortlink' href='/templates/tapchi/index0345.html?p=22' />
<link rel="alternate" type="application/json+oembed" href="/templates/tapchi/wp-json/oembed/1.0/embedb3c8.json?url=https%3A%2F%2Fwww.dangilroy.com%2Fmid-sized-law-firm-website-design%2F" />
<link rel="alternate" type="text/xml+oembed" href="/templates/tapchi/wp-json/oembed/1.0/embed90c0?url=https%3A%2F%2Fwww.dangilroy.com%2Fmid-sized-law-firm-website-design%2F&amp;format=xml" />
<script type="text/javascript">document.documentElement.className += " js";</script>
<link rel="icon" href="/templates/tapchi/wp-content/uploads/2022/04/cropped-favicon-32x32.png" sizes="32x32" />
<link rel="icon" href="/templates/tapchi/wp-content/uploads/2022/04/cropped-favicon-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="/templates/tapchi/wp-content/uploads/2022/04/cropped-favicon-180x180.png" />
<meta name="msapplication-TileImage" content="/templates/tapchi/https://www.dangilroy.com/wp-content/uploads/2022/04/cropped-favicon-270x270.png" />
		
		<noscript><style id="rocket-lazyload-nojs-css">.rll-youtube-player, [data-lazy-src]{display:none !important;}</style></noscript>
<link rel="stylesheet" href="/templates/tapchi/unpkg.com/aos%402.3.1/dist/aos.css">
<link rel="stylesheet" href="/templates/tapchi/cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="/templates/tapchi/kit.fontawesome.com/6e1d190ad0.js" crossorigin="anonymous"></script>
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','/templates/tapchi/www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-196787-4', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>

	<?= $ariacms->getBlock("header"); ?>
	    
	
	<div class="border-top border-bottom main-content margin-below-sticky-header stripe-bg">
	    <div class="flex-container page-header">
			<div class="flex-66">
			<div class="heading-container-left small-page-heading"><h1 class="center-on-mobile">  <?=$category[$params->title]?></h1></div>
			</div>
			<div class="flex-33 breadcrumbs ">
			<p class="desktop-only"><a href="<?=$ariacms->actual_link?>"><?=_HOME?></a>  / <?=$category[$params->title]?></p>
			</div>
		</div>
</div>

<div class="white-band " style="padding: 25px 0 100px 0; background-image: linear-gradient(90deg, #ffffff 49.75%, #fafafa 49.75%, #fafafa 50%, #ffffff 50%, #ffffff 99.75%, #fafafa 99.75%, #fafafa 100%); background-size: 402.00px 402.00px;">

<div class="flex-container max-width">
	
<div class="flex-50 padding-30">
	<div class="stick">







	</div>

</div>


<div class="flex-50">	
	
	<div class="flex-container center-on-mobile sticky">
	<?php foreach ($news as $key => $new) {
 ?>	
		<div class="flex-col-portfolio-page" >
		<div class="project-container">
		<a href="<?=$ariacms->actual_link?>chi-tiet/<?=$new->url_part?>.html"><div class="project-image-container"><picture class="attachment-full size-full">
<source type="image/webp" data-lazy-srcset="<?=$new->hinhdaidien?>" srcset="<?=$new->hinhdaidien?>"/>
<img width="765" height="430" src="<?=$new->hinhdaidien?>" alt="" data-lazy-srcset="<?=$new->hinhdaidien?>" data-lazy-sizes="(max-width: 765px) 100vw, 765px" data-lazy-src="<?=$new->hinhdaidien?>"/>
</picture>
<noscript><picture class="attachment-full size-full">
<source type="image/webp" srcset="<?=$new->hinhdaidien?>" sizes="(max-width: 765px) 100vw, 765px"/>
<img width="765" height="430" src="<?=$new->hinhdaidien?>" alt="" srcset="<?=$new->hinhdaidien?>" sizes="(max-width: 765px) 100vw, 765px"/>
</picture>
</noscript></div></a>		<div class="client-name-container"><a class="client-name" href="<?=$ariacms->actual_link?>chi-tiet/<?=$new->url_part?>.html"><?=$new->{$params->title}?></a>		<p class="city"><?=$ariacms->unixToDate($new->post_created, '/')?></p>
		</div>
		</div>
</div>
		
	<?php } ?>
</div>

	
</div>
	
</div>
</div>

	   <!--  <div class="wp-pagenavi" role="navigation">
							
							<?=$ariacms->paginationPublic($count,$maxRows1, 12) ?>
						</div> -->
	    	
	    
	    

	
	   
	   
        <?=$ariacms->getBlock("footer"); ?>
	
	 <?= $ariacms->getBlock("footer_script"); ?>
	 </body>
	</html>



