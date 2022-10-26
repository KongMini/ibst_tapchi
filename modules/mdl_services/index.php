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
                     
                     <div class="sidebar-title">
                        <h4>PRODUCTS AND SERVICES</h4>
                     </div>
                     <ul class="sidebar-category sidebar-widget list-group">
                        <li class="list-group-item d-flex"><a href="#section1">Equities </a></li>
						<li class="list-group-item d-flex"><a href="#section2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Individual Clients</a></li>
						<li class="list-group-item d-flex"><a href="#section3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Institutional Equities</a></li>
						
						
                        <li class="list-group-item d-flex"><a href="#section4">Capital Market Services</a></li>
                     </ul>
                     <div class="sidebar-widget sidebar-call-action">
                        <img src="images/quotes-logo.png" alt="quotes logo" />
                        <a href="#">Got any Questions?</a>
                        <h3>0912 568 999</h3>
                     </div>
                     
                  </div>
               </div>
               <div class="col-md-7 col-lg-8 wow fadeIn"  data-wow-duration="1s">
                  <div class="post-wrapper-2" id="section1">
                     <div class="post-thumb">
                        <a href="single.html"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/post-thumb4.jpg" alt="post thumb" /></a>
                     </div>
                     <div class="post-details">
                        <div class="post-content">
                           <h4> Equities </h4>
                           <ul class="post-meta list-inline">
                             
                           </ul>
            
                           
                        </div>
                     </div>
                  
				
                     <div class="post-details" id="section2">
                        <div class="post-content">
                           <h5>Individual Clients   </h5>
                          
                           <p>
						    <b>Opening trading account</b></br>
							We provides securities trading account for trading stocks, Funds Certificate, Bonds and UpCom on the Ho Chi Minh Stock Exchange (“HOSE”) and Hanoi Stock Exchange (“HNX”) for follow clients;
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;i.	Domestic individual client account
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ii.	Domestic Corporate client account
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iii.	Foreign individual client account
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iv.	Foreign Corporate client account
							</br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="register.html">Sign up an account now (Link) </a> </br></br>
							<b>Online Trading Account</b></br>
							Online facilities for the Customer as below;</br>
							Place order and modification of trades (as permitted by the Exchanges) through online.</br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;i.	Access to real time live quotes of the Exchanges</br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ii.	Access to key market indicators;</br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iii.	Access to news and information;</br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iv.	Access to research materials; and</br>

							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Such other services available to a “client” of the Company.</br>

							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="register.html">Register an online trading account (link)</a></br></br>
							<b>Securities Depository</b>
							</br>The management of the clients’ scriptless securities with the Vietnam Securities Depository (“VSD”) as following services;
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;i.	Handling shares transfers
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ii.	Rights issues registration.
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iii.	Bonus issues entitlement.
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iv.	Shares dividend payments.


						   </p>
                           
                        </div>
                     </div>
				</div>	 
					  <div class="post-thumb">
				   <div class="post-wrapper-2" id="section3">
				   
                     <div class="post-thumb">
                        
                     </div>
                     <div class="post-details">
                        <div class="post-content">
                           <h4>Institutional Equities  </h4>
                           <ul class="post-meta list-inline">
                             Institutional Equities provides services to a wide variety of Institutional clients based in Vietnam and internationally on following services;
								</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Securities Trading
								</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Securities depository/ custodian.
								</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Investment consultancy

                           </ul>
                           <p>

						   </p>
                           
                        </div>
                     </div>
                  </div>
				  
				  
				  
                   <div class="post-wrapper-2" id="section4">
				   
                     <div class="post-thumb">
                        
                     </div>
                     <div class="post-details">
                        <div class="post-content">
                           <h4>Capital Market Services </h4>
                           <ul class="post-meta list-inline">
                             
                           </ul>
                           <p>
							<b>1.	Mergers and Acquisitions (M&A)</b></br>
							
							RHBSVN is able to leverage of RHBIB’s large client base in Malaysia and Singapore to find foreign strategic investors.

							</br></br><b>2.	Corporate Finance advisory.</b>
							
							</br>To provides corporate finance advisory on listing in the local Exchanges and Cross Listing in other Asian Countries Exchanges.


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