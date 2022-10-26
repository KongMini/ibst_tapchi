<?php
session_start();
if (file_exists("../../../configuration.php")) {
    require_once("../../../configuration.php");
} else {
    echo "Missing Configuration File";
    exit();
}
//Include Database Controller
if (file_exists("../../../include/database.php")) {
    require_once("../../../include/database.php");
} else {
    echo "Missing Database File";
    exit();
}
//Include System File
if (file_exists("../../../include/ariacms.php")) {
    require_once("../../../include/ariacms.php");
} else {
    echo "Missing System File";
    exit();
}
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$query = "SELECT * FROM e4_roles WHERE status = '1' ";
$database->setQuery($query);
$roles = $database->loadObjectList();
?>
<script language="javascript">
    function checkInput() {
        if ((document.form_user_add.newPassword.value) != (document.form_user_add.confirmPassword.value)) {
            alert("Mật khẩu không trùng khớp!");
            document.form_user_add.confirmPassword.focus();
            return false;
        }
        return true;
    }
</script>
<div class="modal-dialog modal-lg">
    <form method="POST" action="?module=user&task=user_add" name="form_user_add" id="form_user_add" onSubmit="return checkInput();">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Cập nhật thông tin chi tiết</h4>
            </div>
            <div class="box-body">
                <div class=" col-md-6">
                    <div class="form-group">
                        <label>User Type <font class="text-red">*</font></label>
                        <select class="form-control" name="user_type" id="user_type" required>
                            <option value='public' selected >Public Web</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tên đầy đủ <font class="text-red">*</font></label>
                        <input class="form-control" name="fullname" type="text" value="" required />
                    </div>
                    <div class="form-group">
                        <label>Email <font class="text-red">*</font> <em class="text-red" id="result_email"></em></label>
                        <input class="form-control" type="text" name="email" id="email" value="" required onblur="check_value_exist('', '#email', 'e4_users', 'email', '#result_email', 'Email');" />
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu <font class="text-red">*</font></label>
                        <input class="form-control" type="password" value="" name="password" id="newPassword" required />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu <font class="text-red">*</font></label>
                        <input class="form-control" type="password" value="" id="confirmPassword" required />
                    </div>

                    <div class="form-group">
                        <label>Phản biện</label>
                        <select class="form-control select2"  value="" required name="phanbien" id="permission">
                            <option value="">Vui lòng chọn</option>
                            <option value="0">Không đồng ý</option>
                            <option value="1">Đồng ý</option>

                        </select>
                    </div>

                </div>
                <div class=" col-md-6">
					<div class="form-group">
                        <label>Học vị</label>
                        <input name='hocvi' class="form-control" type="text" value="" />
                    </div>
                    <div class="form-group">
                        <label>Homephone</label>
                        <input class="form-control" type="text" name="homephone" value="" />
                    </div>
                    <div class="form-group">
                        <label>Mobifone</label>
                        <input class="form-control" type="text" name="mobifone" value="" />
                    </div>
                    <div class="form-group">
                        <label>Facebook</label>
                        <input class="form-control" type="text" name="facebook" value="" />
                    </div>
                    <div class="form-group">
                        <label>Yahoo</label>
                        <input class="form-control" type="text" name="yahoo" value="" />
                    </div>
                    <div class="form-group">
                        <label>Skype</label>
                        <input class="form-control" type="text" name="skype" value="" />
                    </div>
                    <!--div class="form-group">
                        <label>Vai trò</label>
                        <select class="form-control"   required name="menu_privilege" id="menu_privilege">
                            <option value="">Vui lòng chọn</option>
                            <option value="MAKER">Biên tập nội dung</option>
                            <option value="CHECKER">Kiểm duyệt nội dung</option>
                            <option value="ADMIN">Quản trị nội dung</option>
                        </select>
                    </div-->
                </div>
                <div class="col-md-12">
                    <label for="imgfile">Ảnh đại diện</label>
                    <img style="max-height:100px;" id="newImg" txthide="imgfile" class="choiceImg cursor" src="templates/aptcms/dist/img/noimage.png" onclick="fcall.fcChoiceImg(this);" data-toggle="tooltip" title="Nhấn để chọn ảnh đại diện" />
                    <input class="form-control hidden" id="imgfile" name="imgfile" type="text" />
                </div>

            </div>
            <div class="modal-footer">
                <p class="text-orange pull-right">Vui lòng nhập đầy đủ thông tin trường có dấu (<font class="text-red">*</font>).</p>
                <button type="submit" class="btn btn-primary pull-left" name="submit" value="user_add">Cập nhật</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng lại</button>

            </div>
        </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->