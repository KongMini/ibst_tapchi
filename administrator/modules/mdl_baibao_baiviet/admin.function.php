<?php
class Model
{
	static function news_view_link($row)
	{
		global $ariacms;
		$url = $ariacms->actual_link . 'chi-tiet/' . $row->url_part . '.html';
		$str = '';
		$str .= '<a target="_blank" href="https://developers.google.com/speed/pagespeed/insights/?hl=vi&url='.$url.'&tab=mobile"><i class="fa fa-tachometer"></i></a>&nbsp;&nbsp;';
		$str .= '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $row->id . '\',\'ajax/news/ajax.news_view.php\')"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Cập nhật thông tin"></i></a>&nbsp;&nbsp;';
		//$str .= '<a href ="?module=news&task=news_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';
		if($row->status == 'active'){
			$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',1)"><i class="fa fa-ban" title="Gỡ bài" aria-hidden="true"></i></a>';
		}else {
			$str .= '<a href ="javascript:void(0);" onclick="aproved('.$row->id.',0)"><i class="fa fa-thumbs-up" title="Xuất bản" aria-hidden="true"></i></a>';
		}
		return $str;
	}

	static function news_view()
	{
		global $database;
		global $ariacms;
		
		// xử lý form tìm kiếm
		//=================BEGIN====================
		
		$where = $where1 = $where2 = $where3 = $where4 = $where5 = $where6 = $where7 = $trangthai = "";
	
		$keysearch = $_REQUEST['keysearch'];
		$status = $_REQUEST['status'];
		$user_review = $_REQUEST['user_review'];
		$category = $_REQUEST['category'];
		$status = $_REQUEST['status'];
		$post_type = $_REQUEST['post_type'];
		
		$query_status = " a.status = '".$status."' ";
		// điều kiện 1:  người duyệt
		if($_REQUEST['user_review']){
			$user_review = $_REQUEST['user_review'];
			if($user_review != ""){
				$where1 = "and a.user_aproved = ".$user_review;
			}	
		}
		// điều kiện 2:  danh mục
		if($_REQUEST['category']){
			$category = $_REQUEST['category'];
			if($category != ""){
				//$where2 = " and c.category like '%$category%'";
				$where2 = " and c.category_id = '$category'";
			}	
		}	
		// điều kiện 3: keysearch:
		if($_REQUEST['keysearch']){
			$keysearch = $_REQUEST['keysearch'];
			if($keysearch != ""){
				$where = " and a.title_vi like  '%$keysearch%'";
			}	
		}
        // điều kiện 4: mabaibao
        if($_REQUEST['mabaibao']) {
            $keysearch = $_REQUEST['mabaibao'];
            if ($keysearch != "") {
                $where4 = " and a.mabaibao =  '$keysearch'";
            }
        }
        // điều kiện 5: Linh vực - Số tạp chí
        if($_REQUEST['id_linhvuc']) {
            $keysearch = $_REQUEST['id_linhvuc'];
            if ($keysearch != "") {
                $where5 = " and a.id_linhvuc =  $keysearch";
            }
        }
            // điều kiện 6: người tạo
		if($_REQUEST['user_created']){
			$user_created = $_REQUEST['user_created'];
			if($user_created != ""){
				$where6 = " and a.id_tacgia = ".$user_created;
			}	
		}
		     // điều kiện 7: người tạo
		if($_REQUEST['status']){
			$user_created = $_REQUEST['status'];
			if($user_created != ""){
				$where7 = " and a.status = '".$user_created ."'";
			}	
		}
		
		//echo "AAAAA".$_SESSION['user']['role_type'];
		
		if($_SESSION['user']['role_type'] != 'ADMIN' && $_SESSION['user']['role_type'] != 'CHECK' && $_SESSION['user']['role_type'] != 'POST'){
			$where6 = " and a.user_created = ".$_SESSION['user']['id'];
			$users = $ariacms->selectAll('e4_users', 'id='.$_SESSION['user']['id'], '');
		}else{
			$users = $ariacms->selectAll('e4_users', '', '');
		}
		
//		if($_REQUEST['tab'] == 'waiting'){
//			$trangthai = " and a.status = 'waiting'";
//		}elseif($_REQUEST['tab'] == 'xuatban'){
//			$trangthai = " and a.status = 'xuatban'";
//		}elseif($_REQUEST['tab'] == 'chokiemduyet'){
//			$trangthai = " and a.status = 'chokiemduyet'";
//		}elseif($_REQUEST['tab'] == 'chotiepnhan'){
//				$trangthai = " and a.status = 'chotiepnhan'";
//		}
//		elseif($_REQUEST['tab'] == 'khongduocduyet'){
//			$trangthai = " and a.status = 'khongduocduyet'";
//		}
//		elseif($_REQUEST['tab'] == 'dago'){
//			$trangthai = " and a.status = 'dago'";
//		}
//		else{
//			$_REQUEST['tab'] = 'waiting';
//			$trangthai = " and a.status = 'waiting'";
//		}
        if($_SESSION['user']['role_type'] == "CHECK" ){
            $trangthai = " and (a.status = 'khongpheduyetpb' or  a.status = 'chokiemduyet' or a.status = 'chonlaipb' or a.status = 'kiemduyetphanhoipb') " ;
        }else if($_SESSION['user']['role_type'] == "POST"){
            $trangthai = " and a.status = 'moipb' or a.status = 'thaythepb' or a.status = 'pheduyetpb'" ;
        }
		 $trangthai = "";
        //echo $_SESSION['user']['role_type'];
        //
		$where = $trangthai.$where1.$where2.$where3.$where4.$where5.$where6.$where7 . ' and a.id IN (SELECT MAX(id) FROM e4_baibao GROUP BY mabaibao ) ' ;
		//===================END====================
		$order = ' order by a.aproved_date desc';

		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";
		
		$query = "SELECT a.*, b.fullname, c.title_vi as sotapchi, c.nam as namtapchi FROM `e4_baibao` a  
                    LEFT JOIN e4_users b ON a.id_tacgia = b.id 
                    LEFT JOIN e4_linhvuc c ON a.id_linhvuc = c.id 
                       WHERE 1 = 1 " . $where . " order by a.id desc  ".$limit;// . $where . $order . $limit a.id IN ( SELECT MAX(id) FROM `e4_baibao` GROUP BY mabaibao )
	
		$database->setQuery($query);
		$news = $database->loadObjectList();

        $query = "SELECT * from e4_linhvuc order by id desc ";
        $database->setQuery($query);
        $linhvuc = $database->loadObjectList();

		/**/
		$query = "SELECT COUNT(id) total FROM e4_baibao a WHERE 1= 1 ".$where;
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		$totalNews=$totalRows['total'];
		View::news_view($news, $totalNews, $maxRows, $curPg, $users, $linhvuc);
	}

