<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_posts WHERE post_type = 'post' and post_status = 'active' ORDER BY id desc LIMIT 0, 3";
$database->setQuery($query);
$posts = $database->loadObjectList();
?>
<section class="feature-section bg-color3 section-spacing wow fadeIn"  data-wow-duration="1s">
        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <div class="section-title margin-bottom-60 text-center">
                        <h4>Be with you always ... </h4>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-logo">
                            <h2>01</h2>
                            <img src="<?= $ariacms->actual_link ?>templates/hrb/images/feature-logo.png" alt="feature logo" />
                        </div>
                        <div class="feature-details">
                            <h4><a href="services.html">Individual Clients</a> </h4>
                            <p>We provides securities trading account for trading stocks, Funds Certificate, Bonds and UpCom on the Ho Chi Minh Stock Exchange (“HOSE”) and Hanoi Stock Exchange (“HNX”) for follow clients; </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-logo">
                            <h2>03</h2>
                           <img src="<?= $ariacms->actual_link ?>templates/hrb/images/feature-logo2.png" alt="feature logo" />
                        </div>
                        <div class="feature-details">
                            <h4><a href="services.html">Institutional Equities</a> </h4>
                            <p>Institutional Equities provides services to a wide variety of Institutional clients based in Vietnam and internationally on following services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box m-0">
                        <div class="feature-logo">
                            <h2>02</h2>
                            <img src="<?= $ariacms->actual_link ?>templates/hrb/images/feature-logo3.png" alt="feature logo" />
                        </div>
                        <div class="feature-details">
                            <h4><a href="services.html">Capital Market Services</a></h4>
                            <p>RHBSVN is able to leverage of RHBIB’s large client base in Malaysia and Singapore to find foreign strategic investors.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>