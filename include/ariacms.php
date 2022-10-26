<?php
class ariacms
{
	var $web_information;
	var $protocol;
	var $c_url;
	var $actual_link;
	public function __construct()
	{
		global $database;
		global $ariaConfig_sitename;
		$this->web_information = new stdClass;
		$query = "SELECT * FROM e4_options ";
		$database->setQuery($query);
		$options = $database->loadObjectList();
		foreach ($options as $option) {
			$this->web_information->{$option->option_name} = $option->option_value;
		}
		$query = "SELECT * FROM e4_web_image WHERE status = 'active' ";
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		foreach ($rows as $image) {
			$this->web_information->{'image-' . $image->position} = $image->image;
		}
		//$this->protocol = strpos(strtolower($_SERVER['REQUEST_SCHEME']), 'https') == FALSE ? 'http' : 'https';
		$this->protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
		$this->c_url = "$this->protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$this->actual_link = "$this->protocol://$_SERVER[HTTP_HOST]/$ariaConfig_sitename";
	}
	public function checkLoginAdmin()
	{
		$ip = "";
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}else{
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		
		if (isset($_COOKIE["ip_login"]) and $_COOKIE["ip_login"] != "" and $_COOKIE["ip_login"] == $ip) {
			global $database;
			if (isset($_SESSION["user"]) && $_SESSION["xkt_timesession"] > 0) {
				
				$tg = time();
				$tgout = 900;
				$tgnew = $tg - $tgout;
				// Thêm tài khoản truy cập vào database
				$truycap = new stdClass;
				$truycap -> ip = $ip;
				$truycap -> tgtmp = $tg;
				$truycap -> user_id = $_SESSION["user"]['id'];
				$truycap -> local = $_SERVER['PHP_SELF'];
				$database->insertObject('e4_useronline', $truycap, 'id');
				
				// Xóa những bản ghi không hợp lệ
				$query2 = "DELETE FROM e4_useronline WHERE tgtmp < '$tgnew'";
				$database->setQuery($query2);
				$database->query();
				
				return true;
				
			} else if (isset($_COOKIE["xkt_admin"]) and $_COOKIE["xkt_admin"] != "") {
				
				$xkt_code 	= $_COOKIE["xkt_admin"];
				$xkt_login 	= explode(';', base64_decode($xkt_code));
				$email = $xkt_login['0'];
				$random = $xkt_login['1'];
				//$query = "SELECT id, user_type, fullname, email, permission, image_url, random FROM e4_users WHERE user_type = 'admin' AND random = '$random' AND email = '$email' and publish = 1 ";
				$query = "SELECT a.id, a.user_type, a.fullname, a.email, a.permission, a.image_url, a.random,b.role_type FROM e4_users a join e4_roles b on a.permission = b.id WHERE user_type = 'admin' AND random = '$random' AND email = '$email' and publish = 1 ";
				$database->setQuery($query);
				$user = $database->loadRow();
				if (is_array($user)) {
					$_SESSION["xkt_timesession"] = time();
					$_SESSION["user"] = $user;
					
					$tg = time();
					$tgout = 600;
					$tgnew = $tg - $tgout;
					// Thêm tài khoản truy cập vào database
					$truycap = new stdClass;
					$truycap -> ip = $ip;
					$truycap -> tgtmp = $tg;
					$truycap -> user_id = $user['id'];
					$truycap -> local = $_SERVER['PHP_SELF'];
					$database->insertObject('e4_useronline', $truycap, 'id');
					
					// Xóa những bản ghi không hợp lệ
					$query2 = "DELETE FROM e4_useronline WHERE tgtmp < '$tgnew'";
					$database->setQuery($query2);
					$database->query();
					
					return true;
				}
			}
			
		}
		return false;
	}
	/** Check login public */
	public function checkUserLogin()
	{
		return isset($_SESSION["member"]) && $_SESSION["member"]["id"] > 0;
		//return false;
	}
	/** Getpara_html(thứ tự lấy tham số từ url public): trả về chuỗi.*/
	public function getParaHtml($parapos)
	{
		global $ariaConfig_sitename;
		$paraStr = "$_SERVER[REQUEST_URI]";
		$htmlPos = strrpos($paraStr, ".html");
		$paraStr = substr($paraStr, 0, $htmlPos);
		$paraStr = preg_replace("/\.html/", "", $paraStr);
		$paraArr = explode("/", $paraStr);
		array_shift($paraArr);
		$check_ = ($ariaConfig_sitename == $paraArr[0] . "/") ? 1 : 0;
		$i = 0;
		$value_ = "";
		foreach ($paraArr as $para) {
			$value_ = ($check_ == 1) ? (($parapos + 1 == $i) ? $para : $value_) : (($parapos == $i) ? $para : $value_);
			$i++;
		}
		if ($i == 0)
			return "trang-chu";
		return $value_;
	}
	/** Getpara_url(tham số cần lấy từ url public): trả về giá trị tham số.*/
	public function getParaUrl($variable)
	{
		$paraStr = "$_SERVER[REQUEST_URI]";
		$paraStr = strstr($paraStr, $variable);
		$paraStr = str_replace($variable . '=', '', $paraStr);
		$paraArr = explode('&', $paraStr);
		return $paraArr[0];
	}
	/** Getparam(tham số cần lấy từ url request php): trả về giá trị tham số. */
	public function getParam($param)
	{
		$var = $_REQUEST;
		if (is_array($var)) {
			if (isset($var[$param])) {
				return $var[$param];
			}
		}
		return;
	}
	/** GetId( Lấy giá trị id cuối cùng trong chuỗi html trên trình duyệt). */
	public function getId()
	{
		$paraStr = "$_SERVER[REQUEST_URI]";
		$paraArr = explode(".html", $paraStr);
		$paraArr = explode("-", $paraArr[0]);
		return $paraArr[count($paraArr) - 1];
	}
	// Print blocks
	public function getBlock($pos)
	{
		global $database;
		$query = "SELECT * FROM e4_blocks WHERE bposition = '$pos' AND bpublish = '1' ";
		$database->setQuery($query);
		$block = $database->loadRow();
		if ($database->getErrorNum()) {
			echo "Error : " . $database->stderr();
			die();
		}
		if (is_array($block)) {
			ob_start();
			include("blocks/" . $block['bfilename']);
			ob_flush();
		}
	}
	//This function will print body of page
	public function getBodyContent()
	{
		global $database;
		$mdl = $this->getParam("module");
		// Update 24/02/2017
		switch (true) {
			case ($mdl == "" || $mdl == 'index' || $mdl == 'trang-chu'):
				//Include Function File
				if (file_exists("modules/mdl_home/function.php")) {
					@include("modules/mdl_home/function.php");
				} else {
					echo "Missing file function!";
					exit();
				}
				//Include HTML file
				if (file_exists("modules/mdl_home/html.php")) {
					@include("modules/mdl_home/html.php");
				} else {
					echo "Missing file html!";
					exit();
				}
				//Include Main File
				if (file_exists("modules/mdl_home/index.php")) {
					@include("modules/mdl_home/index.php");
				} else {
					echo "Missing file index!";
					exit();
				}
				break;
			default:
				$query  = "SELECT * FROM e4_modules WHERE name='$mdl' and type='public'";
				$database->setQuery($query);
				$module = $database->loadRow();
				if (is_array($module)) {
					if ($module["status"] == 'active') {
						//Include Function File
						if (file_exists("modules/" . $module["folder"] . "/function.php")) {
							@include("modules/" . $module["folder"] . "/function.php");
						}
						//Include HTML file
						if (file_exists("modules/" . $module["folder"] . "/html.php")) {
							@include("modules/" . $module["folder"] . "/html.php");
						}
						//Include Main File
						if (file_exists("modules/" . $module["folder"] . "/index.php")) {
							@include("modules/" . $module["folder"] . "/index.php");
						}
					} else {
						$this->redirect('Chức năng chưa được kích hoạt hoặc đang tạm khóa!', 'javascript:history.back()');
					}
				} else {
					$this->redirect('Không tìm thấy chức năng yêu cầu!', 'javascript:history.back()');
				}
				break;
		}
	}

