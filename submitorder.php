<?php

require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$order = json_decode(file_get_contents('php://input'));

$query = "INSERT INTO orders (customerid, startdate, enddate, approved) VALUES(1, '".mysqli_real_escape_string($link, $order->date)."', '".mysqli_real_escape_string($link, $order->date)."', 0);";
$result = mysqli_query($link, $query);

$id = mysqli_insert_id($link);

for($i = 0; $i < count($order->items); $i++){
	$itemQuery = "INSERT INTO orderitem (orderid, stylesizeid, quantity) VALUES($id, ".mysqli_real_escape_string($link, $order->items[$i]->styleSize).", ".mysqli_real_escape_string($link, $order->items[$i]->quantity).");";
	$itemResult = mysqli_query($link, $itemQuery);
}

echo(json_encode($itemQuery));
?>