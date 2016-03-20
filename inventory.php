<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$action = "";
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == "add"){
	$result = mysqli_query($link, "DELETE FROM stylesize WHERE sizeid = ".mysqli_real_escape_string($link, $_GET['sizeid'])." AND styleid = ".mysqli_real_escape_string($link, $_GET['styleid'])." AND warehouseid = ".mysqli_real_escape_string($link, $_GET['warehouseid'])." ;");
	$result = mysqli_query($link, "INSERT INTO stylesize (sizeid, styleid, warehouseid, quantity) VALUES(".mysqli_real_escape_string($link, $_GET['sizeid']).", ".mysqli_real_escape_string($link, $_GET['styleid']).", ".mysqli_real_escape_string($link, $_GET['warehouseid']).", ".mysqli_real_escape_string($link, $_GET['quantity']).");");
	echo(json_encode($result));
} elseif($action == "getall"){
	$result = mysqli_query($link, "SELECT id, sizeid, styleid, warehouseid, quantity FROM stylesize;");
	$results = array();
	while ($row = mysqli_fetch_row($result)) {
		$details = array();
		$details['sizeid'] = $row[1];
		$details['styleid'] = $row[2];
		$details['warehouseid'] = $row[3];
		$details['quantity'] = $row[4];
		$results[$row[0]] = $details;
	}
	echo(json_encode($results));
} elseif($action == "getstyles"){
	$query = "SELECT stylesize.id, styleid FROM stylesize INNER JOIN style ON stylesize.styleid = style.id WHERE quantity >= ".mysqli_real_escape_string($link, $_GET['quantity'])." AND sizeid = ".mysqli_real_escape_string($link, $_GET['sizeid'])." AND categoryid = ".mysqli_real_escape_string($link, $_GET['categoryid']).";";
	$result = mysqli_query($link, $query);
	$results = array();
	while ($row = mysqli_fetch_row($result)) {
		$details = array();
		$details['styleid'] = $row[1];
		$results[$row[0]] = $details;
	}
	echo(json_encode($results));
} elseif($action == "getsizes"){


	$order = json_decode(file_get_contents('php://input'));

	$usedItems = array();
	$ordersquery = "SELECT stylesizeid, quantity FROM orders JOIN orderitem on orders.id = orderitem.orderid WHERE ((startdate >= '" . mysqli_real_escape_string($link, $_GET['startdate']) . "' AND startdate <= '".mysqli_real_escape_string($link, $_GET['enddate'])."') OR (enddate >= '".mysqli_real_escape_string($link, $_GET['startdate'])."' AND enddate <= '".mysqli_real_escape_string($link, $_GET['enddate'])."')) AND approved = 1";
	$ordersresult = mysqli_query($link, $ordersquery);
	while ($row = mysqli_fetch_row($ordersresult)) {
		if(isset($usedItems[$row[0]])){
			$usedItems[$row[0]] += (int)$row[1];
		} else {
			$usedItems[$row[0]] = (int)$row[1];
		}
	}

	$query = "SELECT sizeid, quantity, stylesize.id FROM stylesize INNER JOIN style ON stylesize.styleid = style.id WHERE quantity >= ".mysqli_real_escape_string($link, $_GET['quantity'])." AND categoryid = ".mysqli_real_escape_string($link, $_GET['categoryid']).";";
	$result = mysqli_query($link, $query);
	$results = array();
	while ($row = mysqli_fetch_row($result)) {
		$details = array();
		$totalQuantity = $row[1];
		$styleSizeId = $row[2];
		$used = 0;
		if(isset($usedItems[$styleSizeId])){
			$used = $usedItems[$styleSizeId];
		}
		$details['sizeid'] = $row[0];
		$details['total'] = $totalQuantity;
		$details['used'] = $used;
		$details['available'] = $totalQuantity - $used;
		if($details['available'] >= $_GET['quantity']){
			$results[$row[0]] = $details;
		}
	}
	echo(json_encode($results));
} else {
	echo(json_encode('Action '.$action.' not supported'));
}
?>