	/**
	 * 
	 * Admin Functions Content
	 * 
	 */

	public function getAdminBodyContent()
	{
		global $database;
		$mdl = $this->getParam("module");
		$task = $this->getParam("task");
		switch (true) {
			case ($mdl == "" || $mdl == 'dashbroad_admin'):
				//Include Function File
				if (file_exists("modules/mdl_dashbroad_admin/admin.function.php")) {
					@include("modules/mdl_dashbroad_admin/admin.function.php");
				} else {
					echo "Không tìm thấy file function!";
					exit();
				}
				//Include HTML file
				if (file_exists("modules/mdl_dashbroad_admin/admin.html.php")) {
					@include("modules/mdl_dashbroad_admin/admin.html.php");
				} else {
					echo "Không tìm thấy file html!";
					exit();
				}
				//Include Main File
				if (file_exists("modules/mdl_dashbroad_admin/index.php")) {
					@include("modules/mdl_dashbroad_admin/index.php");
				} else {
					echo "Không tìm thấy file index!";
					exit();
				}
				break;
			default:
				switch (true) {
					case ($task == ""):
						$query = "SELECT a.* FROM e4_roles a WHERE a.status = 1 AND a.id = " . $_SESSION['user']['permission'] . " AND FIND_IN_SET('$mdl',a.module_name_list) ";
						break;
					case ($task != ""):
						$query = "SELECT a.* FROM e4_roles a WHERE a.status = 1 AND a.id = " . $_SESSION['user']['permission'] . " AND FIND_IN_SET('$mdl',a.module_name_list) AND FIND_IN_SET('$task',a.function_code_list ) ";
						break;
				}
				$database->setQuery($query);
				$check = $database->loadRow();
				if (is_array($check)) {
					$query  = "SELECT * FROM e4_modules WHERE name='$mdl' and type='admin'";
					$database->setQuery($query);
					$module = $database->loadRow();
					if (is_array($module)) {
						if ($module["status"] == 'active') {
							//Include Function File
							if (file_exists("modules/" . $module["folder"] . "/admin.function.php")) {
								@include("modules/" . $module["folder"] . "/admin.function.php");
							}
							//Include HTML file
							if (file_exists("modules/" . $module["folder"] . "/admin.html.php")) {
								@include("modules/" . $module["folder"] . "/admin.html.php");
							}
							//Include Main File
							if (file_exists("modules/" . $module["folder"] . "/index.php")) {
								@include("modules/" . $module["folder"] . "/index.php");
							}
						} else {
							$this->redirect('Chức năng chưa được kích hoạt hoặc đang tạm khóa!', 'javascript:history.back()');
						}
					} else {
						$this->redirect('Không tìm thấy chức năng yêu cầu!', 'javascript:history.back()');
					}
				} else {
					$this->redirect('Bạn không có quyền thực hiện thao tác này!', 'javascript:history.back()');
				}
				break;
		}
	}
	/** Database function */
	public function selectOne($table, $id, $tab, $row)
	{
		global $database;
		$query = "SELECT * from " . $table . " where " . $id . $tab . "'$row'";
		$database->setQuery($query);
		$item = $database->loadRow();
		return $item;
	}

