<?php 
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM  e4_tapchi  WHERE post_status = 'active' AND type='tapchi'  ORDER BY id ";

//echo $query ;

$database->setQuery($query);

$tintucs = $database->loadObjectList(); 

?>
	<div class="col col_4 homesidebar">
				<div class="">
				<div id="sidebar-1">
				<div class="bnleft">
				  
				<div title="A2"></div> 
				<div title="A3"></div> 		
				<div title="B1"></div> 
				<div title="B2"></div> 
					       </div>
				<aside id="secondary" class="widget-area col col_4" role="complementary">
					<section id="text-8" class="widget widget_text"><div class="cat-tilte"><span class="widget-title"><?=_MAGAZINE?></span></div>			<div class="textwidget"><div id="sidetop5">
						<?php 
						$k==0;
						foreach ($tintucs as  $tintuc) {
							if($k==0) { 
						?>
		<div class="smallbox" style="background:url(&quot;<?=$tintuc->hinhdaidien?>&quot;) no-repeat center center;background-size:100%;">
			<div class="boxOverlay">
				<div class="smallboxdetail">
					<a href="<?=$ariacms->actual_link?>chi-tiet/<?=$tintuc->url_part?>.html" class="entry-title">
						<?=$tintuc->{$params->title}?>          </a>
					<div class="entry-meta"><i class="fa fa-calendar" aria-hidden="true"></i>
						<?=$ariacms->unixToDate($tintuc->post_created, '/')?>           </div>
				</div>
			</div>
		</div>
	<?php $k++; } else { ?>
		<div class="grid-single">
			<div class="singleThumb w100">
				<a href="<?=$ariacms->actual_link?>chi-tiet/<?=$tintuc->url_part?>.html">
					<img width="173" height="123" src="<?=$tintuc->hinhdaidien?>" class="attachment-size1-image size-size1-image wp-post-image" alt="">        </a>
			</div>
			<div class="singleContent">
				<a class="entry-title" href="<?=$ariacms->actual_link?>chi-tiet/<?=$tintuc->url_part?>.html">
					<?=$tintuc->{$params->title}?></a>
			</div>
		</div>
	<?php $k++; } ?>
		
		
			
		<?php  } ?>
		<div class="topmore"><a href="<?=$ariacms->actual_link?>chu-de.html">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>
		</div>
	</div>
				</section>    
				</aside>
		</div>        
		</div>
		</div>