	static function move_file($file, $to){
		$path_parts = pathinfo($file);
		$newplace   = "$to/{$path_parts['basename']}";
		if(rename($file, $newplace))
			return $newplace;
		return null;
	}
	
	static function news_edit()
	{
		global $database;
		global $ariacms;
		//echo $_REQUEST["submit"]; die;
		
		if ($_REQUEST["submit"] != "") {

            $link ="index.php?module=baibao_tacgia";

			// lấy dữ liệu từ form
            $phanbien_user =  $_REQUEST['phanbien'];

			$row = new stdClass;
			$row->id 		= $_GET['id'];
            $row->status 	= $_REQUEST['submit'];
			$row->date_update 	= time();

            // Cập nhật trạng thái
			$id_baibao = $database->updateObject('e4_baibao', $row, 'id');

			if ($id_baibao) {
				
				// insert Mời phản biện
				if($_SESSION['user']['role_type'] == "CHECK"){
                    if($_REQUEST['submit']){
                        //print_r($phanbien_user);die;
                        if($_REQUEST['submit'] == 'moipb'){

                            // xóa bản ghi cũ
                            $ariacms->delete("e4_phanbien", 'mabaibao = '.$_REQUEST['mabaibao'] .' And id_baibao='. $_GET['id']);

                            // insert lại
                            $time = time();
                            foreach ($phanbien_user as $value){
                                $row_phanbien = new stdClass;
                                $row_phanbien->id = null;
                                $row_phanbien->id_tacgia = $_REQUEST['id_tacgia'];
                                $row_phanbien->mabaibao = $_REQUEST['mabaibao'];
                                $row_phanbien->id_baibao = $_GET['id'];
                                $row_phanbien->id_nguoiphanbien = $value;
                                $row_phanbien->trangthai = 0;
                                $row_phanbien->time = $time;

                                $database->insertObject('e4_phanbien', $row_phanbien, 'id');
                            }
                        }

                        if($_REQUEST['submit'] == 'thaythepb'){

                            $array_thaythepb = explode(",", $_REQUEST['array_thaythepb']);

                            $query = "SELECT * FROM `e4_phanbien` WHERE mabaibao ='". $_REQUEST["mabaibao"] ."' and id_baibao = ".$_GET["id"] . " ORDER BY id";
                            $database->setQuery($query);
                            $danhsachpb = $database->loadObjectList();

                            // Mời lại phản biện
                            $time = time();
                            foreach ($phanbien_user as $key => $value){

                                if (in_array($key, $array_thaythepb) and $danhsachpb[$key] -> id_nguoiphanbien > 0)
                                {
                                    $row_phanbien = new stdClass;
                                    $row_phanbien->id = $danhsachpb[$key] -> id;
                                    $row_phanbien->id_tacgia = $_REQUEST['id_tacgia'];
                                    $row_phanbien->mabaibao = $_REQUEST['mabaibao'];
                                    $row_phanbien->id_baibao = $_GET['id'];
                                    $row_phanbien->id_nguoiphanbien = $value;
                                    $row_phanbien->trangthai = 4; // 4: mời lại
                                    $row_phanbien->ngayguipb = 0;
                                    $row_phanbien->ngaydongypb = 0;
                                    $row_phanbien->ngaypb = 0;
                                    $row_phanbien->time = $time;

                                    $database->updateObject('e4_phanbien', $row_phanbien, 'id');
                                }
                            }
                        }

                        // cập nhât trạng thái
                        $row = new stdClass;
                        $row->id 			= $_GET['id'];
                        $row->status 	= $_REQUEST['submit'];
                        $row->date_update 	= time();
                        $database->updateObject('e4_baibao', $row, 'id');
                    }
				}
				
				// Kiểm duyệt -> sẽ gửi cho người phản biện
				if($_SESSION['user']['role_type'] == "POST" ){

					// Chấp nhận phản biện
                    if($_REQUEST['submit'] == 'chopb'){
                        // Lấy người phản biên -> gửi mail mời phản biện
                        $query = "SELECT e4_users.*,e4_phanbien.id as id_phanbien   FROM `e4_phanbien`
                        LEFT JOIN e4_users on e4_phanbien.id_nguoiphanbien = e4_users.id
                        WHERE (trangthai = 0 || trangthai = 4) and mabaibao = '". $_REQUEST['mabaibao']."' and id_baibao = ". $_GET['id']."";// . $where . $order . $limit
                        $database->setQuery($query);
                        $nguoiphanbien = $database->loadObjectList();

                        // lấy nội dung
                        $id = $_GET['id'];
                        $query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = $id";
                        $database->setQuery($query);
                        $news_detail = $database->loadRow();

                        // Gửi email báo cáo đến email quản lý
                        foreach($nguoiphanbien as $ad){
						
                            $subject2 = "Tạp chí IBST mời phản biện";

                            $content2='
						<h3>Kính gửi: '. $ad->fullname . '</h3>
						<p>Tôi sẽ rất cảm ơn nếu bạn phản biện bài báo có tựa đề `'.$news_detail["title_vi"] .'` cho tạp chí này</p>
						<p>Tên bài: '.$news_detail["title_vi"].'</p>
						<p>Tóm tắt: '.$news_detail["brief_vi"].'</p>
						<p>Tài liệu tham khảo: '.$news_detail["tailieuthamkhao"].'</p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/dong-y-phan-bien.html?mabaibao='.$news_detail["mabaibao"].'&id_phanbien='.$ad -> id_phanbien.'&id='.$news_detail["id"] .'">Nhấn vào đây đồng ý phản biên</a></p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/tu-choi-phan-bien.html?mabaibao='.$news_detail["mabaibao"].'&id_phanbien='.$ad -> id_phanbien.'&id='. $news_detail["id"].'">Nhấn vào đây từ chối phản biên</a></p>
					';
                            // Gửi email cho khách hàng
                            if($ariacms -> sendMail( $ad->email , $ad->fullname,$subject2,$content2)){

                                // update time
                                $time = time();
                                $row_phanbien             = new stdClass;
                                $row_phanbien->id         = $ad -> id_phanbien;
                                $row_phanbien->trangthai  = 0;
                                $row_phanbien->time       = $time;
                                $row_phanbien->ngayguipb  = $time;

                                $database->updateObject('e4_phanbien', $row_phanbien, 'id');
                                //sendMail($to_email,$to_name,$subject,$content);
                                //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
                                //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
                            }
                        }
                    }

                    //Chọn lại phản biện
                    if($_REQUEST['submit'] == 'chonlaipb'){
                        $query = "SELECT * FROM `e4_phanbien` WHERE trangthai = 4 and  mabaibao ='". $_REQUEST["mabaibao"] ."' and id_baibao = ".$_GET["id"] . " ORDER BY id";
                        $database->setQuery($query);
                        $danhsachpb = $database->loadObjectList();

                        // Mời lại phản biện
                        $time = time();
                        foreach ($phanbien_user as $key => $value){
                            $row_phanbien = new stdClass;
                            $row_phanbien->id = $danhsachpb[$key] -> id;
                            $row_phanbien->id_tacgia = $_REQUEST['id_tacgia'];
                            $row_phanbien->mabaibao = $_REQUEST['mabaibao'];
                            $row_phanbien->id_baibao = $_GET['id'];
                            $row_phanbien->id_nguoiphanbien = $value;
                            $row_phanbien->trangthai = 5; // 5: Không đông ý
                            $row_phanbien->ngayguipb = 0;
                            $row_phanbien->ngaydongypb = 0;
                            $row_phanbien->ngaypb = 0;
                            $row_phanbien->time = $time;
                            $database->updateObject('e4_phanbien', $row_phanbien, 'id');
                        }
                    }

                    // Gửi cho tác giả
                    if($_REQUEST['submit'] == 'phanhoitacgia'){
                        $query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = ".$_GET['id'];// . $where . $order . $limit
                        $database->setQuery($query);
                        $tacgia = $database->loadRow();
                        // Gửi email báo cáo đến email quản lý


                        $subject2 = "Góp ý bài báo";
                        $content2='
                        <h3>Chào bạn: '. $tacgia["fullname"] .'</h3>
                        <p>Sau khi kiểm duyệt bài báo, chúng tôi có góp ý về bài báo '. $tacgia["title_vi"] .'</p>
                        <p>Vui lòng người tiếp nhận kiểm tra.</p>
                        <p><a target="_blank" href="'.$ariacms->actual_link.'member/sua-bai-viet.html?id='.$_GET['id'].'&mabaibao='.$tacgia["mabaibao"]. '>Nhấn vào đây để xem:</a></p>
                        
                        ';
                        // Gửi email cho khách hàng
                        if($ariacms -> sendMail(  $tacgia["email"] , $tacgia["fullname"],$subject2,$content2)){

                        }

                    }
				}

                // Người quản trị
				if( $_SESSION['user']['role_type'] == "ADMIN" ){

                    // Kiểm duyệt và Lựa chọn phản biện
                    if($_REQUEST['submit'] == 'chokiemduyet'){
                        //Gửi mail cho tác giả';die;
                        $query = "SELECT * FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'CHECK'";// . $where . $order . $limit
                        $database->setQuery($query);
                        $banKH = $database->loadObjectList();
                        // Gửi email tới ban khoa học
                        foreach ($banKH as $k => $user){
                            $subject2 = "Kiểm duyệt bài báo";
                            $content2='
                            <h3>Chào: '. $user->fullname .'</h3>
                            <p>Sau khi kiểm tra bài báo, Đội ngũ admin chúng tôi mong muốn ban KH tiếp nhận kiểm duyệt bài báo</p>
                            <p>Vui lòng người tiếp nhận kiểm tra.</p>
                            <p><a target="_blank" href="'.$ariacms->actual_link.'administrator/index.php?module=baibao_tacgia&task=news_edit&id='.$_GET['id'].'">Nhấn vào đây để xem:</a></p>
                            
                            ';
                            // Gửi email cho khách hàng
                            $ariacms -> sendMail(  $user->email , $user->fullname,$subject2,$content2);
                            if($k ==  count($banKH) - 1){
                                // cập nhât trạng thái phản biện
                                $row = new stdClass;
                                $row->id 			= $_GET['id'];
                                $row->status 	= 'chokiemduyet';
                                $row->date_update 	= time();
                                $database->updateObject('e4_baibao', $row, 'id');

                            }
                        }



//                        $query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = ".$_GET['id'];// . $where . $order . $limit
//                        $database->setQuery($query);
//                        $tacgia = $database->loadRow();
//                        // Gửi email báo cáo đến email quản lý
//                        $subject2 = "Kiểm duyệt bài báo";
//                        $content2='
//                        <h3>Chào bạn: '. $tacgia["fullname"] .'</h3>
//                        <p>Sau khi kiểm duyệt bài báo, chúng tôi có góp ý về bài báo '. $tacgia["title_vi"] .'</p>
//                        <p>Vui lòng người tiếp nhận kiểm tra.</p>
//                        <p><a target="_blank" href="'.$ariacms->actual_link.'member/sua-bai-viet.html?id='.$_GET['id'].'">Nhấn vào đây để xem:</a></p>
//
//                        ';
//                        // Gửi email cho khách hàng
//                        if($ariacms -> sendMail(  $tacgia["email"] , $tacgia["fullname"],$subject2,$content2)){
//
//                            // cập nhât trạng thái phản biện
//                            $row = new stdClass;
//                            $row->id 			= $_GET['id'];
//                            $row->status 	= 'waiting';
//                            $row->date_update 	= time();
//                            $database->updateObject('e4_baibao', $row, 'id');
//
//                        }
                    }

                    // Lựa chọn phản biện thay thế khi khi có phản biện từ chối
                    if($_REQUEST['submit'] == 'chonlaipb'){

                        //Gửi mail cho tác giả';die;
                        $query = "SELECT * FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'CHECK'";// . $where . $order . $limit
                        $database->setQuery($query);
                        $banKH = $database->loadObjectList();
                        // Gửi email tới ban khoa học
                        foreach ($banKH as $k => $user){
                            $subject2 = "Thay thế phản biện bài báo";
                            $content2='
                            <h3>Chào: '. $user->fullname .'</h3>
                            <p>Sau khi kiểm tra bài báo, Đội ngũ admin chúng tôi mong muốn ban KH tiếp nhận kiểm duyệt bài báo</p>
                            <p>Vui lòng người tiếp nhận kiểm tra.</p>
                            <p><a target="_blank" href="'.$ariacms->actual_link.'administrator/index.php?module=baibao_tacgia&task=news_edit&id='.$_GET['id'].'">Nhấn vào đây để xem:</a></p>
                            
                            ';
                            // Gửi email cho khách hàng
                            $ariacms -> sendMail(  $user->email , $user->fullname,$subject2,$content2);
                            if($k ==  count($banKH) - 1){
                                // cập nhât trạng thái phản biện
                                $row = new stdClass;
                                $row->id 			= $_GET['id'];
                                $row->status 	= 'chonlaipb';
                                $row->date_update 	= time();
                                $database->updateObject('e4_baibao', $row, 'id');

                            }
                        }



//                        $query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = ".$_GET['id'];// . $where . $order . $limit
//                        $database->setQuery($query);
//                        $tacgia = $database->loadRow();
//                        // Gửi email báo cáo đến email quản lý
//                        $subject2 = "Kiểm duyệt bài báo";
//                        $content2='
//                        <h3>Chào bạn: '. $tacgia["fullname"] .'</h3>
//                        <p>Sau khi kiểm duyệt bài báo, chúng tôi có góp ý về bài báo '. $tacgia["title_vi"] .'</p>
//                        <p>Vui lòng người tiếp nhận kiểm tra.</p>
//                        <p><a target="_blank" href="'.$ariacms->actual_link.'member/sua-bai-viet.html?id='.$_GET['id'].'">Nhấn vào đây để xem:</a></p>
//
//                        ';
//                        // Gửi email cho khách hàng
//                        if($ariacms -> sendMail(  $tacgia["email"] , $tacgia["fullname"],$subject2,$content2)){
//
//                            // cập nhât trạng thái phản biện
//                            $row = new stdClass;
//                            $row->id 			= $_GET['id'];
//                            $row->status 	= 'waiting';
//                            $row->date_update 	= time();
//                            $database->updateObject('e4_baibao', $row, 'id');
//
//                        }
                    }

                    // Yêu cầu kiểm duyệt phản hồi của phản biện
                    if($_REQUEST['submit'] == 'kiemduyetphanhoipb'){

                        //Gửi mail cho tác giả';die;
                        $query = "SELECT * FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'CHECK'";// . $where . $order . $limit
                        $database->setQuery($query);
                        $banKH = $database->loadObjectList();
                        // Gửi email tới ban khoa học
                        foreach ($banKH as $k => $user){
                            $subject2 = "Kiểm duyệt phản hồi của phản biện";
                            $content2='
                            <h3>Chào: '. $user->fullname .'</h3>
                            <p>Sau khi kiểm tra bài báo, Đội ngũ admin chúng tôi mong muốn ban KH tiếp nhận kiểm duyệt phản hồi của phản biện</p>
                            <p>Vui lòng tiếp nhận kiểm tra.</p>
                            <p><a target="_blank" href="'.$ariacms->actual_link.'administrator/index.php?module=baibao_tacgia&task=news_edit&id='.$_GET['id'].'">Nhấn vào đây để xem:</a></p>
                            
                            ';
                            // Gửi email cho khách hàng
                            $ariacms -> sendMail(  $user->email , $user->fullname,$subject2,$content2);
                            if($k ==  count($banKH) - 1){

                            }
                        }



//                        $query = "SELECT * FROM `e4_baibao` a LEFT JOIN e4_users b ON a.id_tacgia = b.id WHERE a.id = ".$_GET['id'];// . $where . $order . $limit
//                        $database->setQuery($query);
//                        $tacgia = $database->loadRow();
//                        // Gửi email báo cáo đến email quản lý
//                        $subject2 = "Kiểm duyệt bài báo";
//                        $content2='
//                        <h3>Chào bạn: '. $tacgia["fullname"] .'</h3>
//                        <p>Sau khi kiểm duyệt bài báo, chúng tôi có góp ý về bài báo '. $tacgia["title_vi"] .'</p>
//                        <p>Vui lòng người tiếp nhận kiểm tra.</p>
//                        <p><a target="_blank" href="'.$ariacms->actual_link.'member/sua-bai-viet.html?id='.$_GET['id'].'">Nhấn vào đây để xem:</a></p>
//
//                        ';
//                        // Gửi email cho khách hàng
//                        if($ariacms -> sendMail(  $tacgia["email"] , $tacgia["fullname"],$subject2,$content2)){
//
//                            // cập nhât trạng thái phản biện
//                            $row = new stdClass;
//                            $row->id 			= $_GET['id'];
//                            $row->status 	= 'waiting';
//                            $row->date_update 	= time();
//                            $database->updateObject('e4_baibao', $row, 'id');
//
//                        }
                    }

                    // else{
					// 	//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");	
					// 	echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
					// }
				}
				
				$ariacms->redirect("", $link);
			}else{
				echo $database->stderr();
			}

		} else {
			View::news_edit();
			//$ariacms->redirect("", "javascript:history.back()");
		}
		
	}
	
