<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$action = "";
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == "add"){
	$result = mysqli_query($link, "INSERT INTO style (name, categoryid) VALUES('".mysqli_real_escape_string($link, $_GET['name'])."', ".mysqli_real_escape_string($link, $_GET['categoryid']).");");
	echo(json_encode($result));
} elseif($action == "update") {
	$result = mysqli_query($link, "UPDATE style SET name = '".mysqli_real_escape_string($link, $_GET['name'])."' WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	echo(json_encode($result));
} elseif($action == "delete"){
	$result = mysqli_query($link, "DELETE FROM style WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	echo(json_encode($result));
} elseif($action == "get") {
	$result = mysqli_query($link, "SELECT id, name, categoryid FROM style WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	$styles = array();
	while ($row = mysqli_fetch_row($result)) {
		$details = array();
		$details['name'] = $row[1];
		$details['categoryid'] = $row[2];
		$styles[$row[0]] = $details;
	}
	echo(json_encode($styles));
} elseif($action == "getcategoryid") {
	$result = mysqli_query($link, "SELECT id, name FROM style WHERE categoryid = ".mysqli_real_escape_string($link, $_GET['categoryid']).";");
	$styles = array();
	while ($row = mysqli_fetch_row($result)) {
		$styles[$row[0]] = $row[1];
	}
	echo(json_encode($styles));
} elseif($action == "getall"){
	$result = mysqli_query($link, "SELECT id, name, categoryid FROM style;");
	$styles = array();
	while ($row = mysqli_fetch_row($result)) {
		$details = array();
		$details['name'] = $row[1];
		$details['categoryid'] = $row[2];
		$styles[$row[0]] = $details;
	}
	echo(json_encode($styles));
} else {
	echo(json_encode('Action '.$action.' not supported'));
}
?>