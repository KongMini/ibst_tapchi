<?php
	global $ariacms;
?>
		<section class="content">
			<div class="row">
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img src="<?php echo ($_SESSION["user"]['image_url']!='')?$_SESSION["user"]['image_url']:'templates/aptcms/dist/img/no-image.png';?>" class="profile-user-img img-responsive img-circle" alt="<?php echo $_SESSION["user"]['fullname']?>">
							<h3 class="profile-username text-center"><?php echo $_SESSION["user"]['fullname']?></h3>
							<p class="text-muted text-center"><?php echo $profile['role_code']?></p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									Ngày tạo tài khoản
									<a class="pull-right"><?=$ariacms->unixToDate($profile['date_created'], "/") . " " . $ariacms->unixToTime($profile['date_created'], ":")?></a>
								</li>
							</ul>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.col -->
				
				<div class="col-md-9">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#settings" data-toggle="tab">Cập nhật thông tin</a></li>
							<li><a href="#profile_change_pass" data-toggle="tab">Thay đổi mật khẩu</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="settings">
								<form class="form-horizontal" action="index.php?module=<?php echo $_REQUEST["module"]?>&task=profile_edit" id="frm_profile_edit" method="POST" name="frm_profile_edit" enctype="multipart/form-data" >
									<div class="form-group">
										<label for="fullname" class="col-sm-3 col-md-3 col-lg-2 control-label">Tên đầy đủ</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="fullname" value="<?php echo $profile['fullname']?>" name="fullname" placeholder="Tên đầy đủ" required />
										</div>
									</div>
									<div class="form-group">
										<label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label">Email</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="email" class="form-control" id="email" value="<?php echo $profile['email']?>" required name="email" placeholder="Email" />
										</div>
									</div>
									<div class="form-group">
										<label for="homephone" class="col-sm-3 col-md-3 col-lg-2 control-label">Homephone</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="homephone" value="<?php echo $profile['homephone']?>"  name="homephone" placeholder="Homephone" />
										</div>
									</div>
									<div class="form-group">
										<label for="mobifone" class="col-sm-3 col-md-3 col-lg-2 control-label">Mobifone</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="mobifone" value="<?php echo $profile['mobifone']?>"  name="mobifone" placeholder="Mobifone" />
										</div>
									</div>
									<div class="form-group">
										<label for="skype" class="col-sm-3 col-md-3 col-lg-2 control-label">Skype</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="skype" value="<?php echo $profile['skype']?>"  name="skype" placeholder="Skype" />
										</div>
									</div>
									<div class="form-group">
										<label for="yahoo" class="col-sm-3 col-md-3 col-lg-2 control-label">Yahoo</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="yahoo" value="<?php echo $profile['yahoo']?>"  name="yahoo" placeholder="Yahoo" />
										</div>
									</div>
									<div class="form-group">
										<label for="facebook" class="col-sm-3 col-md-3 col-lg-2 control-label">Facebook</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="facebook" value="<?php echo $profile['facebook']?>"  name="facebook" placeholder="Facebook" />
										</div>
									</div>
									<div class="form-group">
										<label for="address" class="col-sm-3 col-md-3 col-lg-2 control-label">Địa chỉ</label>
										<div class="col-sm-9 col-md-9 col-lg-10">
											<input type="text" class="form-control" id="address" value="<?php echo $profile['address']?>"  name="address" placeholder="Địa chỉ" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">
											<button type="submit" class="btn btn-danger" name="sb_profile_edit" value="profile_edit">Cập nhật</button>
										</div>
									</div>
								</form>
							</div><!-- /.tab-pane -->
							
							<div class="tab-pane" id="profile_change_pass">
								<form class="form-horizontal" id="frm_profile_change_pass" method="POST" name="frm_profile_change_pass" onSubmit="return checkInput();" action="index.php?module=<?php echo $_REQUEST["module"]?>&task=profile_change_pass" >
									<div class="form-group">
										<label for="password_old" class="col-sm-4 col-md-4 col-lg-3 control-label">Mật khẩu cũ</label>
										<div class="col-sm-8 col-md-8 col-lg-9">
											<input type="password" class="form-control" id="password_old" name="password_old" placeholder="Mật khẩu cũ" required />
										</div>
									</div>
									<div class="form-group">
										<label for="password_new" class="col-sm-4 col-md-4 col-lg-3 control-label">Mật khẩu mới</label>
										<div class="col-sm-8 col-md-8 col-lg-9">
											<input type="password" class="form-control" id="password_new" name="password_new" placeholder="Mật khẩu mới" pattern=".{6,}" required title="ít nhất 6 ký tự" />
										</div>
									</div>
									<div class="form-group">
										<label for="password_confirm" class="col-sm-4 col-md-4 col-lg-3 control-label">Nhập lại mật khẩu mới</label>
										<div class="col-sm-8 col-md-8 col-lg-9">
											<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Nhập lại mật khẩu mới" pattern=".{6,}" required title="ít nhất 6 ký tự" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-8 col-md-offset-4 col-md-8 col-lg-offset-3 col-lg-9">
											<button type="submit" class="btn btn-danger" name="sb_profile_change_pass" value="profile_change_pass">Cập nhật</button>
										</div>
									</div>
								</form>
							</div><!-- /.tab-pane -->
							
							
						</div><!-- /.tab-content -->
						
					</div><!-- /.nav-tabs-custom -->
				</div><!-- /.col -->
			
			</div><!-- /.row -->
		</section><!-- /.content -->
		
	<script language="javascript">
		function checkInput(){
			if((document.frm_profile_change_pass.password_new.value)!=(document.frm_profile_change_pass.password_confirm.value)){
				alert("Mật khẩu không trùng khớp!");
				document.frm_profile_change_pass.password_confirm.focus();
				return false;
			}
			return true;
		}
	</script>