	public function selectAll($table, $condition = false, $info = false)
	{
		global $database;
		if ($condition == '') {
			$query = "SELECT * from " . $table . " " . $info;
		} else {
			$query = "SELECT * from " . $table . " where " . $condition . " " . $info;
		}
		$database->setQuery($query);
		$items = $database->loadObjectList();
		return $items;
	}

	/** function delete
	 * delete some record in a $table under $condition
	 * $table:		the table will be delete som record
	 * $condition:	the delete condition
	 * ----------------------------------------------
	 */
	public function delete($table, $condition, $info = false)
	{
		global $database;
		$query = 'DELETE FROM `' . $table . '` WHERE ' . $condition;
		$database->setQuery($query);
		$database->query();
	}
	//Redirect
	public function redirect($msg, $url)
	{
		if ($msg != "") {
			echo '
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
			<script language="javascript" type="text/javascript">
				alert("' . $msg . '");
			</script>
		';
			if ($url != "") echo '
			<script language="javascript" type="text/javascript">
				window.location = "' . $url . '";
			</script>
		';
			exit();
		} else {
			echo '
			<script language="javascript" type="text/javascript">
				window.location = "' . $url . '";
			</script>
		';
			exit();
		}
	}
	/** Format int to currency */
	public function formatPrice($priceFloat)
	{
		$symbol = '';
		$symbol_thousand = '.';
		$decimal_place = 0;
		$price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
		return $price . $symbol;
	}

