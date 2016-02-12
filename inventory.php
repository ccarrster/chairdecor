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
} else {
	echo(json_encode('Action '.$action.' not supported'));
}
?>