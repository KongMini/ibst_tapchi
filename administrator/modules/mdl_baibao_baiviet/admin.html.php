<?php
class View
{
	static function showNewsManager()
	{
?>
		
<?php
	}
	static function news_view($news, $totalRows, $maxRows, $curPg, $users, $linhvuc)
	{
		include("admin.html.news_view.php");
	}
	static function news_publish($news, $totalRows, $maxRows, $curPg, $users)
	{
		include("admin.html.news_publish.php");
	}
	static function news_add()
	{
		include("admin.html.news_add.php");
	}static function news_edit()
	{
		include("admin.html.news_edit.php");
	}
}
?>