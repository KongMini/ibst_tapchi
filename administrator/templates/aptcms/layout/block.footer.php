<!-- Select2 -->
<script src="templates/aptcms/plugins/select2/select2.full.min.js"></script>
<!-- datepicker -->
<script src="templates/aptcms/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Slimscroll -->
<script src="templates/aptcms/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="templates/aptcms/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="templates/aptcms/dist/js/app.min.js"></script>
<script src="templates/aptcms/js/custom.js"></script>
<script src="../plugins/editor/ekeditor5_new/build/ckeditor.js"></script>
<script src="../plugins/editor/ckfinder/ckfinder.js"></script>
<script language="javascript" type="text/javascript">
	function update_value_by_id(t, c, i, v) {
		var _url = "ajax/ajax.update_value_by_id.php";
		var f = "t=" + t + "&c=" + c + "&i=" + i + "&v=" + v;
		$.ajax({
			url: _url,
			data: f,
			cache: false,
			context: document.body,
			success: function(data) {
				window.location.reload(true);
			}
		});
	}

	function showCNTT(id, ajax_file) {
		var _url = ajax_file;
		$.ajax({
			url: _url,
			data: "id=" + id,
			cache: false,
			context: document.body,
			success: function(data) {
				$("#showCNTT").html(data);
			}
		});
	}

	function check_value_exist(value, input, t, c, id_result, error) {
		var input = $(input).val();
		var _url = "ajax/ajax.check_value_exist.php";
		$.ajax({
			url: _url,
			data: "input=" + input + "&t=" + t + "&c=" + c + "&error=" + error + "&value=" + value,
			cache: false,
			context: document.body,
			success: function(data) {
				$(id_result).html(data);
			}
		});
	}

	function confirmAction() {
		return confirm("Bạn chắc chắn muốn thực hiện thao tác?");
	}

	function checked_by_list(list, element) {
		var Array = list.split(",");
		$(element).each(function() {
			for (i = 0; i < Array.length; i++) {
				if ($(this).val() == Array[i]) {
					$(this).attr('checked', 'checked');
				}
			}
		});
	}

	function set_list_to_element(condition, element) {
		var List = "";
		$(condition).each(function() {
			List = List + $(this).val() + ',';
		});

		List = List.substr(0, List.length - 1);
		$(element).val(List);
	}

	function set_sidebar_config() {
		var cname = 'sidebar_config';
		var cvalue = 'sidebar-collapse';
		var sidebar_config = getCookie(cname);
		var exdays = 30;
		if (sidebar_config === cvalue) exdays = -30;
		setCookie(cname, cvalue, exdays);
	}

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
</script>