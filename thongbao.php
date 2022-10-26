<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Include Configuration File
if (file_exists("configuration.php")) {
    require_once("configuration.php");
} else {
    echo "Missing Configuration File";
    exit();
}
// Include Language File
if (file_exists("languages/lang." . $ariaConfig_language . ".php")) {
    require_once("languages/lang." . $ariaConfig_language . ".php");
} else {
    echo "Missing Language File";
    exit();
}
// Include Params File
if (file_exists("params/params." . $ariaConfig_language . ".php")) {
    require_once("params/params." . $ariaConfig_language . ".php");
} else {
    echo "Missing Params File";
    exit();
}
// Include Database Controller
if (file_exists("include/database.php")) {
    require_once("include/database.php");
} else {
    echo "Missing Database File";
    exit();
}
// Include System File
if (file_exists("include/ariacms.php")) {
    require_once("include/ariacms.php");
} else {
    echo "Missing System File";
    exit();
}
// Set file sendmail
if (file_exists("plugins/phpmailer/class.phpmailer.php")) {
    require_once("plugins/phpmailer/class.phpmailer.php");
} else {
    echo "Missing Mailer File";
    exit();
}
/** Setup Global variables */

$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();
$params = new params();

//SELECT * FROM `e4_phanbien` WHERE trangthai = 0  and (1662779340 - ngayguipb > 432000 and 1662779340 - ngayguipb < 516000);
// Thông báo nhắc đồng ý phản biện
$query = "SELECT b.fullname, c.*, a.* FROM `e4_phanbien` a 
    LEFT JOIN e4_users b ON a.id_nguoiphanbien = b.id 
    LEFT JOIN e4_baibao c ON a.id_baibao = c.id
    WHERE a.trangthai = 0  and (1662779340 - a.ngayguipb > 432000 and 1662779340 - a.ngayguipb < 516000)";
$database->setQuery($query);
$nhacdongy = $database->loadObjectList();

foreach ($nhacdongy as $ad){
    $subject2 = "Tạp chí IBST nhắc bạn trả lời phản biện";

    $content2='
            <h3>Kính gửi: '. $ad->fullname .'</h3>
            <p>Tôi sẽ rất cảm ơn nếu bạn phản biện bài báo có tựa đề `'.$ad->title_vi .'` cho tạp chí này</p>
            <p>Tên bài: '.$ad->title_vi.'</p>
            <p>Tóm tắt: '.$ad->brief_vi.'</p>
            <p>Từ khóa: '.$ad->tukhoa.'</p>
            <p>Tài liệu tham khảo: '.$ad->tailieuthamkhao.'</p>
            <p><a target="_blank" href="'.$ariacms->actual_link.'member/dong-y-phan-bien.html?mabaibao='.$ad -> mabaibao.'&id_phanbien='.$ad -> id_phanbien.'&id='.$ad->id .'">Nhấn vào đây đồng ý phản biên</a></p>
            <p><a target="_blank" href="'.$ariacms->actual_link.'member/tu-choi-phan-bien.html?mabaibao='.$ad -> mabaibao.'&id_phanbien='.$ad -> id_phanbien.'&id='.$ad->id .'">Nhấn vào đây từ chối phản biên</a></p>
					';
    // Gửi email cho khách hàng
    if($ariacms -> sendMail( $ad->email , $ad->fullname,$subject2,$content2)){


        $database->updateObject('e4_phanbien', $row_phanbien, 'id');
        //sendMail($to_email,$to_name,$subject,$content);
        //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
        //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
    }
}

//SELECT * FROM `e4_phanbien` WHERE trangthai = 1  and 1662779340 - ngayguipb > 432000;;
// Thông báo nhắc đồng ý phản biện
$query = "SELECT b.fullname, c.*, a.* FROM `e4_phanbien` a 
    LEFT JOIN e4_users b ON a.id_nguoiphanbien = b.id 
    LEFT JOIN e4_baibao c ON a.id_baibao = c.id
    WHERE a.trangthai = 1  and (1662779340 - a.ngaydongypb > 604800 and 1662779340 - a.ngaydongypb < 688800)";
$database->setQuery($query);
$nhacdongy = $database->loadObjectList();

foreach ($nhacdongy as $ad){
    $subject2 = "Tạp chí IBST nhắc bạn phản biện bài báo";

    $content2='
            <h3>Kính gửi: '. $ad->fullname .'</h3>
            <p>Tôi sẽ rất cảm ơn nếu bạn phản biện bài báo có tựa đề `'.$ad->title_vi .'` cho tạp chí này</p>
            <p>Tên bài: '.$ad->title_vi.'</p>
            <p>Tóm tắt: '.$ad->brief_vi.'</p>
            <p>Từ khóa: '.$ad->tukhoa.'</p>
            <p>Tài liệu tham khảo: '.$ad->tailieuthamkhao.'</p>
            <p><a target="_blank" href="'.$ariacms->actual_link.'member/dong-y-phan-bien.html?mabaibao='.$ad -> mabaibao.'&id_phanbien='.$ad -> id_phanbien.'&id='.$ad->id .'">Nhấn vào đây đồng ý phản biên</a></p>
            <p><a target="_blank" href="'.$ariacms->actual_link.'member/tu-choi-phan-bien.html?mabaibao='.$ad -> mabaibao.'&id_phanbien='.$ad -> id_phanbien.'&id='.$ad->id .'">Nhấn vào đây từ chối phản biên</a></p>
					';
    // Gửi email cho khách hàng
    if($ariacms -> sendMail( $ad->email , $ad->fullname,$subject2,$content2)){


        $database->updateObject('e4_phanbien', $row_phanbien, 'id');
        //sendMail($to_email,$to_name,$subject,$content);
        //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
        //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
    }
}


$query = "UPDATE e4_posts SET view_ngay = 0";
//echo $query;
$database->setQuery($query);
if ($database->query()) {
}else{
}

?>