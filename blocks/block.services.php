<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_posts WHERE post_type = 'post' and post_status = 'active' ORDER BY id desc LIMIT 0, 3";
$database->setQuery($query);
$posts = $database->loadObjectList();
?>
<section class="services-section padding-60-0 bg-color3 section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <div class="section-title margin-bottom-60 text-center">
                        <h4>PRODUCTS AND SERVICES</h4>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 wow fadeIn"  data-wow-duration="1s">
                    <div class="services-wrapper">
                        <ul class="services-title list-inline">
                            <li class="list-inline-item"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/service-logo.png" alt="services logo icon" /></li>
                            <li class="list-inline-item"><a href="#">Opening trading account</a></li>
                        </ul>
                        <p>
						We provides securities trading account for trading stocks, Funds Certificate, Bonds and UpCom on the Ho Chi Minh Stock Exchange (“HOSE”) and Hanoi ...
						</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn"  data-wow-duration="2s">
                    <div class="services-wrapper">
                        <ul class="services-title list-inline">
                            <li class="list-inline-item"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/service-logo2.png" alt="services logo icon" /></li>
                            <li class="list-inline-item"><a href="#">b.	Online Trading Account </a></li>
                        </ul>
                        <p>
						Online facilities for the Customer as below;
Place order and modification of trades (as permitted by the Exchanges) through online.

						</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn"  data-wow-duration="3s">
                    <div class="services-wrapper">
                        <ul class="services-title list-inline">
                            <li class="list-inline-item"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/service-logo3.png" alt="services logo icon" /></li>
                            <li class="list-inline-item"><a href="#">Securities Depository</a></li>
                        </ul>
                        <p>
						The management of the clients’ scriptless securities with the Vietnam Securities Depository (“VSD”) as following services
						</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn"  data-wow-duration="1s">
                    <div class="services-wrapper">
                        <ul class="services-title list-inline">
                            <li class="list-inline-item"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/service-logo4.png" alt="services logo icon" /></li>
                            <li class="list-inline-item"><a href="#">Institutional Equities</a></li>
                        </ul>
                        <p>
						Institutional Equities provides services to a wide variety of Institutional clients based in Vietnam and internationally on following services
						</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn"  data-wow-duration="2s">
                    <div class="services-wrapper">
                        <ul class="services-title list-inline">
                            <li class="list-inline-item"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/service-logo5.png" alt="services logo icon" /></li>
                            <li class="list-inline-item"><a href="#">Mergers and Acquisitions (M&A)</a></li>
                        </ul>
                        <p>RHBSVN is able to leverage of RHBIB’s large client base in Malaysia and Singapore to find foreign strategic investors</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn"  data-wow-duration="3s">
                    <div class="services-wrapper">
                        <ul class="services-title list-inline">
                            <li class="list-inline-item"><img src="<?= $ariacms->actual_link ?>templates/hrb/images/service-logo6.png" alt="services logo icon" /></li>
                            <li class="list-inline-item"><a href="#">Corporate Finance advisory</a></li>
                        </ul>
                        <p>To provides corporate finance advisory on listing in the local Exchanges and Cross Listing in other Asian Countries Exchanges..</p>
                    </div>
                </div>
            </div>
        </div>
    </section>