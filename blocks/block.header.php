<?php
global $database;
global $ariacms;
global $params;
global $web_menus;
global $ariaConfig_template;
global $web_information;
$catid = $ariacms->getParam("task");
$i = 0;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.
$url .= $_SERVER['HTTP_HOST'];;

//print_r($_SESSION['orderCart']); die; 
// Append the requested resource location to the URL
$task = ltrim($_SERVER['REQUEST_URI'], '/');
$_SESSION['url'] = $url . $_SERVER['REQUEST_URI'];
// Nhật ký hoạt động
$query = "select a.title_vi, a.url_part,a.image, b.thoigian thoigian, b.trangthai trangthai from e4_posts a, e4_post_like b where a.id = b.post_id and b.member_id = " . $_SESSION['member']['id'] . "
Union 
select c.title_vi, c.url_part,c.image,  d.date_review thoigian,d.state trangthai  from e4_posts c, e4_post_comment d where c.id = d.post_id and d.member_id = " . $_SESSION['member']['id'] . " and d.state = 0
order by thoigian desc limit 0,200";
$database->setQuery($query);
$histories = $database->loadObjectList();

// Lấy ra bài viết đã đăng
$query_post = "select a.title_vi,a.image,a.image_thumb,a.aproved_date,a.post_status,a.url_part from e4_posts a where (a.post_status='active' or a.post_status='waiting') and user_created = " . $_SESSION['member']['id'] . " order by a.aproved_date desc limit 0,100";
$database->setQuery($query_post);
$baidadang = $database->loadObjectList();


function svl_ismobile()
{
    $is_mobile = '0';
    if (preg_match('/(android|iphone|ipad|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $is_mobile = 1;
    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
        $is_mobile = 1;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'andr', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');

    if (in_array($mobile_ua, $mobile_agents))
        $is_mobile = 1;

    if (isset($_SERVER['ALL_HTTP'])) {
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'OperaMini') > 0)
            $is_mobile = 1;
    }
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0)
        $is_mobile = 0;
    return $is_mobile;
}


if (!$ariacms->checkUserLogin()) {
    $lightbox = "uk-toggle";
    $url_login = '#modal-login';
    $url_post = '#modal-login';
} else {
    $lightbox = "";
    $url_login = "javascript:;";
    $url_post = '/member/tao-bai-viet.html';
}


$month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
$month = array_flip($month);
$mydate = getdate(date("U"));

// kiểm tra

$today = $mydate['mday'] . "-" . $month[$mydate['month']] . "-" . $mydate['year'];
$today = strtotime($today);

$query = "SELECT * FROM `e4_views` WHERE ngay ='$today'";
$database->setQuery($query);
$check = $database->loadRow();

if ($check) {

    //"tồn tại" => update

    $row = new stdClass();
    $row->ngay = $check['ngay'];

    if (svl_ismobile()) {

        $row->mobile = $check["mobile"] + 1;
        //echo "Bạn đang dùng điện thoại";

    } else {

        $row->web = $check["web"] + 1;
        // echo "Bạn đang dùng máy tính";

    }

    $row->toantrang = $check["toantrang"] + 1;

    $database->updateObject('e4_views', $row, 'ngay');

    //print_r($row);

} else {
    // "chưa tồn tại" => insert

    $row = new stdClass();
    $row->id = null;
    $row->ngay = $today;

    if (svl_ismobile()) {

        $row->mobile = $check["mobile"] + 1;
        //echo "Bạn đang dùng điện thoại";

    } else {

        $row->web = $check["web"] + 1;
        // echo "Bạn đang dùng máy tính";

    }

    $row->toantrang = $check["toantrang"] + 1;

    $database->insertObject('e4_views', $row, 'id');

}

if ($_SESSION['member']) {
    $row = new stdClass();
    $row->id = $_SESSION['member']['id'];
    $row->time = time();

    $database->updateObject('e4_users', $row, 'id');
}


//echo $_SERVER['REQUEST_URI'];
?>

<!-- Header -->
<script type="text/javascript">
    function change_Lang(lang) {
        var f = "lang=" + lang;
        var _url = "/ajax/ajax.change_lang.php?" + f;
        //alert(_url);
        $.ajax({
            url: _url,
            data: f,
            cache: false,
            context: document.body,
            success: function (data) {
                //alert("<?= $_SESSION['url']?>");
                window.location = "<?= $_SESSION['url']?>";
            }
        });
    }
</script>


