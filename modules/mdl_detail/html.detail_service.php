<?php
global $ariacms;
global $params;
?>


	<!DOCTYPE html>
		<html lang="vi">

		<head>
			<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
			<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<?= $ariacms->getBlock("head"); ?>
		</head>

		<body>
    <header class="themeix-header">
        <div class="themeix-header-top bg-color2">
            <div class="container">
                <div class="d-flex justify-content-between themeix">
                    <div class="themeix-top-bar-left">
                        <p class="top-content">rhb.suport@gmail.com</p>
                    </div>
                    <div class="themeix-top-bar-right"><a class="top-sign-btn" href="contact.html" data-toggle="modal" data-target="#login-modal"><i class="fa fa-user"></i>Sign In</a></div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="top-login-modal modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="tmx-loginform" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tmx-loginform">Login Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="login-form-modal">
                            <form action="#" method="get">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control" placeholder="Username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <input type="password" class="form-control" placeholder="Pasword">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-primary login-btn">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="message">Not registered? <a href="#">Create an account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="themeix-header-navigation bg-color">
            <div class="container">
                <div class="d-flex justify-content-between themeix">
                    <div class="themeix-logo">
                        <a class="themeix-brand" href="index.html"><img src="images/header-brand.png" alt="header brand" /></a>
                    </div>
                    <nav class="themeix-menu">
                        <ul id="navigation-menu" class="slimmenu">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="#">About Us</a>
							<ul>
                                    <li><a href="blog-left-sidebar.html">T???ng quan</a></li>
                                    <li><a href="blog-right-sidebar.html">T???m nh??n - gi?? tr??? </a></li>
									  <li><a href="blog-left-sidebar.html">S?? ????? t??? ch???c</a></li>
                                    <li><a href="blog-right-sidebar.html">H???i ?????ng qu???n tr??? </a></li>
                                   
                                </ul>
							</li>
                            <li>
                                <a href="#">Products and Services</a>
                                <ul>
                                    <li><a href="#">Equities</a>									 
										<ul>
											<li><a href="services-details.html">Individual Client</a></li>
											<li><a href="services-details.html">Institutional Equities </a></li>
										   
										</ul>
									</li>
                                    <li><a href="projects.html">Capital Market services</a>
									</li>
                                   
                                </ul>
                            </li>
							<li>
                                <a href="#">Froms </a>
                                <ul>
                                    <li><a href="blog-left-sidebar.html">Account Opening form</a></li>
                                    <li><a href="blog-right-sidebar.html">Other forms</a></li>
                                   
                                </ul>
                            </li>
                            <li>
                                <a href="#">News and Events</a>
                                <ul>
                                    <li><a href="blog-right-sidebar.html">Daily market News</a></li>
                                    <li><a href="blog-right-sidebar.html">Event Canendar</a></li>
                                    <li><a href="news.html">RHBSNV's News</a></li>
                                </ul>
                            </li>

                            <li><a href="contact.html">Users Guilde</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- End Themeix Header -->

    <!-- Start Page Tile -->
    <section class="page-title-section section-spacing bg-color1">
        <div class="container">
            <div class="page-title-container">
                <h1>Tham gia RHB ngay b??y gi??? </h1>
                <nav class="finance-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Create an Account</a></li>
                        <li class="breadcrumb-item"><a href="about.html">T?? v???n online</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- End Page Title -->
    <!-- Start Page Tile -->
    <section class="service-details-section section-spacing bg-color1">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-lg-8">
                    <div class="service-details-thumb"><img src="images/services-details-img.jpg" alt="service details img" /></div>
                    <div class="service-details-content">
                        <h4>Giao d???ch ch???ng kho??n</h4>
                        <p>
						M???c ti??u c???a VNSEC l?? cung c???p t???i Qu?? kh??ch h??ng d???ch v??? nhanh, thu???n ti???n v?? ?????t hi???u qu??? cao nh???t. V???i c??ng ngh??? ph???n m???m hi???n ?????i, ????? b???o m???t cao v?? ?????i ng?? nh??n vi??n chuy??n nghi???p.B???ng c??ch ??a d???ng h??a h??nh th???c ?????t l???nh gi??p Qu?? kh??ch h??ng c?? th??? giao d???ch m???i l??c m???i n??i.

