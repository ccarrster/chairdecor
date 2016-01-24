<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$categoryid = $_POST['category'];
$description = $_POST['description'];
$result = mysqli_query($link, "INSERT INTO style (name, categoryid) values('".mysqli_real_escape_string($link, $description)."', ".mysqli_real_escape_string($link, $categoryid).");");
echo(json_encode($result));
?>