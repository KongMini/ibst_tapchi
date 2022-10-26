<?php
class View
{

    public static function news_list($news)
    {
        include "html.news_list.php";
    }
    public static function news_taxonomy($news, $category)
    {
        include "html.news_taxonomy.php";
    }
}
