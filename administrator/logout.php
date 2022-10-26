<?php
	@session_start();
	@session_destroy();
	setcookie('xkt_admin', '', time() - 3600);
	header("location:index.php");
