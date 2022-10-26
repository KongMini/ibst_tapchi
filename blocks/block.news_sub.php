<?php 
global $database;
global $ariacms;
global $params;
$query = "SELECT * FROM  e4_chude  WHERE status = 'active'  ORDER BY id ";

//echo $query ;

$database->setQuery($query);

$categories = $database->loadObjectList(); 



function text_limit($str,$limit=20)

 {

     if(stripos($str," ")){

         $ex_str = explode(" ",$str);

         if(count($ex_str)>$limit){

         for($i=0;$i<$limit;$i++){

         $str_s.=$ex_str[$i]." ";

         }

         return $str_s."...";

         }else{

         return $str;

         }

         }else{

         return $str;

     }

 }

?> 
  <div class="col col_11">
    <!-- grid-1 loaded -->
<div>
                

<!-- grid-1 loaded -->
          
</div>           
 <div class="adgroupM12">
        <div class="col col_6">
		.	
</div>		
        <div class="col col_5">
		.		</div>
        </div>
    <!-- grid-3 loaded -->
    <?php $i=1;

foreach($categories as $category){

      ?>
<div class="cat-section grid1">
    <h2 class="cat-tilte"><a href=""><?=$category->{$params->title};?></a></h2>
                        <div class="col col_6">
                         <?php // Lấy ra tin thuộc Topic 

        $query = "SELECT a.*, c.fullname FROM e4_tapchi a 

            JOIN e4_users c ON a.user_created = c.id

            JOIN (SELECT b.id FROM e4_linhvuc b JOIN e4_chude c ON b.id = c.id_linhvuc AND c.id IN (" .$category->id . ") ) t ON a.id_linhvuc = t.id

            JOIN e4_chude d ON d.id = a.id_chude 

        WHERE type='tapchi' AND post_status='active'    
        
        GROUP BY a.id

        order by  a.id desc limit 0,7";

    //echo $query ;

    $database->setQuery($query);

    $posts = $database->loadObjectList();

                foreach($posts as $key => $post) { 

                     if($key==0) {

                    ?> 
                        <div class="grid-single big">
                            <div class="singleThumb"><a href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><img width="173" height="123" src="<?=$post->hinhdaidien?>" class="b-lazy wp-post-image" alt="" data-src="<?=$post->hinhdaidien?>"></a></div>
                            <div class="singleContent">
                                <a class="entry-title" href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><?=$post->{$params->title}?></a>
                                <div class="entry-meta"><i class="fa fa-calendar" aria-hidden="true"></i><?=$ariacms->unixToDate($post->post_created, '/')?></div>
                                <div class="entry-desc"><?=text_limit($post->{$params->brief},20)?></div>
                            </div>
                        </div>   
                     <?php  } else {   ?>



              <?php 

                    if($key!=0 && $key<=2) {  ?>                    
                        <div class="grid-single">
                            <div class="singleThumb w100"><a href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><img width="173" height="123" src="<?=$post->hinhdaidien?>" class="b-lazy wp-post-image" alt="" data-src="<?=$post->hinhdaidien?>"></a></div>
                            <div class="singleContent">
                                <a class="entry-title" href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><?=$post->{$params->title}?></a>
                                <div class="entry-meta"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$ariacms->unixToDate($post->post_created, '/')?></div>
                            </div>
                        </div>
                      <?php } } } ?>  
                       
                    </div>
                    <div class="col col_5">
                         <?php  foreach($posts as $key => $post) { 
                            if($key>2) { ?>               
                        <div class="grid-single">
                            <div class="singleThumb w100"><a href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><img width="173" height="123" src="<?=$post->hinhdaidien?>" class="b-lazy wp-post-image" alt="" data-src="<?=$post->hinhdaidien?>"></a></div>
                            <div class="singleContent">
                                <a class="entry-title" href="<?=$ariacms->actual_link?>chi-tiet/<?=$post->url_part?>.html"><?=$post->{$params->title}?></a>
                                <div class="entry-meta"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$ariacms->unixToDate($post->post_created, '/')?></div>
                            </div>
                        </div>
                         <?php }} ?>               
                        
                                   
                    </div>
</div>

   <?php 

 $i++; 

}  

?>                     
    <!-- grid-1 loaded -->
                        
    <!-- grid-4 loaded -->
                      
<!-- grid-1 loaded -->
                      
    </div>