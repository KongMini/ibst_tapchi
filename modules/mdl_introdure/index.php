<?php
global $ariacms;
global $params;
?>

<!DOCTYPE HTML>
<html lang="en-US">


<!-- Mirrored from demo.themeix.com/html/helex2/blog-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 03:35:54 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
		<head>
			<title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
			<meta name="description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<meta name="keywords" content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:title" content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>" />
			<meta property="og:description" content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>" />
			<?= $ariacms->getBlock("head"); ?>
		
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
    var target = $(this).attr("href"); //Get the target
    var scrollToPosition = $(target).offset().top - 150;

    $('html').animate({ 'scrollTop': scrollToPosition }, 600, function(){
        window.location.hash = "" + target;
        // This hash change will jump the page to the top of the div with the same id
        // so we need to force the page to back to the end of the animation
        $('html').animate({ 'scrollTop': scrollToPosition }, 0);
    });

    $('body').append("called");
    } // End if
  });
});



</script>	
    <!-- Poppins Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
</head>
	

<body>


<div id="wrapper">

	<?= $ariacms->getBlock("header"); ?>

	<!-- sidebar -->
	
	<?= $ariacms->getBlock("menu"); ?>
	
	<!-- Main Contents -->
	<div class="main_content">
		<div class="mcontainer">
			
			<div>
				
<p align="center"><strong>Chính sách bảo mật</strong></p>

<p><strong>Cám ơn bạn đã truy cập vào website https://biz9.vn. Chúng tôi trân trọng và cam kết sẽ bảo mật những thông tin mang tính riêng tư của Quý người dùng.</strong></p>

<p>&nbsp;</p>

<p>Quý người dùng vui lòng đọc bản “Chính sách bảo mật thông tin người dùng” dưới đây để hiểu rõ hơn những cam kết, nhằm tôn trọng và bảo vệ quyền lợi của người truy cập. Cùng với Chính sách bảo mật thông tin người dùng, https://biz9.vn cũng xây dựng Điều khoản sử dụng Website, quý người dùng có thể xem tại đây.</p>

<p>1. Mục đích và phạm vi thu thập thông tin cá nhân:</p>

<p>Các thông tin thu thập thông qua website sẽ giúp https://biz9.vn:</p>

<p>-Hỗ trợ người dùng tìm hiểu thông tin về các bài viết mà https://biz9.vn tạo ra;<br />
-Tư vấn và giải đáp các thắc mắc của người dùng;<br />
-Thực hiện các bản khảo sát và thu thập các đánh giá người dùng;<br />
- Để truy cập và sử dụng một số dịch vụ tại https://biz9.vn, Quý người dùng có thể sẽ được yêu cầu đăng ký với https://biz9.vn thông tin cá nhân (họ tên, email, số điện thoại, tên đơn vị, …). Mọi thông tin khai báo phải đảm bảo tính chính xác và hợp pháp. https://biz9.vn không chịu mọi trách nhiệm liên quan đến pháp luật của các thông tin khai báo từ Người dùng.<br />
- https://biz9.vn cũng có thể thu thập thông tin về số lần truy cập, bao gồm số trang người dùng xem, số link (liên kết) người dùng đã click và những thông tin liên quan khác đến việc kết nối đến https://biz9.vn. Góc nhìn cũng thu thập các thông tin mà trình duyệt web (browser) người dùng đang sử dụng mỗi khi truy cập vào https://biz9.vn, bao gồm: địa chỉ IP, loại browser, ngôn ngữ sử dụng, thời gian, địa điểm, nguồn tìm kiếm đến website https://biz9.vn và những địa chỉ mà browser truy xuất đến.</p>

<p>2. Sử dụng thông tin</p>

<p>- Website https://biz9.vn thu thập và sử dụng thông tin cá nhân của người dùng với mục đích phù hợp và hoàn toàn tuân thủ nội dung của “Chính sách bảo mật thông tin người dùng” này.</p>

