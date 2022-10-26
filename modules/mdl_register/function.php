<?php
class Model
{
	public static function formlogin()
	{
		global $ariacms;
		global $database;
		View::formlogin();
	}
	
	public static function formregister()
	{
		global $database;
		global $ariacms;
		
		View::formregister();
	}
	
	public static function checklogin()
	{
		global $database;
		global $ariacms;
		
		$username = $_POST['username'];
		$password = $_POST['password'];
        $loginType = $_POST['submit'];

		
		// bắt lỗi sql ' or 1 = 1 # 
		$partten = "/^[A-Za-z0-9_.]{4,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
		$subject = $username;
		if(!preg_match($partten ,$subject)){
			echo '<script language="javascript">alert("Mail bạn vừa nhập không đúng định dạng, vui lòng thử lại");</script>';
			$ariacms->redirect("", "/");
		}
		
		if (trim($username) == "" or trim($password) == "") {
			echo '<script language="javascript">alert("Vui lòng nhập Email và mật khẩu để bắt đầu phiên làm việc.");</script>';
		} else {
			
			$upassword = md5($password);
			$query = "SELECT a.* FROM e4_users a WHERE user_type = 'public' AND password = '$upassword' AND email = '$username' ";
			$database->setQuery($query);
			$user = $database->loadRow();
			if ($database->getErrorNum()) {
			  echo $database->stderr();
			  exit();
			}
			if (is_array($user)) {

				$ip = "";
				if (!empty($_SERVER["HTTP_CLIENT_IP"]))
				{
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				}elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}else{
					$ip = $_SERVER["REMOTE_ADDR"];
				}
				 
				$date_of_expiry = time() + (86400 * 30);
				$xkt_login   = $user['email'] . ';' . $user['random'];
				$xkt_code   = base64_encode($xkt_login);
				setcookie("ip_login", $ip, time() + (86400 * 30)); // Lưu cookie 30 ngày
				setcookie("member_public", $xkt_code, $date_of_expiry);
				
				$_SESSION["member_timesession"] = time();
				$_SESSION["member"] = $user;
				$_SESSION["member"]['LoginType'] = $loginType;


                
				//View::loginsuccess($user);
				//$ariacms->redirect("", "/");
				
				echo '<script language="javascript">
					if(sessionStorage.getItem("url"))
						window.location="/chi-tiet/" + sessionStorage.getItem("url") + ".html";
					else 
						window.location="/";
				</script>';
				
			} else {
				echo '<script language="javascript">alert("Thông tin đăng nhập không chính xác hoặc tài khoản chưa được kích hoạt.");</script>';
				$ariacms->redirect("", "/");
			}
		}
	}
	
	public static function checkregister()
	{
		global $database;
		global $ariacms;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		$fullname = $_POST['fullname'];
		$phonenumber = $_POST['phonenumber'];
		$username = $_POST['username'];
		//$ngaysinh = $_POST['ngaysinh'];
		//$CMND = $_POST['CMND'];
		$hocvi = $_POST['hocvi'];
		$password = $_POST['password'];
		//$phanbien = $_POST['phanbien'];
		
		
		if (trim($username) == "" or trim($password) == "" or trim($fullname) == "") {
			echo '<script language="javascript">alert("Vui lòng điền đầy đủ thông tin.");</script>';
			View::formregister();
		} else {
			
			$query = "SELECT a.id FROM e4_users a WHERE email = '$username' ";
			$database->setQuery($query);
			$user = $database->loadRow();
			
			if($user){
				echo '<script language="javascript">alert("Email này đã tồn tại, vui lòng kiểm tra lại.");</script>';
				View::formregister();
			}else{
				// Thêm mới tài khoản
				$new_user = new stdClass;
				$new_user -> id = null;
				$new_user -> user_type = 'public';
				$new_user -> fullname = $fullname;
				//$new_user -> ngaysinh = strtotime($ngaysinh);
				//$new_user -> CMND = $CMND;
				$new_user -> hocvi = $hocvi;
				$new_user -> email = $username;
				$new_user -> password = md5($password);
				$new_user -> homephone = $phonenumber;
				$new_user -> mobifone = $phonenumber;
				//$new_user -> phanbien = $phanbien;
				$new_user -> date_created = time();
				$new_user -> date_updated = time();
				$new_user -> publish = 0; //  Trạng thái chưa được xác thực
				//print_r($new_user);die;
				if($user_id = $database->insertObject('e4_users', $new_user, 'id')){
					
					// Gửi email xác thực người dùng
					$subject2 = "Xác nhận tài khoản";
					$content2='
					<h3>Chào bạn: '.$fullname.'</h3>
					<p>Chúng tôi nhận được thông tin đăng ký từ diễn đàn Economic247</p>
					<p>Vui lòng xác nhận tài khoản này đúng là bạn đã đăng ký.</p>
					<p><a target="_blank" href="'.$ariacms->actual_link.'register/'.$user_id.'_'.time().'.html">Nhấn vào đây để xác nhận: '.$ariacms->actual_link.'register/'.$user_id.'_'.time().'</a></p>
					';
					// Gửi email cho khách hàng
					if($ariacms -> sendMail($username,$fullname,$subject2,$content2)){
						//sendMail($to_email,$to_name,$subject,$content);
						//redirect("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn","/");
						echo '<script language="javascript">alert("Đăng ký thành công, vui lòng xác nhận tài khoản qua email đăng ký của bạn.");</script>';
					}else{
						//redirect("Chúng tôi đã nhận được thông tin đăng ký của bạn, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Xin cảm ơn","/");	
						echo '<script language="javascript">alert("Gửi email thất bại.");</script>';
					}
					
					
					//$ariacms->redirect("", "/");
					//echo $user_id; die;
					echo '<script language="javascript"> window.history.back();;</script>';
					//View::formlogin();
				}else{
					echo '<script language="javascript">alert("Đăng ký tài khoản thất bại.");</script>';
					View::formregister();
				}
			}
		}
	}
	
	public static function checklogout(){
		
		global $database;
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		unset($_SESSION['member']);
		
		echo '<script language="javascript">alert("Bạn đã đăng xuất tài khoản. Xin cảm ơn.");window.history.back();</script>';
	}
	
	public static function kichhoattaikhoan(){
		global $database;
		global $ariacms;
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$task = $ariacms->getParam("task");
		
		$array_task = explode('_',$task);
		
		$member_id = $array_task[0];
		
		// Kiểm tra tài khoản xác thực
		$query = "SELECT a.* FROM e4_users a WHERE a.user_type ='public' and a.publish = 0 and a.id = '$member_id' ";
		$database->setQuery($query);
		$user = $database->loadRow();
		if($user){
			//echo $member_id;
			//die;
			$query1 = "update e4_users set publish = '1' where id = " . $member_id ;
			$database->setQuery($query1);
			if ($database->query()) {
				$_SESSION["member_timesession"] = time();
				$_SESSION["member"] = $user;
				$_SESSION["member"]['publish'] = 1;
				$ariacms->redirect("Xác nhận thành công","/");
			}
		}else{
			$ariacms->redirect("Không tìm thấy tài khoản hoặc đã được kích hoạt trước đó.","/");
		}
	}
}
