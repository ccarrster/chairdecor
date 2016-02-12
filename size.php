<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$action = "";
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == "add"){
	$result = mysqli_query($link, "INSERT INTO size (name) VALUES('".mysqli_real_escape_string($link, $_GET['name'])."');");
	echo(json_encode($result));
} elseif($action == "update") {
	$result = mysqli_query($link, "UPDATE size SET name = '".mysqli_real_escape_string($link, $_GET['name'])."' WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	echo(json_encode($result));
} elseif($action == "delete"){
	$result = mysqli_query($link, "DELETE FROM size WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	echo(json_encode($result));
} elseif($action == "get") {
	$result = mysqli_query($link, "SELECT id, name FROM size WHERE id = ".mysqli_real_escape_string($link, $_GET['id']).";");
	$sizes = array();
	while ($row = mysqli_fetch_row($result)) {
		$sizes[$row[0]] = $row[1];
	}
	echo(json_encode($sizes));
} elseif($action == "getall"){
	$result = mysqli_query($link, "SELECT id, name FROM size;");
	$sizes = array();
	while ($row = mysqli_fetch_row($result)) {
		$sizes[$row[0]] = $row[1];
	}
	echo(json_encode($sizes));
} else {
	echo(json_encode('Action '.$action.' not supported'));
}
?>