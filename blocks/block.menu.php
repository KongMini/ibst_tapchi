<?php
global $ariacms;
global $params;		
global $database;
global $ariaConfig_template;
global $web_menus;
$catid = $ariacms->getParam("task");
?>
<style>
	.sidebar .sidebar_inner ul li a svg {
    width: 26px;
    height: 26px;
    margin-right: 10px;
}
</style>
<div class="sidebar" style="padding-bottom:70px">
            <div class="sidebar_header"> 
                <img src="<?= $ariacms->actual_link ?>templates/<?= $ariaConfig_template ?>/images/logo.jpg" alt="">
                <img src="<?= $ariacms->actual_link ?>templates/<?= $ariaConfig_template ?>/images/logo.jpg" class="logo-icon" alt="">
                <span class="btn-mobile" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></span>

            </div>
        
            <div class="sidebar_inner" data-simplebar="init">
				
				<div class="simplebar-wrapper" style="margin: -5px -13px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -17px; bottom: 0px;"><div class="simplebar-content" style="padding: 5px 13px; height: 100%; overflow: hidden scroll;">
        
                <ul>
					<?php foreach ($web_menus as $key => $web_menu) { 
					if("tin-tuc/".$catid.".html"==$web_menu->url_html) $classmenu = "active"; else $classmenu = "";
					if($key < 9){
					?>
                    <li class="<?=$classmenu ?>"><a href="<?php echo $ariacms->actual_link . $web_menu->url_html; ?>"> 
                        <?php echo $web_menu->icon; ?>
                        <span><?php echo $web_menu->{$params->title}; ?></span> </a> 
                    </li>
					<?php }else{  ?>
                    <li id="more-veiw" hidden=""><a href="<?php echo $ariacms->actual_link . $web_menu->url_html; ?>"> 
                        <?php echo $web_menu->icon; ?>
                        <span> <?php echo $web_menu->{$params->title}; ?> </span></a> 
                    </li>
					<?php }} ?>
					
                </ul>
				<?php if(count($web_menus) > 9){ ?>
                <a href="#" class="see-mover h-10 flex my-1 pl-2 rounded-xl text-gray-600" uk-toggle="target: #more-veiw; animation: uk-animation-fade"> 
                    <span class="w-full flex items-center" id="more-veiw">
                        <svg class="  bg-gray-100 mr-2 p-0.5 rounded-full text-lg w-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                       Xêm thêm
                    </span>
                    <span class="w-full flex items-center" id="more-veiw" hidden="">
                        <svg class="bg-gray-100 mr-2 p-0.5 rounded-full text-lg w-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg> 
                       Thu gọn
                    </span>
                </a> 
				<?php } ?>
                <hr>

                <?php
					$query = "SELECT a.fullname,a.image_url, COUNT(b.id) as tong from e4_users a 
								LEFT JOIN e4_posts b on b.user_created = a.id
								 WHERE b.post_status = 'active'
								GROUP BY b.user_created
							   
								ORDER BY tong DESC LIMIT 5";
					$database->setQuery($query);
					$useronline = $database->loadObjectList();
					
					
					$query = "SELECT * FROM `e4_web_image` WHERE position='advertisement' and status ='active' ORDER BY id DESC";
					//echo $query ;
					$database->setQuery($query);
					$banner = $database->loadRow();
				
				?>
                <h3 class="text-lg mt-3 font-semibold ml-2 is-title"> Thành viên tích cực </h3>

                <div class="contact-list mt-2 ml-1">
					<?php foreach($useronline as $user){?>
                  
                    <a href="#">
                        <div class="contact-avatar">
                            <img src="<?php if(trim($user->image_url)) echo $user->image_url; else echo $ariacms->actual_link ."upload/noiavatar.png"?>" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"><?php echo $user->fullname; ?></div>
                    </a>
					<?php }?>
                    
                </div>

                <br>
                <br>
            
            </div></div></div><div class="simplebar-placeholder" style="width: 300px; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); visibility: hidden;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 473px; transform: translate3d(0px, 0px, 0px); visibility: visible;">
			</div>
			</div>
			</div>
        
        </div> 
