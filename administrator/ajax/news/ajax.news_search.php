<?php
session_start();
if (file_exists("../../../configuration.php")) {
	require_once("../../../configuration.php");
} else {
	echo "Missing Configuration File";
	exit();
}
//Include Database Controller
if (file_exists("../../../include/database.php")) {
	require_once("../../../include/database.php");
} else {
	echo "Missing Database File";
	exit();
}
//Include System File
if (file_exists("../../../include/ariacms.php")) {
	require_once("../../../include/ariacms.php");
} else {
	echo "Missing System File";
	exit();
}
$database = new database($ariaConfig_server, $ariaConfig_username, $ariaConfig_password, $ariaConfig_database);
$ariacms = new ariacms();

$category = @$_REQUEST['category'];
$keyword = @$_REQUEST['keyword'];

$where2 = $where3 = '';

// điều kiện 2:  danh mục
if($category != "home"){
	$where2 = " and a.news_position != 1 and c.category like '%$category%' ";
}else{
	$where2 = " and a.news_position != 2 ";
}
// điều kiện 3: keyword:
if($keyword != ""){
	$where3 = " and a.title_vi like  '%$keyword%' ";
}
$where = $where2.$where3;
$order = ' order by a.id desc';
$limit = " LIMIT 0,50";

$query = "SELECT a.*, b.fullname, c.category, d.tags,( select fullname from e4_users u where a.user_aproved =u.id) user_aproved 
FROM e4_posts a
	LEFT JOIN e4_users b ON a.user_created = b.id 
	LEFT JOIN ( 
		SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS category
		FROM e4_term_relationships t1 
		LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'category' GROUP BY t1.object_id
		) c ON a.id = c.object_id
	LEFT JOIN ( 
		SELECT t1.object_id, GROUP_CONCAT(' ', t2.title_vi) AS tags
		FROM e4_term_relationships t1 
		LEFT JOIN e4_term_taxonomy t2 ON t1.term_taxonomy_id = t2.id AND t2.taxonomy = 'post_tags' GROUP BY t1.object_id
		) d ON a.id = d.object_id
WHERE a.post_status = 'active' ".$where . $order . $limit;
//echo $query;
$database->setQuery($query);
$news = $database->loadObjectList();

$array_status = array('active'=>'Đã xuất bản','waiting'=>'Chờ duyệt','deactive'=>'Không được duyệt','lock'=>'Đã gỡ');
$array_location = array(2=> 'Nổi bật trang chủ', 1=>'Nổi bật trang trong', 0=>'Tin thường');

?>

<?php
$i = 0;
foreach ($news as $new) {
	$i++;
?>
	<tr class="<?php echo ($i % 2 == 1) ? 'bg-gray-light' : ''; ?> valign-middle" <?php if($new->news_position == 1) {echo 'style="background: #efe9a2;"';} if($new->news_position == 2) {echo 'style="background: #b6e9e4;"';}  if($new->news_position == 3) {echo 'style="background: #e7c9ab;"';} if($new->news_position == 4) {echo 'style="background: #32b12952;"';} ?>>
		<td  class="text-center">
			<?php echo $i ?>
		</td>
		<td><?php echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#showCNTT"  onclick="showCNTT(\'' . $new->id . '\',\'ajax/news/ajax.news_view.php\')">'.$new->title_vi.'</a>' ?></td>
		<td><?php echo $new->fullname ?></td>
		<td id="user_aproved<?=$i?>"><?php echo $new->user_aproved ?></td>
		<td><?php echo $new->category ?></td>
		<td>
			<?php echo ($new->post_created) ? $ariacms->unixToDate($new->post_created, '/') : ''; ?>
		</td>
		<td>
			<?php echo $array_location[$new->news_position]; ?>
		</td>
		<td class="text-center">
			<input type="checkbox" name="vitri[]" id="vitri_<?php echo $new->id ?>" value="<?php echo $new->id ?>"  />
		</td>
	</tr>
<?php } ?>
