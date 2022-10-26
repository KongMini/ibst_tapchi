<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_posts WHERE post_type = 'post' and post_status = 'active' ORDER BY id desc LIMIT 0, 3";
$database->setQuery($query);
$posts = $database->loadObjectList();
?><section class="two-column-section section-spacing wow fadeIn"  data-wow-duration="1s">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="faq-accordion">
                        <div class="faq-card card">
                            <div class="card-header">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne">
                                    What is crypto coin ?
                                </button>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    Với mong muốn mang tới trải nghiệm đầu tư tốt nhất, HRB luôn chú trọng tìm hiểu nhu cầu.
                                </div>
                            </div>
                        </div>
                        <div class="faq-card card">
                            <div class="card-header">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo">
                                    About our company
                                </button>
                            </div>
                            <div id="collapseTwo" class="collapse">
                                <div class="card-body">
                                    Với mong muốn mang tới trải nghiệm đầu tư tốt nhất, HRB luôn chú trọng tìm hiểu nhu cầu.
                                </div>
                            </div>
                        </div>
                        <div class="faq-card card">
                            <div class="card-header">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree">
                                    Why Choose finace ?
                                </button>
                            </div>
                            <div id="collapseThree" class="collapse">
                                <div class="card-body">
                                    Với mong muốn mang tới trải nghiệm đầu tư tốt nhất, HRB luôn chú trọng tìm hiểu nhu cầu.
                                </div>
                            </div>
                        </div>
                        <div class="faq-card card">
                            <div class="card-header">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour">
                                    Privacy Policy
                                </button>
                            </div>
                            <div id="collapsefour" class="collapse">
                                <div class="card-body">
                                    Với mong muốn mang tới trải nghiệm đầu tư tốt nhất, HRB luôn chú trọng tìm hiểu nhu cầu.
                                </div>
                            </div>
                        </div>
                        <div class="faq-card card">
                            <div class="card-header m-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive">
                                    Why join with us
                                </button>
                            </div>
                            <div id="collapsefive" class="collapse">
                                <div class="card-body pb-0">
                                    Với mong muốn mang tới trải nghiệm đầu tư tốt nhất, HRB luôn chú trọng tìm hiểu nhu cầu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-title margin-bottom-60">
                        <h4>Why choose us</h4>
                        <p>VSEC operates with the following mission.</p>
                    </div>
                    <div class="choose-us-container">
                        <div class="choose-us-row">
                            <div class="choose-us-logo">
                                <img src="<?= $ariacms->actual_link ?>templates/hrb/images/choose-logo.png" alt="choose logo" />
                            </div>
                            <div class="choose-us-content">
                                <h4>Increase in Capital value</h4>
                                <p>VSEC operates with the goal of increasing the capitalization of investors and shareholders of the company through securities business activities.</p>
                            </div>
                        </div>
                        <div class="choose-us-row">
                            <div class="choose-us-logo">
                                <img src="<?= $ariacms->actual_link ?>templates/hrb/images/choose-logo2.png" alt="choose logo" />
                            </div>
                            <div class="choose-us-content">
                                <h4>Accelerated growth</h4>
                                <p>VSEC contributes to accelerating growth in size and enhancing its competitiveness in Vietnam through business activities in the financial and securities sector and cooperation with other members of the Group. consulting and consulting</p>
                            </div>
                        </div>
                        <div class="choose-us-row">
                            <div class="choose-us-logo">
                                <img src="<?= $ariacms->actual_link ?>templates/hrb/images/choose-logo3.png" alt="choose logo" />
                            </div>
                            <div class="choose-us-content">
                                <h4>Effective brokerage</h4>
                                <p>VSEC implements brokerage, consultancy and investment activities to create a foothold in its development strategy, professionally contributing to and diversifying the company's financial investment activities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>