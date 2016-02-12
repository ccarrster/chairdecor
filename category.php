<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$action = "";
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == "add"){
	$result = mysqli_query($link, "INSERT INTO category (name) VALUES('".mysqli_real_escape_string($link, $_GET['name'])."');");
	echo(json_encode($result));
} elseif($action == "update") {
	$result = mysqli_query($link, "UPDATE category SET name = '".mysqli_real_escape_string($link, $_GET['name'])."' WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	echo(json_encode($result));
} elseif($action == "delete"){
	$result = mysqli_query($link, "DELETE FROM category WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	echo(json_encode($result));
} elseif($action == "get") {
	$result = mysqli_query($link, "SELECT id, name FROM category WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	$categories = array();
	while ($row = mysqli_fetch_row($result)) {
		$categories[$row[0]] = $row[1];
	}
	echo(json_encode($categories));
} elseif($action == "getall"){
	$result = mysqli_query($link, "SELECT id, name FROM category;");
	$categories = array();
	while ($row = mysqli_fetch_row($result)) {
		$categories[$row[0]] = $row[1];
	}
	echo(json_encode($categories));
} else {
	echo(json_encode('Action '.$action.' not supported'));
}
?>