    public function textLimit($str, $limit)
    {
		$count = 4 * $limit - 4;
		$sum = 0;
        $str_s = '';
        if (stripos($str, " ")) {
            $ex_str = explode(" ", $str);
            if (count($ex_str) > $limit) {
                for ($i = 0; $i < $limit; $i++) {
					$sum += strlen($ex_str[$i]);
					if($sum > $count){
						return $str_s . "...";
					}
                    $str_s .= $ex_str[$i] . " ";
                }
                return $str_s . "...";
            }
			else{
				// $ex_str = explode(" ", $str);
				// for ($i = 0; $i < count($ex_str); $i++) {
					// $sum += strlen($ex_str[$i]);
					// if($sum > $count){
						// return $str_s . "...";
					// }
					// $str_s .= $ex_str[$i] . " ";
				// }
				return $str;
			}
        }
        return $str;
    }

	/** Date - Time function */
	public function getTimeUnix($currhour, $currminute, $currsecond, $currmonth, $currday, $curryear, $chgmonth, $chgday, $chgyear)
	{
		return mktime($currhour, $currminute, $currsecond, $currmonth + $chgmonth, $currday + $chgday, $curryear + $chgyear);
	}
	public function dateFormatAds($datetoformat, $formatcode, $stringFormat)
	{
		$datetemp = date("H i s m d Y", $datetoformat);
		$datearray = explode(" ", $datetemp);
		$HourtoFormat = $datearray[0];
		$MinutetoFormat = $datearray[1];
		$SecondtoFormat = $datearray[2];
		$MonthtoFormat = $datearray[3];
		$DaytoFormat = $datearray[4];
		$YeartoFormat = $datearray[5];

		switch ($formatcode) {
			case "date":
				return $DaytoFormat . $stringFormat . $MonthtoFormat . $stringFormat . $YeartoFormat;
				break;
			case "time":
				return $HourtoFormat . $stringFormat . $MinutetoFormat . $stringFormat . $SecondtoFormat;
				break;
			default:
				return "Missing input paramater";
				break;
		}
	}
	public function unixToDate($rv_date, $stringFormat)
	{
		return $this->dateFormatAds($rv_date, "date", $stringFormat);
	}
	public function unixToTime($rv_date, $stringFormat)
	{
		return $this->dateFormatAds($rv_date, "time", $stringFormat);
	}
	/** Format date input: dd/mm/yyyy */
	public function dateToUnix($n_date)
	{
		$datearray = explode("/", $n_date);
		$currday = $datearray[0];
		$currmonth = $datearray[1];
		$curryear = $datearray[2];
		return $this->getTimeUnix(0, 0, 0, $currmonth, $currday, $curryear, 0, 0, 0);
	}
	/** End Time function */

