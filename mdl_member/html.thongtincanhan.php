<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;

$query = "SELECT * FROM `e4_posts` where `user_created` = " . $_SESSION['member']['id'] . " and `news_position` = 0 and post_status = 'active' ORDER BY id desc";
$database->setQuery($query);
$posts = $database->loadObjectList();


$query = "select post_id  from e4_post_like where member_id = " . $_SESSION["member"]['id'] . " ORDER BY id desc";
$database->setQuery($query);
$member_likes = $database->loadObjectList();

$array_liked = array();
foreach ($member_likes as $key) {
    array_push($array_liked, $key->post_id);
}
$array_liked = array_flip($array_liked);
//print_r($array_liked);
//print_r($_SESSION);

// lấy cái bài viết đã like và comment
$query = "select a.title_vi, a.url_part,a.image, b.thoigian thoigian, b.trangthai trangthai from e4_posts a, e4_post_like b where a.id = b.post_id and b.member_id = " . $_SESSION['member']['id'] . "
			Union 
			select c.title_vi, c.url_part,c.image,  d.date_review thoigian,d.state trangthai  from e4_posts c, e4_post_comment d where c.id = d.post_id and d.member_id = " . $_SESSION['member']['id'] . " and d.state = 0

			order by thoigian desc limit 0,6";
$database->setQuery($query);
$histories = $database->loadObjectList();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>IBST|
        &ensp;<?= (isset($_SESSION['member']['fullname']) and $_SESSION['member']['fullname'] != '') ? $_SESSION['member']['fullname'] : $ariacms->web_information->{$params->name}; ?></title>

    <meta name="description"
          content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>
    <meta name="keywords"
          content="<?= ($ariacms->web_information->{$params->meta_keyword} != '') ? $ariacms->web_information->{$params->meta_keyword} : $ariacms->web_information->{$params->name}; ?>"/>

    <meta property="og:site_name" content="<?= $ariacms->web_information->{$params->name} ?>"/>
    <meta property="og:url" content="<?= $ariacms->c_url ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="<?= ($ariacms->web_information->{$params->meta_title} != '') ? $ariacms->web_information->{$params->meta_title} : $ariacms->web_information->{$params->name}; ?>"/>
    <meta property="og:description"
          content="<?= ($ariacms->web_information->{$params->meta_description} != '') ? $ariacms->web_information->{$params->meta_description} : $ariacms->web_information->{$params->name}; ?>"/>

    <meta property="og:image" content="/templates/Economic247/images/logo.jpg"/>

    <?= $ariacms->getBlock("head"); ?>


</head>

<body>


<div id="wrapper">
    <div class="w1200">
        <?= $ariacms->getBlock("header"); ?>
    </div>
    <!-- sidebar -->


    <!-- Main Contents -->
    <div class="main-content w1200">
        <div class="mcontainer" style="min-height: 60%">
            <div class="lg:flex  lg:space-x-12" style="text-align: center;">
                <div class="lg:w-3/4">
                    <div class="head_member">
                        <a href="<?= $ariacms->actual_link ?>member/chinh-sua-thong-tin.html">
                            <img src="<?php if ($_SESSION["member"]["image_url"]) echo $_SESSION["member"]["image_url"]; else echo "/upload/noimage.png" ?>"
                                 class="is_avatar" alt="" style="border-radius: 100%; margin: auto;" height="150px"
                                 width="150px">
                        </a>
                        <h3 class="text-center" style="margin-top: 10px;font-size: large;color:#3b82f6">
                            <b><?= $_SESSION['member']['fullname'] ?></b>
                        </h3>
                    </div>
                    <div class="flex justify-between  relative flex_detail">
                        <style>
                            .but {
                                border: none;
                                color: white;
                                padding: 15px 32px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;
                                font-size: 16px;
                                margin: 4px 2px;
                                cursor: pointer;
                            }

                            .but:hover {
                                color: white;
                            }

                            .but1 {
                                background-color: #4CAF50;
                            }

                            .but2 {
                                background-color: #008CBA;
                            }
                        </style>
                        <div class="flex-1">
                            <h2 class="text-3xl font-semibold">

                                <?php if ($_SESSION['member']['LoginType'] == 'author') { ?>
                                    <a href="<?= $ariacms->actual_link ?>member/bai-viet.html" class="but but1">Quản lý bài
                                        báo </a>
                                    <a href="<?= $ariacms->actual_link ?>member/tao-bai-viet.html" class="but but2"> Tạo bài
                                        báo</a>
                                <?php }?>

                                <?php if ($_SESSION['member']['LoginType'] == 'reviewer') { ?>
                                    <a href="<?= $ariacms->actual_link ?>member/quan-ly-phan-bien.html"
                                       class="but but1">Quản lý phản biện </a>
                                <?php } ?>



                            </h2>
                        </div>
                    </div>
                    <?php
                    foreach ($posts as $key) {

                        if ($array_liked[$key->id] > -1) {
                            $like = ' style="color: blue;" ';
                        } else {
                            $like = "";
                        }
                        ?>
                        <div class="lg:flex lg:space-x-6 py-6" style="border-bottom: 1px solid #ddd;">
                            <a href="<?= $ariacms->actual_link . 'chi-tiet/' . $key->url_part . '.html'; ?>">
                                <div class="lg:w-60 w-full h-40 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="<?= $key->image ?>" alt=""
                                         class="w-full h-full absolute inset-0 object-cover">
                                    <div class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
                                        <i class="spr spr__clock"></i><?php if ($key->post_created > 0) {
                                            echo $ariacms->unixToDate($key->post_created, '/') . ' ' . $ariacms->unixToTime($key->post_created, ':');
                                        } ?>
                                    </div>
                                </div>
                            </a>
                            <div class="flex-1 lg:pt-0 pt-4">
                                <a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $key->url_part ?>.html"
                                   class="text-xl font-semibold line-clamp-2"> <?= $key->title_vi ?></a>


                                <p class="line-clamp-2 pt-1"><?= $key->brief_vi ?></p>

                                <div class="flex items-center pt-3">
                                    <div class="flex items-center" id="like<?= $key->id ?>">
                                        <a href="javascript:;"
                                           onclick="likepost('<?= $key->id ?>','<?= $_SESSION['member']['id'] ?>','<?= $key->number_like ?>')"
                                           class="items-center">
                                            <ion-icon name="thumbs-up-outline" class="text-xl mr-2 md hydrated"
                                                      role="img"
                                                      aria-label="thumbs up outline" <?= $like ?> ></ion-icon> <?= $key->number_like ?>
                                        </a>
                                    </div>
                                    <div class="flex items-center mx-4">
                                        <a href="javascript:;" class="items-center">
                                            <ion-icon name="chatbubble-ellipses-outline"
                                                      class="text-xl mr-2 md hydrated" role="img"
                                                      aria-label="chatbubble ellipses outline"></ion-icon> <?= $key->number_comment ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="clear"></div>
                    <div class="sticky-bottom"></div>
                </div>
            </div>
            <?= $ariacms->getBlock("footer"); ?>
</body>

</html>