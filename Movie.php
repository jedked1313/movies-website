<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include "config.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Movie</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">
		
		body{
			background-color: #474747;
		}
		video{
			outline: none;
			border-radius: 30px;
			padding : 20px;
			max-width: 600px;
			max-height : 100%;
		}
		.background{
			background-color: #a8a7a7;
			border-radius: 10px;
			margin: 10% auto 0;
			width: 54%;
			max-height:100%;
			box-shadow: -15px 20px 40px -10px;
		}
		.download{
			padding: 0px 0 25px 0;
		}
		.download a{
			padding: 10px 20px;
			border-radius: 25px;
			margin: 0 40%;
			background-color: green;
			color: white;
			text-decoration: none;
			font-weight: bold;
			font-family:  'Microsoft YaHei UI Light' ,sans-serif;
			transition: 0.3s all ease-in-out;
		}
		.download a:hover{
			opacity : 80%;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="background">
		<?php 
		$sql = 'SELECT movie_dir FROM movies WHERE movie_num = '.$_GET['movie_num'];
		$q = $pdo->query($sql);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		$row = $q->fetch();?>
		<video src="<?php echo ($row["movie_dir"]);?>" controls="controls"></video>
		<div class="download">
			<a href="<?php echo ($row["movie_dir"]); ?>">Download</a>
		</div>
	</div>
</div>
</body>
</html>