<?php
class Model
{
	// Form đăng bài
	public static function taobaiviet()
	{
		global $ariacms;
		global $database;
		
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		View::taobaiviet();
	}
	
	// Thành viên đăng bài
	function dangbaiviet(){
		global $ariacms;
		global $database;
			
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		$tieude = $_POST['tieude'];
		$tieude_en = $_POST['tieude_en'];
        $tacgia = $_POST['tacgia'];
		$tomtat = $_POST['tomtat'];
		$tomtat_en = $_POST['tomtat_en'];
		$file = $_POST['file'];
		$noidung = $_POST['noidung'];
        $chude = $_POST['chude'];
        $id_linhvuc = $_POST['id_linhvuc'];
        $tailieuthamkhao = $_POST['tailieuthamkhao'];
        $tukhoa = $_POST['tukhoa'];
        $tukhoa_en = $_POST['tukhoa_en'];
		$member_id = $_SESSION['member']['id'];
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		//$_SESSION['member']['publish'] = 1;
		if($member_id > 0 and $_SESSION['member']['publish'] == 1){

            $query = "SELECT count(id) as id FROM e4_baibao ";
            $database->setQuery($query);
            $total = $database->loadRow();
            $total = $total['id'];

			if($tieude !=""){
				// Thêm mới bài viết
				$new_post = new stdClass;
				$new_post -> id = null;
				$new_post -> mabaibao = bin2hex($total);
				$new_post -> title_vi = $tieude;
				$new_post -> title_en = $tieude_en;
				$new_post -> tacgia = $tacgia;
				$new_post -> brief_vi = $tomtat;
				$new_post -> brief_en = $tomtat_en;
				$new_post -> content_vi = $noidung;
				$new_post -> file = $file;
				$new_post -> id_chude = $chude;
				$new_post -> id_linhvuc = $id_linhvuc;
				$new_post -> tailieuthamkhao = $tailieuthamkhao;
				$new_post -> tukhoa = $tukhoa;
				$new_post -> tukhoa_en = $tukhoa_en;
				$new_post -> status = 'chotiepnhan'; // chờ duyệt
				$new_post -> date_created = time();
				$new_post -> id_tacgia = $member_id;
				$id = $database->insertObject('e4_baibao', $new_post, 'id');
				if($id > 0){
					$query = "SELECT a.* FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'ADMIN'  and a.publish = 1 ";// . $where . $order . $limit
					$database->setQuery($query);
					$admin = $database->loadObjectList();
					// Gửi email báo cáo đến email quản lý
					
					foreach($admin as $ad){
						$subject2 = "Bài báo mới của tác giả";
						$content2='
						<h3>Chào bạn: '. $ad->fullname .'</h3>
						<p>Tác giả '. $_SESSION['member']['fullname'] .' vừa gửi bài viết mới về hệ thống!</p>
						<p>Vui lòng người tiếp nhận kiểm tra.</p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'administrator/index.php?module=baibao_tacgia&task=news_edit&id='.$id.'">Nhấn vào đây để xem:</a></p>
					
					';
						// Gửi email cho khách hàng
						if($ariacms -> sendMail( $ad->email , $ad->fullname,$subject2,$content2)){
							//sendMail($to_email,$to_name,$subject,$content);
							//redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
							//echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
						}
						// else{
						// 	//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");	
						// 	echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
						// }
					}
					echo '<script language="javascript">alert("Thêm thành công, bài viết của bạn sẽ chờ quản trị viên kiểm duyệt trước khi xuất bản. Xin cảm ơn.");window.location.href ="/member/bai-viet.html";</script>';
				}else{
					echo $database->stderr();
					//echo '<script language="javascript">alert("Thêm thất bại.");window.history.back()</script>';
				}
			}else{
				echo '<script language="javascript">alert("Vui lòng điền đầy đủ thông tin.");window.history.back()</script>';
			}
		}else{
			echo '<script language="javascript">alert("Tài khoản của bạn chưa được kích hoạt.");window.history.back()</script>';
		}
	}
	
	// Quản lý bài viết
	function quanlybaiviet(){
		global $database;
		global $ariacms;
		
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$member_id = $_SESSION['member']['id'];
		
		// Lấy danh sách các bài viết của thành viên đăng
		$query = "SELECT a.* FROM e4_baibao a WHERE id_tacgia = '$member_id' order by a.id desc ";
		$database->setQuery($query);
		$member_posts = $database->loadObjectList();
        // Lấy danh sách các bài viết của thành viên đăng
        $query = "SELECT a.* FROM e4_baibao a WHERE id_tacgia = '$member_id' GROUP BY a.mabaibao order by a.id desc ";
		$database->setQuery($query);
		$member_posts_list = $database->loadObjectList();
		View::quanlybaiviet($member_posts, $member_posts_list);
		
	}

