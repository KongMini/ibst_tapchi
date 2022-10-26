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
                                    <li><a href="blog-left-sidebar.html">Tổng quan</a></li>
                                    <li><a href="blog-right-sidebar.html">Tầm nhìn - giá trị </a></li>
									  <li><a href="blog-left-sidebar.html">Sơ đồ tổ chức</a></li>
                                    <li><a href="blog-right-sidebar.html">Hội đồng quản trị </a></li>
                                   
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
                <h1>Tham gia RHB ngay bây giờ </h1>
                <nav class="finance-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Create an Account</a></li>
                        <li class="breadcrumb-item"><a href="about.html">Tư vấn online</a></li>
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
                        <h4>Giao dịch chứng khoán</h4>
                        <p>
						Mục tiêu của VNSEC là cung cấp tới Quý khách hàng dịch vụ nhanh, thuận tiện và đạt hiệu quả cao nhất. Với công nghệ phần mềm hiện đại, độ bảo mật cao và đội ngũ nhân viên chuyên nghiệp.Bằng cách đa dạng hóa hình thức đặt lệnh giúp Quý khách hàng có thể giao dịch mọi lúc mọi nơi.

Để có thể giao dịch đặt lệnh tại VNSEC, Quý khách hàng vui lòng đến  Phòng giao dịch của VNSEC để ký Hợp đồng mở Tài khoản và Hợp đồng Giao dịch trực tuyến. Các giao dịch viên sẽ hướng dẫn quý khách điền thông tin trên hợp đồng.

Hiện nay, Quý khách hàng có thể đặt lệnh giao dịch thông qua các kênh giao dịch như sau:
						</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="service-us-container">
                                <div class="service-us-title">
                                    <div class="service-us-logo">
                                        <img src="images/choose-logo.png" alt="choose logo">
                                    </div>
                                    <h4> Đặt lệnh tại quầy giao dịch</h4>
                                </div>
                                <p>Điều kiện thực hiện: Ký hợp đồng Mở tài khoản Giao dịch chứng khoán

Quý khách hàng sẽ được cung cấp phiếu lệnh và được hỗ trợ điền thông tin trên phiếu lệnh.

Địa chỉ các Phòng giao dịch của VNSEC	
								</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="service-us-container">
                                <div class="service-us-title">
                                    <div class="service-us-logo">
                                        <img src="images/choose-logo2.png" alt="choose logo">
                                    </div>
                                    <h4>Đặt lệnh qua điện thoại</h4>
                                </div>
                                <p>
								Điều kiện thực hiện:

							- Ký hợp đồng Mở tài khoản Giao dịch chứng khoán

							- Ký hợp đồng Giao dịch trực tuyến

							Quý khách hàng vui lòng gọi điện tới Trung tâm nhận lệnh theo số 04.39446067

							Trường hợp Quý khách hàng muốn nghe lại lệnh đặt của mình, xin vui lòng đến phòng giao dịch của VNSEC - Trung tâm dịch vụ khách hàng để được trợ giúp.
															</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="service-us-container">
                                <div class="service-us-title">
                                    <div class="service-us-logo">
                                        <img src="images/choose-logo3.png" alt="choose logo">
                                    </div>
                                    <h4>Đặt lệnh trực tuyến</h4>
                                </div>
                                <p>
									Điều kiện thực hiện:

									- Ký hợp đồng Mở tài khoản Giao dịch chứng khoán

									- Ký hợp đồng Giao dịch trực tuyến

									VNSEC cung cấp 02 hình thức giao dịch trực tuyến tới Quý khách hàng như sau:

									- Quý khách hàng truy cập website http://www.vnsec.vn để thực hiện giao dịch trực tuyến qua website của VNSEC
																	</p>
                            </div>
                        </div>
                        
                    </div>
					
 
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="right-sidebar">
                        <div class="sidebar-title sidebar-top">
                            <h4>Khách hàng cá nhân </h4>
                        </div>
                        <ul class="sidebar-category sidebar-widget list-group">
						
                            <li class="list-group-item d-flex"><a href="#">Mở tài khoản giao dịch</a></li>
							 <li class="list-group-item d-flex"><a href="#"><b>Giao dịch chứng khoán</b></a></li>
                            <li class="list-group-item d-flex"><a href="#">Tài khoản giao dịch trực tuyến </a></li>
                            <li class="list-group-item d-flex"><a href="#">Lưu ký Chứng khoán </a></li>                           
                            <li class="list-group-item d-flex"><a href="#">Hỗ trợ vốn</a></li>
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