<div class="header">


    <!-- NAVIGATION
        ================================================== -->


    <nav id="navigation" class="navigation">
        <div class="nav-header">
            <a href="<?= $ariacms->actual_link ?>" class="nav-logo"
               title="<?= $ariacms->web_information->{$params->name} ?>"><img
                        src="<?= $ariacms->web_information->{'image-logo'} ?>"
                        alt="Dan Gilroy Design | Websites For Lawyers"
                        data-lazy-src="<?= $ariacms->web_information->{'image-logo'} ?>">
                <noscript><img src="<?= $ariacms->web_information->{'image-logo'} ?>"
                               alt="<?= $ariacms->web_information->{$params->name} ?>"></noscript>
            </a>
            <div class="nav-toggle"></div>
        </div>

        <div class="nav-menus-wrapper hide">

            <section id="top-row" class="top-row-wrapper desktop-only hide">
                <div class="top-row">
                    <div class="top-bar">
                        <small class="desktop-only">&nbsp;</small>
                        <div class="right-info">
                            <a class="quote-top-row"
                               style="cursor:pointer;color: #ff0000;background-color: #0268b300;text-align: center;font-size: 16px;text-transform: uppercase;padding: 6px 12px;">
                                ISSN: <?=$ariacms->web_information->brief_vi?>
                            </a>
                            <a class="quote-top-row"
                               style="cursor:pointer;color: #ff0000;background-color: #0268b300;text-align: center;font-size: 16px;text-transform: uppercase;padding: 6px 12px;">
                                DOI: <?=$ariacms->web_information->brief_en?>
                            </a>

                            <!-- Mã ss -->
                        </div>

                    </div>
                </div>
            </section>
            <div class="nav-search desktop-only hide">
                <!--                <div class="nav-search-button"><i class="fas fa-search" aria-label="Search" style="color:#000"-->
                <!--                                                  aria-hidden="true"></i></div>-->
                <form method="post" id="searchform" action="<?= $ariacms->actual_link ?>search.html"
                      style="display: none;">
					
					
                    <div class="nav-search-inner">
                        <label for="s" class="assistive-text sr-only">Desktop Search Form</label>
                        <input type="text" class="field" name="keysearch" id="s" placeholder="<?= _SEARCH_CONTENT ?>">
                        <input type="submit" class="submit sr-only" name="submit" id="searchsubmit" value="Search">
                    </div>
					<span class="nav-search-close-button" tabindex="0"></span>
                </form>
            </div>
			<style>
			
			
			
				.pd-l{
					padding-left: 40%
				}
				@media only screen and (max-width: 1366px) {
				  .pd-l {
					padding-left: 34%
				  }
				}
				
			</style>
            <ul id="menu-primary-menu" class="nav-menu align-to-right pd-l" style="">
                <?php if ($_SESSION['member']) { ?>
                    <li id="menu-item-15"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-15 ">
                        <a style="cursor: pointer">
                            <i class="fas fa-user" style="font-size: 16px"></i>
                            <?php echo $_SESSION['member']['fullname'] ?>
                        </a>
                        <ul class="nav-dropdown nav-submenu">

                            <li id="menu-item-524"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-524">
                                <a href="<?php echo $ariacms->actual_link . '/member/chinh-sua-thong-tin.html'; ?>"><?= _YOUR_PROFILE ?></a>
                            </li>

                            <?php if ($_SESSION['member']['LoginType'] == 'author') { ?>

                                <li id="menu-item-524"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-524">
                                    <a href="<?= $ariacms->actual_link ?>member/bai-viet.html"
                                       class="but but1"><?= _ARTICLE_MANAGAMENT ?></a>
                                </li>

                                <li id="menu-item-524"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-524">
                                    <a href="<?= $ariacms->actual_link ?>member/tao-bai-viet.html"
                                       class="but but2"> <?= _CREATE ?></a>
                                </li>

                            <?php } ?>

                            <?php if ($_SESSION['member']['LoginType'] == 'reviewer') { ?>


                                <li id="menu-item-524"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-524">
                                    <a href="<?= $ariacms->actual_link ?>member/quan-ly-phan-bien.html"
                                       class="but but1"><?= _FEEDBACK_MANAGAMENT ?></a>
                                </li>

                            <?php } ?>


                            <li id="menu-item-524" style="background: red;color: red"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-524" >
                                <a  style="background: #fc4141;"
                                        href="<?php echo $ariacms->actual_link . '/register/logout.html'; ?>"><?= _SIGN_OUT ?></a>
                            </li>


                        </ul>
                    </li>
                <?php } else { ?>
                    <li id="menu-item-540"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-540"
                        data-uw-styling-context="true">
                        <a>
                            &nbsp;
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <ul id="menu-primary-menu" class="nav-menu align-to-right">
                <?php foreach ($web_menus as $key => $web_menu) {
                    if ($web_menu->url_html == $catid) $classmenu = "active"; else $classmenu = "";
                    if ($web_menu->parent == 0) {
                        if ($web_menu->submenu == 0) {
                            ?>
                            <li id="menu-item-540"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-540  ">
                                <a href="<?= $ariacms->actual_link . $web_menu->url_html ?>"
                                   aria-current="page"><?= $web_menu->{$params->title} ?></a></li>
                        <?php } else { ?>
                            <li id="menu-item-15"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-15 ">
                                <a href="<?= $ariacms->actual_link . $web_menu->url_html ?>"><?= $web_menu->{$params->title} ?></a>
                                <ul class="nav-dropdown nav-submenu">
                                    <?php
                                    foreach ($web_menus as $key1 => $sub_menu) {
                                        if ($web_menu->id == $sub_menu->parent) {
                                            ?>
                                            <li id="menu-item-524"
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-524">
                                                <a href="<?= $ariacms->actual_link . $sub_menu->url_html ?>"><?= $sub_menu->{$params->title} ?></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>

                                </ul>
                            </li>
                        <?php }
                    }
                } ?>

                <?php if (!$_SESSION['member']) { ?>
                    <li id="menu-item-540"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-540"
                        data-uw-styling-context="true">
                        <a style="cursor: pointer" href="<?php echo $ariacms->actual_link . 'register.html'; ?>">
                            <?= _SIGN_IN ?>
                        </a>
                    </li>
                <?php } ?>
                <li id="menu-item-540"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-540"
                    data-uw-styling-context="true">
                    <a style="cursor: pointer" onclick="change_Lang('<?= $_SESSION['steam_lang'] ?>')">
                        <img src="<?php if ($_SESSION['steam_lang'] == 'vi') echo $ariacms->actual_link . './upload/flag_en.jpg'; else echo $ariacms->actual_link . './upload/flag_vi.jpg'; ?>"
                             style="height: 20px;">
                    </a>
                </li>
                <li id="menu-item-540"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-540"
                    data-uw-styling-context="true">
                    <a style="cursor: pointer">
                        <div class="nav-search-button"><i class="fas fa-search" aria-label="Search" style="color:#000"
                                                          aria-hidden="true"></i></div>
                    </a>
                </li>
            </ul>


    </nav>

</div><!--end sticky header-->
