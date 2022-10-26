<?php

class Model
{
    static function viewhome()
    {
        global $database;


        $where = "";
        if($_POST['to']){
            $where .= " AND post_created < ". strtotime( $_POST['to']);
        }
        if($_POST['from']){
            $where .= " AND post_created > ". strtotime( $_POST['from']);
        }
        if($_POST['author']){
            $key = $_POST['author'];
            $where .= " AND tacgia_vi like '%$key%' or tacgia_en like '%$key%'";
        }
        if($_POST['key_word']){
            $key = $_POST['key_word'];
            $where .= " AND tukhoa_vi like '%$key%' or tukhoa_en like '%$key%'";
        }

        $key = $_POST['keysearch'];
        // tim  kiem theo tu
        if( $key){
            $query = "SELECT * FROM e4_tapchi WHERE (title_vi like '%$key%' or title_en like '%$key%' 
                            ) and post_status = 'active' 
                          and type='tapchi'". $where ." ORDER BY id desc LIMIT 0, 40";
            $database->setQuery($query);
            $taxonomies = $database->loadObjectList();
        }


        View::viewhome($taxonomies, $key);
    }
}
