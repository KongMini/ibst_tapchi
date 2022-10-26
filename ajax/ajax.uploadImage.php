<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0); //echo "dddd";
// Include Configuration File
if (file_exists("../configuration.php")) {
  require_once("../configuration.php");
} else {
  echo "Missing Configuration File";
  exit();
}
// Include Language File
if (file_exists("../languages/lang." . $ariaConfig_language . ".php")) {
  require_once("../languages/lang." . $ariaConfig_language . ".php");
} else {
  echo "Missing Language File";
  exit();
}
// Include Params File
if (file_exists("../params/params." . $ariaConfig_language . ".php")) {
  require_once("../params/params." . $ariaConfig_language . ".php");
} else {
  echo "Missing Params File";
  exit();
}
// Include Database Controller
if (file_exists("../include/database.php")) {
  require_once("../include/database.php");
} else {
  echo "Missing Database File";
  exit();
}
// Include System File
if (file_exists("../include/ariacms.php")) {
  require_once("../include/ariacms.php");
} else {
  echo "Missing System File";
  exit();
}
// Set file sendmail
if (file_exists("../plugins/phpmailer/class.phpmailer.php")) {
  require_once("../plugins/phpmailer/class.phpmailer.php");
} else {
  echo "Missing Mailer File";
  exit();
}
/* Setup Global variables */
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();
$params = new params();



if(isset( $_FILES['hinhanh'])){

   /* Getting file name */
   $fileName = $_FILES['hinhanh']["name"];
	
	$targetDir = "upload/member".$_SESSION["member"]["id"]."/";
			//$allowTypes = array('jpg','png','jpeg','gif');
	if(!file_exists($targetDir)){
		if(mkdir($targetDir)){
			//echo "Tạo thư mục thành công.";
		} else{
			//echo "ERROR: Không thể tạo thư mục.";
		}
	} else{
		//echo "ERROR: Thư mục đã tồn tại.";
	}
	
	
	if($_FILES['hinhanh']['name']){
		$image_name = $_FILES['hinhanh']['name'];
		$tmp_name   = $_FILES['hinhanh']['tmp_name'];
		$size       = $_FILES['hinhanh']['size'];
		$type       = $_FILES['hinhanh']['type'];
		$error      = $_FILES['hinhanh']['error'];
		
		$fileName = basename(str_replace(",","_",$_FILES['hinhanh']['name']));
		$targetFilePath = "../".$targetDir . $fileName;
		
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		
		if(move_uploaded_file($_FILES['hinhanh']['tmp_name'],$targetFilePath)){
			$images =$targetDir . $fileName;
		}
		//$images = "aaaaaaa";
	}
   echo $images;
   exit;
}else{
echo "11111111";
}
?>
<?php /* if($posts){
	if(!$ariacms->checkUserLogin()){
		$lightbox = "uk-toggle";
		$url_login = '#modal-login';
		$url_post = '#modal-login';
	}else{
		$lightbox = "";
		$url_login = "javascript:;";
		$url_post = '/member/tao-bai-viet.html';
	}
	$i = 0;
	foreach($posts  as $post){ 
	$i++;
	$like="";
	if($array_liked[$post->id] > -1){
		$like = 'style="color: blue;"';
	}
	?>
			<div class="lg:flex lg:space-x-6 py-6 danhsachtin">
				
				<div class="flex-1 lg:pt-0 pt-4">
					
					<div class="story__meta">
						<div class="story__avatar">
							<img src="<?if($post->image_url) echo $post->image_url; else echo "/upload/noiavatar.png"; ?>" alt="Mạnh Quân" class="img-fluid rounded-circle">
						</div>
						<div class="story__info">
							<h3 class="story__author"><?=$post->fullname?></h3>
							<?php
							$first_date = time();
							$secon_date = $post->post_created;
							$diff = abs($first_date - $secon_date);
							$phut = $diff / 24;
							
							if($phut >= 60){
								$gio = floor($phut/60);
								if($gio < 48){
									$hienthingay = floor($gio).' giờ trước';
								}else{
									$hienthingay = date('H:i d/m/Y',$post->post_created);
								}
							}else{
								$hienthingay = floor($phut).' phút trước';
							}
							?>
							<div class="story__time"><time datetime="<?php echo date('Y-m-d H:i:s',$post->post_created) ?>" class="time-ago"><?=$hienthingay?></time></div>
						</div>
					</div>
					
					<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>" class="text-xl font-semibold line-clamp-2">  <?=$post->title_vi?></a>
					<p class="line-clamp-2 pt-1"> <?=$post->brief_vi?></p>
					
					<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>">
						<div class="w-full overflow-hidden relative shadow-sm"> 
							<img id="avt<?=$k?>" src="<?php if(trim($post->image)){echo  $post->image;} else {echo "/upload/noimage1.png";}?>" alt="" class="w-full h-full inset-0 object-cover">
						</div>
					</a>
					<div class="flex items-center pt-3">
						<style>
							.image{    
								height: 40px;
								width: 40px;
								margin-right: 5px;
								border: 100%;
							}
						</style>
						
						<div class="flex items-center" id="like<?=$post->id?>">  
							<a href="<?=$url_login;?>" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="likepost('<?=$post->id?>')" <?php } ?> class="items-center">
							<ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="thumbs up outline" <?= $like ?>></ion-icon> <?php echo $post->number_like ?> </a>
						</div>
						<div class="flex items-center mx-4" > 
							<a href="<?=$ariacms->actual_link . 'chi-tiet/' . $post->url_part . '.html';?>#comment<?= $post->id?>" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="commentpost('<?=$post->id?>','<?=$_SESSION["member"]['id']?>')" <?php } ?> class="items-center">
							<ion-icon name="chatbubble-ellipses-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon>  <?php echo $post->number_comment ?> 
							</a>
						</div>
						<div class="flex items-center mx-2" > 
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $ariacms->actual_link ?>chi-tiet/<?=$post->url_part?>.html" <?=$lightbox?> <?php if($url_login == 'javascript:;'){ ?> onclick="commentpost('<?=$post->id?>','<?=$_SESSION["member"]['id']?>')" <?php } ?> class="items-center">
								<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=164228616928969&autoLogAppEvents=1"></script>
											 
							 <ion-icon name="share-outline" class="text-xl mr-2 md hydrated" role="img" aria-label="chatbubble ellipses outline"></ion-icon> 
							</a>
						</div>
					</div>	
				</div>
			</div>
<?php } } */?> 