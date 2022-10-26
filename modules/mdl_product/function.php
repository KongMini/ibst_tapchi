<?php
class Model
{
	static function product_list()
	{
		global $database;
		/** Filter session product */
		if ($_POST['btn_filter'] == 'filter') {
			$_SESSION["filter"]->taxonomy = ($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : null;
			$_SESSION["filter"]->price_from = ($_REQUEST['price_from']) ? $_REQUEST['price_from'] : 0;
			$_SESSION["filter"]->price_to = ($_REQUEST['price_to']) ? $_REQUEST['price_to'] : 0;
		}
		$where = " ";
		/** Check exist session filter to add condition search */
		if ($_SESSION["filter"]) {
			($_SESSION["filter"]->price_from) ? $where .= " AND (a.product_sale = 0 OR a.product_sale >= " . $_SESSION["filter"]->price_from . ')' : '';
			($_SESSION["filter"]->price_to) ? $where .= " AND (a.product_sale = 0 OR a.product_sale <= " . $_SESSION["filter"]->price_to . ')' : '';
			if ($_SESSION["filter"]->taxonomy) {
				$filter = implode(",", $_SESSION["filter"]->taxonomy);
				$where .= " AND b.term_taxonomy_id IN (" . $filter . ")";
			}
		}
		/** All product */
		$query = "SELECT a.* FROM e4_posts a 
			JOIN e4_term_relationships b ON b.object_id = a.id AND b.object_type = 'product'
				WHERE a.post_type = 'product' AND a.post_status = 'active' " . $where . "
				GROUP BY a.id 
				order by a.id desc ";
		$database->setQuery($query);
		$products = $database->loadObjectList();
		/** All taxonomy product */
		$query = "SELECT a.*, count(b.parent) submenu  FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT parent FROM e4_term_taxonomy) b ON a.id = b.parent
		WHERE a.taxonomy LIKE '%product_%' AND a.status = 'active' 
		GROUP BY a.id
		order by a.taxonomy, a.parent, a.order ";
		$database->setQuery($query);
		$taxonomies = $database->loadObjectList();
		View::product_list($products, $taxonomies);
	}

	static function product_taxonomy()
	{
		global $ariacms;
		global $database;
		$task = $ariacms->getParam("task"); // Get task check with category product
		if ($_POST['btn_filter'] == 'filter') {
			$_SESSION["filter"]->taxonomy = ($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : null;
			$_SESSION["filter"]->price_from = ($_REQUEST['price_from']) ? $_REQUEST['price_from'] : 0;
			$_SESSION["filter"]->price_to = ($_REQUEST['price_to']) ? $_REQUEST['price_to'] : 0;
		}
		$where = " AND a.post_type = 'product' ";
		if ($_SESSION["filter"]) {
			($_SESSION["filter"]->price_from) ? $where .= " AND (a.product_sale = 0 OR a.product_sale >= " . $_SESSION["filter"]->price_from . ')' : '';
			($_SESSION["filter"]->price_to) ? $where .= " AND (a.product_sale = 0 OR a.product_sale <= " . $_SESSION["filter"]->price_to . ')' : '';
			if ($_SESSION["filter"]->taxonomy) {
				$filter = implode(",", $_SESSION["filter"]->taxonomy);
				$where .= " AND d.term_taxonomy_id IN (" . $filter . ")";
			}
		}
		/** Get category information */
		$query = "SELECT a.*, GROUP_CONCAT('',b.id) submenu  FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT id, parent FROM e4_term_taxonomy) b ON a.id = b.parent OR a.id = b.id
		WHERE a.url_part = '" . $task . "' AND a.status = 'active' 
		GROUP BY a.id";
		$database->setQuery($query);
		$category = $database->loadRow();
		/** Get all product with condition filter and store in category */
		$query = "SELECT a.* FROM e4_posts a JOIN
			(SELECT b.object_id FROM e4_term_relationships b 
			JOIN e4_term_taxonomy c ON b.term_taxonomy_id = c.id AND c.id IN (" . $category['submenu'] . ")
			WHERE b.object_type = 'product') t ON a.id = t.object_id
			JOIN e4_term_relationships d ON d.object_id = a.id " . $where . "
		GROUP BY a.id
		order by a.id desc ";
		$database->setQuery($query);
		$products = $database->loadObjectList();
		/** Get all taxonomy */
		$query = "SELECT a.*, count(b.parent) submenu  FROM e4_term_taxonomy a 
		LEFT JOIN (SELECT parent FROM e4_term_taxonomy) b ON a.id = b.parent
		WHERE a.taxonomy LIKE '%product_%' AND a.status = 'active' 
		GROUP BY a.id
		order by a.taxonomy, a.parent, a.order ";
		$database->setQuery($query);
		$taxonomies = $database->loadObjectList();

		View::product_taxonomy($products, $taxonomies, $category);
	}
}
