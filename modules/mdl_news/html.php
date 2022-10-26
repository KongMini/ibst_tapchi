<?php
class View
{

    public static function news_list($news,$count,$maxRows1)
    {
        include "html.news_list.php";
    }
    public static function news_taxonomy($news, $category,$news_head,$array_liked, $term_meta )
    {
        include "html.news_taxonomy.php";
    }
}
