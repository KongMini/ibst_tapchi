<?php
class View
{

    public static function news_list($news ,$nam ,$count ,$maxRows1)
    {
        include "html.news_list.php";
    }
    public static function news_taxonomy($news,$detail, $category,$count,$maxRows1 )
    {
        include "html.news_taxonomy.php";
    }
}