	// Quản lý phản biện
	function quanlyphanbien(){
		global $database;
		global $ariacms;
		
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$member_id = $_SESSION['member']['id'];
		
		// Lấy danh sách các bài viết của thành viên đăng
		$query = "SELECT c.*, b.* FROM e4_users a 
                        LEFT JOIN e4_phanbien b ON a.id = b.id_tacgia 
                        LEFT JOIN e4_baibao c ON b.id_baibao = c.id 
                        WHERE a.id = $member_id AND b.trangthai =1  order by c.id";
		$database->setQuery($query);
		$phanbien_posts = $database->loadObjectList();
		
		View::quanlyphanbien($phanbien_posts);
		
	}

	function phanbien(){
		global $database;
		global $ariacms;

        if($_POST){
            //print_r($_POST);die;
            // update

            $row = new stdClass;
            $row->id 			= $_POST['id'];
            $row->dongy 			= $_POST['dongy'];
            $row->trangthai     = 3;
            $row->file     =  $_POST['file'];
            $row->time 	= time();
            $row->ngaypb 	= time();

            $id_baibao = $database->updateObject('e4_phanbien', $row, 'id');

            // gửi mail cho người tiếp nhận
            if($id_baibao > 0){
                $query = "SELECT a.* FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'ADMIN'  and a.publish = 1 ";// . $where . $order . $limit
                $database->setQuery($query);
                $admin = $database->loadObjectList();
                // Gửi email báo cáo đến email quản lý

                foreach($admin as $ad){
                    $subject2 = "Phản biện bài báo";
                    $content2='
						<h3>Chào bạn: '. $ad->fullname .'</h3>
						<p>Tác giả '. $_SESSION['member']['fullname'] .' vừa gửi phản biện về hệ thống!</p>
						<p>Vui lòng người tiếp nhận kiểm tra.</p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'administrator/index.php?module=baibao_tacgia&task=news_edit&id='.$id.'">Nhấn vào đây để xem:</a></p>
					
					';
                    // Gửi email cho khách hàng
                    if($ariacms -> sendMail( $ad->email , $ad->fullname,$subject2,$content2)){
                        //sendMail($to_email,$to_name,$subject,$content);
                        //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
                        //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
                    }
                    // else{
                    // 	//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");
                    // 	echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
                    // }
                }



                echo '<script language="javascript">alert("Thêm thành công, phản biện của bạn sẽ chờ quản trị viên kiểm duyệt. Xin cảm ơn.");window.location.href ="/";</script>';
            }


            echo '<script language="javascript">alert("Cảm ơn bạn đã phản hồi.");window.href="./member/phan-bien.html"</script>';
        }
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$member_id = $_SESSION['member']['id'];
		$post_edit = $ariacms->getParaUrl("id");
		
		
		// Lấy danh sách các bài viết của thành viên đăng
        $query = "SELECT c.*, b.*, b.id as id_phanbien FROM e4_users a 
                        LEFT JOIN e4_phanbien b ON a.id = b.id_tacgia 
                        LEFT JOIN e4_baibao c ON b.id_baibao = c.id 
                        WHERE  b.id='$post_edit' ";
		$database->setQuery($query);
		$phanbien_posts = $database->loadRow();

		if(!$phanbien_posts)
			echo '<script language="javascript">alert("Bạn không có quyền truy cập.");window.history.back()</script>';
	
		
		View::phanbien($phanbien_posts);
		
	}
	
	// Sửa bài viết
	function suabaiviet(){
		global $database;
		global $ariacms;
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$member_id = $_SESSION['member']['id'];
		$post_edit = $ariacms->getParaUrl("id");
		$mabaibao = $ariacms->getParaUrl("mabaibao");

		
		// Lấy danh sách các bài viết của thành viên đăng
		$query = "SELECT a.* FROM e4_baibao a WHERE id_tacgia = '$member_id' and id='$post_edit'  and mabaibao='$mabaibao'";
		$database->setQuery($query);
		$member_posts = $database->loadRow();
		
		if(!$member_posts)
			echo '<script language="javascript">alert("Bạn không có quyền truy cập.");window.history.back()</script>';
	
		
		View::suabaiviet($member_posts);
		
	}
	