????? c?? th??? giao d???ch ?????t l???nh t???i VNSEC, Qu?? kh??ch h??ng vui l??ng ?????n  Ph??ng giao d???ch c???a VNSEC ????? k?? H???p ?????ng m??? T??i kho???n v?? H???p ?????ng Giao d???ch tr???c tuy???n. C??c giao d???ch vi??n s??? h?????ng d???n qu?? kh??ch ??i???n th??ng tin tr??n h???p ?????ng.

Hi???n nay, Qu?? kh??ch h??ng c?? th??? ?????t l???nh giao d???ch th??ng qua c??c k??nh giao d???ch nh?? sau:
						</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="service-us-container">
                                <div class="service-us-title">
                                    <div class="service-us-logo">
                                        <img src="images/choose-logo.png" alt="choose logo">
                                    </div>
                                    <h4> ?????t l???nh t???i qu???y giao d???ch</h4>
                                </div>
                                <p>??i???u ki???n th???c hi???n: K?? h???p ?????ng M??? t??i kho???n Giao d???ch ch???ng kho??n

Qu?? kh??ch h??ng s??? ???????c cung c???p phi???u l???nh v?? ???????c h??? tr??? ??i???n th??ng tin tr??n phi???u l???nh.

?????a ch??? c??c Ph??ng giao d???ch c???a VNSEC	
								</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="service-us-container">
                                <div class="service-us-title">
                                    <div class="service-us-logo">
                                        <img src="images/choose-logo2.png" alt="choose logo">
                                    </div>
                                    <h4>?????t l???nh qua ??i???n tho???i</h4>
                                </div>
                                <p>
								??i???u ki???n th???c hi???n:

							- K?? h???p ?????ng M??? t??i kho???n Giao d???ch ch???ng kho??n

							- K?? h???p ?????ng Giao d???ch tr???c tuy???n

							Qu?? kh??ch h??ng vui l??ng g???i ??i???n t???i Trung t??m nh???n l???nh theo s??? 04.39446067

							Tr?????ng h???p Qu?? kh??ch h??ng mu????n nghe l???i l????nh ??????t cu??a mi??nh, xin vui lo??ng ??????n ph??ng giao d???ch cu??a VNSEC - Trung t??m d???ch v??? kha??ch ha??ng ?????? ????????c tr???? giu??p.
															</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="service-us-container">
                                <div class="service-us-title">
                                    <div class="service-us-logo">
                                        <img src="images/choose-logo3.png" alt="choose logo">
                                    </div>
                                    <h4>?????t l???nh tr???c tuy???n</h4>
                                </div>
                                <p>
									??i???u ki???n th???c hi???n:

									- K?? h???p ?????ng M??? t??i kho???n Giao d???ch ch???ng kho??n

									- K?? h???p ?????ng Giao d???ch tr???c tuy???n

									VNSEC cung c???p 02 h??nh th???c giao d???ch tr???c tuy???n t???i Qu?? kh??ch h??ng nh?? sau:

									- Qu?? kh??ch h??ng truy c???p website http://www.vnsec.vn ????? th???c hi???n giao d???ch tr???c tuy???n qua website c???a VNSEC
																	</p>
                            </div>
                        </div>
                        
                    </div>
					
 
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="right-sidebar">
                        <div class="sidebar-title sidebar-top">
                            <h4>Kh??ch h??ng c?? nh??n </h4>
                        </div>
                        <ul class="sidebar-category sidebar-widget list-group">
						
                            <li class="list-group-item d-flex"><a href="#">M??? t??i kho???n giao d???ch</a></li>
							 <li class="list-group-item d-flex"><a href="#"><b>Giao d???ch ch???ng kho??n</b></a></li>
                            <li class="list-group-item d-flex"><a href="#">T??i kho???n giao d???ch tr???c tuy???n </a></li>
                            <li class="list-group-item d-flex"><a href="#">L??u k?? Ch???ng kho??n </a></li>                           
                            <li class="list-group-item d-flex"><a href="#">H??? tr??? v???n</a></li>
                        </ul>
                        <div class="sidebar-widget sidebar-call-action">
                            <img src="images/quotes-logo.png" alt="quotes logo" />
                            <a href="#">Got any Questions?</a>
                            <h3>0912 568 999</h3>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Page Title -->
    
	
	<?= $ariacms->getBlock("footer"); ?>
	<?= $ariacms->getBlock("footer_script"); ?>
</body>

</html>