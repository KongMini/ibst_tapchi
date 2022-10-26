<?php
global $ariacms;

class View
{
    static function userManagerFront()
    {
        ?>
        <section class="content-header">
        <h1><a class="col-lg-3 col-md-4 col-sm-4 col-xs-12 btn-lg btn btn-warning "
               href="index.php?module=<?php echo $_REQUEST['module'] ?>">Quản
        lý <?php if ($_REQUEST['task']) echo "Tác giả / Phản biện"; else echo " người dùng" ?></a>
        <a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right"
           href="index.php?module=<?php echo $_REQUEST['module'] ?>">
            Danh sách
        </a>
        <?php if ($_REQUEST['task']){?>
            <a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="javascript:void(0);"
               data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/user/ajax.user_public_add.php');">
                Thêm mới
            </a>

        <?php }else{?>
            <a class="col-lg-1 col-md-2 col-sm-2 col-xs-12 btn btn-success pull-right" href="javascript:void(0);"
               data-toggle="modal" data-target="#showCNTT" onclick="showCNTT('','ajax/user/ajax.user_add.php');">
                Thêm mới
            </a>
        <?php }?>
        </h1>
        </section>
        <?php
    }


    static function user_public($users, $totalRows, $curPg, $curRow, $maxRows)
    {
        if ($_REQUEST['task'] == 'user_public') {
            include("admin.html.user_public.php");
        }
    }

    static function user_view($users, $totalRows, $curPg, $curRow, $maxRows)
    {
        if ($_REQUEST['task'] != 'user_public') {
            include("admin.html.user_view.php");
        }
    }

}

?>