<p>- Khi cần thiết, https://biz9.vn có thể sử dụng những thông tin này để liên hệ trực tiếp với người dùng dưới các hình thức như: gởi thư ngỏ, gửi thư định kỳ cung cấp thông tin, dịch vụ mới; thông tin về các sự kiện sắp tới; khảo sát thu thập thông tin.</p>

<p>- Website https://biz9.vn cam kết không bán hoặc cho thuê Email của người dùng từ bên thứ ba. Nếu người dùng vô tình nhận được Email không theo yêu cầu từ hệ thống chúng tôi do một nguyên nhân ngoài ý muốn, xin vui lòng nhắn vào link từ chối nhận Email kèm theo hoặc thông báo trực tiếp đến Ban quản trị website.</p>

<p>- Trong một số trường hợp, https://biz9.vn có thể thuê một đơn vị độc lập để tiến hành các dự án nghiên cứu thị trường và khi đó thông tin của người dùng sẽ được cung cấp cho đơn vị này để tiến hành dự án. Bên thứ ba này sẽ bị ràng buộc bởi một thỏa thuận về bảo mật mà theo đó họ chỉ được phép sử dụng những thông tin được cung cấp cho mục đích hoàn thành dự án.</p>

<p>3. Chỉnh sửa thông tin cá nhân</p>

<p>Bất cứ thời điểm nào, người dùng cũng có thể truy cập và chỉnh sửa những thông tin cá nhân của mình (nếu có đăng ký) theo các liên kết thích hợp mà chúng tôi cung cấp hoặc liên hệ trực tiếp qua email để chúng tôi chỉnh sửa.</p>

<p>4. Bảo mật thông tin cá nhân</p>

<p>- Khi người dùng gửi thông tin cá nhân của người dùng cho https://biz9.vn, người dùng đã đồng ý với các điều khoản mà chúng tôi đã nêu ở trên, https://biz9.vn cam kết bảo mật thông tin cá nhân của người dùng bằng mọi cách thức có thể. Chúng tôi sẽ sử dụng nhiều biện pháp thích hợp về kỹ thuật, công nghệ và an ninh nhằm ngăn chặn truy cập trái phép hoặc trái pháp luật, đồng thời bảo vệ thông tin này không bị truy lục, sử dụng hoặc tiết lộ ngoài ý muốn.</p>

<p>- Ngoại trừ các trường hợp về sử dụng thông tin cá nhân như đã nêu trong chính sách này, https://biz9.vn cam kết sẽ không tiết lộ thông tin cá nhân của người dùng ra ngoài.</p>

<p>- https://biz9.vn có thể tiết lộ hoặc cung cấp thông tin cá nhân của người dùng trong các trường hợp thật sự cần thiết như sau: (a) khi có yêu cầu của cơ quan nhà nước; (b) trong trường hợp mà https://biz9.vn tin rằng điều đó sẽ giúp chúng tôi bảo vệ quyền lợi chính đáng của mình trước pháp luật; (c) tình huống khẩn cấp và cần thiết để bảo vệ quyền an toàn cá nhân của các người dùng khác trên website này.</p>

<p>- Tuy nhiên, do hạn chế về mặt kỹ thuật, không một dữ liệu nào có thể được truyền trên đường truyền internet mà có thể bảo mật được 100%. Do vậy, chúng tôi không thể đưa ra được một cam kết chắc chắn rằng thông tin người dùng cung cấp cho chúng tôi được bảo mật một cách tuyệt đối an toàn và chúng tôi không thể chịu trách nhiệm trong trường hợp có sự truy cập trái phép thông tin cá nhân của người dùng như các trường hợp người dùng tự ý chia sẻ thông tin với người khác, … Nếu Người dùng không đồng ý với các điều khoản như đã mô tả ở trên. Chúng tôi khuyên người dùng không nên gửi thông tin đến cho chúng tôi.</p>

<p>- Vì vậy chúng tôi cũng khuyến cáo người dùng nên bảo mật các thông tin liên quan đến thông tin của người dùng và không nên chia sẻ với bất kỳ người nào khác, đặc biệt trong trường hợp sử dụng máy tính chung nhiều người.</p>

