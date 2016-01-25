<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);
$warehouseid = $_POST['warehouseid'];
$sizeid = $_POST['sizeid'];
$styleid = $_POST['styleid'];
$quantity = $_POST['quantity'];
$result = mysqli_query($link, "INSERT INTO stylesize (sizeid, styleid, warehouseid, quantity) values(".mysqli_real_escape_string($link, $sizeid).", ".mysqli_real_escape_string($link, $styleid).", ".mysqli_real_escape_string($link, $warehouseid).", ".mysqli_real_escape_string($link, $quantity).");");
echo(json_encode($result));
?>