<?php
	include_once("../lib/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="" /> 
	<meta name="keywords" content="" /> 
	<title>Admin | How About Some Fucking Group Dynamics</title>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" media="screen" type="text/css" href="main.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(init);
		
		function init(){
			$('.ui img').live('click', handleAdvice);
		}
		
		function handleAdvice(){
			var c = $(this).attr('class');
			var id = $(this).parent().parent().attr('id');
			var post = $(this).parent().parent();

			switch(c){
				case "check":
					var sendid = id.substr(2, id.length);
					$.post('accept.php',{id:sendid}, function(data) {
						post.fadeOut(300, function(){
							var html = '<div class="post" id="'+id+'">'+post.html()+'</div>';
							$('.accepted').prepend(html);
						});
						
					});
				break;
				
				case "trash":
					var sendid = id.substr(2, id.length);
					$.post('delete.php',{id:sendid}, function(data) {
						post.fadeOut(300);
					});
				break;
				
				case "delete":
					var sendid = id.substr(2, id.length);
					$.post('decline.php',{id:sendid}, function(data) {
						post.fadeOut(300, function(){
							var html = '<div class="post" id="'+id+'">'+post.html()+'</div>';
							$('.declined').prepend(html);
						});
					});
				break;
			}
			
		
		}
	</script>
	
</head>
<body>
	<div id="main">
		<h1>How About Some Fucking Group Dynamics?</h1>
		<hr />
		<h2>Pending</h2>
		<?php
			$res = mysql_query("SELECT * FROM fgd WHERE aAccepted = 0 ORDER BY aID");
			if(mysql_num_rows($res) == 0){
				echo '<span>No pending advices</span>';
			}
			while($row = mysql_fetch_array($res)){
		?>
				<div class="post" id="p-<?=$row['aID']?>">
					<strong><?=$row['aText']?></strong>
					<div class="ui">
						<img src="trash_box.png" alt="" width="22" class="trash" title="Remove forever" />
						<img src="delete_2.png" alt="" width="22" class="delete" title="Move to declined" />
						<img src="check-64.png" alt="" width="22" class="check" title="Accept" />
					</div>
				</div>
		<?php	
			}
		?>
		
		<h2>Accepted</h2>
		<div class="accepted">
			<?php
				$res = mysql_query("SELECT * FROM fgd WHERE aAccepted = 1 ORDER BY aID");
				while($row = mysql_fetch_array($res)){
			?>
					<div class="post" id="p-<?=$row['aID']?>">
						<strong><a href="../#/<?=$row['aURL']?>" target="_blank"><?=$row['aText']?></a></strong>
						<div class="ui">
							<img src="trash_box.png" alt="" width="22" class="trash" title="Remove forever" />
							<img src="delete_2.png" alt="" width="22" class="delete" title="Move to declined" />
							<img src="check-64.png" alt="" width="22" class="check" title="Accept" />
						</div>
					</div>
			<?php	
				}
			?>
		</div>
		
		<h2>Declined</h2>
		<div class="declined">
		<?php
			$res = mysql_query("SELECT * FROM fgd WHERE aAccepted = 2 ORDER BY aID");
			if(mysql_num_rows($res) == 0){
				echo '<span>No declined advices</span>';
			}
			while($row = mysql_fetch_array($res)){
		?>
				<div class="post" id="p-<?=$row['aID']?>">
					<strong><?=$row['aText']?></strong>
					<div class="ui">
						<img src="trash_box.png" alt="" width="22" class="trash" title="Remove forever" />
						<img src="delete_2.png" alt="" width="22" class="delete" title="Move to declined" />
						<img src="check-64.png" alt="" width="22" class="check" title="Accept" />
					</div>
				</div>
		<?php	
			}
		?>
		</div>
	</div>
</body>
</html>