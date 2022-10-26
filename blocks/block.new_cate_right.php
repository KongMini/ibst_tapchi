<?php
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM e4_posts WHERE post_type = 'post' and post_status = 'active' ORDER BY id desc LIMIT 0, 3";
$database->setQuery($query);
$posts = $database->loadObjectList();
?>
		 <div class="sidebar-recent sidebar-widget">
		 <div class="sidebar-title">
			<h4>Tin mới nhất</h4>
		 </div>
			<?php
			foreach ($posts as $post) {
			?>
			
			 <div class="recent-container">
				   <div class="recent-content">
					  <a href="#"><a href="<?= $ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html'; ?>"><?= $post->{$params->title} ?></a></a>
					  <ul class="recent-meta list-inline">
						 <li class="list-inline-item">20/03/2018</li>
						 <li class="list-inline-item">11 Comments</li>
					  </ul>
				   </div>
				</div>
						
				
			<?php
			}
			?>
		</div>
