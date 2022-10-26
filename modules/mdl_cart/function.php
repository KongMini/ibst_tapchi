
<?php
class Model
{
	static function viewhome()
	{
		global $database;
		global $ariacms;
		if (isset($_SESSION['orderCart'])) {
			switch ($_POST['btnSubmit']) {
				case 'sendOder':
					$name     = $_POST['txtName'];
					$phone    = $_POST['txtPhone'];
					$address  = $_POST['txtAddress'];
					$email    = $_POST['txtEmail'];
					$content  = $_POST['txtContent'];
					$total  = $_POST['total'];
					$row = new stdClass;
					$row->id = null;
					$row->name = $name;
					$row->phone = $phone;
					$row->email = $email;
					$row->address = $address;
					$row->content = $content;
					$row->date_created  = time();
					if ($id_order = $database->insertObject("e4_order", $row, "id")) {
						$row = new stdClass;

						foreach ($_SESSION['orderCart'] as $productID => $qt) {
							$item = $ariacms->selectOne('e4_posts', 'id', '=', $productID);
							$row->id = NULL;
							$row->order_id   = $id_order;
							$row->product_id = $productID;
							$row->quantity    = $qt;
							$row->price  	 = $item["product_sale"];
							$row->date_created = time();
							$database->insertObject('e4_order_detail', $row, 'id');
						}
						unset($_SESSION['orderCart']);
						$to_name = $ariacms->web_information->name_vi;
						$to_email = $ariacms->web_information->admin_email;
						$subject = "Bạn nhận được đơn hàng từ hệ thống";
						$content_mail = "Thông tin chi tiết: <br />";
						$content_mail .= "Tên : " . $name . "<br />";
						$content_mail .= "Điện thoại: " . $phone . "<br />";
						$content_mail .= "Địa chỉ: " . $address . "<br />";
						$content_mail .= "Email: " . $email . "<br />";
						$content_mail .= "Nội dung: " . $content . "<br />";
						$content_mail .= "Tổng tiền hàng: " . $ariacms->formatPrice($total) . "<br />";
						$ariacms->sendMail($to_email, $to_name, $subject, $content_mail);
						$ariacms->redirect("Gửi đơn hàng thành công. Chúng tôi sẽ liên hệ lại cho quý khách sớm nhất.", $ariacms->web_information->actual_link . "trang-chu.html");
					} else {
						echo $database->stderr();
					}
					break;
				default:
					View::viewhome();
					break;
			}
		}else {
			$ariacms->redirect("Giỏ hàng trống.", "javascript:history.back()");
		}
	}
}


?>