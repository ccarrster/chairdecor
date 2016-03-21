<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$action = "";
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == 'getall'){
	$result = mysqli_query($link, "SELECT id, customerid, startdate, enddate, approved FROM orders;");
	$orders = array();
	while ($row = mysqli_fetch_row($result)) {
		$order = array();
		$order['customerid'] = $row[1];
		$order['startdate'] = $row[2];
		$order['enddate'] = $row[3];
		$order['approved'] = $row[4];
		$order['items'] = array();
		$query = "SELECT orderitem.id, stylesizeid, orderitem.quantity, orderid, size.name, style.name, warehouse.name FROM orderitem JOIN stylesize ON stylesizeid = stylesize.id JOIN size ON sizeid = size.id JOIN style ON styleid = style.id JOIN warehouse ON warehouseid = warehouse.id WHERE orderid = ".$row[0].";";
		$resultItems = mysqli_query($link, $query);
		while ($rowItem = mysqli_fetch_row($resultItems)) {
			$item = array();
			$item['stylesizeid'] = $rowItem[1];
			$item['quantity'] = $rowItem[2];
			$item['orderid'] = $rowItem[3];
			$item['sizename'] = $rowItem[4];
			$item['stylename'] = $rowItem[5];
			$item['warehousename'] = $rowItem[6];
			$order['items'][$rowItem[0]] = $item;
		}
		$orders[$row[0]] = $order;
	}
	echo(json_encode($orders));
} elseif($action == 'approve'){
	$result = mysqli_query($link, "UPDATE orders SET approved = 1 WHERE id = ".mysqli_real_escape_string($link, $_GET['orderid']).";");
	echo(json_encode($result));
} elseif($action == 'delete'){
	mysqli_query($link, "DELETE FROM orderitem WHERE orderid = ".mysqli_real_escape_string($link, $_GET['orderid']).";");
	$result = mysqli_query($link, "DELETE FROM orders WHERE id = ".mysqli_real_escape_string($link, $_GET['orderid']).";");
	echo(json_encode($result));
} else {
	echo(json_encode('Action '.$action.' not supported'));
}
?>