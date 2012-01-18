<?php
	include_once("../lib/db.php");
	$id = $_POST["id"];
	mysql_query("UPDATE fgd SET aAccepted=2 WHERE aID='$id'");
?>