	// Cập nhật bài viết
	function capnhatbaiviet()
    {

        global $database;
        global $ariacms;

        $post_edit = $_POST['id'];
        $mabaibao = $_POST['mabaibao'];
        $tieude = $_POST['tieude'];
        $tieude_en = $_POST['tieude_en'];
        $tacgia = $_POST['tacgia'];
        $tomtat = $_POST['tomtat'];
        $tomtat_en = $_POST['tomtat_en'];
        $file = $_POST['file'];
        $noidung = $_POST['noidung'];
        $chude = $_POST['chude'];
        $id_linhvuc = $_POST['id_linhvuc'];
        $status = $_POST['status'];
        $tailieuthamkhao = $_POST['tailieuthamkhao'];
        $tukhoa = $_POST['tukhoa'];
        $tukhoa_en = $_POST['tukhoa_en'];
        $member_id = $_SESSION['member']['id'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        //$_SESSION['member']['publish'] = 1;
        if ($member_id > 0 and $_SESSION['member']['publish'] == 1) {
            if ($tieude != "") {
                if ($status == 'phanhoitacgia') {


                    // Cập nhật bài viết cũ
                    $new_post = new stdClass;
                    $new_post->status = 'daphanbien'; // chờ duyệt
                    $new_post->date_created = time();
                    $new_post->id_tacgia = $member_id;
                    $database->updateObject('e4_baibao', $new_post, 'id');


                    // Thêm mới bài viết
                    $new_post = new stdClass;
                    $new_post->id = null;
                    $new_post->mabaibao = $mabaibao;
                    $new_post->title_vi = $tieude;
                    $new_post->title_en = $tieude_en;
                    $new_post->tacgia = $tacgia;
                    $new_post->brief_vi = $tomtat;
                    $new_post->brief_en = $tomtat_en;
                    $new_post->content_vi = $noidung;
                    $new_post->file = $file;
                    $new_post->id_chude = $chude;
                    $new_post->id_linhvuc = $id_linhvuc;
                    $new_post->tailieuthamkhao = $tailieuthamkhao;
                    $new_post->tukhoa = $tukhoa;
                    $new_post->tukhoa_en = $tukhoa_en;
                    $new_post->status = 'phanbien'; // chờ duyệt
                    $new_post->date_created = time();
                    $new_post->id_tacgia = $member_id;


                    if ($database->insertObject('e4_baibao', $new_post, 'id')) {

                        $query = "SELECT a.* FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'ADMIN'  and a.publish = 1 ";// . $where . $order . $limit
                        $database->setQuery($query);
                        $admin = $database->loadObjectList();
                        // Gửi email báo cáo đến email quản lý

                        foreach ($admin as $ad) {
                            $subject2 = "Bài báo mới của tác giả";
                            $content2 = '
						<h3>Chào bạn: ' . $ad->fullname . '</h3>
						<p>Tác giả ' . $_SESSION['member']['fullname'] . ' vừa cập nhật bài viết về hệ thống!</p>
						<p>Vui lòng người tiếp nhận kiểm tra.</p>
						<p><a target="_blank" href="' . $ariacms->actual_link . 'administrator/index.php?module=baibao_tacgia&task=news_edit&id=' . $id . '">Nhấn vào đây để xem:</a></p>
					
					';
                            // Gửi email cho khách hàng
                            if ($ariacms->sendMail($ad->email, $ad->fullname, $subject2, $content2)) {
                                //sendMail($to_email,$to_name,$subject,$content);
                                //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
                                //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
                            }
                            // else{
                            // 	//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");
                            // 	echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
                            // }
                        }


                        echo '<script language="javascript">alert("Cập nhật thành công.");window.location.href ="/member/bai-viet.html";</script>';
                    }

                }
                if ($status == 'chotiepnhan') {
                    // Cập nhật bài viết
                    $new_post = new stdClass;
                    $new_post->id = $post_edit;
                    $new_post->mabaibao = $mabaibao;
                    $new_post->title_vi = $tieude;
                    $new_post->title_en = $tieude_en;
                    $new_post->tacgia = $tacgia;
                    $new_post->brief_vi = $tomtat;
                    $new_post->brief_en = $tomtat_en;
                    $new_post->content_vi = $noidung;
                    $new_post->file = $file;
                    $new_post->id_chude = $chude;
                    $new_post->id_linhvuc = $id_linhvuc;
                    $new_post->tailieuthamkhao = $tailieuthamkhao;
                    $new_post->tukhoa = $tukhoa;
                    $new_post->tukhoa_en = $tukhoa_en;
                    $new_post->status = 'chotiepnhan'; // chờ duyệt
                    $new_post->date_created = time();
                    $new_post->id_tacgia = $member_id;


                    if ($database->updateObject('e4_baibao', $new_post, 'id')) {

                        $query = "SELECT a.* FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'ADMIN'  and a.publish = 1 ";// . $where . $order . $limit
                        $database->setQuery($query);
                        $admin = $database->loadObjectList();
                        // Gửi email báo cáo đến email quản lý

                        foreach ($admin as $ad) {
                            $subject2 = "Bài báo mới của tác giả";
                            $content2 = '
                            <h3>Chào bạn: ' . $ad->fullname . '</h3>
                            <p>Tác giả ' . $_SESSION['member']['fullname'] . ' vừa cập nhật bài viết về hệ thống!</p>
                            <p>Vui lòng người tiếp nhận kiểm tra.</p>
                            <p><a target="_blank" href="' . $ariacms->actual_link . 'administrator/index.php?module=baibao_tacgia&task=news_edit&id=' . $id . '">Nhấn vào đây để xem:</a></p>
					
					';
                            // Gửi email cho khách hàng
                            if ($ariacms->sendMail($ad->email, $ad->fullname, $subject2, $content2)) {
                                //sendMail($to_email,$to_name,$subject,$content);
                                //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
                                //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
                            }
                            // else{
                            // 	//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");
                            // 	echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
                            // }
                        }


                        echo '<script language="javascript">alert("Cập nhật thành công.");window.location.href ="/member/bai-viet.html";</script>';
                    }
                } else {
                    echo $database->stderr();
                    //echo '<script language="javascript">alert("Thêm thất bại.");window.history.back()</script>';
                }

            } else {
                echo '<script language="javascript">alert("Vui lòng điền đầy đủ thông tin.");window.history.back()</script>';
            }
        } else {
            echo '<script language="javascript">alert("Tài khoản của bạn chưa được kích hoạt.");window.history.back()</script>';
        }
    }

	public static function thongtincanhan()
	{
		global $database;
		global $ariacms;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		View::thongtincanhan();
	}
	
	public static function nhatkyhoatdong()
	{
		global $database;
		global $ariacms;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		View::nhatkyhoatdong();
	}

    public static function dongy()
    {
        global $database;
        global $ariacms;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $id = $ariacms->getParaUrl("id_phanbien");
        $i = $ariacms->getParaUrl("id");
        $mabaibao = $ariacms->getParaUrl("mabaibao");

        // Kiểm tra đã phản hồi chưa

        $query = "SELECT * FROM `e4_phanbien` WHERE id = ". $id . " and mabaibao = '".$mabaibao."' and trangthai > 0;";
        $database->setQuery($query);
        $check = $database->loadRow();

        if($check){
            echo '<script language="javascript">alert("Bạn đã phản hồi trước đó nên thao tác này không hợp lệ!");window.href=""</script>';

        }else{
            $row = new stdClass;
            $row->id 			= $id;
            $row->trangthai     = 1;
            $row->time 	= time();
            $row->ngaydongypb 	= time();

            $id_baibao = $database->updateObject('e4_phanbien', $row, 'id');

            $query = "SELECT e4_users.*,e4_phanbien.id as id_phanbien  FROM `e4_phanbien`
                    LEFT JOIN e4_users on e4_phanbien.id_nguoiphanbien = e4_users.id
                    WHERE e4_phanbien.id = ". $id;
            $database->setQuery($query);
            $nguoiphanbien = $database->loadRow();

            if($id_baibao){
                $subject2 = "Tạp chí IBST cảm ơn";

                $content2='
						<p>Cảm ơn bạn đã đồng ý xem xét bản thảo cho Tạp Chí Khoa học công nghệ xây dựng.</p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/phan-bien.html?mabaibao='.$mabaibao.'&id='.$id .'">Để tải xuống bài báo ngay bây giờ, vui lòng nhấp vào liên kết này</a></p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/phan-bien.html?mabaibao='.$mabaibao.'&id='.$id .'">Nếu bạn đã sẵn sàng gửi nhận xét của mình,, vui lòng nhấp vào liên kết này</a></p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/phan-bien.html?mabaibao='.$mabaibao.'&id='.$id .'">Nội dung phản biện: về nội dung, về hình thức, về nội dung cần sửa đổi, kết luận</a></p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/phan-bien.html?mabaibao='.$mabaibao.'&id='.$id .'">Nếu có thể, tôi đánh giá cao việc nhận được đánh giá của bạn trước ngày</a></p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'member/phan-bien.html?mabaibao='.$mabaibao.'&id='.$id .'">Bạn có thể gửi bình luận của mình trực tuyến tại trang web của tạp chí</a></p>
						';
                // Gửi email cho khách hàng
                if($ariacms -> sendMail( $nguoiphanbien['email'] , $nguoiphanbien['fullname'],$subject2,$content2)){
                    echo '<script language="javascript">alert("Cảm ơn bạn đã đồng ý. Vui lòng kiểm tra mail.");window.href="'.$ariacms->actual_link.'"</script>';
                }
            }
            echo '<script language="javascript">window.href="'.$ariacms->actual_link.'"</script>';
        }



    }

    public static function tuchoi()
    {
        global $database;
        global $ariacms;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $id = $ariacms->getParaUrl("id_phanbien");
        $i = $ariacms->getParaUrl("id");
        $mabaibao = $ariacms->getParaUrl("mabaibao");

        $query = "SELECT * FROM `e4_phanbien` WHERE id = ". $id . " and mabaibao = '".$mabaibao."' and trangthai > 0;";
        $database->setQuery($query);
        $check = $database->loadRow();

        if($check){
            echo '<script language="javascript">alert("Bạn đã phản hồi trước đó nên thao tác này không hợp lệ!");window.href="'.$ariacms->actual_link.'"</script>';
            header('Location: /');
            exit();
        }else{
            $row = new stdClass;
            $row->id 			= $id;
            $row->trangthai     = 2;
            $row->time 	= time();

            $id_baibao = $database->updateObject('e4_phanbien', $row, 'id');

            // gửi mail cho người tiếp nhận
            if($id_baibao > 0){
                $query = "SELECT a.* FROM `e4_users` a LEFT JOIN e4_roles b ON a.permission = b.id WHERE b.role_type = 'ADMIN'  and a.publish = 1 ";// . $where . $order . $limit
                $database->setQuery($query);
                $admin = $database->loadObjectList();
                // Gửi email báo cáo đến email quản lý

                foreach($admin as $ad){
                    $subject2 = "Từ chối phản biện";
                    $content2='
						<h3>Chào bạn: '. $ad->fullname .'</h3>
						<p>Phản biện: '. $_SESSION['member']['fullname'] .' vừa gửi từ chối phản biện về hệ thống!</p>
						<p>Vui lòng người tiếp nhận kiểm tra.</p>
						<p><a target="_blank" href="'.$ariacms->actual_link.'administrator/index.php?module=baibao_tacgia&task=news_edit&id='.$id.'">Nhấn vào đây để xem:</a></p>
					
					';
                    // Gửi email cho khách hàng
                    if($ariacms -> sendMail( $ad->email , $ad->fullname, $subject2, $content2)){
                        //sendMail($to_email,$to_name,$subject,$content);
                        //redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
                        //echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
                    }
                    // else{
                    // 	//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");
                    // 	echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
                    // }
                }
                echo '<script language="javascript">alert(" phản hồi của bạn sẽ chờ quản trị viên kiểm duyệt. Xin cảm ơn.");window.location.href ="/";</script>';
            }


            echo '<script language="javascript">alert("Cảm ơn bạn đã đồng ý. Vui lòng kiểm tra mail.");window.href="'.$ariacms->actual_link.'"</script>';
        }



    }

    public static function editthongtincanhan()
	{
		global $database;
		global $ariacms;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		if(!$ariacms->checkUserLogin()){
			echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/";</script>';
		}
		
		if($_POST["edit"]){

			//echo 
			$row = new stdClass;
			$row->id = $_SESSION["member"]["id"];
			$row->fullname = $_POST["fullname"];
			$row->homephone = $_POST["homephone"];
			$row->hocvi = $_POST["hocvi"];
			if($_POST['password'] == $_POST['re_password'] && $_POST['password']){
				$row->password =  md5($_POST['password']);
			}
			// if($images)
				// $row->image_url = "/".$images;
			if ($database->updateObject('e4_users', $row, 'id')){
				
					$_SESSION["member"]["fullname"] = $_POST["fullname"];
					$_SESSION["member"]["hocvi"] = $_POST["hocvi"];
					$_SESSION["member"]["homephone"] = $_POST["homephone"];
					$_SESSION["member"]["hocvi"] = $_POST["hocvi"];

					?>
					<script language="javascript" type="text/javascript">
						window.location = "<?=$ariacms->actual_link?>";
					</script>
			
			<?php
					//redirect("Thay đổi thông tin thành công !...", "/member/ca-nhan.html" );
				}else{
					echo $database->stderr();
				}
		}else {
			View::editthongtincanhan();
		}
	}
}
