<?php
global $database;
global $ariacms;
global $params;
?> 



<section class="zone zone--comment">
<header class="zone__heading">
<h3 class="heading">bình luận (0)</h3>
</header>
<div class="zone__body">
	<div class="cmt-container">
		<div class="cmt-container-story">
			<div class="cmt-btn" id="212544" data-objectid="212544" style="display: block;" onclick="openComment();">
				Viết bình luận...
			</div>

		<form class="cmt-form" id="commentForm" data-parentid="0" data-objectid="212545"  style="display: none;">
			<textarea class="cmt-comment" placeholder="Hãy sử dụng tiếng Việt có dấu, tối thiểu 20 ký tự và tối đa 500 ký tự." minlength="20" maxlength="500" required="required"
			oninvalid="setCustomValidity('Bạn cần nhập bình luận của mình. Hãy sử dụng tiếng Việt có dấu, tối thiểu 20 ký tự và tối đa 500 ký tự.')" oninput="setCustomValidity('')"></textarea>
			<div class="clearfix"></div>
			<input type="text" class="cmt-name" name="cmt-name" placeholder="Tên của bạn" minlength="5" required="required"
				oninvalid="setCustomValidity('Bạn cần nhập tên của mình(tối thiểu 5 kí tự)')" oninput="setCustomValidity('')" />
			<div class="clearfix"></div>
			<input class="cmt-email" name="cmt-email" value="" placeholder="Email của bạn" type="email" required="required"
				oninvalid="setCustomValidity('Bạn cần nhập đúng email')" oninput="setCustomValidity('')" />
			<div class="clearfix"></div>
			<button type="reset" class="btn cmt-cancel-btn btn-dismiss">Hủy</button>
			<button type="submit" class="btn cmt-submit-btn btn-primary">Gửi bình luận</button>
		</form>
		<div class="cmt-list cmt-collapse usercomment">


		</div>

		</div>
	</div>
</div>
</section>

<script>
// thay đổi thuộc tính 
	function openComment(){
		document.getElementById("212544").setAttribute("style", "display: none;");
		document.getElementById("commentForm").setAttribute("style", "display: block;");
	}
</script>

