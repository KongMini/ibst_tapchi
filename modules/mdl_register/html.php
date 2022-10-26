<?php
class View
{

    public static function formregister()
    {
        include "html.formregister.php";
    }
    public static function formlogin()
    {
        include "html.formlogin.php";
    }
	public static function loginsuccess($user)
    {
        include "html.loginsuccess.php";
    }
}