	//Send mail
	public function sendMail($to_email, $to_name, $subject, $content)
	{	
		$content .='<br><p>Trân trọng cảm ơn!</p>
		<p>Tạp chí Khoa học công nghệ xây dựng - Viện Khoa học công nghệ xây dựng</p>
		<p>Số 81 Trần Cung, Nghĩa Tân, Cầu Giấy, Hà Nội</p>
		<p>ĐT: 024 37556098, Email: tapchi@ibst.vn, Website: tapchi.ibst.vn</p>';
	
		$mailer = new PHPMailer();
		$mailer->IsSMTP();
		$mailer->SMTPAuth = true; // Đăng nhập
		$mailer->SMTPSecure = "ssl"; // Giao thức SSL
		$mailer->Host = $this->web_information->mailserver_url; // SMTP của GMAIL
		$mailer->Port = $this->web_information->mailserver_port; // cổng SMTP
		$mailer->Username = $this->web_information->mailserver_login;  // SMTP username
		$mailer->Password = $this->web_information->mailserver_pass; // SMTP password
		$mailer->CharSet = 'utf-8';
		$mailer->From     = $this->web_information->admin_email;
		$mailer->FromName = $this->web_information->name_vi;
		$mailer->AddReplyTo($this->web_information->admin_email, $this->actual_link);
		$mailer->AddAddress($to_email, $to_name);
		$mailer->IsHTML(true);
		$mailer->Subject  =  $subject;
		$mailer->Body     =  $content;
		return $mailer->Send();
	}
	/**
	 * 
	 * Convert String UTF8 to ASCII
	 * 
	 */
	public function utf8Convert($str)
	{
		if (!$str) return false;
		$utf8 = array(
			'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|ạ|á|à|ả|ã',
			'd' => 'đ|Đ',
			'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|é|è|ẻ|ẹ|ẽ',
			'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị|í|ị|ĩ|ì|ỉ',
			'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|ọ|ỏ|ò|ó|õ',
			'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|ụ|ú|ủ|ũ|ù',
			'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ|ỹ|ỷ|ỳ|ý|ỵ',
		);
		foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);
		return $str;
	}
	public function utf8ToUrl($text)
	{
		$text = strtolower($this->utf8Convert($text));
		$text = preg_replace("/[^a-zA-Z0-9]+/", "-", html_entity_decode($text, ENT_QUOTES));
		return $text;
	}

	public function convertFont_file($str)
	{
		$str = $this->utf8Convert($str);
		$str = str_replace("/ /", '-', $str);
		return $str;
	}
	public function convertEditor($str)
	{
		$str = str_replace('<body>', '', str_replace('<title>', '', str_replace('<head>', '', str_replace('<html>', '', $str))));
		$str = str_replace('</body>', '', str_replace('</title>', '', str_replace('</head>', '', str_replace('</html>', '', $str))));
		$str = str_replace("\\", '', $str);
		return $str;
	}

	public function paginationAdmin($totalRows, $maxRow, $max_page)
	{
		$current = $this->getParam("curPg");
		if ($current == "") $current = 1;
		$url = str_replace('curPg=' . $current, '', str_replace('curPg=' . $current . '&', '', str_replace('&curPg=' . $current . '&', '', $this->c_url)));
		$url = str_replace('.php?', '.php', $url);
		// Tong so trang
		$total_page = ceil($totalRows / $maxRow);
		// Next and Pre
		$next = $current + 1;
		$previous = $current - 1;
		if ($current > $max_page) {
			$start_page = $current - $max_page;
			if ($total_page > $current + $max_page)
				$end_page = $current + $max_page;
			else if ($current <= $total_page && $current > $total_page - $max_page) {
				$start_page = $total_page - $max_page;
				$end_page = $total_page;
			} else {
				$end_page = $total_page;
			}
		} else {
			$start_page = 1;
			if ($total_page > $max_page)
				$end_page = $max_page;
			else
				$end_page = $total_page;
		}
		// Link page
		if ($total_page > 1) {
			if ($current > 1) {
				$new_url = str_replace('.php', '.php?curPg=' . $previous . '&', $url);
				echo '<li class="paginate_button previous"><a href="' . $new_url . '">&laquo;</a></li>';
			}
			for ($i = $start_page; $i <= $end_page; $i++) {
				$new_url = str_replace('.php', '.php?curPg=' . $i . '&', $url);
				if ($current == $i) {
					echo '<li class="paginate_button active"><a>' . $i . '</a></li>';
				} else {
					echo '<li class="paginate_button"><a href="' . $new_url . '">' . $i . '</a></li>';
				}
			}
			if ($current < $total_page) {
				$new_url = str_replace('.php', '.php?curPg=' . $next . '&', $url);
				echo '<li class="paginate_button next"><a href="' . $new_url . '">&raquo;</a></li>';
			}
		}
	}
	public function paginationPublic($totalRows, $maxRow, $max_page)
	{
		$current = $this->getParaUrl("curPg");
		if ($current == "") $current = 1;
		$url = str_replace('curPg=' . $current, '', str_replace('&curPg=' . $current, '', str_replace('curPg=' . $current . '&', '', $this->c_url)));
		$url = str_replace('.html?', '.html', $url);
		// Tong so trang
		$total_page = ceil($totalRows / $maxRow);
		// Hien tai
		// Next and Pre
		$next = $current + 1;
		$previous = $current - 1;
		if ($current > $max_page) {
			$start_page = $current - $max_page;
			if ($total_page > $current + $max_page)
				$end_page = $current + $max_page;
			else if ($current <= $total_page && $current > $total_page - $max_page) {
				$start_page = $total_page - $max_page;
				$end_page = $total_page;
			} else {
				$end_page = $total_page;
			}
		} else {
			$start_page = 1;
			if ($total_page > $max_page)
				$end_page = $max_page;
			else
				$end_page = $total_page;
		}
		// Link page
		if ($total_page > 1) {
			if ($current > 1) {

				$new_url = str_replace('&&', '&', str_replace('.html', '.html?curPg=' . $previous . '&', $url));
				echo '<a class="prev page-numbers" href="' . $new_url . '"><i class="fa fa-angle-left"></i></a>';
			}
			for ($i = $start_page; $i <= $end_page; $i++) {
				$new_url = str_replace('&&', '&', str_replace('.html', '.html?curPg=' . $i . '&', $url));
				if ($current == $i) {
					echo '<a style="color:red;">' . $i . '</a>';
				} else {
					echo '<a class="page-numbers" href="' . $new_url . '">' . $i . '</a>';
				}
			}
			if ($current < $total_page) {
				$new_url = str_replace('&&', '&', str_replace('.html', '.html?curPg=' . $next . '&', $url));
				echo '<a class="next page-numbers" href="' . $new_url . '"><i class="fa fa-angle-right"></i></a>';
			}
		}
	}

	/** Lấy menu và submenu truyền vào danh sách các option trong thẻ select */
	public function printMenuOption($table, $option_value, $option_show, $parent_id, $str, $option_selected, $taxonomy)
	{
		global $database;
		$content = '';
		$str .= "- - ";
		$parent_id != '' ? $parent_id = $parent_id : $parent_id = 0;
		$where = " WHERE a.parent = " . $parent_id;
		if ($taxonomy != '') $where .= " AND taxonomy = '" . $taxonomy . "'";
		$group = " GROUP BY a.id ";
		$order = " ORDER BY a.order ";
		$where_taxonomy = ($taxonomy != '') ? " WHERE taxonomy = '" . $taxonomy . "' " : "";
		$parent_id != '' ? $where .= " AND a.parent = " . $parent_id : '';
		$query = "SELECT a.*, count(b.parent) submenu FROM " . $table . " a 
			LEFT JOIN (SELECT parent FROM " . $table . $where_taxonomy . " ) b ON a.id = b.parent
				" . $where . $group . $order;
		$database->setQuery($query);
		$categories = $database->loadObjectList();
		foreach ($categories as $category) {
			$content .= '<option value="' . $category->$option_value . '"';
			if ($option_selected == $category->$option_value) $content .= ' selected="selected">';
			else $content .= ' >';
			$content .= $str . $category->$option_show . '</option>';
			if ($category->submenu > 0) {
				$content .= $this->printMenuOption($table, $option_value, $option_show, $category->id, $str, $option_selected, $taxonomy);
			}
		}
		return $content;
	}
}