	static function news_delete()
	{
		global $ariacms;
		global $database;
		$id	= $_REQUEST["id"];
		
		$query = "SELECT * FROM e4_posts a WHERE a.id =".$id;
		$database->setQuery($query);
		$PostRows = $database->loadRow();
		
		$row_history = new stdClass;
		$row_history->action = 'delete';
		$row_history->id_post = $id;
		foreach($PostRows as $key2 => $value2){
			if(!is_numeric($key2)){
				$row_history->$key2 = $value2;
			}
		}
		
		$row_history->user_modified = $_SESSION["user"]['id'];
		$row_history->id = NULL;
		$database->insertObject('e4_posts_history', $row_history, 'id'); // Thêm vào bảng lịch sử thao tác
		
		$ariacms->delete('e4_posts', 'id=' . $id);
		$ariacms->delete('e4_posts_meta', 'post_id=' . $id);
		$taxonomies = $ariacms->selectAll('e4_term_relationships', 'object_id=' . $id . ' AND object_type="post" ', '');
		foreach ($taxonomies as $taxonomy) {
			$query = "UPDATE e4_term_taxonomy SET count = (SELECT COUNT(*) total FROM e4_term_relationships 
			WHERE term_taxonomy_id = " . $taxonomy->term_taxonomy_id . " AND object_type = 'post') WHERE id = " . $taxonomy->term_taxonomy_id;
			$database->setQuery($query);
			$database->query();
		}
		$ariacms->delete('e4_term_relationships', 'object_id=' . $id . ' AND object_type="post" ');
		$ariacms->redirect("", "javascript:history.back()");
	}
}