<p>5. Sử dụng “Cookie”</p>

<p>- Webiste https://biz9.vn dùng “Cookie” để giúp cá nhân hóa và nâng cao tối đa hiệu quả sử dụng thời gian trực tuyến của người dùng. Một Cookie là một file văn bản được đặt trên đĩa cứng của người dùng bởi một máy chủ của trang web. Cookie không được dùng để chạy chương trình hay đưa virus vào máy tính của người dùng. Cookie được chỉ định vào máy tính của người dùng và chỉ có thể được đọc bởi một máy chủ trang web trên miền được đưa ra cookie cho người dùng.</p>

<p>- Một trong những mục đích của Cookie là cung cấp những tiện ích để tiết kiệm thời gian của người dùng khi truy cập tại website https://biz9.vn hoặc viếng thăm website lần nữa mà không cần đăng ký lại thông tin sẵn có.</p>

<p>- Người dùng có thể chấp nhận hoặc từ chối dùng cookie. Hầu hết những Browser tự động chấp nhận Cookie, nhưng Người dùng có thể thay đổi những cài đặt để từ chối tất cả những Cookie nếu Người dùng muốn. Tuy nhiên, nếu Người dùng chọn từ chối Cookie, điều đó có thể gây cản trở và ảnh hưởng không tốt đến một số dịch vụ và tính năng phụ thuộc vào Cookie tại website https://biz9.vn.</p>

<p>6. Thay đổi về chính sách</p>

<p>- https://biz9.vn hoàn toàn có thể thay đổi nội dung trong trang này mà không cần phải thông báo trước, để phù hợp với các nhu cầu của https://biz9.vn, nhu cầu và sự phản hồi từ người dùng (nếu có) cũng như các quy định của pháp luật (nếu có). Khi cập nhật nội dung chính sách này, chúng tôi sẽ chỉnh sửa lại thời gian “Cập nhật lần cuối” bên dưới.</p>

<p>- Nội dung “Chính sách bảo mật thông tin” này chỉ áp dụng tại https://biz9.vn, không bao gồm hoặc liên quan đến các bên thứ ba đặt quảng cáo hay có link tại https://biz9.vn. Chúng tôi khuyến khích người dùng đọc kỹ chính sách an toàn và bảo mật của các trang web của bên thứ ba trước khi cung cấp thông tin cá nhân cho các trang web đó. Chúng tôi không chịu trách nhiệm dưới bất kỳ hình thức nào về nội dung và tính pháp lý của trang web thuộc bên thứ ba.</p>

<p>- Vì vậy, người dùng đã đồng ý rằng, khi sử dụng website của chúng tôi sau khi chỉnh sửa nghĩa là người dùng đã thừa nhận, đồng ý tuân thủ cũng như tin tưởng vào sự chỉnh sửa này. Do đó, chúng tôi đề nghị người dùng nên xem trước nội dung trang này trước khi truy cập các nội dung khác trên website cũng như nên đọc và tham khảo kỹ nội dung “Chính sách bảo mật thông tin” của từng website mà người dùng đang truy cập.</p>

<p>7. Thời gian lưu trữ thông tin</p>

<p>- https://biz9.vn sẽ lưu trữ các thông tin cá nhân do người dùng cung cấp trên hệ thống nội bộ của chúng tôi trong quá trình cung cấp dịch vụ cho người dùng hoặc cho đến khi hoàn thành mục đích thu thập thông tin hoặc khi người dùng có yêu cầu hủy các thông tin đã cung cấp. Chúng tôi rất hoan nghênh các góp ý đóng góp và phản hồi thông tin từ người dùng về Chính sách bảo mật thông tin này.</p>

<p>&nbsp;</p>

				<?php //$ariacms->getBlock("hot_news"); ?>
			</div>
		</div>
	</div>
	
</div>
<?= $ariacms->getBlock("footer"); ?>
</body>


<!-- Mirrored from demo.themeix.com/html/helex2/blog-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 03:35:56 GMT -->
</html>