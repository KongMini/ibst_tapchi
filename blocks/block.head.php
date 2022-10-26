<?php
global $ariacms;
global $params;
global $ariaConfig_template;
global $analytics_code;
?>
<head>
   
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'/>
	<!--meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- This site is optimized with the Yoast SEO plugin v19.0 - https://yoast.com/wordpress/plugins/seo/ -->

    <link media="all"
          href="/templates/tapchi/wp-content/cache/autoptimize/css/autoptimize_0e1b5559e852493a7712ddab072ae0c7.css"
          rel="stylesheet"/>
    <link media="print" href="/templates/tapchi/wp-content/cache/autoptimize/css/auto_a.css" rel="stylesheet"/>
    <title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@300;400&amp;family=Overpass:wght@300;400&amp;family=Roboto&amp;display=swap"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@300;400&amp;family=Overpass:wght@300;400&amp;family=Roboto&amp;display=swap"
          media="print" onload="this.media='all'"/>
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@300;400&amp;family=Overpass:wght@300;400&amp;family=Roboto&amp;display=swap"/>
    </noscript>

    <script type='text/javascript' src='/templates/tapchi/wp-includes/js/jquery/jquery.minaf6c.js'
            id='jquery-core-js'></script>


   
    <script type="text/javascript">document.documentElement.className += " js";</script>
    <link rel="icon" href="<?= $ariacms->web_information->{'image-icon'}; ?>" sizes="32x32"/>
    <link rel="icon" href="<?= $ariacms->web_information->{'image-icon'}; ?>" sizes="192x192"/>
  

    <noscript>
        <style id="rocket-lazyload-nojs-css">.rll-youtube-player, [data-lazy-src] {
                display: none !important;
            }</style>
    </noscript>
    <link rel="stylesheet" href="/templates/tapchi/unpkg.com/aos%402.3.1/dist/aos.css">
    <link rel="stylesheet" href="/templates/tapchi/cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="/templates/tapchi/kit.fontawesome.com/6e1d190ad0.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

 
</head>