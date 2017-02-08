<?php
$dbhost = "localhost";
$dbuser = "";
$dbpass = "";
$dbname = "";

$db_conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($db_conn->connect_error) {
	die("Database does not exist.");
}
?>