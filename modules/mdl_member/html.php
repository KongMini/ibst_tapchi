<?php
class View
{

    public static function formregister()
    {
        include "html.formregister.php";
    }
    public static function taobaiviet()
    {
        include "html.taobaiviet.php";
    }
	public static function quanlybaiviet($member_posts, $member_posts_list)
    {
        include "html.quanlybaiviet.php";
    }
	public static function suabaiviet($member_posts)
    {
        include "html.suabaiviet.php";
    }
	public static function thongtincanhan()
    {
        include "html.thongtincanhan.php";
    }
	public static function editthongtincanhan()
	{
		 include "html.editthongtincanhan.php";
	}
	public static function nhatkyhoatdong()
	{
		 include "html.nhatkyhoatdong.php";
	}
	public static function quanlyphanbien($phanbien_posts)
	{
		 include "html.quanlyphanbien.php";
	}
	public static function phanbien($member_posts)
	{
		 include "html.phanbienbaiviet.php";
	}
}
