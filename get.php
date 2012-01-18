<?php
	include_once('lib/db.php');
	$res = mysql_query('SELECT * FROM fgd WHERE aAccepted = 1 ORDER BY aID');
	$json = '{"advice": [';
	$dbcount = mysql_num_rows($res);
	$count = 0;
	while($row = mysql_fetch_array($res)){
		$count++;
		if($count == $dbcount){
			$json .= '{"id": '.$row["aID"].', "text": "'.$row["aText"].'", "url":"'.$row["aURL"].'"}';
		}else{
			$json .= '{"id": '.$row["aID"].', "text": "'.$row["aText"].'", "url":"'.$row["aURL"].'"}, ';
		}
	}
	$json .= ']}';
	
	echo $json;
?>