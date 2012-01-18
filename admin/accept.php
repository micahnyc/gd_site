<?php
	include_once("../lib/db.php");
	$id = $_POST["id"];
	mysql_query("UPDATE fgd SET aAccepted=1 WHERE aID='$id'");
?>