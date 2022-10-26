<?php
global $ariacms;
global $database;
$act = $ariacms->getParam("action");
if ($act == "doLogin") {
  $uemail = $ariacms->getParam("txtUemail");
  $upassword = $ariacms->getParam("txtUpassword");
  $remember = $ariacms->getParam("remember");
	// bắt lỗi sql ' or 1 = 1 # 
	$partten = "/^[A-Za-z0-9_.]{4,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
	$subject = $uemail;
 if(!preg_match($partten ,$subject)){
	   echo '<script language="javascript">alert("Mail bạn vừa nhập không đúng định dạng, vui lòng thử lại");</script>';
	}
  else if (trim($uemail) == "" or trim($upassword) == "") {
    echo '<script language="javascript">alert("Vui lòng nhập Email và mật khẩu để bắt đầu phiên làm việc.");</script>';
  } else {
    $upassword = md5($upassword);
    $query = "SELECT a.id, a.user_type, a.password, a.fullname, a.email, a.permission, a.image_url, a.random, b.role_type FROM e4_users a join e4_roles b on a.permission = b.id WHERE email = '$uemail' and password = '$upassword' and publish = 1 ";
    $database->setQuery($query);
    $user = $database->loadRow();
    if ($database->getErrorNum()) {
      echo $database->stderr();
      exit();
    }
	
    if (is_array($user)) {
		
		if($user['password'] == $upassword and $user['user_type'] == 'admin'){
		
			if ($remember == 'on') {
				
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
				setcookie("xkt_admin", $xkt_code, $date_of_expiry);
				
			}
			$_SESSION["xkt_timesession"] = time();
			$_SESSION["user"] = $user;

			header("location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			exit();
		}
    } else {
      echo '<script language="javascript">alert("Thông tin đăng nhập không chính xác hoặc tài khoản chưa được kích hoạt.");</script>';
    }
  }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOGIN - SYSTEM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="templates/aptcms/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="templates/aptcms/font-awesome-4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="templates/aptcms/font-awesome-4.4.0/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="templates/aptcms/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="templates/aptcms/ionicons/css/ionicons.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/aptcms/dist/css/AdminXKT.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="templates/aptcms/plugins/iCheck/square/blue.css">

  <script src="templates/aptcms/plugins/jQuery/jQuery-2.1.4.min.js"></script>

</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="javascript:void(0);"><?=_SIGN_IN?></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <form id="form_login" name="form_login" method="post" action="" class="form-signin">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email..." autofocus name="txtUemail" id="txtUemail" required />
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="<?=_PASSWORD?>..." name="txtUpassword" id="txtUpassword" required />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="remember" id="remember" checked> <?=_REMEMBER_ME?>
              </label>
            </div>
          </div><!-- /.col -->
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <button type="submit" value="<?=_SIGN_IN?>" class="btn btn-primary btn-block btn-flat"><?=_SIGN_IN?></button>
          </div><!-- /.col -->
        </div>
        <input type="hidden" name="action" value="doLogin" />
      </form>
    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->
  <!-- Bootstrap 3.3.5 -->
  <script src="templates/aptcms/bootstrap/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="templates/aptcms/plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</body>

</html>