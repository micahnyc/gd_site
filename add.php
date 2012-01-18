<?php
	function rand_chars($c, $l, $u = FALSE) { 
		if (!$u) for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c{$x}, $i++); 
		else for ($i = 0, $z = strlen($c)-1, $s = $c{rand(0,$z)}, $i = 1; $i != $l; $x = rand(0,$z), $s .= $c{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s)); 
		return $s; 
	}
	
	function checkRandom(){
		$r = rand_chars('abcdefghiklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', 4);
		$res = mysql_query("SELECT aURL FROM fgd");
		while($row = mysql_fetch_array($res)){
			if($r == $row['aURL']){
				checkRandom();
				return false;
			}
		}
		return $r;
	}
	
	mysql_connect("localhost", "lvl3_se", "bedside");
	mysql_select_db("lvl3_se");
	
	$ad = $_POST['advice'];
	$url = checkRandom();
	
	mysql_query("INSERT INTO fgd (aText, aURL, aAccepted) VALUES ('$ad', '$url', 0)");
	
	echo 'ok';
?>
