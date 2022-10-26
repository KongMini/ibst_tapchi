<?php
global $ariacms;
global $params;
?>

<!DOCTYPE HTML>
<html lang="en-US">


<!-- Mirrored from demo.themeix.com/html/helex2/blog-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 03:35:54 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

		<head>
			<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
			<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<?= $ariacms->getBlock("head"); ?>
		
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
    var target = $(this).attr("href"); //Get the target
    var scrollToPosition = $(target).offset().top - 150;

    $('html').animate({ 'scrollTop': scrollToPosition }, 600, function(){
        window.location.hash = "" + target;
        // This hash change will jump the page to the top of the div with the same id
        // so we need to force the page to back to the end of the animation
        $('html').animate({ 'scrollTop': scrollToPosition }, 0);
    });

    $('body').append("called");
    } // End if
  });
});



</script>	
    <!-- Poppins Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
</head>

<body>
    <?= $ariacms->getBlock("header"); ?>
    <!-- End Themeix Header -->

      <!-- Start Page Tile -->
          <section class="page-title-section section-spacing bg-color1">
        <div class="container">
            <div class="page-title-container">
                <h1>Join RHB Now </h1>
                <nav class="finance-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Create an Account</a></li>
                        <li class="breadcrumb-item"><a href="about.html">Online Counseling</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </section
      <!-- End Page Title -->  
      <!-- Start Services -->
      <section class="service-details-section section-spacing bg-color1">
         <div class="container">
            <div class="row">
               <div class="col-md-5 col-lg-4" >
                  <div class="left-sidebar" id="left-sidebar">
                     
                    <div class="sidebar-widget sidebar-call-action">
                        <img src="<?= $ariacms->actual_link ?>templates/hrb/images/quotes-logo.png" alt="quotes logo" />
                        <a href="#">Got any Questions?</a>
                        <h5>+84-043-9446.489</h5>
						<h5>contact@rhb.com.vn</h5>
                     </div>
                     
                  </div>
               </div>
			   
			   
               <div class="col-md-7 col-lg-8 wow fadeIn"  data-wow-duration="1s">
                  <div class="post-wrapper-2" id="section1">
                     <div class="post-thumb">
                        <a href="single.html"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/post-thumb4.jpg" alt="post thumb" /></a>
                     </div>

				
                     <div class="post-details" id="section2">
                        <div class="post-content">
                           <h5>G.	Career Opportunities.   </h5>
                          
                           <p>
						   Join us now!
We believe that the long-term success of RHBSVN lies in building a pool of highly skilled professional staff that would be able to drive its business strategies and plans.
 <br>
Teamwork, training, building a professional and dynamic working environment as well as offering competitive salary and benefit schemes in line with market practice are some of the key matters that the Management of RHBSVN have implemented to ensure that its staff remain their motivation and full commitment to achieve the goals of the Company.
<br>
In addition, being a part of RHB Banking Group - one of the largest integrated financial and services group in Malaysia, RHBSVN has transformed into an efficient entity that now has a good corporate governance, well laid down systems, policies and procedures and is in a position to compete with the major players in the market.


						   </p>
                           
                        </div>
                     </div>
				</div>	 
				
                
      </section>
      <!-- End Services -->
      <!-- Start Footer -->
      <?= $ariacms->getBlock("footer"); ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" async=""></script>
	<script>
	
        $(function(){
        $(window).scroll(function () {
        if ($(this).scrollTop() > 300 && $(this).scrollTop() < 2040){
			
			document.getElementById("left-sidebar").setAttribute("style", "position: fixed; top: 100px;");
		} 
        else  { 
		document.getElementById("left-sidebar").setAttribute("style", "position: relative;");
		}
        });
		
        });
    
	</script>
      <!-- End Footer -->
    <!-- Add Javascript File -->
	<?= $ariacms->getBlock("footer_script"); ?>
</body>


<!-- Mirrored from demo.themeix.com/html/helex2/blog-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 03:35:56 GMT -->
</html>