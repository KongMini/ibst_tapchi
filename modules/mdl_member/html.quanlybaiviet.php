<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;
//print_r($_SESSION["member"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?></title>
    <meta name="description"
          content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>
    <meta name="keywords"
          content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>"/>
    <meta property="og:title"
          content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
    <meta property="og:description"
          content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>

    <meta property="og:site_name" content="<?= $ariacms->web_information->{$params->name} ?>"/>
    <meta property="og:url" content="<?= $ariacms->c_url ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
    <meta property="og:description"
          content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>

    <meta property="og:image" content="https://taichinhso.net.vn/upload/banner.png"/>

    <?= $ariacms->getBlock("head"); ?>
    <!--
    <script type="text/javascript" src="/plugins/editor/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="/templates/aptcms/bootstrap/css/bootstrap.min.css">
    <script src="/templates/aptcms/bootstrap/js/bootstrap.min.js"></script>
    -->
</head>
<body>
<div class="w1200">
    <?= $ariacms->getBlock("header"); ?>
</div>
<style>
    .tabcontent {
        display: none;
    }

    .active a {
        color: blue;
        font-weight: 600;
        border-bottom: 3px solid #2a41e8;
    }

    .cd-secondary-nav ul li:not(:last-child) {
        padding-right: 10px;
    }

    table {
        margin-top: 30px;
    }

    table, th, td {
        border: 1px solid #818181;
        color: #818181;
    }

    td.tdst {
        padding: 10px;
    }

    td.tdst.ct {
        text-align: center;
    }
</style>
<div class="main_content w1200" style="min-height: 450px; padding: 0 50px">
    <div class="mcontainer">
        <div class="flex justify-between  flex-col-reverse lg:flex-row">
            <div class="flex items-center space-x-1.5 flex-shrink-0 pr-3  justify-center order-1">

                <table>
                    <tr>
                        <th style="width:4%">STT</th>
                        <th style="width:10%">M?? b??i b??o</th>
                        <th style="width:30%">Ti??u ?????</th>

                        <th style="width:12%">Tr???ng th??i</th>
                        <th style="width:12%">Th???i gian</th>
                        <th style="width:10%">Thao t??c</th>
                    </tr>
                    <?php
                    $stt = 0;
                    $next = 0;
                    foreach ($member_posts_list as $k => $postlist) {
                        foreach ($member_posts as $i => $post){
                            if( $postlist-> mabaibao == $post -> mabaibao){
                                $stt ++;

                                if ($post->status == 'chokiemduyet') {
                                    $status = 'Ch??? ki???m duy???t';
                                }else if ($post->status == 'choduyet') {
                                    $status = 'Ch??? duy???t';
                                }else if ($post->status == 'chotiepnhan') {
                                    $status = 'Ch??? ti???p nh???n';
                                }else if ($post->status == 'phanhoitacgia') {
                                    $status = 'Ti???p thu ?? ki???n';
                                }else if ($post->status == 'phanbien') {
                                    $status = '???? ph???n bi???n';
                                }else if ($post->status == 'phanhoi') {
                                    $status = 'Ph???n h???i ph???n bi???n';
                                }else if ($post->status == 'active') {
                                    $status = '?????ng ?? ????ng';
                                }else{
                                    $status = 'Ch??? ki???m duy???t';
                                }

                            ?>
                                <tr>

                                    <td class="tdst ct"><?php if($next == $k) echo $k+1; ?></td>
                                    <td class="tdst"><a
                                                href='sua-bai-viet.html?id=<?= $post->id ?>&mabaibao=<?= $post->mabaibao ?>'><?php if($next == $k) echo $post->mabaibao ?></a></td>
                                    <td class="tdst"><a
                                                href='sua-bai-viet.html?id=<?= $post->id ?>&mabaibao=<?= $post->mabaibao ?>'><?php echo $post->title_vi ?></a></td>
                                    <td class="tdst ct"><a
                                                href='sua-bai-viet.html?id=<?= $post->id ?>&mabaibao=<?= $post->mabaibao ?>'><?php echo $status?></a></td>
                                    <td class="tdst"><?php echo date("d-m-Y H:i:s", $post->date_created) ?></td>
                                    <td class="tdst ct"><a
                                                href='sua-bai-viet.html?id=<?= $post->id ?>&mabaibao=<?= $post->mabaibao ?>'><i
                                                    class="fa fa-eye" aria-hidden="true"></i></a></td>
                                </tr>
                        <?php unset($member_posts[$i]);$next++;}
                        }
                        $next = $k +1;
                    }?>
                </table>

            </div>
        </div>


        <div class="clear"></div>
    </div>
</div>
</div>


<?= $ariacms->getBlock("footer"); ?>
<?= $ariacms->getBlock("footer_script"); ?>
</body>
</html>
