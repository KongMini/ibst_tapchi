<?php
class View {

    public static function product_list($products, $taxonomies) {
        include "html.product_list.php";
    }
    public static function product_taxonomy($products, $taxonomies, $category){
        include "html.product_taxonomy.php";
    }

}
