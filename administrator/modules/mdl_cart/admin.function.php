<?php
class Model
{
	static function cart_view_link($row)
	{
		$str = '';
		$str .= '<a href ="?module=cart&task=cart_edit&id=' . $row->id . '" ><i class="fa fa-pencil-square-o" data-toggle="tooltip"  title="Chi tiết đơn hàng"></i></a>&nbsp;&nbsp;';
		$str .= '<a href ="?module=cart&task=cart_delete&id=' . $row->id . '" onclick="return confirmAction();"><i class="fa fa-trash text-red" data-toggle="tooltip"  title="Xóa"></i></a>&nbsp;&nbsp;';

		return $str;
	}
	static function cart_view()
	{
		global $database;
		global $ariacms;
		$curPg = ($_REQUEST["curPg"] > 0) ? $_REQUEST["curPg"] : 1;
		$maxRows = ($_REQUEST["page_size"] > 0) ? $_REQUEST["page_size"] : $ariacms->web_information->admin_per_page;
		$curRow = ($curPg - 1) * $maxRows;
		$limit = " LIMIT " . $curRow . "," . $maxRows . " ";

		$query = "SELECT a.*, SUM(b.quantity * b.price) total FROM e4_order a LEFT JOIN e4_order_detail b ON a.id = b.order_id 
		GROUP BY a.id
		ORDER BY a.id desc " . $limit;
		$database->setQuery($query);
		$carts = $database->loadObjectList();

		$query = "SELECT COUNT(*) total FROM e4_order a ";
		$database->setQuery($query);
		$totalRows = $database->loadRow();
		View::cart_view($carts, $totalRows['total'], $maxRows, $curPg);
	}

	static function cart_edit()
	{
		global $database;
		global $ariacms;
		switch ($_POST["submitCart"]) {
			case "cart_edit":
				$row = new stdClass;
				$row->id 		= $_REQUEST["id"];
				foreach ($_POST as $key => $value) {
					if ($key != "submitCart")
						$row->$key = $value;
				}
				$row->date_updated = time();
				if ($database->updateObject('e4_order', $row, 'id'))
					$ariacms->redirect("", "javascript:history.back()");
				else echo $database->stderr();
				break;

			case "cart_edit_detail":
				$id_detail =  $_REQUEST["id_detail"];
				if ($id_detail > 0) {
					$row = new stdClass;
					$row->id 		= $id_detail;
					foreach ($_POST as $key => $value) {
						if ($key != "submitCart" && $key != "submitDetail")
							$row->$key = $value;
					}
					$row->date_updated = time();
					if ($database->updateObject('e4_order_detail', $row, 'id'))
						$ariacms->redirect("", "javascript:history.back()");
					else echo $database->stderr();
				}
				break;

			default:
				$query = "SELECT a.*, SUM(b.quantity * b.price) total FROM e4_order a JOIN e4_order_detail b ON a.id = b.order_id 
			WHERE a.id = " . $_REQUEST["id"] . " GROUP BY a.id ";
				$database->setQuery($query);
				$detail = $database->loadRow();

				$query = "SELECT a.*, b.title_vi, b.image, b.url_part FROM e4_order_detail a LEFT JOIN e4_posts b ON a.product_id = b.id
		 WHERE a.order_id = " . $_REQUEST["id"];
				$database->setQuery($query);
				$products = $database->loadObjectList();

				View::cart_edit($detail, $products);
				break;
		}
	}
	static function cart_delete()
	{
		global $ariacms;
		$id	= $_REQUEST["id"];
		$id_detail = $_REQUEST["id_detail"];
		if ($id) {
			$ariacms->delete('e4_order', 'id=' . $id);
			$ariacms->delete('e4_order_detail', 'order_id=' . $id);
		}
		if ($id_detail) {
			$ariacms->delete('e4_order_detail', 'id=' . $id_detail);
		}
		$ariacms->redirect("", "javascript:history.back()");
	}
}
