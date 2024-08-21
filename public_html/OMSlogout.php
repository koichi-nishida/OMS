<?php

require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");
session_start();


$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

new_header("Delete from OMS");

if (($output = message()) !== null) {
	echo $output;
}

session_destroy();

redirect("OMSlogin.php");

new_footer("2021 Video Games");
Database::dbDisconnect();

?>
