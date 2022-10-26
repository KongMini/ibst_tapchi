<?php
class View
{

    public static function news_list($news)
    {
        include "html.news_list.php";
    }
    public static function news_taxonomy($news, $category,$news_head )
    {
        include "html.news_taxonomy.php";
    }
}
