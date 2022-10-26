<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_posts WHERE post_type = 'post' and post_status = 'active' ORDER BY id desc LIMIT 0, 3";
$database->setQuery($query);
$posts = $database->loadObjectList();
?><section class="Video-section bg-color1 section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="video-thumbnails">
                        <img src="images/video-bg.jpg" alt="video image" />
                        <div class="video-thumbnails-img js-modal-btn" data-video-id="7TUOI23spt0">
                           <iframe width="550" height="404" src="https://www.youtube.com/embed/rVhBjqrjOpw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn"  data-wow-duration="1s">
                    <div class="section-title margin-bottom-30">
                        <h2>Introduction </h2>
						<p>At RHB Vietnam Securities Co., Ltd, we believe in providing the highest quality service to our customers. In that spirit, we value your feedback in helping us improve our service standards. If you have any complaints
						</p>
                       </div>
                    <ul class="section-list list-inline">
					

<li>An acknowledgment will be provided within three (3) days of receipt of the complaint.</li>
<li>Complaints are usually answered fourteen (14) days after receipt.</li>
<li>However, if the complaint should be thoroughly investigated or responded to</li>
                      
                    </ul>
                </div>
            </div>
        </div>
    </section>