<?php
include_once('FileManager/class/FileManager.php');
?>
<table border="0" style="width:100%; height:100%"><tr>
    <td align="center">
    <?php 
	
	// Khi chuyển lên website cần chỉnh lại các tham số bên dưới //
    $FileManager = new FileManager();
    $FileManager->tmpFilePath = __dir__.'/FileManager/tmp';
	
	if(isset($_SESSION["user"]) and $_SESSION["xkt_timesession"] > 0){
		if($_SESSION["user"]["role_type"] == "ADMIN"){
			$FileManager->rootDir = __dir__.'/upload';
			if (!file_exists($FileManager->rootDir)) {
				mkdir($FileManager->rootDir, 0777, true);
			}
			$member_id = '';
		}else{
			$thanhvien = "news_images".$_SESSION["user"]["id"];
			$FileManager->rootDir = __dir__.'/upload/'.$thanhvien;
			if (!file_exists($FileManager->rootDir)) {     
				mkdir($FileManager->rootDir, 0777, true); 
			}
			$member_id = $thanhvien;
		}
	}
	if(isset($_SESSION["member"]) && $_SESSION["member_timesession"] > 0 ){
		$member_id = 'member/hinhanh'.$_SESSION["member"]['id'];
		$FileManager->loginPassword  = false;
	}else{
		$member_id = 'member/hinhanh';
		$FileManager->loginPassword  = true;
	}
	$FileManager->rootDir = __dir__.'/upload/'.$member_id;
	
	if (!file_exists($FileManager->rootDir)) {
		mkdir($FileManager->rootDir, 0777, true); 
	}
	
	//$FileManager->rootDir =  __dir__."/upload/member";
    $FileManager->fmWebPath  =  '/FileManager';
	//echo "dddddddd". __dir__;echo $FileManager->fmWebPath;
	// Phân quyền //
	$FileManager->enableUpload  = true;
	$FileManager->enablePermissions  = true;
	$FileManager->hideDisabledIcons  = true;
	$FileManager->useRightClickMenu  = true;
	$FileManager->enableEdit  = true;
	$FileManager->enableCopy  = true;
	$FileManager->enableSearch  = true;
	$FileManager->enableImageRotation  = false;
	$FileManager->enableBulkDownload  = false;
	$FileManager->replSpacesUpload  = true;
	$FileManager->lowerCaseUpload  = true;
	
	$FileManager->language  = 'vi';
	
	// In ra content
    print $FileManager->create();    
	
    ?>
	
    </td>
    </tr>
</table>
<script>
    function getUrlParam(paramName)
    {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
        var match = window.location.search.match(reParam);
        return (match && match.length > 1) ? match[1] : '';
    }
    //var mediaUrl= 'http://127.0.0.1:8083/upload';
    var mediaUrl= "/upload/<?php echo $member_id ?>";
</script>