<?php
require_once("dbconfig.php");

$link = mysqli_connect($dbaddress, $dbuser, $dbpassword, $dbschema);

$result = mysqli_query($link, "SELECT id, name from size;");
$sizes = array();
while ($row = mysqli_fetch_row($result)) {
	$sizes[$row[0]] = $row[1];
}
echo(json_encode($sizes));
?>