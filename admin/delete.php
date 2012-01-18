<?php
	include_once("../lib/db.php");
	$id = $_POST["id"];
	mysql_query("DELETE FROM fgd WHERE aID='$id'");
?>